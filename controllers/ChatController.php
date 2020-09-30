<?php

namespace app\controllers;

use app\models\MessageForm;
use app\repositories\MessagesRepository;
use app\repositories\UsersRepository;
use Yii;
use yii\web\Controller;

class ChatController extends Controller
{      
    protected const TEN_MINUTES = 10 * 60;

    protected MessagesRepository $messagesRepository;
    protected UsersRepository $usersRepository;

    public function init()
    {   
        parent::init();

        $this->messagesRepository = new MessagesRepository;
        $this->usersRepository = new UsersRepository;
    }

    public function actionIndex()
    {   
        $model = new MessageForm;

        $messages = $this->messagesRepository->getAllActive();
        $users = $this->usersRepository->getAll();

        return $this->render('index', [
            'messages' => $messages,
            'users' => $users,
            'model' => $model
        ]);
    }

    public function actionNewMessage()
    {
        $model = new MessageForm;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (!Yii::$app->request->isAjax) {
            return ['isOk' => false, 'message' => 'Bad Request.'];
        }
        
        if (!$model->load(Yii::$app->request->post())) {
            return ['isOk' => false, 'message' => 'Fail load data.'];
        }
        
        if (!$model->validate()) {
            return ['isOk' => false, 'message' => $model->firstErrors];
        }
        
        if (!$message = $model->save()) {
            return ['isOk' => false, 'message' => $model->firstErrors]; 
        }
        
        return ['isOk' => true, 'message' => $this->renderPartial('message', ['message' => $message])];
    }

    public function actionUpdateMessages()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;

        if (!$request->isAjax) {
            return ['isOk' => false, 'message' => 'Bad Request.'];
        }

        $messages = $this->messagesRepository->getAllActive();

        $responseText = '';

        foreach ($messages as $message) {
            $responseText .= $this->renderPartial('message', ['message' => $message]);
        }

        return ['isOk' => true, 'message' => $responseText];
    }

    public function actionBlockMessage() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;

        if (!$request->isAjax) {
            return ['isOk' => false, 'message' => 'Bad Request.'];
        }

        $msgId = $request->get('msgId');

        if ($msgId === null) {
            return ['isOk' => true, 'message' => ''];
        }

        $isOk = $this->messagesRepository->blockMessageById((int)$msgId);

        if (!$isOk) {
            return ['isOk' => false, 'message' => 'Failed to block message.'];
        }
        
        return ['isOk' => true, 'message' => 'ok.'];
    }


    public function actionUnblockMessage() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;

        if (!$request->isAjax) {
            return ['isOk' => false, 'message' => 'Bad Request.'];
        }

        $msgId = $request->get('msgId');

        if ($msgId === null) {
            return ['isOk' => true, 'message' => ''];
        }

        $isOk = $this->messagesRepository->unblockMessageById((int)$msgId);

        if (!$isOk) {
            return ['isOk' => false, 'message' => 'Failed to unblock message.'];
        }
        
        return ['isOk' => true, 'message' => 'ok.'];
    }
    

    public function actionBlockedMessagesList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;

        if (!$request->isAjax) {
            return ['isOk' => false, 'message' => 'Bad Request.'];
        }

        $messages = $this->messagesRepository->getBlocked();

        $responseText = $this->renderPartial('blockedMessage', ['messages' => $messages]);

        return ['isOk' => true, 'message' => $responseText];
    }
}