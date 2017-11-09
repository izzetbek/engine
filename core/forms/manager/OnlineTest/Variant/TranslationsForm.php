<?php

namespace core\forms\manager\OnlineTest\Variant;

use yii\base\Model;
use core\entities\OnlineTest\Variant\Translation;

class TranslationsForm extends Model
{
    public $language;
    public $iterator;
    public $content;

    private $_translation;

    public function formName()
    {
        return 'VariantTranslationsForm_' . $this ->iterator . '_' . $this->language;
    }

    public function __construct($language, $iterator, Translation $translation = null, array $config = [])
    {
        if ($translation) {
            $this->content = $translation->content;
            $this->_translation = $translation;

        }
        $this->iterator = $iterator;
        $this->language = $language;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['content', 'string']
        ];
    }
}