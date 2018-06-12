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

	'login' => ['label' => 'Войти', 'url' => ['/user/login']],
];

$authorItem = [
	'label' => 'Личный кабинет',
	'url'   => '#',
	'items' => [
		['label' => 'Профиль', 'url' => ['/user/settings/profile']],
		'<li class="divider"></li>',
		['label' => 'Выход', 'url' => ['/user/logout'], 'linkOptions' => ['data-method' => 'post']],
	],
];

if (!Yii::$app->user->isGuest) {
	/** @var \common\models\User $userModel */
	$userModel = Yii::$app->user->identity;
	$author = $userModel->author;

	if ($author !== null) {
		$newMenuItems = ['<li class="divider"></li>'];
		foreach (AuthorHelper::getViewSections($author) as $section) {
			$newMenuItems[] = [
				'label' => ArrayHelper::getValue($section, 'label'),
				'url'   => ArrayHelper::getValue($section, 'url'),
			];
		}

		array_splice($authorItem['items'], 1, 0, $newMenuItems);
	}

	if (Yii::$app->user->can(\common\Rbac::ADMIN_ACCESS)) {
		array_splice($authorItem['items'], 0, 0, [
			['label' => 'Панель администратора', 'url' => Yii::$app->backendUrlManager->createAbsoluteUrl(['/site/index'], true)],
			'<li class="divider"></li>',
		]);
	}

	$menuItems['login'] = $authorItem;
}

?>
<?php \yii\bootstrap\NavBar::begin([
	'brandLabel' => 'ArtHouse.Ru',
	'options'    => ['class' => 'navbar navbar-default navbar-fixed-top'],
]) ?>
<?= \yii\bootstrap\Nav::widget([
	'items'   => $menuItems,
	'options' => ['class' => 'navbar-nav'],
]) ?>
<?php \yii\bootstrap\NavBar::end() ?>
