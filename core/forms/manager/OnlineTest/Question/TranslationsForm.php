<?php

namespace core\forms\manager\OnlineTest\Question;

use core\entities\OnlineTest\Question\Translation;
use yii\base\Model;

class TranslationsForm extends Model
{
    public $language;
    public $title;

    private $_translation;

    public function formName()
    {
        return 'TranslationsForm_' . $this->language;
    }

    public function __construct($language, Translation $translation = null, array $config = [])
    {
        if ($translation) {
            $this->title = $translation->title;
            $this->_translation = $translation;

        }
        $this->language = $language;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['title', 'required']
        ];
    }
}