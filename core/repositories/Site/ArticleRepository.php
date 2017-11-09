<?php

namespace core\repositories\Site;

use core\repositories\NotFoundException;
use core\entities\Site\Article\Article;

class ArticleRepository
{
    public function get($id)
    {
        if(!$article = Article::findOne($id)) {
            throw new NotFoundException('Article is not found.');
        }
        return $article;
    }

    public function save(Article $article)
    {
        if(!$article->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Article $article)
    {
        if(!$article->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}