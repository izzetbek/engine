<?php

namespace backend\controllers;

use core\forms\manager\User\UserCreateForm;
use core\forms\manager\User\UserEditForm;
use core\services\manager\UserManagerService;
use Yii;
use core\entities\User\User;
use backend\forms\UserSearch;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    private $service;

    public function __construct($id, $module, UserManagerService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new UserCreateForm();
        if($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->create($form);
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $form = new UserEditForm($user);
        if($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->edit($id, $form);
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'user' => $user
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeactivate($id)
    {
        try {
            $this->service->deactivate($id);
            return $this->redirect(['index']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash($e->getMessage());
        }
        return $this->redirect(['index']);
    }

    public function actionActivate($id)
    {
        try {
            $this->service->activate($id);
            return $this->redirect(['index']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash($e->getMessage());
        }
        return $this->redirect(['index']);
    }

    public function actionCompanyList($q = null, $id = null)
    {
        \Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if ($q) {
            $query = new Query();
            $query->select(['id', 'company'])->from('{{%users}}')->andFilterWhere(['like', 'company', $q])->orderBy('company');
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => User::findOne(['id' => $id])->company];
        }
        return $out;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return \core\entities\User\User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
