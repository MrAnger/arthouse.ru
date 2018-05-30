<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \common\models\MusicWork $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$this->title = $model->name . ' - Кинемотограф - ' . $author->user->displayName;

$this->params['breadcrumbs'] = [
	['label' => 'Список авторов', 'url' => ['/author/index']],
	['label' => $author->user->displayName, 'url' => ['/author/view', 'id' => $author->id]],
	['label' => 'Музыкальные работы', 'url' => ['/author-musician/index', 'authorId' => $author->id]],
	$model->name,
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
			<?= $this->render('_form', [
				'model'           => $model,
				'imageUploadForm' => $imageUploadForm,
			]) ?>
        </div>
    </div>
</div>
