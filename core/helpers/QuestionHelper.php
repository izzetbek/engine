<?php

namespace core\helpers;

use core\entities\Cabinet\Question;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class QuestionHelper
{
    public static function statusesList()
    {
        return [
            Question::STATUS_WAIT => 'Waiting for answer',
            Question::STATUS_ANSWERED => 'Answered',
        ];
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case Question::STATUS_WAIT:
                $class = 'label label-warning';
                break;
            case Question::STATUS_ANSWERED:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
                break;
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusesList(), $status), [
            'class' => $class
        ]);
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusesList(), $status);
    }

    public static function buildTree($data, $rootID = null)
    {
        $tree = [];
        foreach ($data as $id => $node) {
            if ($node['parent_id'] == $rootID) {
                unset($data[$id]);
                $node['childs'] = self::buildTree($data, $node['id']);
                $tree[] = $node;
            }
        }
        return $tree;
    }
}