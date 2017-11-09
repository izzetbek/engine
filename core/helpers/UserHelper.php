<?php

namespace core\helpers;

use core\entities\User\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserHelper
{
    public static function statusesList()
    {
        return [
            User::STATUS_WAIT => 'Wait',
            User::STATUS_ACTIVE => 'Active',
        ];
    }

    public static function rolesList()
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusesList(), $status);
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case User::STATUS_WAIT:
                $class = 'label label-default';
                break;
            case User::STATUS_ACTIVE:
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

    public static function roleLabel($role)
    {
        switch ($role) {
            case 'admin':
                $class = 'label label-danger';
                break;
            case 'user':
                $class = 'label label-primary';
                break;
            default:
                $class = 'label label-default';
                break;
        }

        return Html::tag('span', ArrayHelper::getValue(self::rolesList(), $role), [
            'class' => $class
        ]);
    }
}