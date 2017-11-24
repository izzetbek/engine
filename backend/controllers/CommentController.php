<?php

namespace backend\controllers;

use core\entities\Cabinet\Answer;
use yii;
use core\forms\cabinet\AnswerForm;
use core\services\cabinet\QuestionService;
use yii\web\Controller;

class CommentController extends Controller
{
    private $service;

    public function __construct($id, $module, QuestionService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionUpdate($id)
    {
        $answer = $this->findModel($id);
        $form = new AnswerForm($answer);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editAnswer($id, $form);
                $this->redirect(['question/update', 'id' => $answer->question_id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash($e->getMessage());
            }
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $form,
            ]);
        } else {
            return $this->render('update', [
                'model' => $form,
            ]);
        }
    }

    public function actionAttach($id)
    {
        $form = new AnswerForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $questionId = $this->service->attach($id, $form);
                $this->redirect(['question/update', 'id' => $questionId]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash($e->getMessage());
            }
        }
    }

    public function actionDelete($id)
    {
        try {
            $questionId = $this->service->deleteAnswer($id);
            $this->redirect(['question/view', 'id' => $questionId]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash($e->getMessage());
        }
    }

    private function findModel($id)
    {
        if (($model = Answer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new yii\web\NotFoundHttpException('Answer does not exist.');
        }
    }
}