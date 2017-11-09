<?php

namespace core\services\manager\Site;

use core\entities\Meta;
use core\entities\Site\Category\Category;
use core\forms\manager\Site\Category\CategoryForm;
use core\repositories\Site\CategoryRepository;
use yii\db\ActiveRecord;

class CategoryManageService
{
    private $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function create(CategoryForm $form)
    {
        $category = Category::create(
            $form->name,
            $form->slug,
            $form->draft
        );
        foreach ($form->translations as $translation) {
            $category->addTranslation(
                $translation->language,
                $translation->title,
                $translation->description,
                new Meta(
                    $translation->meta->title,
                    $translation->meta->description,
                    $translation->meta->keywords
                )
            );
        }
        if ($form->parentId) {
            $parent = $this->categories->get($form->parentId);
            /** @var Category $parent */
            $category->appendTo($parent);
        } else {
            $category->makeRoot();
        }
        $this->categories->save($category);
        return $category;
    }

    public function edit($id, CategoryForm $form)
    {
        $category = $this->categories->get($id);
        /** @var Category $category */
        $this->assertIsNotRoot($category);
        $category->edit(
            $form->name,
            $form->slug,
            $form->draft
        );
        $category->revokeTranslations();
        foreach ($form->translations as $translation) {
            $category->addTranslation(
                $translation->language,
                $translation->title,
                $translation->description,
                new Meta(
                    $translation->meta->title,
                    $translation->meta->description,
                    $translation->meta->keywords
                )
            );
        }
        if($form->parentId !== $category->parent->id) {
            $parent = $this->categories->get($form->parentId);
            /** @var Category $parent */
            $category->appendTo($parent);
        }
        $this->categories->save($category);
    }

    public function moveUp($id)
    {
        $category = $this->categories->get($id);
        /** @var Category $category */
        $this->assertIsNotRoot($category);
        if ($prev = $category->getPrev()) {
            /** @var ActiveRecord $prev */
            $category->insertBefore($prev);
        }
        $this->categories->save($category);
    }

    public function moveDown($id)
    {
        $category = $this->categories->get($id);
        /** @var Category $category */
        $this->assertIsNotRoot($category);
        if ($next = $category->getNext()) {
            /** @var ActiveRecord $next */
            $category->insertAfter($next);
        }
        $this->categories->save($category);
    }

    public function remove($id)
    {
        $category = $this->categories->get($id);
        /** @var Category $category */
        $this->assertIsNotRoot($category);
        $this->categories->remove($category);
    }

    private function assertIsNotRoot(Category $category)
    {
        if($category->isRoot()) {
            throw new \DomainException('Root category can`t be modified.');
        }
    }
}