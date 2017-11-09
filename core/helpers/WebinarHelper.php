<?php

namespace core\helpers;

use core\entities\User\User;
use yii\helpers\ArrayHelper;
use core\entities\Webinar\Webinar;
use yii\helpers\Html;

class WebinarHelper
{
    public static function statusesList()
    {
        return [
            Webinar::STATUS_NOT_STARTED => 'Coming',
            Webinar::STATUS_ACTIVE => 'Active',
            Webinar::STATUS_FINISHED => 'Completed',
        ];
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case Webinar::STATUS_NOT_STARTED:
                $class = 'label label-warning';
                break;
            case Webinar::STATUS_ACTIVE:
                $class = 'label label-info';
                break;
            case Webinar::STATUS_FINISHED:
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

    public static function userWebinarsList(User $user)
    {
        $webinars = [];
        foreach ($user->webinars as $webinar) {
            /** @var Webinar $webinar */
            $webinars[$webinar->id] = $webinar->translation->title;
        }
        return $webinars;
    }
}