<?php

/**
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$menuItems = [
	['label' => 'Новости', 'url' => ['/news/index']],
	['label' => 'Литература', 'url' => '#'],
	['label' => 'Изостудия', 'url' => '#'],
	['label' => 'Фотография', 'url' => '#'],
	['label' => 'Музыка', 'url' => '#'],
	['label' => 'Кино', 'url' => '#'],
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
