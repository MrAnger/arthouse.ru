<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 */

$dummyModel = new \backend\models\AuthorRequestDeclineForm();

$this->registerJs(<<<JS
(function() {
    var modal = $('#modal-author-request-decline'),
        form = modal.find('form'),
        requestIdInput = form.find('.js-request-id-input');

    modal.on('show.bs.modal', function (e) {
        var relatedTarget = e.relatedTarget;

        // Обнуляем значения полей ввода
        requestIdInput.val('');
        //form.find('textarea').val('');
        
        requestIdInput.val($(relatedTarget).data('id'));
        
        form.yiiActiveForm('resetForm');
    });
    
    form.on('beforeSubmit', function (e) {
        $.post(form.attr('action'), form.serialize(), function (response) {
            if (response.status) {
                modal.modal('hide');
            }
            
            location.reload();
        }).fail(function(response) {
            console.log(response);
            
            alert("Произошла ошибка во время обработки запроса.");
        });
        
        return false;
    });
})();
JS
);
?>
<div id="modal-author-request-decline" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Отклонение заявки</h4>
            </div>

            <div class="modal-body">
				<?php $form = \yii\widgets\ActiveForm::begin([
					'enableClientValidation' => false,
					'enableAjaxValidation'   => true,
					'action'                 => ['decline'],
					'validationUrl'          => ['validate-decline-form'],
				]) ?>

				<?= Html::activeHiddenInput($dummyModel, 'requestId', [
					'class' => 'js-request-id-input',
				]) ?>

				<?= $form->field($dummyModel, 'comment')
					->textarea([
						'maxlength' => true,
						'rows'      => 7,
					]) ?>

				<?php $form->end() ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button form="<?= $form->id ?>" type="submit" class="btn btn-primary">Отклонить заявку</button>
            </div>
        </div>
    </div>
</div>
