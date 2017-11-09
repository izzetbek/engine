<?php

namespace core\services\manager\Site;

use core\entities\Meta;
use core\entities\Site\Brand;
use core\forms\manager\Site\BrandForm;
use core\repositories\Site\BrandRepository;

class BrandManageService
{
    private $brands;

    public function __construct(BrandRepository $brands)
    {
        $this->brands = $brands;
    }

    public function create(BrandForm $form): Brand
    {
        $brand = Brand::create(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brands->save($brand);
        return $brand;
    }

    public function edit($id, BrandForm $form): void
    {
        $brand = $this->brands->get($id);
        $brand->edit(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brands->save($brand);
    }

    public function remove($id): void
    {
        $brand = $this->brands->get($id);
        $this->brands->remove($brand);
    }
}