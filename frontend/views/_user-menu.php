<?php

/**
 * @var $this \yii\web\View
 */

use frontend\helpers\AuthorHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$menuItems = [
	['label' => 'Профиль', 'url' => ['/user/settings/profile']],
	['label' => 'Выход', 'url' => ['/user/logout'], 'template' => '<a href="{url}" data-method="post">{label}</a>'],
];

if (!Yii::$app->user->isGuest) {
	/** @var \common\models\User $userModel */
	$userModel = Yii::$app->user->identity;
	$author = $userModel->author;

	if ($author !== null) {
		$newMenuItems = [];
		foreach (AuthorHelper::getViewSections($author) as $section) {
			$newMenuItems[] = [
				'label' => ArrayHelper::getValue($section, 'label'),
				'url'   => ArrayHelper::getValue($section, 'url'),
			];
		}

		array_splice($menuItems, 1, 0, $newMenuItems);
	}

	if (Yii::$app->user->can(\common\Rbac::ADMIN_ACCESS)) {
		array_splice($menuItems, 0, 0, [
			['label' => 'Админка', 'url' => Yii::$app->backendUrlManager->createAbsoluteUrl(['/'], true)],
		]);
	}
}
?>
<?= \yii\widgets\Menu::widget([
	'items'   => $menuItems,
	'options' => [
		'class' => 'menu',
	],
]) ?>
