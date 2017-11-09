<?php

namespace core\forms\manager\Site\HRTemplate;

use core\entities\Site\HRTemplate\Translation;
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