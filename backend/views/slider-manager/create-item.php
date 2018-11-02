<?php

/**
 * @var yii\web\View $this
 * @var \common\models\SliderItem $sliderItem
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Создать новый слайд';

$this->params['breadcrumbs'] = [
	['label' => 'Слайдеры', 'url' => ['index']],
	['label' => $sliderItem->slider->name, 'url' => ['update', 'id' => $sliderItem->slider_id]],
	'Создать слайд',
];

?>
<?= $this->render('_form-item', [
	'sliderItem'      => $sliderItem,
	'imageUploadForm' => $imageUploadForm,
]) ?>