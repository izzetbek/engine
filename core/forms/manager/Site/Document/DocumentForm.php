<?php

namespace core\forms\manager\Site\Document;

use core\entities\Site\Document\Document;
use core\forms\CompositeForm;
use yii\web\UploadedFile;

/**
 * Class DocumentForm
 * @property TranslationsForm[] $translations
 */
class DocumentForm extends CompositeForm
{
    public $file;
    /** @var  UploadedFile $imageFile */
    public $textFile;
    public $order;
    public $draft;
    public $isNewRecord = true;

    private $_document;

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct(Document $document = null, array $config = [])
    {
        $translations = [];
        if ($document) {
            $this->file = $document->file;
            $this->order = $document->order;
            $this->draft = $document->draft;
            $this->isNewRecord = false;

            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $document->getTranslation($code)->one());
            }

            $this->_document = $document;
        } else {
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code);
            }
        }
        $this->translations = $translations;
        parent::__construct($config);
    }

    public function getId()
    {
        return $this->_document->id;
    }

    public function getName()
    {
        return $this->_document->translation->title;
    }

    public function getPreviewOpts()
    {
        $pieces = explode('.', $this->file);
        $extension = end($pieces);
        switch ($extension) {
            case 'pdf':
                $previewOpts = [
                    'initialPreviewFileType' => 'pdf',
                    'initialPreview' => \Yii::getAlias('@frontendUpload/documents/' . $this->file),
                ];
                break;
            default:
                $previewOpts = [
                    'initialPreviewFileType' => 'html',
                    'initialPreview' => '<a href="' . \Yii::getAlias('@frontendUpload/documents/' . $this->file) . '" target="_blank" class="doc-preview">
                                             <span class="fa fa-file-word-o"></span>
                                         </a>'
                ];
                break;
        }
        return $previewOpts;
    }

    public function rules()
    {
        return [
            ['order', 'integer'],
            ['draft', 'boolean'],
            [['textFile'], 'file', 'extensions' => 'doc, pdf, docx'],
        ];
    }
}