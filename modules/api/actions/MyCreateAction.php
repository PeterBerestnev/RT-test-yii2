<?php
namespace app\modules\api\actions;

use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\rest\CreateAction;
use yii\web\UploadedFile;

class MyCreateAction extends CreateAction
{
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->tags != null) {
            $model->tags = json_decode($model->tags, true);
        }

        $image = UploadedFile::getInstanceByName('photo');

       

        if ($model->status == 'Опубликованно') {
            $model->date = Yii::$app->formatter->asDatetime('now', 'short');
        }
        if (is_object($image)) {
            $model->photo = $image;
        }
        if ($model->validate()) {
            if(is_object($image)){
                $model->photo = time() . "_" . uniqid() . '.' . $image->extension;
                $image->saveAs('img/' . $model->photo);
            }
            if ($model->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                $id = implode(',', $model->getPrimaryKey(true));
                $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        }
        return $model;
    }
}