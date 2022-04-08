<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class PaginationCount
 * @package app\models
 */
final class PaginationCount extends ActiveRecord
{
    /**
     * @return string[]
     */
    public static function primaryKey(): array
    {
        return ["table"];
    }
}