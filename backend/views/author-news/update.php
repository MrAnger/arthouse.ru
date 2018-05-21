<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Author $author
 * @var string $activeSection
 * @var array $sectionList
 * @var \common\models\News $model
 */

$this->title = $model->name . ' - Новости - ' . $author->user->displayName;

$this->params['breadcrumbs'] = [
	['label' => 'Список авторов', 'url' => ['/author/index']],
	['label' => $author->user->displayName, 'url' => ['/author/view', 'id' => $author->id]],
	['label' => 'Новости', 'url' => ['/author-news/index', 'authorId' => $author->id]],
	$model->name,
];

$newsUrl = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/news/view-by-slug', 'slug' => ''], true);
?>
<div>
	<?= $this->render('//_author-menu', [
		'activeSection' => $activeSection,
		'sectionList'   => $sectionList,
	]) ?>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="<?= $activeSection ?>">
			<?php $form = \yii\widgets\ActiveForm::begin([
				'enableClientValidation' => false,
			]) ?>

            <div class="row">
                <div class="col-md-8">
					<?= $form->field($model, 'name')
						->textInput(['maxlength' => true])
					?>

					<?= $form->field($model, 'slug')
						->textInput([
							'maxlength'   => true,
							'placeholder' => $newsUrl,
						])
					?>

                    <?= $form->field($model, 'intro')->widget(\mranger\ckeditor\CKEditor::class) ?>

                    <?= $form->field($model, 'content')->widget(\mranger\ckeditor\CKEditor::class) ?>
                </div>

                <div class="col-md-4">

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
					<?= $form->errorSummary($model) ?>

					<?= Html::submitButton(Yii::t('app.actions', 'Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>

			<?php \yii\widgets\ActiveForm::end() ?>
        </div>
    </div>
</div>
