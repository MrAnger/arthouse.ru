<?php

namespace frontend\controllers\author;

use common\models\Author;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

/**
 * @author MrAnger
 */
abstract class BaseController extends \frontend\controllers\BaseController {
	public $layout = 'author';

	/** @var Author */
	public $author;

	/**
	 * @return array
	 */
	public function getAccessRules() {
		return [
			[
				'allow' => true,
				'roles' => ['@'],
			],
		];
	}

	public function init() {
		parent::init();

		/** @var User $user */
		$user = Yii::$app->user->identity;

		$this->author = $user->author;

		if ($this->author === null) {
			throw new ForbiddenHttpException("Доступ разрешен только авторам.");
		}
	}

	/**
	 * @param Model $model
	 *
	 * @throws
	 */
	protected function checkAccessToModel($model) {
		if ($model->author_id != $this->author->id) {
			throw new ForbiddenHttpException("Нельзя управлять чужими записями.");
		}
	}
}