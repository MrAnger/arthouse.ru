<?php

namespace backend\controllers;

use common\models\post\PostSection;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class PostSectionManagerController extends BaseController {
	const MENU_KEY = 'Разделы'; // Множественное число
	const MENU_KEY_SINGLE = 'Раздел'; // Единственное число
	const MENU_ICON = '<i class="fa fa-bars"></i>';

	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => PostSection::find()
				->orderBy(['sort' => SORT_ASC]),
			'sort'  => false,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionCreate() {
		$model = new PostSection();
		$config = $model->getConfigModel();

		if (Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			$config->load(Yii::$app->request->post());

			if (Model::validateMultiple([$model, $config])) {
				$model->setConfigModel($config);

				if ($model->save()) {
					Yii::$app->session->addFlash('success', "Раздел успешно создан. " . Html::a('Создать новый раздел', ['create'], ['class' => 'btn btn-success btn-xs']));

					return $this->redirect(['update', 'id' => $model->id]);
				}
			}
		}

		return $this->render('create', [
			'model'       => $model,
			'configModel' => $config,
		]);
	}

	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$config = $model->getConfigModel();

		if (Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			$config->load(Yii::$app->request->post());

			if (Model::validateMultiple([$model, $config])) {
				$model->setConfigModel($config);

				if ($model->save()) {
					Yii::$app->session->addFlash('success', "Раздел успешно сохранён. " . Html::a('Создать новый раздел', ['create'], ['class' => 'btn btn-success btn-xs']));

					return $this->redirect(['update', 'id' => $model->id]);
				}
			}
		}

		return $this->render('update', [
			'model'       => $model,
			'configModel' => $config,
		]);
	}

	public function actionDelete($id) {
		$model = $this->findModel($id);

		if ($model->delete()) {
			Yii::$app->session->addFlash('success', "Раздел успешно удалён. " . Html::a('Создать новый раздел', ['create'], ['class' => 'btn btn-success btn-xs']));
		} else {
			Yii::$app->session->addFlash('warning', 'Не удалось удалить раздел.');
		}

		return $this->redirect(['index']);
	}

	/**
	 * @param integer $id
	 *
	 * @return PostSection
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = PostSection::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested PostSection does not exist.');
		}
	}
}
