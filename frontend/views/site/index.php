<?php

use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var string $aboutContent
 * @var array $lastWorkList
 * @var \common\models\News[] $newsList
 */

$lastWorkViewMap = [
	\common\models\Cinema::class      => '//_cinema-work-list-item',
	\common\models\MusicWork::class   => '//_music-work-list-item',
	\common\models\PainterWork::class => '//_painter-work-list-item',
	\common\models\WriterWork::class  => '//_writer-work-list-item',
];
?>
<?php if ($aboutContent): ?>
	<?= $aboutContent ?>
<?php endif; ?>

<?php if (!empty($lastWorkList)): ?>
    <!-- Последние работы -->
    <div>
        <h3 class="text-center">Последние работы авторов</h3>

        <div class="panel-group" id="accordion">
			<?php foreach ($lastWorkList as $index => $data): ?>
				<?php $itemId = uniqid() ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#<?= $itemId ?>">
								<?= ArrayHelper::getValue($data, 'name') ?>
                            </a>
                        </h4>
                    </div>

                    <div id="<?= $itemId ?>" class="panel-collapse collapse <?= ($index == 0) ? 'in' : '' ?>">
                        <div class="panel-body">
							<?php
							/** @var \yii\base\Model[] $items */
							$items = ArrayHelper::getValue($data, 'items');
							?>
							<?php foreach ($items as $item): ?>
								<?= $this->render($lastWorkViewMap[$item::className()], ['model' => $item]) ?>
							<?php endforeach; ?>
                        </div>
                    </div>
                </div>
			<?php endforeach; ?>
        </div>
    </div>
    <!-- Последние работы -->
<?php endif; ?>

<?php if (!empty($newsList)): ?>
    <!-- Последние новости -->
    <div>
        <h3 class="text-center">Последние новости</h3>

		<?php foreach ($newsList as $news): ?>
			<?= $this->render('//_news-list-item', ['model' => $news]) ?>
		<?php endforeach; ?>
    </div>
    <!-- Последние новости -->
<?php endif; ?>
