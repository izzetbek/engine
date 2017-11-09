<?php

namespace core\services\cabinet;

use core\entities\Cabinet\Question;
use core\forms\cabinet\QuestionForm;
use core\forms\manager\Cabinet\AnswerForm;
use Imagine\Exception\RuntimeException;
use yii\mail\MailerInterface;

class QuestionService
{
    private $adminEmail;
    private $mailer;

    public function __construct($adminEmail, MailerInterface $mailer)
    {
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
    }

    public function ask(QuestionForm $form)
    {
        $question = Question::create(\Yii::$app->user->id, $form->webinar, $form->body);
        if (!$question->save()) {
            throw new RuntimeException('Question saving error');
        }

        $sent = $this->mailer->compose()
            ->setTo($this->adminEmail)
            ->setSubject('Question from webinar participant ')
            ->setTextBody($form->body)
            ->send();
        if(!$sent) {
            throw new \RuntimeException('Mail sending error.');
        }
    }

    public function answer($id, AnswerForm $form)
    {
        $question = Question::findOne($id);
        $question->answer($form->answer);
        if (!$question->save()) {
            throw new RuntimeException('Question saving error');
        }
        $sent = $this->mailer->compose()
            ->setTo($question->user->email)
            ->setSubject('Answer for question')
            ->setTextBody($form->answer)
            ->send();
        if(!$sent) {
            throw new \RuntimeException('Mail sending error.');
        }
    }
}