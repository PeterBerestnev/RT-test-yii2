<?php
namespace app\modules\api\actions;

use yii\helpers\Url;
use Yii;
use yii\rest\ViewAction;

class MyViewAction extends ViewAction
{

    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        if($model->photo){
            $link = Url::base(true).'/img/'.$model->photo;
            $model->photo = $link;
        }

        return $model;
    }

}