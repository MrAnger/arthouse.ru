<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;

$request = Yii::$app->request;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="shortcut icon" href="/static/images/favicon.ico" type="image/x-icon" />
	<?= Html::csrfMetaTags() ?>

	<title><?= Html::encode($this->title) ?></title>

	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
