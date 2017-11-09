<?php

namespace backend\grid;

use core\entities\Site\Category\Category;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $template = "{activate} {deactivate} {view} {update} {delete}";

    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        $this->buttons['deactivate'] = function ($url, $model) {
            /** @var Category $model */
            return $model->isDraft() ? Html::a('<span class="glyphicon glyphicon glyphicon-thumbs-down"></span>', $url, [
                'title' => 'Deactivate',
            ]) : '';
        };
        $this->buttons['activate'] = function ($url, $model) {
            /** @var Category $model */
            return !$model->isDraft() ? Html::a('<span class="glyphicon glyphicon glyphicon-thumbs-up"></span>', $url, [
                'title' => 'Activate',
            ]) : '';
        };
    }
}