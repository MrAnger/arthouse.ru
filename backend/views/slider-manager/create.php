<?php

/**
 * @var yii\web\View $this
 * @var \common\models\Slider $slider
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Создать новый слайдер';

$this->params['breadcrumbs'] = [
	['label' => 'Слайдеры', 'url' => ['index']],
	'Создать',
];

?>
<?= $this->render('_form', [
	'slider' => $slider,
]) ?>