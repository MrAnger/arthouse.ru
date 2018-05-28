<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\NewsSearch $searchModel
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
            <p class="text-right">
				<?= Html::a('Создать', ['create', 'authorId' => $author->id], ['class' => 'btn btn-success']) ?>
            </p>

			<?php \yii\widgets\Pjax::begin([
				'enablePushState'    => false,
				'enableReplaceState' => true,
				'timeout'            => 6000,
			]) ?>

			<?= $this->render('/_news-list', [
				'dataProvider' => $dataProvider,
				'searchModel'  => $searchModel,
			]) ?>

			<?php \yii\widgets\Pjax::end() ?>
        </div>
    </div>
</div>
