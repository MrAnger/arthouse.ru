<?php

namespace backend\controllers;

use backend\helpers\AuthorHelper;
use backend\models\WriterWorkSearch;
use common\models\Author;
use common\models\WriterWork;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class AuthorWriterController extends BaseController {
	private $section = 'is_writer';

	public function actionIndex($authorId) {
		$author = $this->findAuthorModel($authorId);

		$searchModel = new WriterWorkSearch();

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

	public function actionCreate($authorId) {
		$author = $this->findAuthorModel($authorId);

		$model = new WriterWork([
			'author_id' => $author->id,
		]);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->addFlash('success', 'Работа успешно создана. ' . Html::a('Создать еще', ['create', 'authorId' => $model->author_id], ['class' => 'btn btn-success btn-xs']));

			return $this->redirect(['update', 'id' => $model->id]);
		}

		return $this->render('create', [
			'model'         => $model,
			'activeSection' => $this->section,
			'sectionList'   => AuthorHelper::getViewSections($author),
			'author'        => $author,
		]);
	}

	public function actionUpdate($id) {
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->addFlash('success', 'Работа успешно изменена. ' . Html::a('Создать еще', ['create', 'authorId' => $model->author_id], ['class' => 'btn btn-success btn-xs']));

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
			Yii::$app->session->addFlash('success', 'Работа успешно удалена.');
		} else {
			Yii::$app->session->addFlash('warning', 'Не удалось удалить работу.');
		}

		return $this->redirect(Yii::$app->request->referrer);
	}

	/**
	 * @param integer $id
	 *
	 * @return WriterWork
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = WriterWork::findOne($id)) !== null) {
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
