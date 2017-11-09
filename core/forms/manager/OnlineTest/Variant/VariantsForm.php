<?php

namespace core\forms\manager\OnlineTest\Variant;

use core\entities\OnlineTest\Variant\Variant;
use core\forms\CompositeForm;

/**
 * @property TranslationsForm[] $translations
 */
class VariantsForm extends CompositeForm
{
    public $correct;
    public $iterator;

    private $_variant;


    public function formName()
    {
        return 'VariantsForm_' . $this->iterator;
    }

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct($iterator, Variant $variant = null, $config = [])
    {
        $translations = [];
        if ($variant) {
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $iterator, $variant->getTranslation($code)->one());
            }
            $this->correct = $variant->correct;
            $this->_variant = $variant;
        } else {
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $iterator);
            }
        }
        $this->iterator = $iterator;
        $this->translations = $translations;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['correct', 'boolean'],
        ];
    }

    public function getId()
    {
        return $this->_variant->id;
    }
}