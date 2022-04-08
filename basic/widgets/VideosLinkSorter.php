<?php

namespace app\widgets;

use yii\helpers\Html;
use yii\widgets\LinkSorter;


class VideosLinkSorter extends LinkSorter
{
    /**
     * Renders the sort links.
     * @return string the rendering result
     */
    protected function renderSortLinks()
    {
        $attributes = empty($this->attributes) ? array_keys($this->sort->attributes) : $this->attributes;
        $links = [];
        foreach ($attributes as $name) {
            $links[] = $this->sort->link($name, $this->linkOptions);
        }

        return Html::tag('div', "Sort by: " . implode(" ", $links));
    }
}
