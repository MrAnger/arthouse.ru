<?php

Yii::$container->set('yii\jui\DatePicker', [
	'dateFormat' => 'php:Y-m-d',
]);

Yii::$container->set('yii\data\Pagination', [
	'defaultPageSize' => 21,
]);