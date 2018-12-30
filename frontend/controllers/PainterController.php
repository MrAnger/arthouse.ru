<?php

namespace frontend\controllers;

use common\models\PainterWork;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class PainterController extends BaseController {
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => PainterWork::find()
				->orderBy(['created_at' => SORT_DESC]),
		]);

		$dataProvider->sort = false;

		$this->view->title = implode(' - ', [
			'Каталог арт-студии',
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
	 * @return PainterWork
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = PainterWork::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
