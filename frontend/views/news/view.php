<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\News $model
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$formatter = Yii::$app->formatter;

$authorText = "<b>Администратор</b>";
if ($model->author_id) {
	$authorText = Html::a($model->author->user->displayName, ['/author/view', 'username' => $model->author->user->username]);
}

$next = $model->getNext();
$prev = $model->getPrev();
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="blog-entry">
                <div class="entry-header">
                    <h1><?= $model->name ?></h1>
                </div>

				<?php if ($model->image_id): ?>
                    <div class="entry-cover">
						<?= Html::img(Yii::$app->imageManager->getOriginalUrl($model->image), [
							'alt' => $model->name,
						]) ?>
                    </div>
				<?php endif; ?>

                <div class="entry-content-details">
                    <!--<span>Опубликовано: </span> <?/*= Yii::$app->formatter->asDate($model->created_at) */?> / --><?= $authorText ?></a>
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
