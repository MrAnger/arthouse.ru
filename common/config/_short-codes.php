<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;

return [
	'homeUrl'    => function ($attrs, $content, $tag) {
		return Yii::$app->homeUrl;
	},
	'currentUrl' => function ($attrs, $content, $tag) {
		$isAbsolute = ArrayHelper::getValue($attrs, 'absolute', false);

		if ($isAbsolute) {
			return Yii::$app->request->absoluteUrl;
		} else {
			return Yii::$app->request->url;
		}
	},
	'block'      => function ($attrs, $content, $tag) {
		$code = ArrayHelper::getValue($attrs, 'code');
	},
];