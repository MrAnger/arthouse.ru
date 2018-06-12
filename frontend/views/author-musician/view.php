<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \common\models\MusicWork $model
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
                        <small style="font-size: small;"><?= $formatter->asDate($model->created_at) ?>
                            / <?= $authorText ?></small>
                    </h1>
					<?= $model->description ?>

					<?php if ($model->music_code): ?>
                        <p class="text-center"><?= $model->music_code ?></p>
					<?php endif; ?>

					<?php if ($model->music_url): ?>
                        <p>
                            <b>Ссылка на аудио</b>: <?= Html::a($model->music_url, $model->music_url, ['target' => '_blank']) ?>
                        </p>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
