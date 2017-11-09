<?php

namespace core\forms\manager\Site\Glossary;

use core\entities\Site\Glossary\Glossary;
use core\forms\CompositeForm;

/**
 * Class GlossaryForm
 * @property TranslationsForm[] $translations
 */
class GlossaryForm extends CompositeForm
{
    public $draft;
    public $isNewRecord = true;

    private $_glossary;

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct(Glossary $glossary = null, array $config = [])
    {
        $translations = [];
        if ($glossary) {
            $this->draft = $glossary->draft;
            $this->isNewRecord = false;
            $this->_glossary = $glossary;

            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $glossary->getTranslation($code)->one());
            }
        } else {
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code);
            }
        }
        $this->translations = $translations;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['draft', 'boolean']
        ];
    }

    public function getId()
    {
        return $this->_glossary->id;
    }

    public function getTitle()
    {
        return $this->_glossary->translation->title;
    }
}