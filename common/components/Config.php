<?php

namespace common\components;

use yii\base\Component;
use core\entities\Config as Entity;

class Config extends Component
{
    protected $data = [];

    public function init()
    {
        $items = Entity::find()->all();
        foreach ($items as $item) {
            /** @var $item Entity */
            if ($item->param) {
                $this->data[$item->param] = $item->value === '' ? $item->default : $item->value;
            }
        }
        parent::init();
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            throw new \DomainException('Undefined parameter ' . $key);
        }
    }

    public function set($key, $value)
    {
        $model = Entity::findOne(['param' => $key]);
        if (!$model) {
            throw new \DomainException('Undefined parameter ' . $key);
        }
        $this->data[$key] = $value;
        $model->value = $value;
        $model->save();
    }
}