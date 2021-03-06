<?php

namespace core\forms\manager\Site;

use core\entities\Site\Brand;
use core\forms\CompositForm;
use core\forms\manager\MetaForm;
use core\validators\SlugValidator;

/**
 * @property MetaForm $meta;
 */
class BrandForm extends CompositForm
{
    public $name;
    public $slug;

    private $_brand;

    public function internalForms(): array
    {
        return ['meta'];
    }

    public function __construct(\core\entities\Site\Brand $brand = null, array $config = [])
    {
        if($brand) {
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null]
        ];
    }
}