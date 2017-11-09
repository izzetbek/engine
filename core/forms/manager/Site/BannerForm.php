<?php

namespace core\forms\manager\Site;

use core\entities\Site\Banner;
use yii\web\UploadedFile;
use yii\base\Model;

class BannerForm extends Model
{
    public $thumb;
    /** @var  UploadedFile $imageFile */
    public $imageFile;
    public $link;
    public $order;
    public $draft = true;
    public $isNewRecord = true;

    private $_banner;

    public function __construct(Banner $banner = null, array $config = [])
    {
        if ($banner) {
            $this->thumb = $banner->thumb;
            $this->link = $banner->link;
            $this->order = $banner->order;
            $this->draft = $banner->draft;
            $this->isNewRecord = false;
            $this->_banner = $banner;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['link', 'string', 'max' => 255],
            ['order', 'integer'],
            ['draft', 'boolean'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function getId()
    {
        return $this->_banner->id;
    }
}