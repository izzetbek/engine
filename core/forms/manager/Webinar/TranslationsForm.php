<?php

namespace core\forms\manager\Webinar;

use core\forms\CompositeForm;
use core\entities\Webinar\Translation;
use core\forms\manager\MetaForm;

/**
 * @property \core\forms\manager\MetaForm $meta;
 */
class TranslationsForm extends CompositeForm
{
    public $language;
    public $title;
    public $siteDescription;
    public $cabinetDescription;

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
            $this->siteDescription = $translation->site_description;
            $this->cabinetDescription = $translation->cabinet_description;
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
            ['title', 'string', 'max' => 255],
            [['siteDescription', 'cabinetDescription'], 'string'],
        ];
    }
}