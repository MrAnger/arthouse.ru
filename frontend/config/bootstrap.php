<?php

Yii::$container->set('yii\jui\DatePicker', [
	'dateFormat' => 'php:Y-m-d',
]);

Yii::$container->set('yii\data\Pagination', [
	'defaultPageSize' => 21,
]);

Yii::$container->set('yii\widgets\ListView', [
	'emptyText' => <<<HTML
В данном разделе работы временно отсутствуют. Вы можете предложить свои, отправив нам заявку на <a href="mailto:author@artxayc.ru" style="color: black; font-weight: bold; text-decoration: underline;">author@artxayc.ru</a>.
HTML
,
	'emptyTextOptions' => [
		'class' => 'col-md-12 empty'
	],
]);