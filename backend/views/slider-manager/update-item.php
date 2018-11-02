<?php

/**
 * @var yii\web\View $this
 * @var \common\models\SliderItem $sliderItem
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = $sliderItem->name;

$this->params['breadcrumbs'] = [
	['label' => 'Слайдеры', 'url' => ['index']],
	['label' => $sliderItem->slider->name, 'url' => ['update', 'id' => $sliderItem->slider_id]],
	$sliderItem->name,
];

?>
<?= $this->render('_form-item', [
	'sliderItem'      => $sliderItem,
	'imageUploadForm' => $imageUploadForm,
]) ?>