<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Messages model
 * 
 * @property int id
 * @property int user_id
 * @property string text
 * @property int date
 * @property bool active        
 */
class Messages extends ActiveRecord
{   
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUserId($userId): self
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get the value of text
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */ 
    public function setText($text): self
    {   
        $text = strip_tags($text);
        $text = htmlspecialchars($text);

        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return date('G:i', $this->date);;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of active
     */ 
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */ 
    public function setActive($active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}