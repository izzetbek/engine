<?php

namespace core\helpers;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class FieldHelper
{
    public static function draftList()
    {
        return [
            true => 'Active',
            false => 'Inactive',
        ];
    }

    public static function draftLabel($status)
    {
        switch ($status) {
            case false:
                $class = 'label label-danger';
                break;
            case true:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-danger';
                break;
        }

        return Html::tag('span', ArrayHelper::getValue(self::draftList(), $status), [
            'class' => $class
        ]);
    }

    public static function duration($from, $to)
    {
        return \Yii::$app->formatter->asDate($from) . ' / ' . \Yii::$app->formatter->asDate($to);
    }
}