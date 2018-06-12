<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<div>
    <h1><?= $author->user->displayName ?></h1>

	<?= $this->render('//_author-menu', [
		'activeSection' => $activeSection,
		'sectionList'   => $sectionList,
	]) ?>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="<?= $activeSection ?>" style="margin-top: 15px;">
			<?php \yii\widgets\Pjax::begin([
				'enablePushState'    => false,
				'enableReplaceState' => true,
				'timeout'            => 6000,
			]) ?>

			<?= \yii\widgets\ListView::widget([
				'dataProvider' => $dataProvider,
				'summary'      => false,
				'itemOptions'  => [
					'tag' => false,
				],
				'itemView'     => function ($model, $key, $index, $widget) {
					return $this->render('//_news-list-item', [
						'model' => $model,
					]);
				},
			]) ?>

			<?php \yii\widgets\Pjax::end() ?>
        </div>
    </div>
</div>
