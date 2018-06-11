<?php

namespace backend\controllers;

use common\models\Feedback;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class FeedbackController extends BaseController {
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => Feedback::find(),
		]);

		$dataProvider->sort->defaultOrder = [
			'created_at' => SORT_DESC,
		];

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionMarkAsViewed($id) {
		$model = $this->findModel($id);

		if ($model->updateAttributes(['status' => Feedback::STATUS_VIEWED])) {
			Yii::$app->session->addFlash('success', 'Обращение помечено как просмотренное.');
		} else {
			Yii::$app->session->addFlash('warning', 'Не удалось пометить просмотренным обращение.');
		}

		return $this->redirect(Yii::$app->request->referrer);
	}

	/**
	 * @param integer $id
	 *
	 * @return Feedback
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = Feedback::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
