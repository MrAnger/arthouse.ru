<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \common\models\PhotoWork $model
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$formatter = Yii::$app->formatter;

$authorText = Html::a($model->author->user->displayName, ['/author/view', 'username' => $model->author->user->username]);
?>
<div class="container">
    <div class="site-title">
		<?= $author->user->displayName ?>
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

				<?php if (false): ?>
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

					<?php if (!empty($model->images)): ?>
                        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
                            <div class="carousel-inner">
								<?php foreach ($model->getImages()->all() as $index => $image): ?>
                                    <div class="item <?= ($index == 0) ? 'active' : '' ?>">
										<?= Html::img(Yii::$app->imageManager->getOriginalUrl($image), ['alt' => $image->title]) ?>

										<?php if ($image->title || $image->description): ?>
                                            <div class="carousel-caption">
												<?php if ($image->title): ?>
													<?= $image->title ?>
												<?php endif; ?>

												<?php if ($image->description): ?>
                                                    <p style="font-style: italic;"><?= $image->description ?></p>
												<?php endif; ?>
                                            </div>
										<?php endif; ?>
                                    </div>
								<?php endforeach; ?>
                            </div>

                            <!-- Элементы управления -->
                            <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Предыдущий</span>
                            </a>
                            <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Следующий</span>
                            </a>
                        </div>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
