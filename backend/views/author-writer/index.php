<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\WriterWorkSearch $searchModel
 */

$this->title = 'Писательские работы - ' . $author->user->displayName;

$this->params['breadcrumbs'] = [
	['label' => 'Список авторов', 'url' => ['/author/index']],
	['label' => $author->user->displayName, 'url' => ['/author/view', 'id' => $author->id]],
	'Писательские работы',
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
            <p class="text-right">
				<?= Html::a('Создать', ['create', 'authorId' => $author->id], ['class' => 'btn btn-success']) ?>
            </p>

			<?php \yii\widgets\Pjax::begin([
				'enablePushState'    => false,
				'enableReplaceState' => true,
				'timeout'            => 6000,
			]) ?>

			<?= \yii\grid\GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel'  => $searchModel,
				'tableOptions' => ['class' => 'table table-hover'],
				'columns'      => [
					'name',
					[
						'attribute' => 'slug',
						'format'    => 'raw',
						'value'     => function (\common\models\WriterWork $model) {
							$url = \common\helpers\WriterWorkHelper::getWriterWorkFrontendUrl($model);

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
