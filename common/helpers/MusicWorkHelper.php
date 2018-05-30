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
	public static function getMusicWorkFrontendUrl($work) {
		return Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author/view-music-work-by-slug/', 'slug' => $work->slug, 'username' => $work->author->user->username], true);
	}
}
