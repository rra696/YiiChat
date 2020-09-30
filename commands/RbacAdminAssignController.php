<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class RbacAdminAssignController extends Controller
{
    public function actionInit($id)
    {
        if (!$id) {
            $this->stdout("Param 'id' must be set!\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $user = (new User())->findIdentity($id);

        if (!$user) {
            $this->stdout("User witch id:'$id' is not found!\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $auth = Yii::$app->authManager;

        $role = $auth->getRole('admin');

        $auth->revokeAll($id);

        $auth->assign($role, $id);

        $this->stdout("Done!\n", Console::BOLD);
        
        return ExitCode::OK;
    }   
}