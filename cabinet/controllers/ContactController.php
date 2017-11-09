<?php
namespace cabinet\controllers;

use core\forms\cabinet\QuestionForm;
use core\services\cabinet\QuestionService;
use yii\web\Controller;
use yii;
use core\entities\User\User;
use yii\web\NotFoundHttpException;

class ContactController extends Controller
{
    private $service;

    public function __construct($id, $module, QuestionService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * Displays contact page.
     *
     */
    public function actionIndex()
    {
        $form = new QuestionForm();
        $user = $this->findUser(Yii::$app->user->id);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->ask($form);
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } catch (\RuntimeException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }
            return $this->refresh();
        } else {
            return $this->render('index', [
                'model' => $form,
                'user' => $user,
            ]);
        }
    }

    private function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Participant does not exist.');
        }
    }
}