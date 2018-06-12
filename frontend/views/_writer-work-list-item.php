<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\WriterWork $model
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$formatter = Yii::$app->formatter;

$authorText = Html::a($model->author->user->displayName, ['/author/view', 'username' => $model->author->user->username]);
?>
<div class="thumbnail">
    <div class="caption">
        <h3>
			<?= $model->name ?>
            <br>
            <small style="font-size: small;"><?= $formatter->asDate($model->created_at) ?>
                / <?= $authorText ?></small>
        </h3>
		<?= $model->intro ?>
        <p>
			<?= Html::a('Подробнее', \common\helpers\WriterWorkHelper::getWriterWorkFrontendUrl($model), [
				'class'     => 'btn btn-primary',
				'data-pjax' => '0',
			]) ?>
        </p>
    </div>
</div>