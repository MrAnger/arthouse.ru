<?php

/**
 * @var $this \yii\web\View
 */

use frontend\helpers\AuthorHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$menuItems = [
	['label' => 'Новости', 'url' => ['/news/index']],
	['label' => 'Литература', 'url' => '#'],
	['label' => 'Изостудия', 'url' => '#'],
	['label' => 'Фотография', 'url' => '#'],
	['label' => 'Театр', 'url' => '#'],
	['label' => 'Авторы', 'url' => ['/author/index']],
	['label' => 'Контакты', 'url' => ['/site/contacts']],
];

?>
<?= \yii\widgets\Menu::widget([
	'items'   => $menuItems,
	'options' => [
		'class' => 'menu',
	],
]) ?>
