<?php

namespace frontend\controllers;

use common\models\Author;
use common\models\WriterWork;
use common\models\User;
use frontend\helpers\AuthorHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * @author MrAnger
 */
class AuthorWriterController extends BaseController {
	protected $section = 'is_writer';

	public function actionIndex($username) {
		$author = $this->findAuthorModel($username);

		$dataProvider = new ActiveDataProvider([
			'query' => WriterWork::find()
				->where([
					'AND',
					['=', 'author_id', $author->id],
				])
				->orderBy(['created_at' => SORT_DESC]),
		]);

		$dataProvider->sort = false;

		$this->view->title = implode(' - ', [
			'Литература',
			$author->user->displayName,
			Yii::$app->name,
		]);

		$this->view->registerMetaTag([
			'name'    => 'description',
			'content' => $this->view->title,
		], 'description');

		return $this->render('index', [
			'dataProvider'  => $dataProvider,
			'author'        => $author,
			'activeSection' => $this->section,
			'sectionList'   => AuthorHelper::getProfileViewSections($author),
		]);
	}

	public function actionView($slug, $username) {
		$author = $this->findAuthorModel($username);
		$model = $this->findModel([
			'slug'      => $slug,
			'author_id' => $author->id,
		]);

		$title = implode(' - ', [
			$model->name,
			'Литература',
			$author->user->displayName,
			Yii::$app->name,
		]);

		$this->view->title = ($model->meta_title) ? $model->meta_title : $title;
		$this->view->registerMetaTag(['name' => 'description', 'content' => ($model->meta_description) ? $model->meta_description : $this->view->title], 'description');
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
