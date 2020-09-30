<?php

namespace app\repositories;

use app\models\User;

class UsersRepository
{   
    
    public function findFirstByLogin(string $login)
    {
        $user = User::find()
                ->where(['login' => $login])
                ->one();

        return $user;
    }

    public function getAll()
    {
        $users = User::find()->all();

        return $users;
    }
} 