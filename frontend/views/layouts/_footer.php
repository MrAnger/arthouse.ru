<?php

/**
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="footer">
    <div class="footer-copyright">
        Все права защищены © 2008 <a href="<?= Url::to('/', true) ?>"><?= Yii::$app->name ?></a>
        <br/>
        Идея: Филипп Канонит&nbsp;| Разработка: <a href="https://vk.com/mranger" target="_blank">Вячеслав Шарапов</a> | <?= Html::a('Контакты', ['/site/contacts']) ?>
    </div>
</div>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->