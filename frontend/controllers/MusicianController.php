<?php

namespace frontend\controllers;

use common\models\MusicWork;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class MusicianController extends BaseController {
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => MusicWork::find()
				->orderBy(['created_at' => SORT_DESC]),
		]);

		$dataProvider->sort = false;

		$this->view->title = implode(' - ', [
			'Каталог музыкальных работ',
			Yii::$app->name,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * @param integer $id
	 *
	 * @return MusicWork
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = MusicWork::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
