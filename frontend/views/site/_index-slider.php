<?php

use common\models\Slider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 */

$slider = Slider::findOne([
	'code'       => 'main_page_top_slider',
	'is_enabled' => true,
]);

/** @var \common\models\SliderItem[] $sliderItems */
$sliderItems = [];
if ($slider) {
	$sliderItems = $slider->getItems()
		->andWhere(['=', 'is_enabled', 1])
		->all();
}
?>
<?php if (!empty($sliderItems)): ?>
    <div class="the-slider" data-tesla-plugin="slider" data-tesla-item=".slide" data-tesla-next=".slide-right"
         data-tesla-prev=".slide-left" data-tesla-container=".slide-wrapper">
        <div class="row">
            <div class="col-md-8 slider-left">
                <div class="slide-arrows">
                    <div class="slide-left"></div>
                    <div class="slide-right"></div>
                </div>

                <ul class="slide-wrapper">
					<?php foreach ($sliderItems as $sliderItem): ?>
                        <li class="slide">
							<?= Html::img(Yii::$app->imageManager->getThumbnailUrl($sliderItem->image, [
								'thumbnail' => [
									'width'  => 900,
									'height' => 450,
									'mode'   => \sadovojav\image\Thumbnail::THUMBNAIL_OUTBOUND,
								],
							]), [
								'alt' => $sliderItem->name,
							]) ?>
                        </li>
					<?php endforeach; ?>
                </ul>

                <ul class="the-bullets-dots" data-tesla-plugin="bullets">
					<?php foreach ($sliderItems as $sliderItem): ?>
                        <!--<li><span></span></li>-->
					<?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-4 slider-right">
                <ul class="the-bullets" data-tesla-plugin="bullets">
					<?php foreach ($sliderItems as $sliderItem): ?>
                        <li style="height: <?= 100/count($sliderItems) ?>%;">
                            <h4><?= $sliderItem->name ?></h4>
							<?= $sliderItem->description ?>
                        </li>
					<?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>