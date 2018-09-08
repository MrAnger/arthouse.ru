<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle {
	public $basePath = '@webroot/theme';
	public $baseUrl = '@web/theme';
	public $css = [
		'https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,600,700,800',
		'css/style.css',
	];
	public $js = [
		'js/modernizr.custom.63321.js',
		'js/placeholder.js',
		'js/imagesloaded.pkgd.min.js',
		'js/masonry.pkgd.min.js',
		'js/jquery.swipebox.min.js',
		'js/farbtastic/farbtastic.js',
		'js/options.js',
		'js/plugins.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
		'yii\jui\JuiAsset',
	];
}
