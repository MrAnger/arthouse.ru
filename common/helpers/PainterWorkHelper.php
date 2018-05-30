<?php

namespace common\helpers;

use common\models\PainterWork;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class PainterWorkHelper {
	/**
	 * @param PainterWork $work
	 *
	 * @return string
	 */
	public static function getPainterWorkFrontendUrl($work) {
		return Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author/view-painter-work-by-slug/', 'slug' => $work->slug, 'username' => $work->author->user->username], true);
	}
}
