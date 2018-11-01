<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$profile = $author->user->profile;
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
            <div class="row" style="margin-right: 0;">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="row">
                        <?php if ($profile->avatar_image_id): ?>
                            <div class="col-sm-6 col-md-4">
								<?= Html::img(
									Yii::$app->imageManager->getThumbnailUrl($profile->avatarImage),
									[
										'class' => 'img-rounded img-responsive',
										'alt' => $profile->user->username,
									]
								) ?>
                            </div>
                        <?php endif; ?>

                        <div class="col-sm-6 col-md-8">
                            <h4><?= $this->title ?></h4>
                            <ul style="padding: 0; list-style: none outside none;">
								<?php if (!empty($profile->location)): ?>
                                    <li>
                                        <i class="glyphicon glyphicon-map-marker text-muted"></i>
										<?= Html::encode($profile->location) ?>
                                    </li>
								<?php endif; ?>

								<?php if (!empty($profile->website)): ?>
                                    <li>
                                        <i class="glyphicon glyphicon-globe text-muted"></i>
										<?= Html::a(Html::encode($profile->website), Html::encode($profile->website)) ?>
                                    </li>
								<?php endif; ?>

								<?php if (!empty($profile->public_email)): ?>
                                    <li>
                                        <i class="glyphicon glyphicon-envelope text-muted"></i>
										<?= Html::a(
											Html::encode($profile->public_email),
											'mailto:' .
											Html::encode($profile->public_email)
										)
										?>
                                    </li>
								<?php endif; ?>

                                <li>
                                    <i class="glyphicon glyphicon-time text-muted"></i>
									<?= Yii::t('usuario', 'Joined on {0, date}', $profile->user->created_at) ?>
                                </li>
                            </ul>

							<?php if (!empty($profile->bio)): ?>
                                <p><?= nl2br(Html::encode($profile->bio)) ?></p>
							<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
