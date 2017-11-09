<?php

namespace core\entities\Site;

use yii\db\ActiveRecord;

/**
 * Class Partner
 * @package core\entities\Site
 * @property integer $id
 * @property string $title
 * @property string $thumb
 * @property string $link
 * @property integer $order
 * @property integer $draft
 */
class Partner extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%partners}}';
    }

    public static function create($title, $thumb, $link, $order, $draft)
    {
        $partner = new static();
        $partner->title = $title;
        $partner->thumb = $thumb;
        $partner->link = $link;
        $partner->order = $order;
        $partner->draft = $draft;
        return $partner;
    }

    public function edit($title, $thumb, $link, $order, $draft)
    {
        $this->title = $title;
        $this->thumb = $thumb;
        $this->link = $link;
        $this->order = $order;
        $this->draft = $draft;
    }

    public function getPrevious()
    {
        if(!$previous = self::find()->where(['<=', 'order', $this->order])->orderBy('order DESC')->limit(1)->one()) {
            throw new \DomainException('It is the first element');
        }
        return $previous;
    }

    public function getNext()
    {
        if(!$previous = self::find()->where(['>=', 'order', $this->order])->orderBy('order')->limit(1)->one()) {
            throw new \DomainException('It is the first element');
        }
        return $previous;
    }

    public function isDraft()
    {
        return $this->draft == true;
    }
}