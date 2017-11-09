<?php

namespace core\helpers;

use core\entities\OnlineTest\Test\OnlineTest;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class OnlineTestHelper
{
    public static function statusesList()
    {
        return [
            OnlineTest::STATUS_ACTIVE => 'Active',
            OnlineTest::STATUS_INACTIVE => 'Inactive',
        ];
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case OnlineTest::STATUS_INACTIVE:
                $class = 'label label-danger';
                break;
            case OnlineTest::STATUS_ACTIVE:
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

    public static function testList()
    {
        $tests = OnlineTest::find()->orderBy('created_at DESC')->all();
        $list = [];
        foreach ($tests as $test) {
            $list[$test->id] = $test->translation->title;
        }
        return $list;
    }
}