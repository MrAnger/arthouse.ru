<?php

namespace frontend\controllers;

use common\models\Author;
use common\models\Profile;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class AuthorController extends BaseController {
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => Author::find()
				->joinWith('user.profile upt')
				->orderBy(['upt.name' => SORT_ASC]),
		]);

		$dataProvider->sort = false;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * @param integer $id
	 *
	 * @return Author
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = Author::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
