<?php

namespace frontend\controllers\my\author;

use backend\helpers\AuthorHelper;
use backend\models\NewsSearch;
use common\models\Author;
use common\models\ImageUploadForm;
use common\models\News;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
					$imageEntry = $imageUploadForm->upload();
					if ($imageEntry) {
						if (!$model->updateAttributes(['image_id' => $imageEntry->id])) {
							Yii::$app->imageManager->deleteImage($imageEntry->id);

							throw new \Exception("Model save with new image is not successfully.");
						}
					}

					$transaction->commit();
				} catch (\Exception $e) {
					$transaction->rollBack();

					throw $e;
				}

				Yii::$app->session->addFlash('success', 'Новость успешно создана.');

				return $this->redirect(['update', 'id' => $model->id]);
			}
		}

		return $this->render('create', [
			'model' => $model,
			'imageUploadForm' => $imageUploadForm,
		]);
	}

	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$imageUploadForm = new ImageUploadForm();

		$this->checkAccessToModel($model);

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
					$imageEntry = $imageUploadForm->upload();
					if ($imageEntry) {
						if (!$model->updateAttributes(['image_id' => $imageEntry->id])) {
							Yii::$app->imageManager->deleteImage($imageEntry->id);

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
					Yii::$app->imageManager->deleteImage($oldImageId);
				}

				Yii::$app->session->addFlash('success', 'Новость успешно изменена.');

				return $this->redirect(Yii::$app->request->referrer);
			}
		}

		return $this->render('update', [
			'model' => $model,
			'imageUploadForm' => $imageUploadForm,
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
