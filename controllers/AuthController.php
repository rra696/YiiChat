<?php

namespace app\controllers;

use Yii;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\User;
use app\repositories\UsersRepository;
use app\utils\PasswordHasher;
use yii\web\Controller;

class AuthController extends Controller
{   
    protected PasswordHasher $hasher;
    protected UsersRepository $usersRepository;

    public function init()
    {
        parent::init();

        $this->hasher = new PasswordHasher;
        $this->usersRepository = new UsersRepository;
    }

    public function actionRegister()
    {   
        $model = new RegisterForm;

        return $this->render('register', [
            'model' => $model
        ]);
    }

    public function actionRegisterSubmit()
    {   
        $model = new RegisterForm;

        $model->load(Yii::$app->request->post());

        if (!$model->validate()) {
            Yii::$app->session->setFlash('error', $model->firstErrors);
            
            return $this->redirect(['register', $model]);
        }

        if (!$model->register($this->hasher)) {
            Yii::$app->session->setFlash('error', $model->firstErrors);

            return $this->redirect(['register', $model]);
        }

        Yii::$app->session->setFlash('success', 'Регистрация завершена!');

        return $this->redirect(['chat/index']);
    }

    public function actionLogin()
    {
        $model = new LoginForm;

        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionLoginSubmit()
    {
        $model = new LoginForm($this->usersRepository, $this->hasher);

        $model->load(Yii::$app->request->post());

        if (!$model->login()) {
            Yii::$app->session->setFlash('error', $model->firstErrors);
            
            return $this->redirect(['login', $model]);
        }

        Yii::$app->session->setFlash('success', 'Вход выполнен успешно!');
        
        return $this->redirect(['chat/index']);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionChangeUserRole()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $request = Yii::$app->request;

        if (!$request->isAjax) {
            return ['isOk' => false, 'message' => 'Bad Request.'];
        }

        $userId = $request->get('userId');
        $roleName = $request->get('roleName');

        $user = (new User())->findIdentity((int)$userId);

        if (!$user) {
            return ['isOk' => false, 'message' => 'User not found.'];
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);

        $auth->revokeAll($user->getId());
        $auth->assign($role, $user->getId());

        $response = $this->renderPartial('/chat/member', ['user' => $user]);

        return ['isOk' => true, 'message' => $response];
    }
}