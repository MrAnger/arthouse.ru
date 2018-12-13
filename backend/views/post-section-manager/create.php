<?php

/**
 * @var yii\web\View $this
 * @var \common\models\post\PostSection $model
 * @var \common\models\post\PostSectionConfig $configModel
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Добавление: ' . Yii::$app->controller::MENU_KEY_SINGLE;
$this->params['breadcrumbs'][] = ['label' => Yii::$app->controller::MENU_KEY, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Добавление';

?>
<?= $this->render('_form', [
	'model'       => $model,
	'configModel' => $configModel,
]) ?>