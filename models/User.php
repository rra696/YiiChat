<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 * 
 * @property integer id
 * @property string $login
 * @property string $password
 * @property int $created_at
 * @property int $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{   
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of login
     */ 
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */ 
    public function setLogin(string $login): self
    {
        $this->login = $login;
        
        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of cteatedAt
     *
     * @return  self
     */ 
    public function setCreatedAt(int $createdAt): self
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt(int $updatedAt): self
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    public static function findIdentity($id) 
    {
        return User::findOne((int)$id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {}

    public function getAuthKey() {}

    public function validateAuthKey($authKey) {}

}