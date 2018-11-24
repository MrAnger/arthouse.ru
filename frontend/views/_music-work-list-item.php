<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\MusicWork $model
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

if(!isset($showImageCover)) {
	$showImageCover = true;
}

$formatter = Yii::$app->formatter;

$authorText = Html::a($model->author->user->displayName, ['/author/view', 'username' => $model->author->user->username]);

$modelUrl = \common\helpers\MusicWorkHelper::getMusicWorkFrontendUrl($model);

$imageUrl = $model->image_url;
if ($model->image_id) {
	$imageUrl = Yii::$app->imageManager->getThumbnailUrl($model->image, 'frontend-cover-image-preview');
}else{
	$imageUrl = Yii::$app->imageManager->getThumbnailUrlByFile('@frontend/web/static/images/no-image.jpg', 'frontend-cover-image-preview');
}
?>
<div class="col-md-4">
    <div class="home-post">
        <?php if($showImageCover): ?>
            <div class="home-post-cover">
				<a href="<?= $modelUrl ?>">
					<?= Html::img($imageUrl, ['alt' => $model->name, 'style' => 'max-width: 100%;']) ?>
                </a>
            </div>
        <?php endif; ?>

        <h2 class="home-post-title">
            <a href="<?= $modelUrl ?>">
				<?= $model->name ?>
            </a>
        </h2>

        <div class="home-post-details">
			<?/*= $formatter->asDate($model->created_at) */?><!-- / --><?= $authorText ?>
        </div>

        <div class="intro-text">
			<?= $model->description ?>
        </div>

        <div class="home-post-more">
            <a class="click-more" href="<?= $modelUrl ?>">Подробнее</a>
        </div>
    </div>
</div>