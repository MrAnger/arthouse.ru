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
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="blog-entry">
                <div class="entry-header">
                    <h1><?= $model->name ?></h1>
                </div>

                <div class="entry-content-details">
                    <!--<span>Опубликовано: </span> <?/*= Yii::$app->formatter->asDate($model->created_at) */?> / --><?= $authorText ?></a>
                </div>

                <div class="entry-content">
					<?= $model->content ?>
                </div>
            </div>
        </div>
    </div>
</div>
