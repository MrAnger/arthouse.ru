<?php

use yii\helpers\Html;

/**
 * @var \common\models\AuthorRequest $authorRequest
 * @var string $declineReason
 */

?>
<?php if($declineReason): ?>
    <p><?= nl2br($declineReason) ?></p>
<?php else: ?>
    <p>Уважаемый <?= $authorRequest->name ?>.</p>
    <p>На ваш запрос стать автором на сайте <?= Yii::$app->name ?> был получен отказ.</p>
<?php endif; ?>
