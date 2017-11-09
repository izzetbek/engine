<?php
namespace cabinet\controllers;

use core\entities\Cabinet\Question;
use core\entities\Webinar\Webinar;
use yii\web\Controller;
use core\entities\User\User;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $user = $this->findUser(\Yii::$app->user->id);
        return $this->render('index', [
            'user' => $user,
        ]);
    }

    public function actionView($id)
    {
        $webinar = $this->findWebinar($id);
        return $this->render('view', [
            'webinar' => $webinar,
        ]);
    }

    private function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Participant does not exist.');
        }
    }

    private function findWebinar($id)
    {
        if (($model = Webinar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Webinar does not exist.');
        }
    }
}
