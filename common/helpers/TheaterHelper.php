<?php

namespace common\helpers;

use common\models\Theater;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class TheaterHelper {
	/**
	 * @param Theater $theater
	 *
	 * @return string
	 */
	public static function getTheaterFrontendUrl(Theater $theater) {
		return Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author-theater/view', 'slug' => $theater->slug, 'username' => $theater->author->user->username], true);
	}
}
