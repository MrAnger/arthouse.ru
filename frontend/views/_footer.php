<?php

/**
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;

$siteUrl = Url::to(['/site/index'], true);
?>
<footer>
	<p>
		Все права защищены © 2008 - <?= date('Y') ?> <?= Html::a($siteUrl, $siteUrl, ['class' => 'footer-link']) ?>
	</p>
    <p>
        Идея: Филипп Канонит | Разработка: <?= Html::a('Шарапов Вячеслав', 'https://vk.com/mranger', ['class' => 'footer-link', 'target' => '_blank']) ?>
    </p>
</footer>
