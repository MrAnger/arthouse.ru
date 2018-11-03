<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \common\models\Theater $model
 * @var \common\models\ImageUploadForm $imageUploadForm
 */

$this->title = 'Создать работу - ' . $author->user->displayName;

$this->params['breadcrumbs'] = [
	['label' => 'Список авторов', 'url' => ['/author/index']],
	['label' => $author->user->displayName, 'url' => ['/author/view', 'id' => $author->id]],
	['label' => 'Театр', 'url' => ['/author-theater/index', 'authorId' => $author->id]],
	'Создать',
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
