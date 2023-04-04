<?php
namespace app\modules\api\actions;

use yii\helpers\Url;
use yii\rest\IndexAction;

class MyIndexAction extends IndexAction
{

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $elements = $this->prepareDataProvider();
        
        foreach($elements as $element){
            if($element->photo){
                $link = Url::base(true).'/img/'.$element->photo;
                $element->photo = $link;
            }
        }
        return $elements;
    }
}