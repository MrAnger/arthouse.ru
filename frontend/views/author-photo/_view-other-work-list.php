<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\PhotoWork $model
 */

use frontend\helpers\AuthorHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$authorOtherWorkList = $model->getSimilarAuthorWorkList();
$otherWorkList = $model->getSimilarWorkList();
?>
<div class="widget">
    <div class="tabs">
        <ul class="tab_nav">
            <li class="active"><a href="#author-work-list" data-toggle="tab">Другие работы автора</a></li>
            <li><a href="#work-list" data-toggle="tab">Работы других авторов</a></li>
        </ul>

        <div class="clear"></div>

        <div class="tab-content">
            <div class="tab-pane active" id="author-work-list">
				<?php foreach ($authorOtherWorkList as $work): ?>
					<?php
					$workUrl = \common\helpers\PhotoWorkHelper::getPhotoWorkFrontendUrl($work);
					$workImageUrl = Yii::$app->imageManager->getThumbnailUrl($work->image, 'frontend-cover-image-preview-work-right-col');
					?>
                    <div class="tab-one">
                        <div class="tab-cover">
                            <a href="<?= $workUrl ?>">
								<?= Html::img($workImageUrl, ['alt' => $work->name, 'style' => 'max-width: 100%;']) ?>
                            </a>
                        </div>

                        <h4>
                            <a href="<?= $workUrl ?>">
								<?= $work->name ?>
                            </a>
                        </h4>
                    </div>
				<?php endforeach; ?>

				<?php if(empty($authorOtherWorkList)): ?>
                    <div class="tab-one" style="padding-left: unset;">
                        <p class="text-center">Работ нет...</p>
                    </div>
				<?php endif; ?>
            </div>

            <div class="tab-pane" id="work-list">
				<?php foreach ($otherWorkList as $work): ?>
					<?php
					$workUrl = \common\helpers\PhotoWorkHelper::getPhotoWorkFrontendUrl($work);
					$workImageUrl = Yii::$app->imageManager->getThumbnailUrl($work->image, 'frontend-cover-image-preview-work-right-col');
					$workAuthorText = Html::a(Html::tag('span', $work->author->user->displayName), ['/author/view', 'username' => $model->author->user->username]);
					?>
                    <div class="tab-one">
                        <div class="tab-cover">
                            <a href="<?= $workUrl ?>">
								<?= Html::img($workImageUrl, ['alt' => $work->name, 'style' => 'max-width: 100%;']) ?>
                            </a>
                        </div>

                        <h4>
                            <a href="<?= $workUrl ?>">
								<?= $work->name ?>
                            </a>
                        </h4>

                        <div class="tab-date">
							<?= $workAuthorText ?>
                        </div>
                    </div>
				<?php endforeach; ?>

				<?php if(empty($otherWorkList)): ?>
                    <div class="tab-one" style="padding-left: unset;">
                        <p class="text-center">Работ нет...</p>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
</div>
