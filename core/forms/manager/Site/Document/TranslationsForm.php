<?php

namespace core\forms\manager\Site\Document;

use yii\base\Model;
use core\entities\Site\Document\Translation;

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
        if($translation) {
            $this->title = $translation->title;
            $this->_translation = $translation;
        }
        $this->language = $language;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 255],
        ];
    }
}