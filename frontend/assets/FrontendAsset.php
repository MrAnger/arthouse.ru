<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class FrontendAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		//'static/css/site.css',
		//'static/css/design.css',
		'static/css/style-override.css',
	];
	public $js = [
		'static/js/main.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
		'yii\bootstrap\BootstrapPluginAsset',
	];
}
