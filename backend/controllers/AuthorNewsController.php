<?php

namespace backend\controllers;

use backend\helpers\AuthorHelper;
use backend\models\AuthorSearch;
use backend\models\NewsSearch;
use common\models\Author;
use common\models\News;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class AuthorNewsController extends BaseController {
	private $section = 'news';

	public function actionIndex($authorId) {
		$author = $this->findAuthorModel($authorId);

		$searchModel = new NewsSearch();

		$dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), [
			'author_id' => $author->id,
		]);

		$dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

		return $this->render('index', [
			'searchModel'   => $searchModel,
			'dataProvider'  => $dataProvider,
			'activeSection' => $this->section,
			'sectionList'   => AuthorHelper::getViewSections($author),
			'author'        => $author,
		]);
	}

	public function actionUpdate($id) {
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->addFlash('success', 'Новость успешно изменена.');

			return $this->redirect(Yii::$app->request->referrer);
		}

		return $this->render('update', [
			'model'         => $model,
			'activeSection' => $this->section,
			'sectionList'   => AuthorHelper::getViewSections($model->author),
			'author'        => $model->author,
		]);
	}

	public function actionDelete($id) {
		$model = $this->findModel($id);

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

	/**
	 * @param integer $id
	 *
	 * @return Author
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findAuthorModel($id) {
		if (($model = Author::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
