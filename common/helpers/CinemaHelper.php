<?php

namespace common\helpers;

use common\models\News;
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
	public static function getCinemaFrontendUrl($cinema) {
		return Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author/view-cinema-by-slug/', 'slug' => $cinema->slug, 'username' => $cinema->author->user->username], true);
	}
}
