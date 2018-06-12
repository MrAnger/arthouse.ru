<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\MusicWork $model
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$formatter = Yii::$app->formatter;

$authorText = Html::a($model->author->user->displayName, ['/author/view', 'username' => $model->author->user->username]);

$imageUrl = $model->image_url;
if ($model->image_id) {
	$imageUrl = Yii::$app->imageManager->getThumbnailUrl($model->image);
}
?>
<div class="thumbnail">
    <div class="caption">
        <div class="row">
            <div class="col-md-3">
				<?php if ($imageUrl): ?>
					<?= Html::img($imageUrl, ['alt' => $model->name, 'style' => 'max-width: 100%;']) ?>
				<?php endif; ?>
            </div>
            <div class="col-md-9">
                <h3>
					<?= $model->name ?>
                    <br>
                    <small style="font-size: small;"><?= $formatter->asDate($model->created_at) ?>
                        / <?= $authorText ?></small>
                </h3>
				<?= $model->description ?>
                <p>
					<?= Html::a('Подробнее', \common\helpers\MusicWorkHelper::getMusicWorkFrontendUrl($model), [
						'class'     => 'btn btn-primary',
						'data-pjax' => '0',
					]) ?>
                </p>
            </div>
        </div>
    </div>
</div>