<?php

namespace frontend\controllers\author;

use backend\helpers\AuthorHelper;
use backend\models\NewsSearch;
use common\models\Author;
use common\models\News;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class NewsController extends BaseController {
	public function actionIndex() {
		$searchModel = new NewsSearch();

		$dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), [
			'author_id' => $this->author->id,
		]);

		$dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionCreate() {
		$model = new News([
			'author_id' => $this->author->id,
		]);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->addFlash('success', 'Новость успешно создана.');

			return $this->redirect(['update', 'id' => $model->id]);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	public function actionUpdate($id) {
		$model = $this->findModel($id);

		$this->checkAccessToModel($model);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->addFlash('success', 'Новость успешно изменена.');

			return $this->redirect(Yii::$app->request->referrer);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	public function actionDelete($id) {
		$model = $this->findModel($id);

		$this->checkAccessToModel($model);

		if ($model->delete()) {
			Yii::$app->session->addFlash('success', 'Новость успешно удалена.');
		} else {
			Yii::$app->session->addFlash('warning', 'Не удалось удалить новость.');
		}

		return $this->redirect(Yii::$app->request->referrer);
	}

	/**
	 * @param integer $id
	 *
	 * @return News
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = News::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
