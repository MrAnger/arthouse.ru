<?php

/**
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<?= $this->render('//_main-menu') ?>

<?php if (Yii::$app->user->isGuest): ?>
	<?= $this->render('_login-form') ?>
<?php else: ?>
	<?= $this->render('//_user-menu') ?>
<?php endif; ?>
