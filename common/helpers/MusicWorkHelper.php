<?php

namespace common\helpers;

use common\models\MusicWork;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class MusicWorkHelper {
	/**
	 * @param MusicWork $work
	 *
	 * @return string
	 */
	public static function getMusicWorkFrontendUrl(MusicWork $work) {
		return Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author-musician/view', 'slug' => $work->slug, 'username' => $work->author->user->username], true);
	}
}
