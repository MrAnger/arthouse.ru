<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\Author $model
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;

$authorUrl = Url::to(['/author/view', 'username' => $model->user->username]);
?>
<div class="thumbnail">
    <div class="caption">
        <h3>
			<?= $model->user->displayName ?>
            <br>
            <small style="font-size: small;"></small>
        </h3>
        <p><?= nl2br($model->user->profile->bio) ?></p>
        <p>
			<?= Html::a('Подробнее', $authorUrl, [
				'class'     => 'btn btn-primary',
				'data-pjax' => '0',
			]) ?>
        </p>
    </div>
</div>