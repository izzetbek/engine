<?php

namespace core\repositories\Site;

use core\entities\Site\Category\Category;
use core\repositories\NotFoundException;

class CategoryRepository
{
    public function get($id)
    {
        if(!$category = Category::findOne($id)) {
            throw new NotFoundException('Category is not found.');
        }
        return $category;
    }

    public function save(Category $category)
    {
        if(!$category->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Category $category)
    {
        if(!$category->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}