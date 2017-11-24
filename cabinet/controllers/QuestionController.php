<?php

namespace cabinet\controllers;

use yii;
use core\entities\Cabinet\Answer;
use core\forms\cabinet\AnswerForm;
use core\services\cabinet\QuestionService;
use yii\web\Controller;
use core\entities\Cabinet\Question;
use yii\web\NotFoundHttpException;

class QuestionController extends Controller
{
    private $service;

    public function __construct($id, $module, QuestionService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $questions = Question::find()->andWhere(['user_id' => \Yii::$app->user->id])->orderBy('ask_date DESC')->all();
        return $this->render('index', [
            'questions' => $questions
        ]);
    }

    public function actionComplete($id)
    {
        try {
            $this->service->complete($id);
            Yii::$app->session->setFlash('success', 'You`we closed your question. You can reopen issue wherever you want.');
            $this->redirect(['view', 'id' => $id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash($e->getMessage());
        }
    }

    public function actionOpen($id)
    {
        try {
            $this->service->open($id);
            Yii::$app->session->setFlash('warning', 'You`we reopened your question. Tutor will respond to you as soon as possible.');
            $this->redirect(['view', 'id' => $id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash($e->getMessage());
        }
    }

    public function actionView($id)
    {
        $question = $this->findModel($id);
        $answers = Answer::find()->joinWith('user')->andWhere(['question_id' => $id])->orderBy('answer_date')->asArray()->all();
        $form = new AnswerForm();
        return $this->render('view', [
            'question' => $question,
            'answers' => $answers,
            'model' => $form,
        ]);
    }

    private function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Participant does not exist.');
        }
    }
}