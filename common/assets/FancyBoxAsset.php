<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * @author MrAnger
 */
class FancyBoxAsset extends AssetBundle {
	public $sourcePath  = '@bower/fancybox';

	public $css = [
		'dist/jquery.fancybox.min.css'
	];

	public $js = [
		'dist/jquery.fancybox.min.js',
	];

	public $depends = [
		'yii\web\JqueryAsset'
	];
}
