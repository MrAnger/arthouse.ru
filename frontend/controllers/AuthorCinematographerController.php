<?php

namespace frontend\controllers;

use common\models\Author;
use common\models\Cinema;
use common\models\User;
use frontend\helpers\AuthorHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class AuthorCinematographerController extends BaseController {
	protected $section = 'is_cinematographer';

	public function actionIndex($username) {
		$author = $this->findAuthorModel($username);

		$dataProvider = new ActiveDataProvider([
			'query' => Cinema::find()
				->where([
					'AND',
					['=', 'author_id', $author->id],
				])
				->orderBy(['created_at' => SORT_DESC]),
		]);

		$dataProvider->sort = false;

		$this->view->title = "Кинемотография - " . $author->user->displayName;

		return $this->render('index', [
			'dataProvider'  => $dataProvider,
			'author'        => $author,
			'activeSection' => $this->section,
			'sectionList'   => AuthorHelper::getProfileViewSections($author),
		]);
	}

	public function actionView($slug) {
		$model = $this->findModel(['slug' => $slug]);
		$author = $model->author;

		$this->view->title = ($model->meta_title) ? $model->meta_title : $model->name;
		$this->view->registerMetaTag(['name' => 'description', 'content' => $model->meta_description], 'description');
		$this->view->registerMetaTag(['name' => 'keywords', 'content' => $model->meta_keywords], 'keywords');

		return $this->render('view', [
			'author'        => $author,
			'model'         => $model,
			'activeSection' => $this->section,
			'sectionList'   => AuthorHelper::getProfileViewSections($author),
		]);
	}

	/**
	 * @param integer $id
	 *
	 * @return Cinema
	 *
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id) {
		if (($model = Cinema::findOne($id)) !== null) {
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
	protected function findAuthorModel($username) {
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
