<?php

namespace core\services\manager\OnlineTest;

use core\entities\OnlineTest\Question\Question;
use core\entities\OnlineTest\Variant\Variant;
use core\forms\manager\OnlineTest\Question\QuestionForm;
use core\repositories\OnlineTest\QuestionRepository;
use core\services\TransactionManager;

class QuestionManageService
{
    private $repository;
    private $transaction;

    public function __construct(QuestionRepository $repository, TransactionManager $transaction)
    {
        $this->repository = $repository;
        $this->transaction = $transaction;
    }

    public function create(QuestionForm $form)
    {
        $question = Question::create($form->testId, $form->order);
        foreach ($form->translations as $translation) {
            $question->addTranslation($translation->language, $translation->title);
        }
        $this->repository->save($question);
        return $question->id;
    }

    public function edit($id, QuestionForm $form)
    {
        $question = $this->repository->get($id);
        /** @var Question $question */
        $question->edit($form->testId, $form->order);
        $question->revokeTranslations();
        foreach ($form->translations as $translation) {
            $question->addTranslation($translation->language, $translation->title);
        }
        $question->revokeVariants();
        foreach ($form->variants as $variant) {
            $object = Variant::create($variant->correct);
            foreach ($variant->translations as $translation) {
                $object->addTranslation($translation->language, $translation->content);
            }
            $question->addVariant($object);
        }
        $this->repository->save($question);
        return $question;
    }
}