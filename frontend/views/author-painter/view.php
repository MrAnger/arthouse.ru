<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \common\models\PainterWork $model
 */

use frontend\helpers\AuthorHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$formatter = Yii::$app->formatter;

$authorText = Html::a($model->author->user->displayName, ['/author/view', 'username' => $model->author->user->username]);

$next = $model->getNext();
$prev = $model->getPrev();

$authorOtherWorkList = $model->getSimilarAuthorWorkList();
$otherWorkList = $model->getSimilarWorkList();
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
            <div class="_row">
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
							<?= $model->description ?>

							<?= $this->render('//_image-gallery', [
								'imageList' => $model->getImages()->all(),
							]) ?>
                        </div>

                        <div class="prev-next-navigation">
                            <hr>
							<?php if($prev): ?>
                                <div class="pull-left">
									<?= Html::a('<< Предыдущая работа', \common\helpers\PainterWorkHelper::getPainterWorkFrontendUrl($prev)) ?>
                                </div>
							<?php endif; ?>

							<?php if($next): ?>
                                <div class="pull-right">
									<?= Html::a('Следующая работа >>', \common\helpers\PainterWorkHelper::getPainterWorkFrontendUrl($next)) ?>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="sidebar">
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
											$workUrl = \common\helpers\PainterWorkHelper::getPainterWorkFrontendUrl($work);
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
											$workUrl = \common\helpers\PainterWorkHelper::getPainterWorkFrontendUrl($work);
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
