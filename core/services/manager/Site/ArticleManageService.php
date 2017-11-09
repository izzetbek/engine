<?php

namespace core\services\manager\Site;

use core\entities\Meta;
use core\entities\Site\Article\Article;
use core\forms\manager\Site\Article\ArticleForm;
use core\repositories\Site\ArticleRepository;
use core\services\manager\ManagerService;

class ArticleManageService extends ManagerService
{
    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ArticleForm $form)
    {
        if ($form->imageFile) {
            $form->thumb = self::saveFile($form->imageFile, 'articles');
        }
        $article = Article::create($form->thumb, $form->draft, strtotime($form->postDate), $form->slug);
        foreach ($form->translations as $translation) {
            $article->addTranslation(
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
        $this->repository->save($article);
        return $article->id;
    }

    public function edit($id, ArticleForm $form)
    {
        $article = $this->repository->get($id);
        /** $@var Article $article */
        if ($form->imageFile) {
            if ($form->thumb) {
                self::saveFile($form->imageFile, 'articles', $form->thumb);
            } else {
                $form->thumb = self::saveFile($form->imageFile, 'articles');
            }
        }
        $article->edit($form->thumb, $form->draft, strtotime($form->postDate), $form->slug);
        $article->revokeTranslations();
        foreach ($form->translations as $translation) {
            $article->addTranslation(
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
        $this->repository->save($article);
    }

    public function deleteThumb($id)
    {
        $article = $this->repository->get($id);
        /** $@var Article $article */
        if (!$article->thumb) {
            throw new \DomainException('Image doesn`t exist');
        }
        unlink(\Yii::getAlias('@frontend/web/upload/articles/' . $article->thumb));
        $article->thumb = null;
        $this->repository->save($article);
    }
}