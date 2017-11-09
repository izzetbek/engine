<?php

namespace cabinet\controllers;

use yii\web\Controller;
use core\entities\Cabinet\Question;
use yii\web\NotFoundHttpException;

class QuestionController extends Controller
{
    public function actionIndex()
    {
        $questions = Question::find()->andWhere(['user_id' => \Yii::$app->user->id])->orderBy('ask_date DESC')->all();
        return $this->render('index', [
            'questions' => $questions
        ]);
    }

    public function actionView($id)
    {
        $question = $this->findModel($id);
        return $this->render('view', [
            'question' => $question,
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