<?php

namespace common\helpers;

use common\models\News;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class CinemaHelper {
	/**
	 * @param News $news
	 *
	 * @return string
	 */
	public static function getCinemaFrontendUrl($news) {
		return Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author/view-cinema-by-slug/', 'slug' => $news->slug, 'username' => $news->author->user->username], true);
	}
}
