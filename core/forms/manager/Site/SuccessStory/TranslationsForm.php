<?php

namespace core\forms\manager\Site\SuccessStory;

use core\entities\Site\SuccessStory\Translation;
use yii\base\Model;

class TranslationsForm extends Model
{
    public $language;
    public $name;
    public $position;
    public $story;

    private $_translation;

    public function formName()
    {
        return 'TranslationsForm_' . $this->language;
    }

    public function __construct($language, Translation $translation = null, array $config = [])
    {
        if($translation) {
            $this->name = $translation->name;
            $this->position = $translation->position;
            $this->story = $translation->story;
            $this->_translation = $translation;
        }
        $this->language = $language;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            [['name', 'position'], 'string', 'max' => 255],
            ['story', 'string']
        ];
    }
}