<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \common\models\News $model
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$formatter = Yii::$app->formatter;

$authorText = Html::a($model->author->user->displayName, ['/author/view', 'username' => $model->author->user->username]);
?>
<div>
    <div class="h1"><?= $author->user->displayName ?></div>

	<?= $this->render('//_author-menu', [
		'activeSection' => $activeSection,
		'sectionList'   => $sectionList,
	]) ?>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="<?= $activeSection ?>" style="margin-top: 15px;">
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
        </div>
    </div>
</div>
