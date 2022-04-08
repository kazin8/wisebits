<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Video
 * @package app\models
 */
final class Video extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'videos';
    }

    /**
     * @return string
     */
    public function getFormattedDuration(): string
    {
        return $this->duration > 60 * 60 ?
            gmdate("H:i:s", $this->duration) :
            gmdate("i:s", $this->duration);
    }
}