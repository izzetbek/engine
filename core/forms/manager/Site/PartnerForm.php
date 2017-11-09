<?php

namespace core\forms\manager\Site;

use core\entities\Site\Partner;
use yii\base\Model;
use yii\web\UploadedFile;

class PartnerForm extends Model
{
    public $title;
    public $thumb;
    /** @var  UploadedFile $imageFile */
    public $imageFile;
    public $link;
    public $order;
    public $draft = true;
    public $isNewRecord = true;

    private $_partner;

    public function __construct(Partner $partner = null, array $config = [])
    {
        if ($partner) {
            $this->title = $partner->title;
            $this->thumb = $partner->thumb;
            $this->link = $partner->link;
            $this->order = $partner->order;
            $this->draft = $partner->draft;
            $this->isNewRecord = false;
            $this->_partner = $partner;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title', 'link'], 'required'],
            [['title', 'link'], 'string', 'max' => 255],
            ['order', 'integer'],
            ['draft', 'boolean'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    public function getId()
    {
        return $this->_partner->id;
    }
}