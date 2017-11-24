<?php

namespace core\services\cabinet;

use core\entities\Cabinet\Answer;
use core\entities\Cabinet\Question;
use core\entities\User\User;
use core\forms\cabinet\QuestionForm;
use core\forms\cabinet\AnswerForm;
use core\repositories\Cabinet\AnswerRepository;
use core\repositories\Cabinet\QuestionRepository;
use core\repositories\UserRepository;
use yii\helpers\StringHelper;
use yii\mail\MailerInterface;

class QuestionService
{
    private $adminEmail;
    private $mailer;
    private $questions;
    private $answers;
    private $users;

    public function __construct($adminEmail, MailerInterface $mailer, QuestionRepository $questions, AnswerRepository $answers, UserRepository $users)
    {
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
        $this->questions = $questions;
        $this->answers = $answers;
        $this->users = $users;
    }

    public function ask(QuestionForm $form)
    {
        $question = Question::create(\Yii::$app->user->id, $form->title, $form->body);
        $this->questions->save($question);

        $sent = $this->mailer->compose()
            ->setTo($this->adminEmail)
            ->setSubject('Question from webinar participant ')
            ->setTextBody($form->body)
            ->send();
        if(!$sent) {
            throw new \RuntimeException('Mail sending error.');
        }
    }

    public function edit($id, QuestionForm $form)
    {
        $question = $this->questions->get($id);
        /** @var Question $question */
        if (!$question->isFrom(\Yii::$app->user->id)) {
            throw new \DomainException('Question doesn`t belong to this user');
        }
        $question->edit($form->title, $form->body);
        $this->questions->save($question);
    }

    public function editAnswer($id, AnswerForm $form)
    {
        $answer = $this->answers->get($id);
        /** @var Answer $answer */
        if (!$answer->isFrom(\Yii::$app->user->id)) {
            throw new \DomainException('Answer doesn`t belong to this user');
        }
        $answer->edit($form->content);
        $this->answers->save($answer);
    }

    public function answer($id, AnswerForm $form)
    {
        $answer = Answer::create(\Yii::$app->user->id, $id, $form->content);
        $this->answers->save($answer);

        $question = $this->questions->get($id);
        /** @var Question $question */

        $user = $this->users->get($question->user_id);
        /** @var User $user */

        $sent = $this->mailer->compose()
            ->setTo($user->email)
            ->setSubject('New answer for your question: ' . $question->title)
            ->setTextBody($form->content)
            ->send();
        if(!$sent) {
            throw new \RuntimeException('Mail sending error.');
        }
    }

    public function attach($id, AnswerForm $form)
    {
        $parentAnswer = $this->answers->get($id);
        /** @var Answer $parentAnswer */
        $answer = Answer::create(\Yii::$app->user->id, $parentAnswer->question_id, $form->content);
        $answer->attachTo($id);
        $this->answers->save($answer);

        $sent = $this->mailer->compose()
            ->setTo($parentAnswer->user->email)
            ->setSubject('New answer for your comment: ' . StringHelper::truncate($parentAnswer->content, 5))
            ->setTextBody($form->content)
            ->send();
        if(!$sent) {
            throw new \RuntimeException('Mail sending error.');
        }

        return $parentAnswer->question_id;
    }

    public function complete($id)
    {
        $question = $this->questions->get($id);
        /** @var Question $question */
        if (!$question->isFrom(\Yii::$app->user->id)) {
            throw new \DomainException('Question doesn`t belong to this user');
        }
        $question->complete();
        $this->questions->save($question);
    }

    public function open($id)
    {
        $question = $this->questions->get($id);
        /** @var Question $question */
        if (!$question->isFrom(\Yii::$app->user->id)) {
            throw new \DomainException('Question doesn`t belong to this user');
        }
        $question->open();
        $this->questions->save($question);
    }

    public function deleteAnswer($id)
    {
        $answer = $this->answers->get($id);
        /** @var Answer $answer */
        $this->answers->remove($answer);
        return $answer->question_id;
    }
}