<?php

namespace core\services\manager\Site;

use core\entities\Site\Tag;
use core\forms\manager\Site\TagForm;
use core\repositories\Site\TagRepository;

class TagManageService
{
    private $tags;

    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
    }

    public function create(TagForm $form)
    {
        $tag = Tag::create($form->name, $form->slug);
        $this->tags->save($tag);
        return $tag;
    }

    public function edit($id, TagForm $form)
    {
        $tag = $this->tags->get($id);
        $tag->edit($form->name, $form->slug);
        $this->tags->save($tag);
    }

    public function remove($id)
    {
        $tag = $this->tags->get($id);
        $this->tags->remove($tag);
    }
}