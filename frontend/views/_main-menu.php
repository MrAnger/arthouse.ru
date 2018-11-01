<?php

/**
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$menuItems = [
	['label' => 'Новости', 'url' => ['/news/index']],
	['label' => 'Литература', 'url' => '/writer/index'],
	['label' => 'Изостудия', 'url' => '/painter/index'],
	['label' => 'Фотография', 'url' => '/photo/index'],
	['label' => 'Музыка', 'url' => '/musician/index'],
	['label' => 'Кино', 'url' => '/cinematographer/index'],
	['label' => 'Театр', 'url' => '#'],
	['label' => 'Авторы', 'url' => ['/author/index']],
	['label' => 'Контакты', 'url' => ['/site/contacts']],
];

?>
<div class="responsive-menu">Меню</div>
<?= \yii\widgets\Menu::widget([
	'items'           => $menuItems,
	'activeCssClass'  => 'current-page',
	'submenuTemplate' => "\n<ul class=\"children\">\n{items}\n</ul>\n",
	'options'         => [
		'class' => 'responsive-menu-active',
	],
]) ?>
