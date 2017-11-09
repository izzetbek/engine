<?php

namespace core\services\manager\Site;

use core\entities\Site\Banner;
use core\forms\manager\Site\BannerForm;
use core\repositories\Site\BannerRepository;
use core\services\manager\ManagerService;

class BannerManageService extends ManagerService
{
    public function __construct(BannerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(BannerForm $form)
    {
        if ($form->imageFile) {
            $form->thumb = self::saveFile($form->imageFile, 'banners');
        }

        $banner = Banner::create($form->thumb, $form->link, $form->draft, $form->order);
        $this->repository->save($banner);
        return $banner->id;
    }

    public function edit($id, BannerForm $form)
    {
        $banner = $this->repository->get($id);
        /** @var Banner $banner */
        if ($form->imageFile) {
            if ($form->thumb) {
                self::saveFile($form->imageFile, 'banners', $form->thumb);
            } else {
                $form->thumb = self::saveFile($form->imageFile, 'banners');
            }
        }
        $banner->edit($form->thumb, $form->link, $form->draft, $form->order);
        $this->repository->save($banner);
    }

    public function deleteThumb($id)
    {
        $banner = $this->repository->get($id);
        /** $@var Banner $banner */
        if (!$banner->thumb) {
            throw new \DomainException('Image doesn`t exist');
        }
        unlink(\Yii::getAlias('@frontend/web/upload/banners/' . $banner->thumb));
        $banner->thumb = null;
        $this->repository->save($banner);
    }
}