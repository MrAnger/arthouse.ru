<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Author $model
 * @var string $activeSection
 * @var array $sectionList
 */

$this->title = $model->user->displayName;

$this->params['breadcrumbs'] = [
	['label' => 'Список авторов', 'url' => ['index']],
	$model->user->displayName,
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
			<?= \yii\widgets\DetailView::widget([
				'model'      => $model,
				'attributes' => [
					'user.username',
					'user.profile.name',
					'user.email:email',
					[
						'attribute' => 'user.profile.bio',
						'format'    => 'html',
						'value'     => function (\common\models\Author $model) {
							return nl2br($model->user->profile->bio);
						},
					],
					[
						'label'  => 'Заблокирован?',
						'format' => 'boolean',
						'value'  => $model->user->isBlocked,
					],
					'user.created_at:datetime',
				],
			]) ?>

            <div>
                <a href="<?= Url::to(['update', 'id' => $model->id]) ?>" class="btn btn-success btn-xs">
                    Редактировать автора
                </a>
                <a href="<?= Url::to(['/user/admin/update', 'id' => $model->user_id]) ?>"
                   class="btn btn-primary btn-xs">
                    Редактировать пользователя
                </a>
            </div>
        </div>
    </div>
</div>
