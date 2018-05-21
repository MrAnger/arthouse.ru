<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\NewsSearch = $searchModel
 */

$this->title = 'Новости - ' . $author->user->displayName;

$this->params['breadcrumbs'] = [
	['label' => 'Список авторов', 'url' => ['/author/index']],
	['label' => $author->user->displayName, 'url' => ['/author/view', 'id' => $author->id]],
	'Новости',
];

?>
<div>
	<?= $this->render('//_author-menu', [
		'activeSection' => $activeSection,
		'sectionList'   => $sectionList,
	]) ?>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="<?= $activeSection ?>">
			<?php \yii\widgets\Pjax::begin([
				'enablePushState'    => false,
				'enableReplaceState' => true,
				'timeout'            => 6000,
			]) ?>

			<?= \yii\grid\GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel'  => $searchModel,
				'columns'      => [
					'name',
					[
						'attribute' => 'slug',
						'format'    => 'raw',
						'value'     => function (\common\models\News $model) {
							$url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/news/view-by-slug', 'slug' => $model->slug], true);

							return Html::a($url, $url, [
								'target'    => '_blank',
								'data-pjax' => 0,
							]);
						},
					],
					[
						'attribute' => 'created_at',
						'format'    => 'datetime',
						'filter'    => false,
					],
					[
						'class'         => \yii\grid\ActionColumn::class,
						'template'      => '{update} {delete}',
						'filterOptions' => [
							'class' => 'action-column',
						],
						'headerOptions' => [
							'class' => 'action-column',
						],
						'options'       => [
							'class' => 'action-column',
						],
					],
				],
			]) ?>

			<?php \yii\widgets\Pjax::end() ?>
        </div>
    </div>
</div>
