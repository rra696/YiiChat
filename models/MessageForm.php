<?php

namespace app\models;

use Yii;
use yii\base\Model;

class MessageForm extends Model
{   
    protected const ACTIVE_MESSAGE = true;

    public ?string $text = null;

    public function rules()
    {
        return [
            ['text', 'required'],
            ['text', 'string']
        ];
    }

    public function save()
    {
        $message = new Messages;

        $message->setUserId(Yii::$app->user->id);
        $message->setText($this->text);
        $message->setDate(time());
        $message->setActive(self::ACTIVE_MESSAGE);

        if (!$message->save()) {
            return false;
        }

        return $message;
    }
}