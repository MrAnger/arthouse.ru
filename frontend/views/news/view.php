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
<div class="thumbnail">
    <div class="caption">
        <h1>
			<?= $model->name ?>
            <br>
            <small style="font-size: small;"><?= $formatter->asDate($model->created_at) ?> / <?= $authorText ?></small>
        </h1>
		<?= $model->content ?>
    </div>
</div>