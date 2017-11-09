<?php

namespace core\services\manager\Site;

use core\entities\Site\Partner;
use core\forms\manager\Site\PartnerForm;
use core\repositories\Site\PartnerRepository;
use core\services\manager\ManagerService;

class PartnerManageService extends ManagerService
{
    public function __construct(PartnerRepository $partners)
    {
        $this->repository = $partners;
    }

    public function create(PartnerForm $form)
    {
        if ($form->imageFile) {
            $form->thumb = self::saveFile($form->imageFile, 'partners');
        }
        $partner = Partner::create($form->title, $form->thumb, $form->link, $form->order, $form->draft);
        $this->repository->save($partner);
        return $partner->id;
    }

    public function edit($id, PartnerForm $form)
    {
        $partner = $this->repository->get($id);
        /** $@var Partner $partner */
        if ($form->imageFile) {
            if ($form->thumb) {
                self::saveFile($form->imageFile, 'partners', $form->thumb);
            } else {
                $form->thumb = self::saveFile($form->imageFile, 'partners');
            }
        }
        $partner->edit($form->title, $form->thumb, $form->link, $form->order, $form->draft);
        $this->repository->save($partner);
    }

    public function deleteThumb($id)
    {
        $partner = $this->repository->get($id);
        /** $@var Partner $partner */
        if (!$partner->thumb) {
            throw new \DomainException('Image doesn`t exist');
        }
        unlink(\Yii::getAlias('@frontend/web/upload/partners/' . $partner->thumb));
        $partner->thumb = null;
        $this->repository->save($partner);
    }
}