<?php

namespace app\repositories;

use app\models\Messages;

class MessagesRepository
{
    public function getAllActive()
    {
        $messages = Messages::find()
                    ->where('active = 1')
                    ->all();

        return $messages;
    }

    public function getLastFromDate(int $date)
    {
        $messages = Messages::find()
                    ->where('date > :date AND active = 1', [':date' => $date])
                    ->all();

        return $messages;
    }

    public function findOneById(int $id)
    {
        $message = Messages::findOne($id);

        return $message;
    }

    public function getLastFromId(int $id)
    {
        $messages = Messages::find()
                    ->where('id > :id AND user_id != :user_id', [':id' => $id, 'user_id' => \Yii::$app->user->getId()])
                    ->all();

        return $messages;
    }

    public function blockMessageById(int $id): bool
    {
        $message = Messages::findOne($id);

        if (!$message) {
            return false;
        }

        $message->setActive(false);

        return $message->save();
    }

    public function unblockMessageById(int $id): bool
    {
        $message = Messages::findOne($id);

        if (!$message) {
            return false;
        }

        $message->setActive(true);

        return $message->save();
    }

    public function getBlocked()
    {
        $messages = Messages::find()
                    ->where('active = 0')
                    ->all();

        return $messages;
    }
}