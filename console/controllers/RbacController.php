<?php

namespace console\controllers;

use backend\rbac\Rbac;
use yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        $adminPanel = $auth->createPermission(Rbac::PERMISSION_ADMIN_PANEL);
        $adminPanel->description = 'Admin panel';
        $auth->add($adminPanel);

        $cabinet = $auth->createPermission(\cabinet\rbac\Rbac::PERMISSION_CABINET);
        $cabinet->description = 'Cabinet';
        $auth->add($cabinet);

        $user = $auth->createRole('user');
        $user->description = 'User';
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        $participant = $auth->createRole('participant');
        $participant->description = 'Participant';
        $auth->add($participant);

        $auth->addChild($participant, $user);
        $auth->addChild($participant, $cabinet);

        $auth->addChild($admin, $user);
        $auth->addChild($admin, $adminPanel);
        $auth->addChild($admin, $cabinet);

        $this->stdout('Done!' . PHP_EOL);
    }
}