<?php

/**
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="logo">
                    <a href="<?= Yii::$app->homeUrl ?>">
                        <span class="site-text-color">Art</span>Xayc.Ru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="menu site-bg-color">
        <div class="container">
            <?= $this->render('/_main-menu') ?>
        </div>
    </div>
</div>