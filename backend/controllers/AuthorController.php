<?php

namespace backend\controllers;

use backend\helpers\AuthorHelper;
use backend\models\AuthorSearch;
use common\models\Author;
use common\models\ImageUploadForm;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * @author MrAnger
 */
class AuthorController extends BaseController {
	/**
	 * @var string
	 */
	private $section = 'base';

	public function actionIndex() {
		$searchModel = new AuthorSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionUpdate($id) {
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->addFlash('success', 'Автор успешно обновлен.');

			return $this->redirect(['update', 'id' => $model->id]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	public function actionUploadAvatar($id) {
		Yii::$app->response->format = Response::FORMAT_JSON;

		$author = $this->findModel($id);
		$profile = $author->user->profile;

		$imageManager = Yii::$app->imageManager;
		$imageUploadForm = new ImageUploadForm();

		$imageUploadForm->load(Yii::$app->request->post());

		$imageUploadForm->file = UploadedFile::getInstance($imageUploadForm, 'file');

		if ($imageUploadForm->validate() && $imageUploadForm->file !== null) {
			$imageEntry = $imageManager->upload($imageUploadForm->file);

			$profile->updateAttributes(['avatar_image_id' => $imageEntry->id]);
		} else {
			Yii::$app->session->addFlash('warning', $imageUploadForm->getFirstError('file'));
		}

		return true;
	}

	public function actionView($id) {
		$model = $this->findModel($id);

		return $this->render('view', [
			'model'         => $model,
			'activeSection' => $this->section,
			'sectionList'   => AuthorHelper::getViewSections($model),
		]);
	}

	/**
	 * @param integer $id
	 *
	 * @return Author
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = Author::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
