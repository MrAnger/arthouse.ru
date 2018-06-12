<?php

namespace common\helpers;

use common\models\News;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class NewsHelper {
	/**
	 * @param News $news
	 *
	 * @return string
	 */
	public static function getNewsFrontendUrl($news) {
		$url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/news/view-by-slug', 'slug' => $news->slug], true);

		if ($news->author_id !== null) {
			$url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author-news/view', 'slug' => $news->slug, 'username' => $news->author->user->username], true);
		}

		return $url;
	}
}
