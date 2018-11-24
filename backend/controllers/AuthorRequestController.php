<?php

namespace backend\controllers;

use backend\models\AuthorRequestDeclineForm;
use common\components\UserBuddy;
use common\helpers\MailHelper;
use common\models\Author;
use common\models\AuthorRequest;
use common\models\User;
use common\Rbac;
use Da\User\Event\UserEvent;
use Da\User\Factory\MailFactory;
use Da\User\Helper\SecurityHelper;
use Da\User\Service\UserCreateService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * @author MrAnger
 */
class AuthorRequestController extends BaseController {
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => AuthorRequest::find(),
		]);

		$dataProvider->sort->defaultOrder = [
			'created_at' => SORT_DESC,
		];

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionApprove($id) {
		$model = $this->findModel($id);

		/** @var UserBuddy $userBuddy */
		$userBuddy = Yii::$app->get('userBuddy');

		$user = new User([
			'username' => $userBuddy->generateUniqueUserName(explode('@', $model->email)[0]),
			'email'    => $model->email,
		]);
		$user->setScenario('create');

		$event = new UserEvent($user);

		$author = new Author();

		$transaction = Yii::$app->db->beginTransaction();

		try {
			if ($user->validate()) {
				$this->trigger(UserEvent::EVENT_BEFORE_CREATE, $event);

				$mailService = MailFactory::makeWelcomeMailerService($user);
				$securityHelper = new SecurityHelper(Yii::$app->security);
				$userCreateService = new UserCreateService($user, $mailService, $securityHelper);

				if (!$userCreateService->run()) {
					throw new \Exception('Не удалось создать нового пользователя.');
				}

				$user->refresh();

				$user->profile->updateAttributes([
					'name' => $model->name,
					'bio'  => $model->about,
				]);

				$author->user_id = $user->id;

				if (!$author->save(false)) {
					throw new \Exception('Не удалось создать нового автора.');
				}

				$model->updateAttributes(['status' => AuthorRequest::STATUS_APPROVED]);

				$transaction->commit();

				$this->trigger(UserEvent::EVENT_AFTER_CREATE, $event);

				Yii::$app->session->addFlash('success', 'Новый автор успешно создан.');

				return $this->redirect(['/author/update', 'id' => $author->id]);
			}

			$transaction->rollBack();

			$errorList = [];
			foreach ($user->errors as $fieldErrorList) {
				$errorList = array_merge($errorList, $fieldErrorList);
			}

			Yii::$app->session->addFlash('warning', "Не удалось создать нового автора.<br>" . implode("<br>", $errorList));

			return $this->redirect(Yii::$app->request->referrer);
		} catch (\Exception $e) {
			$transaction->rollBack();

			throw $e;
		}
	}

	public function actionDecline() {
		Yii::$app->response->format = Response::FORMAT_JSON;

		$output = ['status' => false];

		$form = new AuthorRequestDeclineForm();

		if (!$form->load(Yii::$app->request->post()) || !$form->validate()) {
			throw new BadRequestHttpException("Ошибка при загрузки или валидации модели.");
		}

		$model = $this->findModel($form->requestId);

		$sendResult = MailHelper::sendMail(null, $model->email, 'Заявка на авторство - отказ', 'author-request-decline-notification', [
			'authorRequest' => $model,
			'declineReason' => $form->comment,
		]);

		if ($sendResult) {
			$output['status'] = (boolean)$model->updateAttributes(['status' => AuthorRequest::STATUS_DECLINED]);
		}

		if ($output['status']) {
			Yii::$app->session->addFlash('success', 'Заявка успешно отклонена.');
		} else {
			Yii::$app->session->addFlash('warning', 'Не удалось отклонить заявку.');
		}

		return $output;
	}

	public function actionValidateDeclineForm() {
		Yii::$app->response->format = Response::FORMAT_JSON;

		$form = new AuthorRequestDeclineForm();

		$form->load(Yii::$app->request->post());

		return ActiveForm::validate($form);
	}

	/**
	 * @param integer $id
	 *
	 * @return AuthorRequest
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = AuthorRequest::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
