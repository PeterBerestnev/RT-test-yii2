<?php
namespace app\modules\api\actions;

use Yii;
use yii\helpers\Url;
use yii\rest\UpdateAction;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class MyUpdateAction extends UpdateAction
{
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if (isset($model->tags) && is_string($model->tags)) {
            $model->tags = json_decode($model->tags, true);
        }

        $image = UploadedFile::getInstanceByName('photo');
        $oldImage = $model->photo;

        if ($model->status == 'Опубликованно') {
            $model->date = Yii::$app->formatter->asDatetime('now', 'short');
        }

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
        if(is_object($image)){
            $model->photo = $image;
        }
        
        if ($model->validate()) {
           
            if(is_object($image)){
                if(isset($oldImage)){
                    unlink('img/'.$oldImage);
                }
                    $model->photo = time() . "_" . uniqid() . '.' . $image->extension;
                    $image->saveAs('img/' . $model->photo);
                
            }
            if ($model->save()) {
                return $model;
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        } 

    }
}