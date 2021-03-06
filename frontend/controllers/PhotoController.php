<?php

namespace frontend\controllers;

use common\models\PhotoWork;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class PhotoController extends BaseController {
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => PhotoWork::find()
				->orderBy(['created_at' => SORT_DESC]),
		]);

		$dataProvider->sort = false;

		$this->view->title = implode(' - ', [
			'Каталог фото работ',
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
	 * @return PhotoWork
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = PhotoWork::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
