<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \common\models\News $model
 */

use frontend\helpers\AuthorHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$formatter = Yii::$app->formatter;

$authorText = Html::a($model->author->user->displayName, ['/author/view', 'username' => $model->author->user->username]);

$next = $model->getNext();
$prev = $model->getPrev();
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
            <div class="col-md-8">
                <div class="blog-entry">
                    <div class="entry-header">
                        <h1 style="margin-bottom: 0;"><?= $model->name ?></h1>
                    </div>

					<?php if ($model->image_id): ?>
                        <div class="entry-cover">
							<?= Html::img(Yii::$app->imageManager->getThumbnailUrl($model->image, 'frontend-post-head-image'), [
								'alt' => $model->name,
							]) ?>
                        </div>
					<?php endif; ?>

                    <div class="entry-content-details" style="margin-bottom: 10px;">
						<?/*= $formatter->asDate($model->created_at) */?><!-- / --><?= $authorText ?>
                    </div>

                    <div class="entry-content">
						<?= $model->content ?>
                    </div>

                    <div class="prev-next-navigation">
                        <hr>
						<?php if($prev): ?>
                            <div class="pull-left">
								<?= Html::a('<< Предыдущая новость', \common\helpers\NewsHelper::getNewsFrontendUrl($prev)) ?>
                            </div>
						<?php endif; ?>

						<?php if($next): ?>
                            <div class="pull-right">
								<?= Html::a('Следующая новость >>', \common\helpers\NewsHelper::getNewsFrontendUrl($next)) ?>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="sidebar">
					<?= $this->render('_view-other-work-list', [
						'model' => $model,
					]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
