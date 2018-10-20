<?php

namespace common\helpers;

use common\models\PhotoWork;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class PhotoWorkHelper {
	/**
	 * @param PhotoWork $work
	 *
	 * @return string
	 */
	public static function getPhotoWorkFrontendUrl(PhotoWork $work) {
		return Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author-photo/view', 'slug' => $work->slug, 'username' => $work->author->user->username], true);
	}
}
