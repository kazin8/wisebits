<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Url;

/**
 * Class PerPager
 * @package app\widgets
 */
class PerPager extends Widget
{
    /**
     * @var int[]
     */
    public $options = [10, 50];

    /**
     * @var int
     */
    public $selected;

    /**
     * @return string
     */
    public function run()
    {
        $links = [];
        foreach ($this->options as $option) {
            $params = ['video/index', 'per-page' => $option] + $_GET;
            $links[$option] = Url::to($params) ;
        }

        return $this->render('per_page', [
            'links'    => $links,
            'selected' => $this->selected,
        ]);
    }
}
