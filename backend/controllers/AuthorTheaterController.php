<?php

namespace backend\controllers;

use backend\helpers\AuthorHelper;
use backend\models\CinemaSearch;
use backend\models\TheaterSearch;
use common\models\Author;
use common\models\Cinema;
use common\models\ImageUploadForm;
use common\models\News;
use common\models\Theater;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * @author MrAnger
 */
class AuthorTheaterController extends BaseController {
	private $section = 'is_theater';

	public function actionIndex($authorId) {
		$author = $this->findAuthorModel($authorId);

		$searchModel = new TheaterSearch();

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

		$imageManager = Yii::$app->imageManager;

		$model = new Theater([
			'author_id' => $author->id,
		]);
		$imageUploadForm = new ImageUploadForm();

		if (Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			$imageUploadForm->load(Yii::$app->request->post());

			$imageUploadForm->file = UploadedFile::getInstance($imageUploadForm, 'file');

			if (Model::validateMultiple([$model, $imageUploadForm])) {
				$transaction = Yii::$app->db->beginTransaction();

				try {
					if (!$model->save(false)) {
						throw new \Exception("Model save is not successfully.");
					}

					// Image
					if ($imageUploadForm->file !== null) {
						$imageEntry = $imageManager->upload($imageUploadForm->file);

						if (!$model->updateAttributes(['image_id' => $imageEntry->id])) {
							$imageManager->deleteImage($imageEntry->id);

							throw new \Exception("Model save with new image is not successfully.");
						}
					}

					$transaction->commit();
				} catch (\Exception $e) {
					$transaction->rollBack();

					throw $e;
				}

				Yii::$app->session->addFlash('success', 'Работа успешно создана. ' . Html::a('Создать еще', ['create', 'authorId' => $model->author_id], ['class' => 'btn btn-success btn-xs']));

				return $this->redirect(['update', 'id' => $model->id]);
			}
		}

		return $this->render('create', [
			'model'           => $model,
			'imageUploadForm' => $imageUploadForm,
			'activeSection'   => $this->section,
			'sectionList'     => AuthorHelper::getViewSections($author),
			'author'          => $author,
		]);
	}

	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$imageUploadForm = new ImageUploadForm();

		$imageManager = Yii::$app->imageManager;

		if (Yii::$app->request->isPost) {
			$oldImageId = $model->image_id;
			$deleteOldImage = false;

			$model->load(Yii::$app->request->post());
			$imageUploadForm->load(Yii::$app->request->post());

			$imageUploadForm->file = UploadedFile::getInstance($imageUploadForm, 'file');

			if (Model::validateMultiple([$model, $imageUploadForm])) {
				$transaction = Yii::$app->db->beginTransaction();

				try {
					if (!$model->save(false)) {
						throw new \Exception("Model save is not successfully.");
					}

					// Image
					if ($imageUploadForm->file !== null) {
						$imageEntry = $imageManager->upload($imageUploadForm->file);

						if (!$model->updateAttributes(['image_id' => $imageEntry->id])) {
							throw new \Exception("Model save with new image is not successfully.");
						}

						$deleteOldImage = true;
					}

					$transaction->commit();
				} catch (\Exception $e) {
					$transaction->rollBack();

					throw $e;
				}

				if ($deleteOldImage && $oldImageId !== null) {
					$imageManager->deleteImage($oldImageId);
				}

				Yii::$app->session->addFlash('success', 'Работа успешно изменена. ' . Html::a('Создать еще', ['create', 'authorId' => $model->author_id], ['class' => 'btn btn-success btn-xs']));

				return $this->redirect(Yii::$app->request->referrer);
			}
		}

		return $this->render('update', [
			'model'           => $model,
			'imageUploadForm' => $imageUploadForm,
			'activeSection'   => $this->section,
			'sectionList'     => AuthorHelper::getViewSections($model->author),
			'author'          => $model->author,
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
	 * @return Theater
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = Theater::findOne($id)) !== null) {
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
