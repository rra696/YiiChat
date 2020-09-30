<?php

namespace app\models;

use Yii;
use app\repositories\UsersRepository;
use app\utils\PasswordHasher;
use yii\base\Model;

class LoginForm extends Model
{
    public ?string $login = null;
    public ?string $password = null;
    protected ?User $user = null;
    protected ?UsersRepository $usersRepository;
    protected ?PasswordHasher $hasher;

    public function __construct(UsersRepository $usersRepository = null, PasswordHasher $hasher = null)
    {
        $this->hasher = $hasher;
        $this->usersRepository = $usersRepository;
    }

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['password', 'validatePassword']
        ];
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->user);
        }

        return false;
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->user = $this->usersRepository->findFirstByLogin($this->login);

            if (!$this->user || !$this->hasher->validate($this->password, $this->user->getPassword())) {
                $this->addError($attribute, 'Некорректный логин или пароль!');
            }
        }
    }

}
