<?php

namespace core\entities\Site;

use core\entities\behaviors\MetaBehavior;
use core\entities\Meta;
use yii\db\ActiveRecord;

/**
 * Class Brand
 * @package shop\entities\Shop
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property Meta $meta
 */
class Brand extends ActiveRecord
{
    public $meta;

    public static function tableName()
    {
        return '{{%site_brands}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => MetaBehavior::class,
                'attribute' => 'meta',
                'jsonAttribute' => 'meta_json',
            ],
        ];
    }

    public static function create($name, $slug, Meta $meta)
    {
        $brand = new static();
        $brand->name = $name;
        $brand->slug = $slug;
        $brand->meta = $meta;
        return $brand;
    }

    public function edit($name, $slug, Meta $meta)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->meta = $meta;
    }
}