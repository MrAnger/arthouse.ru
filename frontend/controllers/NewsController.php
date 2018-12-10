<?php

namespace frontend\controllers;

use common\models\News;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class NewsController extends BaseController {
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => News::find()
				->joinWith('image')
				->where([
					'AND',
					new Expression('archived_at IS NULL'),
				])
				->orderBy(['created_at' => SORT_DESC]),
		]);

		$dataProvider->sort = false;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionArchive() {
		$dataProvider = new ActiveDataProvider([
			'query' => News::find()
				->where([
					'AND',
					new Expression('archived_at IS NOT NULL'),
				])
				->orderBy(['created_at' => SORT_DESC]),
		]);

		$dataProvider->sort = false;

		return $this->render('archive', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionViewBySlug($slug) {
		$model = $this->findModel(['slug' => $slug]);

		return $this->render('view', [
			'model' => $model,
		]);
	}

	/**
	 * @param integer $id
	 *
	 * @return News
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = News::find()->where($id)->andWhere(new Expression("author_id IS NULL"))->one()) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
