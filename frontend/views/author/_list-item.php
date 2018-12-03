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

$imageUrl = null;
if ($model->user->profile->avatar_image_id) {
	$imageUrl = Yii::$app->imageManager->getThumbnailUrl($model->user->profile->avatarImage, 'frontend-cover-image-preview');
}


?>
<div class="col-md-4">
    <div class="home-post">
        <div class="home-post-cover">
			<a href="<?= $authorUrl ?>">
				<?php if ($imageUrl): ?>
					<?= Html::img($imageUrl, ['alt' => $model->user->profile->name, 'style' => 'max-width: 100%;']) ?>
				<?php else: ?>
					<?= Html::img(['static/images/no-image.jpg'], ['alt' => $model->user->profile->name, 'style' => 'max-width: 100%;']) ?>
				<?php endif; ?>
            </a>
        </div>

        <h2 class="home-post-title">
            <a href="<?= $authorUrl ?>">
				<?= $model->user->profile->name ?>
            </a>
        </h2>

        <div class="intro-text">
			<p>
                <?= $model->user->profile->bio ?>
            </p>
        </div>

        <div class="home-post-more">
            <a class="click-more" href="<?= $authorUrl ?>">Перейти в профиль</a>
        </div>
    </div>
</div>