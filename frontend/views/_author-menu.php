<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var string $activeSection
 * @var array $sectionList
 */
?>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<?php foreach ($sectionList as $section): ?>
        <li role="presentation" class="<?= (($section['code'] == $activeSection) ? 'active' : '') ?>">
            <a href="<?= Url::to($section['url']) ?>" aria-controls="<?= $section['code'] ?>">
				<?= $section['label'] ?>
            </a>
        </li>
	<?php endforeach; ?>
</ul>