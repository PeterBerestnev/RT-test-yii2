<?php

namespace app\controllers;

use app\models\Admin;
use app\models\User;
use Yii;
use app\models\TestForm;

class PostController extends AppController{

    public $layout = 'basic'; 

    public function beforeAction($action){
        if( $action->id == 'index'){
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex(){
        $this->view->title = 'Все статьи';
        if( Yii::$app->request->isAjax )
        {
            // debug($_POST);
            debug(Yii::$app->request->post());
            return 'test';
        }

        $model = new TestForm();

        return $this->render('test', compact('model'));
    }

    public function actionShow(){
        // $this->layout = 'basic';
        $this->view->title = 'Одна статья';
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'ключевики ...']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'описание страниц ...']);

        // $admin = new Admin();
        // $admin->name = 'Peter';
        // $admin->save();
        // $username = 'Peter';
        // $password = 'qwe123';
        // $security = \Yii::$app->security;
        // $user = new User();
        // $user->username = $username;
        // $user->password_hash = $security->generatePasswordHash($password);
        // $user->access_token = $security->generateRandomString(255);
        // $user->save();
        $adm =Admin::find()->all();


        return $this->render('show',compact('adm'));
    }   
}