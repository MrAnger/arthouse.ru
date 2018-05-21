<?php

namespace backend\controllers;

use backend\models\AuthorSearch;
use common\models\Author;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class AuthorController extends BaseController {
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
