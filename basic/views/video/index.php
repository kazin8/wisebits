<?php

use app\widgets\VideoLinkPager;
use app\widgets\VideosLinkSorter;
use app\widgets\PerPager;
use yii\widgets\ListView;

$formatter = \Yii::$app->formatter;
$linkPager = VideoLinkPager::widget([
    'pagination'     => $pagination,
    'firstPageLabel' => 'first',
    'prevPageLabel'  => 'prev',
    'nextPageLabel'  => 'next',
    'lastPageLabel'  => 'last',
]);

$perPageLinks = PerPager::widget([
        'options'  => [6, 10, 50],
        'selected' => $_GET['per-page'],
]);
?>
    <h1>Videos:</h1>
    <div>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => 'video',
            'layout' => "<div style='overflow: auto;'>
<div style='float: left;'>{sorter}</div>
<div style='float: right;'>{$linkPager}</div>
<div style='float: right; margin-right: 20px;'>{$perPageLinks}</div>
</div>{items}",
            'sorter' => [
                'class' => VideosLinkSorter::class,
            ],
        ]) ?>
    </div>