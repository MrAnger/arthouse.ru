<?php

/**
 * @var $this \yii\web\View
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use frontend\helpers\AuthorHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<div class="container">
    <a href="<?= AuthorHelper::getProfileUrl($author) ?>">
		<?= $author->user->displayName ?>
    </a>

	<?= $this->render('//_author-menu', [
		'activeSection' => $activeSection,
		'sectionList'   => $sectionList,
	]) ?>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="<?= $activeSection ?>" style="margin-top: 15px;">
			<?= \yii\widgets\ListView::widget([
				'dataProvider' => $dataProvider,
				'layout'       => "{summary}\n{items}\n<div class='col-md-12 text-center'>{pager}</div>",
				'summary'      => false,
				'itemOptions'  => [
					'tag' => false,
				],
				'options'      => [
					'class' => 'row',
					'style' => 'margin-right: 0;',
				],
				'itemView'     => function ($model, $key, $index, $widget) {
					return $this->render('//_cinema-work-list-item', [
						'model' => $model,
					]);
				},
			]) ?>
        </div>
    </div>
</div>
