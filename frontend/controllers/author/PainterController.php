<?php

namespace frontend\controllers\author;

use backend\models\PainterWorkSearch;
use common\models\ImageUploadForm;
use common\models\PainterWork;
use common\models\PainterWorkImage;
use MrAnger\Yii2_ImageManager\models\Image;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * @author MrAnger
 */
class PainterController extends BaseController {
	public function actionIndex() {
		$searchModel = new PainterWorkSearch();

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
		$imageManager = Yii::$app->imageManager;

		$model = new PainterWork([
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

				Yii::$app->session->addFlash('success', 'Работа успешно создана.');

				return $this->redirect(['update', 'id' => $model->id]);
			}
		}

		return $this->render('create', [
			'model'           => $model,
			'imageUploadForm' => $imageUploadForm,
		]);
	}

	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$imageUploadForm = new ImageUploadForm();

		$imageManager = Yii::$app->imageManager;

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

				Yii::$app->session->addFlash('success', 'Работа успешно изменена.');

				return $this->redirect(Yii::$app->request->referrer);
			}
		}

		return $this->render('update', [
			'model'           => $model,
			'imageUploadForm' => $imageUploadForm,
		]);
	}

	public function actionDelete($id) {
		$model = $this->findModel($id);

		$this->checkAccessToModel($model);

		if ($model->delete()) {
			Yii::$app->session->addFlash('success', 'Работа успешно удалена.');
		} else {
			Yii::$app->session->addFlash('warning', 'Не удалось удалить работу.');
		}

		return $this->redirect(Yii::$app->request->referrer);
	}

	public function actionImageUpload() {
		Yii::$app->response->format = Response::FORMAT_JSON;

		$workId = Yii::$app->request->post('workId');

		$workModel = $this->findModel($workId);

		if ($workModel === null) {
			throw new BadRequestHttpException("PainterWork[ID: $workId] not found.");
		}

		$this->checkAccessToModel($workModel);

		$imageManager = Yii::$app->imageManager;
		$imageUploadForm = new ImageUploadForm();

		$imageUploadForm->load(Yii::$app->request->post());

		$imageUploadForm->file = UploadedFile::getInstanceByName('file');

		if ($imageUploadForm->validate() && $imageUploadForm->file !== null) {
			$imageEntry = $imageManager->upload($imageUploadForm->file);

			$painterImageModel = new PainterWorkImage([
				'work_id'  => $workModel->id,
				'image_id' => $imageEntry->id,
			]);

			return $painterImageModel->save();
		}

		throw new BadRequestHttpException("ImageUploadForm not validate.");
	}

	public function actionUpdateImage($imageId) {
		Yii::$app->response->format = Response::FORMAT_JSON;

		$model = Image::findOne($imageId);

		if ($model === null) {
			throw new NotFoundHttpException("Image[ID: $imageId] not found.");
		}

		$this->checkAccessToImage($model);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return true;
		}

		throw new BadRequestHttpException("Image model not loaded or validated.");
	}

	public function actionDeleteImage($imageId) {
		Yii::$app->response->format = Response::FORMAT_JSON;

		/** @var PainterWorkImage $model */
		$model = PainterWorkImage::findOne(['image_id' => $imageId]);

		if ($model === null) {
			return true;
		}

		$this->checkAccessToImage($model);

		$model->delete();
		Yii::$app->imageManager->deleteImage($model->image);

		return true;
	}

	public function actionSetOrderImage($imageId, $order) {
		Yii::$app->response->format = Response::FORMAT_JSON;

		/** @var PainterWorkImage $model */
		$model = PainterWorkImage::findOne(['image_id' => $imageId]);

		if ($model === null) {
			throw new NotFoundHttpException("PainterWorkImage[IMAGE_ID: $imageId] not found.");
		}

		$this->checkAccessToImage($model);

		return $model->moveToPosition($order);
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

	/**
	 * @param Image $model
	 *
	 * @throws
	 */
	protected function checkAccessToImage($model) {
		$query = PainterWorkImage::find()
			->where([
				'AND',
				['=', 'image_id', $model->id],
				['in', 'work_id', PainterWork::find()->select('id')->where(['author_id' => $this->author->id])],
			]);

		if (!$query->exists()) {
			throw new ForbiddenHttpException("Нельзя управлять чужими записями.");
		}
	}
}
