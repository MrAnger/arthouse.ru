<?php

namespace backend\controllers;

use common\models\ImageUploadForm;
use common\models\Slider;
use common\models\SliderItem;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * @author MrAnger
 */
class SliderManagerController extends BaseController {
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => Slider::find(),
		]);

		$dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionCreate() {
		$request = Yii::$app->request;

		$slider = new Slider([
			'is_enabled' => 1,
		]);

		if ($slider->load($request->post()) && $slider->save()) {
			Yii::$app->session->addFlash('success', 'Слайдер успешно создан.');

			return $this->redirect(['update', 'id' => $slider->id]);
		}

		return $this->render('create', [
			'slider' => $slider,
		]);
	}

	public function actionUpdate($id) {
		$request = Yii::$app->request;

		$slider = $this->findModel($id);
		$sliderItemsDataProvider = new ArrayDataProvider([
			'allModels'  => $slider->getItems()->indexBy('id')->all(),
			'modelClass' => SliderItem::className(),
			'pagination' => false,
			'sort'       => false,
		]);

		if ($slider->load($request->post()) && $slider->save()) {
			Yii::$app->session->addFlash('success', 'Слайдер успешно изменен.');

			return $this->redirect(['update', 'id' => $slider->id]);
		}

		return $this->render('update', [
			'slider'                  => $slider,
			'sliderItemsDataProvider' => $sliderItemsDataProvider,
		]);
	}

	public function actionDelete($id) {
		$model = $this->findModel($id);

		$model->delete();

		Yii::$app->session->addFlash('success', 'Слайдер успешно удален.');

		return $this->redirect(Yii::$app->request->referrer);
	}

	public function actionCreateItem($id) {
		$request = Yii::$app->request;

		$sliderItem = new SliderItem([
			'is_enabled' => 1,
			'slider_id'  => $id,
		]);
		$imageUploadForm = new ImageUploadForm([
			'isFileRequired' => true,
		]);

		if ($request->isPost) {
			$sliderItem->load($request->post());
			$imageUploadForm->getFileInstance();

			if (Model::validateMultiple([$sliderItem, $imageUploadForm])) {
				$transaction = Yii::$app->db->beginTransaction();

				try {
					$imageEntry = $imageUploadForm->upload();

					$sliderItem->image_id = $imageEntry->id;

					if (!$sliderItem->save(false)) {
						throw new Exception("Не удалось сохранить модель SliderItem.");
					}

					$transaction->commit();
				} catch (\Exception $e) {
					$transaction->rollBack();

					throw $e;
				}

				Yii::$app->session->addFlash('success', 'Слайд успешно создан.');

				return $this->redirect(['update', 'id' => $sliderItem->slider_id]);
			}
		}

		return $this->render('create-item', [
			'sliderItem'      => $sliderItem,
			'imageUploadForm' => $imageUploadForm,
		]);
	}

	public function actionUpdateItem($id) {
		$request = Yii::$app->request;

		$sliderItem = $this->findModelSliderItem($id);
		$imageUploadForm = new ImageUploadForm([
			'isFileRequired' => false,
		]);

		if ($request->isPost) {
			$sliderItem->load($request->post());
			$imageUploadForm->getFileInstance();

			if (Model::validateMultiple([$sliderItem, $imageUploadForm])) {
				$transaction = Yii::$app->db->beginTransaction();

				try {
					$imageEntry = $imageUploadForm->upload();

					if ($imageEntry) {
						$sliderItem->image_id = $imageEntry->id;
					}

					if (!$sliderItem->save(false)) {
						throw new Exception("Не удалось сохранить модель SliderItem.");
					}

					$transaction->commit();
				} catch (\Exception $e) {
					$transaction->rollBack();

					throw $e;
				}

				Yii::$app->session->addFlash('success', 'Слайд успешно изменён.');

				return $this->redirect(['update', 'id' => $sliderItem->slider_id]);
			}
		}

		return $this->render('update-item', [
			'sliderItem'      => $sliderItem,
			'imageUploadForm' => $imageUploadForm,
		]);
	}

	public function actionDeleteItem($id) {
		$model = $this->findModelSliderItem($id);

		$model->delete();

		Yii::$app->session->addFlash('success', 'Слайд успешно удален.');

		return $this->redirect(Yii::$app->request->referrer);
	}

	public function actionItemSetOrder($imageId, $order) {
		Yii::$app->response->format = Response::FORMAT_JSON;

		/** @var SliderItem $model */
		$model = SliderItem::findOne($imageId);

		if ($model === null) {
			throw new NotFoundHttpException("Модель SliderItem не найдена.");
		}

		return (boolean)$model->moveToPosition($order);
	}

	/**
	 * @param mixed $pk
	 *
	 * @return Slider
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($pk) {
		if (($model = Slider::findOne($pk)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	/**
	 * @param mixed $pk
	 *
	 * @return SliderItem
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModelSliderItem($pk) {
		if (($model = SliderItem::findOne($pk)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
