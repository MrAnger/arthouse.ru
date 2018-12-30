<?php

namespace frontend\controllers;

use common\models\Cinema;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class CinematographerController extends BaseController {
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => Cinema::find()
				->orderBy(['created_at' => SORT_DESC]),
		]);

		$dataProvider->sort = false;

		$this->view->title = implode(' - ', [
			'Каталог кинематогрофа',
			Yii::$app->name,
		]);

		$this->view->registerMetaTag([
			'name'    => 'description',
			'content' => $this->view->title,
		], 'description');

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * @param integer $id
	 *
	 * @return Cinema
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = Cinema::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
