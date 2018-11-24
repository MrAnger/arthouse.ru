<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \MrAnger\Yii2_ImageManager\models\Image[] $imageList
 */

\common\assets\FancyBoxAsset::register($this);

$imageManager = Yii::$app->imageManager;
?>
<?php if (!empty($imageList)): ?>
    <div class="image-gallery">
		<?php foreach ($imageList as $image): ?>
			<?= Html::a(Html::img($imageManager->getThumbnailUrl($image, [
				'thumbnail' => [
					'width'  => 320,
					'height' => 230,
					'mode'   => \sadovojav\image\Thumbnail::THUMBNAIL_OUTBOUND,
				],
			]), [
				'alt' => $image->title,
			]), $imageManager->getOriginalUrl($image), [
				'data' => [
					'fancybox' => 'image-gallery',
					'caption'  => $image->title,
				],
			]) ?>
		<?php endforeach; ?>
    </div>
<?php endif; ?>
