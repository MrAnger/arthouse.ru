<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 */

$emptyModel = new \MrAnger\Yii2_ImageManager\models\Image();
?>
<!-- Modal Image Update -->
<div class="modal fade" id="modal-image-update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Изменить описание изображения</h4>
            </div>
            <div class="modal-body">
				<?php $form = \yii\widgets\ActiveForm::begin([
					'enableClientValidation' => false,
				]) ?>

				<?= $form->field($emptyModel, 'title')
					->textInput([
						'maxlength' => true,
					]) ?>

				<?= $form->field($emptyModel, 'description')
					->textInput([
						'maxlength' => true,
					]) ?>

                <div class="text-right">
					<?= Html::submitButton(Yii::t('app.actions', 'Submit'), ['class' => 'btn btn-primary']) ?>
                </div>

				<?php \yii\widgets\ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>
