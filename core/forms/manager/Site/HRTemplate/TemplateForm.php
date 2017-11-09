<?php

namespace core\forms\manager\Site\HRTemplate;

use core\entities\Site\HRTemplate\Template;
use yii\web\UploadedFile;
use core\forms\CompositeForm;

/**
 * Class TemplateForm
 * @property TranslationsForm[] $translations
 */
class TemplateForm extends CompositeForm
{
    public $file;
    /** @var  UploadedFile $imageFile */
    public $textFile;
    public $order;
    public $draft;
    public $isNewRecord = true;

    private $_template;

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct(Template $template = null, array $config = [])
    {
        $translations = [];
        if ($template) {
            $this->file = $template->file;
            $this->order = $template->order;
            $this->draft = $template->draft;
            $this->isNewRecord = false;

            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $template->getTranslation($code)->one());
            }

            $this->_template = $template;
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
        return $this->_template->id;
    }

    public function getName()
    {
        return $this->_template->translation->title;
    }

    public function getPreviewOpts()
    {
        $pieces = explode('.', $this->file);
        $extension = end($pieces);
        switch ($extension) {
            case 'pdf':
                $previewOpts = [
                    'initialPreviewFileType' => 'pdf',
                    'initialPreview' => \Yii::getAlias('@frontendUpload/templates/' . $this->file),
                ];
                break;
            default:
                $previewOpts = [
                    'initialPreviewFileType' => 'html',
                    'initialPreview' => '<a href="' . \Yii::getAlias('@frontendUpload/templates/' . $this->file) . '" target="_blank" class="doc-preview">
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