<?php

namespace app\controllers;

class MyController extends AppController{
    public function actionIndex($id = null){
        if(!$id)
        {
            $id = 'no id';
        }
        $hi = 'Hello world!';
        $names = ['Peter','Dmitry','Ivan','Anton','Alexandr'];
        return $this->render('index', compact('hi','names','id'));
    }

    public function actionBlogPost(){
        // my/blog-post  -  это роут
        return 'my-post';
    }
}