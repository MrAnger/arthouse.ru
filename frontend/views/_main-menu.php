<?php

/**
 * @var $this \yii\web\View
 */

use frontend\helpers\AuthorHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$menuItems = [
	['label' => 'Новости', 'url' => ['/news/index']],
	['label' => 'Литература', 'url' => ['/writer/index']],
	['label' => 'Арт-студия', 'url' => ['/painter/index']],
	['label' => 'Фотография', 'url' => ['/photo/index']],
	['label' => 'Музыка', 'url' => ['/musician/index']],
	['label' => 'Кино', 'url' => ['/cinematographer/index']],
	['label' => 'Театр', 'url' => '/theater/index'],
	['label' => 'Авторы', 'url' => ['/author/index']],
	['label' => 'Контакты', 'url' => ['/site/contacts']],
	'my' => [
		'label' => 'Личный кабинет',
		'url'   => ((Yii::$app->user->isGuest) ? ['/user/login'] : '#'),
		'items' => [],
	],
];

if (!Yii::$app->user->isGuest) {
	$menuItems['my']['items'][] = ['label' => 'Профиль', 'url' => ['/user/settings/profile']];

	/** @var \common\models\User $userModel */
	$userModel = Yii::$app->user->identity;
	$author = $userModel->author;

	if ($author !== null) {
		foreach (AuthorHelper::getViewSections($author) as $section) {
			$menuItems['my']['items'][] = [
				'label' => ArrayHelper::getValue($section, 'label'),
				'url'   => ArrayHelper::getValue($section, 'url'),
			];
		}
	}

	$menuItems['my']['items'][] = ['label' => 'Выход', 'url' => ['/user/logout'], 'template' => '<a href="{url}" data-method="post">{label}</a>'];

	if (Yii::$app->user->can(\common\Rbac::ADMIN_ACCESS)) {
		$menuItems['my']['items'][] = ['label' => 'Админка', 'url' => Yii::$app->backendUrlManager->createAbsoluteUrl(['/'], true)];
	}
}
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
