<?php

namespace core\forms\manager\Site\Gallery;

use core\entities\Site\Gallery\Gallery;
use core\forms\CompositeForm;

/**
 * Class AlbumForm
 * @package core\forms\manager\Site\Gallery
 * @property TranslationsForm[] $translations
 */
class AlbumForm extends CompositeForm
{
    private $isNewRecord = true;
    private $_album;

    public function __construct(Gallery $album = null, array $config = [])
    {
        $translations = [];
        if ($album) {
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $album->getTranslation($code)->one());
            }
            $this->_album = $album;
            $this->isNewRecord = false;
        } else {
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code);
            }
        }
        $this->translations = $translations;
        parent::__construct($config);
    }

    public function internalForms()
    {
        return ['translations'];
    }

    public function isNewRecord()
    {
        return $this->isNewRecord === true;
    }

    public function getName()
    {
        $object = $this->_album->getTranslation()->one();
        return $object->name;
    }

    public function getAlbum()
    {
        return $this->_album;
    }
}