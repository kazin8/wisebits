<?php

use yii\helpers\Html;

$formatter = \Yii::$app->formatter;
?>

<div style="margin: 20px; float: left;">
    <?= Html::encode("{$model->title}") ?> <br/>
    <span style="color:blue;">&asymp;</span>
    <?= $model->getFormattedDuration(); ?>
    <br/>
    <video width=300 src="<?= $model->thumbnail ?>" controls>
        <?= Html::encode("{$model->title}") ?>
    </video>
    <br/>
    <span style="color:blue;">&#9022;</span> <?= $formatter->asInteger($model->views) ?>
    <span style="color:blue;">&#9782;</span> <?= $formatter->asDate($model->added); ?>
</div>