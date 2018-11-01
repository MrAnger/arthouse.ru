<?php

namespace frontend\controllers;

use common\models\Author;
use common\models\Profile;
use common\models\User;
use frontend\helpers\AuthorHelper;
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
				->joinWith('user.profile.avatarImage')
				->orderBy(['upt.name' => SORT_ASC]),
		]);

		$dataProvider->sort = false;

		$this->view->title = "Авторы";

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionView($username) {
		$author = $this->findModelByUsername($username);

		$this->view->title = $author->user->displayName;

		return $this->render('view', [
			'author'        => $author,
			'activeSection' => 'base',
			'sectionList'   => AuthorHelper::getProfileViewSections($author),
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

	/**
	 * @param string $username
	 *
	 * @return Author
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModelByUsername($username) {
		$model = Author::find()
			->where([
				'AND',
				['=', 'user_id', User::find()->select('id')->where(['username' => $username])],
			])
			->one();

		if ($model !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
