<?php

namespace app\models;

use yii\base\Model;

class TestForm extends Model{

    public $name;
    public $email;
    public $text;

    public function attributeLabels(){
        return [
            'name' => 'Имя',
            'email' => 'E-mail',
            'text' => 'Текст сообщения'
        ];
    }

    public function rules(){
        return [
            [['name','email'],'required'],
            ['email','email'],
            ['name', 'string' ,'min' => 4]
        ];
    }

}