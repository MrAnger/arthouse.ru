<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;

?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>
    <div class="container">
		<?= $content ?>
    </div>
<?php $this->endContent() ?>