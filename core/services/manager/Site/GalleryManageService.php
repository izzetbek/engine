<?php

namespace core\services\manager\Site;

use core\entities\Site\Gallery\Gallery;
use core\forms\manager\Site\Gallery\AlbumForm;
use core\repositories\Site\GalleryRepository;

class GalleryManageService
{
    private $albums;

    public function __construct(GalleryRepository $albums)
    {
        $this->albums = $albums;
    }

    public function create(AlbumForm $form)
    {
        $album = Gallery::create();
        foreach ($form->translations as $translation) {
            $album->addTranslation($translation->language, $translation->name, $translation->description);
        }
        $this->albums->save($album);
        return $album;
    }

    public function edit($id, AlbumForm $form)
    {
        $album = $this->albums->get($id);
        /** @var Gallery $album */
        $album->edit();
        $album->revokeTranslations();
        foreach ($form->translations as $translation) {
            $album->addTranslation($translation->language, $translation->name, $translation->description);
        }
        $this->albums->save($album);
    }
}