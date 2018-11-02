<?php

use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var string $aboutContent
 * @var array $lastWorkList
 * @var \common\models\News[] $newsList
 */

$lastWorkViewMap = [
	\common\models\Cinema::className()      => '//_cinema-work-list-item',
	\common\models\MusicWork::className()   => '//_music-work-list-item',
	\common\models\PainterWork::className() => '//_painter-work-list-item',
	\common\models\PhotoWork::className()   => '//_photo-work-list-item',
	\common\models\WriterWork::className()  => '//_writer-work-list-item',
];
?>
<div class="container">
	<?php if ($aboutContent): ?>
        <!--<div class="intro-text">
			<?= $aboutContent ?>
        </div>-->
	<?php endif; ?>

    <?= $this->render('_index-slider') ?>

	<?php if (!empty($newsList)): ?>
        <!-- Последние новости -->
        <div class="site-title">Последние новости</div>

        <div class="row">
			<?php foreach ($newsList as $news): ?>
				<?= $this->render('//_news-list-item', ['model' => $news]) ?>
			<?php endforeach; ?>
        </div>
        <!-- Последние новости -->
	<?php endif; ?>

	<?php if (!empty($lastWorkList)): ?>
        <!-- Последние работы -->
		<?php foreach ($lastWorkList as $index => $data): ?>
            <div class="site-title"><?= ArrayHelper::getValue($data, 'name') ?></div>

            <div class="row">
				<?php
				/** @var \yii\base\Model[] $items */
				$items = ArrayHelper::getValue($data, 'items');
				?>
				<?php foreach ($items as $item): ?>
					<?= $this->render($lastWorkViewMap[$item::className()], ['model' => $item]) ?>
				<?php endforeach; ?>
            </div>
		<?php endforeach; ?>
        <!-- Последние работы -->
	<?php endif; ?>
</div>
