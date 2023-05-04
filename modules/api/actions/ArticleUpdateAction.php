<?php
namespace app\modules\api\actions;

use Yii;
use yii\helpers\Url;
use yii\rest\UpdateAction;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class ArticleUpdateAction extends UpdateAction
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

        if ($model->status == 'Опубликовано' && empty($model->date)) {
            $model->date = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s', 'UTC');
        }

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
        if (is_object($image)) {
            $model->photo = $image;
        }

        if ($model->validate()) {

            $authHeader = Yii::$app->request->headers->get('Authorization');
            $authToken = preg_replace('/^Bearer\s/', '', $authHeader);
            $token = Yii::$app->get('jwt')->getParser()->parse((string) $authToken);
            $userId = $token->getClaim('uid');
            $model->updated_by = $userId;

            if (is_object($image)) {
                $model->photo = time() . "_" . uniqid() . '.' . $image->extension;
                if ($image->saveAs('img/' . $model->photo)) {
                    if (isset($oldImage)) {
                        unlink('img/' . $oldImage);
                    }
                } else {
                    $model->addError('photo', 'Failed to save the photo.');
                }
            }
            if ($model->save() === false && !$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
        }

        return $model;
    }
}