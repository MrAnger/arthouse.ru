<?php

namespace common\helpers;

use common\models\Cinema;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class CinemaHelper {
	/**
	 * @param News $cinema
	 *
	 * @return string
	 */
	public static function getCinemaFrontendUrl(Cinema $cinema) {
		return Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author-cinematographer/view', 'slug' => $cinema->slug, 'username' => $cinema->author->user->username], true);
	}
}
