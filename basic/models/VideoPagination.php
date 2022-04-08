<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class VideoPagination
 * @package app\models
 */
final class VideoPagination extends ActiveRecord
{
    /**
     * @return string[]
     */
    public static function primaryKey(): array
    {
        return ["position"];
    }
}