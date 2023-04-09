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
        /* @var $model ActiveRecord */
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(isset($model->tags) && is_string($model->tags))
        {
            $model->tags = json_decode($model->tags,true);
        }
        
        $image = UploadedFile::getInstanceByName('photo');
        if (is_object ( $image )) { // if there is image
            if($model->photo){
                unlink(str_replace(Url::base(true),Yii::$app->basePath.'/web',$model->photo));
            }
			$model->photo = time () . "_" . uniqid () . '.' . $image->extension;
			$image->saveAs ( 'img/' . $model->photo );
            $model->photo = Url::base(true).'/img/'.$model->photo;
		} 

        if($model->status == 'Опубликованно'){
            $model->date = Yii::$app->formatter->asDatetime('now', 'short');
        }
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }
}