<?php

namespace common\helpers;

use common\models\WriterWork;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class WriterWorkHelper {
	/**
	 * @param WriterWork $work
	 *
	 * @return string
	 */
	public static function getWriterWorkFrontendUrl($work) {
		return Yii::$app->frontendUrlManager->createAbsoluteUrl(['/author-writer/view', 'slug' => $work->slug, 'username' => $work->author->user->username], true);
	}
}
