<?php

namespace app\modules\api\actions;

use Yii;
use yii\helpers\Url;
use yii\rest\UpdateAction;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;
use MongoDB\BSON\UTCDateTime;

class ArticleUpdateAction extends UpdateAction
{
    public function run($id)
    {
        // Find the model by ID
        $model = $this->findModel($id);

        // Check if the user has access to update the model
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        // Set the scenario and load the request data into the model
        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        // Decode tags if they are a JSON string
        if (isset($model->tags) && is_string($model->tags)) {
            $model->tags = json_decode($model->tags, true);
        }

        // Get uploaded image and the old image (if any)
        $image = UploadedFile::getInstanceByName('photo');
        $oldImage = $model->photo;

        // Set the publication date if the model is being published for the first time
        if ($model->status == 'Опубликовано' && empty($model->date)) {
            $model->date = new UTCDateTime((new \DateTime())->getTimestamp() * 1000);
        }

        // Save the model and check for errors
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        // Save uploaded image to the model if it exists
        if (is_object($image)) {
            $model->photo = $image;
        }

        // Validate the model and update the user who made the change
        if ($model->validate()) {
            $authHeader = Yii::$app->request->headers->get('Authorization');
            $authToken = preg_replace('/^Bearer\s/', '', $authHeader);
            $token = Yii::$app->get('jwt')->getParser()->parse((string) $authToken);
            $userId = $token->getClaim('uid');
            $model->updated_by = $userId;

            // Save the uploaded image to disk and update the model's photo attribute
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

            // Save the model again and check for errors
            if ($model->save() === false && !$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
        }

        // Return the updated model
        return $model;
    }
}
