<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \common\models\Cinema $model
 */

use frontend\helpers\AuthorHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$formatter = Yii::$app->formatter;

$authorText = Html::a($model->author->user->displayName, ['/author/view', 'username' => $model->author->user->username]);
?>
<div class="container">
    <div class="site-title">
        <a href="<?= AuthorHelper::getProfileUrl($author) ?>">
			<?= $author->user->displayName ?>
        </a>
    </div>

	<?= $this->render('//_author-menu', [
		'activeSection' => $activeSection,
		'sectionList'   => $sectionList,
	]) ?>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="<?= $activeSection ?>" style="margin-top: 15px;">
            <div class="blog-entry">
                <div class="entry-header">
                    <h1 style="margin-bottom: 0;"><?= $model->name ?></h1>
                </div>

				<?php if ($model->image_id && false): ?>
                    <div class="entry-cover">
						<?= Html::img(Yii::$app->imageManager->getOriginalUrl($model->image), [
							'alt' => $model->name,
						]) ?>
                    </div>
				<?php endif; ?>

                <div class="entry-content-details" style="margin-bottom: 10px;">
					<?/*= $formatter->asDate($model->created_at) */?><!-- / --><?= $authorText ?>
                </div>

                <div class="entry-content">
					<?= $model->description ?>

					<?php if ($model->video_code): ?>
                        <p class="text-center"><?= $model->video_code ?></p>
					<?php endif; ?>

					<?php if ($model->video_url): ?>
                        <p>
                            <b>Ссылка на
                                видео</b>: <?= Html::a($model->video_url, $model->video_url, ['target' => '_blank']) ?>
                        </p>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
