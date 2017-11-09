<?php

namespace core\forms\manager;

use core\entities\Meta;
use yii\base\Model;

class MetaForm extends Model
{
    public $language;
    public $title;
    public $description;
    public $keywords;

    public function formName()
    {
        return 'MetaForm_' . $this->language;
    }

    public function __construct($language, Meta $meta = null, array $config = [])
    {
        if($meta) {
            $this->title = $meta->title;
            $this->description = $meta->description;
            $this->keywords = $meta->keywords;
        }
        $this->language = $language;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['title', 'string', 'max' => 255],
            [['description', 'keywords'], 'string']
        ];
    }
}