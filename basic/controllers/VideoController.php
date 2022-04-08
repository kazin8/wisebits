<?php

namespace app\controllers;

use app\components\VideoPaginationHelper;
use app\models\PaginationCount;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;
use app\models\Video;

/**
 * Class VideoController
 * @package app\controllers
 */
class VideoController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $pageSize = $_GET['per-page'] ?? 6;
        $paginationCount = PaginationCount::findOne('videos');
        $totalCount = $paginationCount ? $paginationCount->count : Video::find()->count();
        $sort = $_GET['sort'] ?: '-added';
        $page = $_GET['page'] ?: 1;

        $query = Video::find()->limit($pageSize);
        if (in_array($sort, ['-added', '-views'], true)) {
            $field = trim($sort, "-");
            VideoPaginationHelper::addDescCond($query, $page, $field, $totalCount, $pageSize);
        } elseif (in_array($sort, ['added', 'views'], true)) {
            VideoPaginationHelper::addAscCond($query, $page, $sort, $pageSize);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['added' => SORT_DESC],
                'attributes'   => ['views', 'added'],
            ],
            'pagination' => false,
        ]);

        $pagination = new Pagination([
            'pageSize'   => $pageSize,
            'totalCount' => $totalCount,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'pagination'   => $pagination,
        ]);
    }
}