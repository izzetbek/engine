<?php

namespace common\components;

use yii\base\Component;
use core\entities\Config as Entity;
use yii\db\Connection;

class Config extends Component
{
    public $cache = 0;
    public $dependency = null;

    protected $data = [];

    public function init()
    {
        $items = $this->getItems();
        foreach ($items as $item) {
            /** @var $item Entity */
            if ($item['param']) {
                $this->data[$item['param']] = $item['value'] === '' ? $item['default'] : $item['value'];
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

    protected function getItems()
    {
        $db = \Yii::$app->db;

        if ($this->cache) {
            $items = $db->cache(function ($db) {
                /** @var Connection $db */
                return $db->createCommand('SELECT * FROM {{config}}')->queryAll();
            }, $this->cache, $this->dependency);
        } else {
            $items = $db->createCommand('SELECT * FROM {{config}}')->queryAll();
        }

        return $items;
    }
}