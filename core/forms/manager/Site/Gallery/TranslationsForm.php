<?php

namespace core\forms\manager\Site\Gallery;

use core\entities\Site\Gallery\Translation;
use yii\base\Model;

class TranslationsForm extends Model
{
    public $language;
    public $name;
    public $description;

    private $_translation;

    public function formName()
    {
        return 'TranslationsForm_' . $this->language;
    }

    public function __construct($language, Translation $translation = null, array $config = [])
    {
        if($translation) {
            $this->name = $translation->name;
            $this->description = $translation->description;
            $this->_translation = $translation;
        }
        $this->language = $language;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['description', 'string']
        ];
    }
}