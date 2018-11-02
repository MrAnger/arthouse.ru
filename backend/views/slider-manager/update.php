<?php

/**
 * @var yii\web\View $this
 * @var \common\models\Slider $slider
 * @var \yii\data\ArrayDataProvider $sliderItemsDataProvider
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = $slider->name;

$this->params['breadcrumbs'] = [
	['label' => 'Слайдеры', 'url' => ['index']],
	$slider->name,
];

?>
<?= $this->render('_form', [
	'slider'                  => $slider,
	'sliderItemsDataProvider' => $sliderItemsDataProvider,
]) ?>