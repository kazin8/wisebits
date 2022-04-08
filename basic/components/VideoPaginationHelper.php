<?php

namespace app\components;

use app\models\VideoPagination;
use yii\db\ActiveQueryInterface;

/**
 * Class PaginationHelper
 * @package app\widgets
 */
class VideoPaginationHelper
{
    const DEFAULT_BATCH_SIZE = 1000;

    /**
     * @param ActiveQueryInterface $query
     * @param int $page
     * @param string $field
     * @param int $totalCount
     * @param int $pageSize
     * @param int $batchSize
     */
    public static function addDescCond(
        ActiveQueryInterface $query,
        int $page,
        string $field,
        int $totalCount,
        int $pageSize,
        int $batchSize = self::DEFAULT_BATCH_SIZE
    ): void {
        $firstElement = ($page - 1) * $pageSize;
        $position = (int)(($totalCount - $firstElement) / $batchSize) * $batchSize + $batchSize;
        $videoPagination = VideoPagination::findOne(['position' => $position]);

        if ($videoPagination) {
            $offset = $batchSize - (($totalCount - $firstElement) % $batchSize);
            $query->where(['<=', $field, $videoPagination->$field])->offset($offset);
        } elseif ($firstElement) {
            $offset = $firstElement;

            $query->offset($offset);
        }
    }

    /**
     * @param ActiveQueryInterface $query
     * @param int $page
     * @param string $field
     * @param int $pageSize
     * @param int $batchSize
     */
    public static function addAscCond(
        ActiveQueryInterface $query, 
        int $page, 
        string $field,
        int $pageSize, 
        int $batchSize = self::DEFAULT_BATCH_SIZE
    ): void {
        $firstElement = ($page - 1) * $pageSize;
        $position = (int)($firstElement / $batchSize) * $batchSize;
        $videoPagination = VideoPagination::findOne(['position' => $position]);

        if ($videoPagination) {
            $offset = $firstElement - $videoPagination->position;
            $query->where(['>=', $field, $videoPagination->$field])->offset($offset);
        } else {
            $offset = $firstElement;
            $query->offset($offset);
        }
    }
}