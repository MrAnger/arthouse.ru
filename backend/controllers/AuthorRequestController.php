<?php

namespace backend\controllers;

use common\components\UserBuddy;
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
use yii\web\NotFoundHttpException;

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

				// Пока думаю обойдемся без роли автора :)
				//$this->assignRole($user, Rbac::ROLE_AUTHOR);

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

	public function actionDecline($id) {
		$model = $this->findModel($id);

		if ($model->updateAttributes(['status' => AuthorRequest::STATUS_DECLINED])) {
			Yii::$app->session->addFlash('success', 'Заявка успешно отклонена.');
		} else {
			Yii::$app->session->addFlash('warning', 'Не удалось отклонить заявку.');
		}

		return $this->redirect(Yii::$app->request->referrer);
	}

	protected function assignRole(User $user, $role) {
		$auth = Yii::$app->authManager;

		$userRole = $auth->getRole($role);

		if ($userRole !== null) {
			$auth->assign($userRole, $user->id);
		}
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
