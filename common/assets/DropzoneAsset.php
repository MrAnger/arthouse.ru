<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * @author MrAnger
 */
class DropzoneAsset extends AssetBundle {
	public $sourcePath  = '@bower/dropzone';

	public $css = [
		'dist/min/dropzone.min.css'
	];

	public $js = [
		'dist/min/dropzone.min.js',
	];

	public $depends = [
		'yii\web\JqueryAsset'
	];
}
