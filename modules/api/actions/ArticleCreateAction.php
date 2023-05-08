<?php

namespace app\modules\api\actions;

use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\rest\CreateAction;
use yii\web\UploadedFile;
use sizeg\jwt\Jwt;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectID;

class ArticleCreateAction extends CreateAction
{
    public function run()
    {
        // Check access if provided
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        // Create a new model instance
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        // Load the request body parameters into the model
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        // Decode tags if provided
        if ($model->tags != null) {
            $model->tags = json_decode($model->tags, true);
        }

        // Get the uploaded image file
        $image = UploadedFile::getInstanceByName('photo');

        // Set the date if status is "Опубликовано" ("Published" in Russian)
        if ($model->status == 'Опубликовано') {
            $model->date = new UTCDateTime((new \DateTime())->getTimestamp() * 1000);
        }

        // Set the photo attribute if an image was uploaded
        if (is_object($image)) {
            $model->photo = $image;
        }

        // Validate the model
        if ($model->validate()) {

            // Get the user ID from the JWT token
            $authHeader = Yii::$app->request->headers->get('Authorization');
            $authToken = preg_replace('/^Bearer\s/', '', $authHeader);
            $token = Yii::$app->get('jwt')->getParser()->parse((string) $authToken);
            $userId = $token->getClaim('uid');
            $model->created_by = new ObjectID($userId);

            // Save the image file and model
            if (is_object($image)) {
                $model->photo = time() . "_" . uniqid() . '.' . $image->extension;
                if (!$image->saveAs('img/' . $model->photo)) {
                    $model->addError('photo', 'Failed to save the photo.');
                }
            }
            if ($model->save()) {

                // Set the response status and location header
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                $id = implode(',', $model->getPrimaryKey(true));
                $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        }

        // Return the model
        return $model;
    }
}
