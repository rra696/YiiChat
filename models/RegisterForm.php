<?php

namespace app\models;

use app\utils\PasswordHasher;
use Yii;
use yii\base\Model;

class RegisterForm extends Model
{   
    public ?string $login = null;
    public ?string $password = null;
    public ?string $confirmPassword = null;

    public function rules()
    {
        return [
            [['login', 'password', 'confirmPassword'], 'required'],
            ['login', 'unique', 'targetClass' => 'app\models\User'],
            [['password', 'confirmPassword'], 'string', 'length' => [3, 48]],
            ['password', 'compare', 'compareAttribute' => 'confirmPassword', 'message' => 'Пароли не совпадают'],

        ];
    }

    public function register(PasswordHasher $hasher)
    {
        $user = new User;
 
        $user->setLogin($this->login);
        $user->setPassword($hasher->hash($this->password));
        $user->setCreatedAt(time());
        $user->setUpdatedAt(time());

        if (!$user->save()) {
            return false;
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole('user');
        $auth->assign($role, $user->getId());

        return $user;
    }

}