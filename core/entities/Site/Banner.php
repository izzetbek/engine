<?php

namespace core\entities\Site;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $thumb
 * @property string $link
 * @property boolean $draft
 * @property int $order
 */
class Banner extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%banners}}';
    }

    public static function create($thumb, $link, $draft, $order)
    {
        $banner = new self();
        $banner->thumb = $thumb;
        $banner->link = $link;
        $banner->draft = $draft;
        $banner->order = $order;
        return $banner;
    }

    public function edit($thumb, $link, $draft, $order)
    {
        $this->thumb = $thumb;
        $this->link = $link;
        $this->draft= $draft;
        $this->order = $order;
    }

    public function isDraft()
    {
        return $this->draft == true;
    }
}