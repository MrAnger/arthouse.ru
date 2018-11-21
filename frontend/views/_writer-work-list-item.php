<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\WriterWork $model
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$formatter = Yii::$app->formatter;

$authorText = Html::a($model->author->user->displayName, ['/author/view', 'username' => $model->author->user->username]);

$modelUrl = \common\helpers\WriterWorkHelper::getWriterWorkFrontendUrl($model);
?>
<div class="col-md-4">
    <div class="home-post">
        <h2 class="home-post-title">
            <a href="<?= $modelUrl ?>">
				<?= $model->name ?>
            </a>
        </h2>

        <div class="home-post-details">
			<?/*= $formatter->asDate($model->created_at) */?><!-- / --><?= $authorText ?>
        </div>

        <div class="intro-text">
			<?= $model->intro ?>
        </div>

        <div class="home-post-more">
            <a class="click-more" href="<?= $modelUrl ?>">Подробнее</a>
        </div>
    </div>
</div>