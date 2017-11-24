<?php

namespace core\forms\manager\Vacancy;

use core\forms\CompositeForm;
use core\entities\Vacancy\Translation;
use core\forms\manager\MetaForm;

/**
 * @property \core\forms\manager\MetaForm $meta;
 */
class TranslationsForm extends CompositeForm
{
    public $language;
    public $title;
    public $location;
    public $description;

    private $_translation;

    public function formName()
    {
        return 'TranslationsForm_' . $this->language;
    }

    public function internalForms()
    {
        return ['meta'];
    }

    public function __construct($language, Translation $translation = null, array $config = [])
    {
        if ($translation) {
            $this->title = $translation->title;
            $this->location = $translation->location;
            $this->description = $translation->description;
            $this->meta = new MetaForm($language, $translation->meta);
            $this->_translation = $translation;
        } else {
            $this->meta = new MetaForm($language);
        }
        $this->language = $language;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['title', 'required'],
            [['title', 'location'], 'string', 'max' => 255],
            ['description', 'string'],
        ];
    }
}