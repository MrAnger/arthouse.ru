<?php

use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var string $aboutContent
 * @var array $lastWorkList
 * @var \common\models\News[] $newsList
 */

$lastWorkViewMap = [
	\common\models\Cinema::className()      => 'index/_cinema-work-list-item',
	\common\models\MusicWork::className()   => 'index//_music-work-list-item',
	\common\models\PainterWork::className() => 'index/_painter-work-list-item',
	\common\models\WriterWork::className()  => 'index/_writer-work-list-item',
];
?>
<div class="container">
	<?php if ($aboutContent): ?>
        <div class="intro-text">
			<?= $aboutContent ?>
        </div>
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

	<?php if (!empty($newsList)): ?>
        <!-- Последние новости -->
        <div class="site-title">Последние новости</div>

		<?php foreach ($newsList as $news): ?>
			<?= $this->render('index/_news-list-item', ['model' => $news]) ?>
		<?php endforeach; ?>
        <!-- Последние новости -->
	<?php endif; ?>
</div>
