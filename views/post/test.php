<h1>Test Action</h1>

<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
// $this->title = 'Index';
// debug(Yii::$app);


?>
<?php $form = ActiveForm::begin(['id' => 'test-form']) ?>
<?= $form->field($model, 'name')->label('Имя') ?>
<?= $form->field($model, 'email')->label('Электронная почта')->input('email') ?>
<?= $form->field($model, 'text')->label('Текст сообщения')->textarea(['rows' => 5]) ?>
<?= Html::submitButton('Отправить', ['class' => 'btn btn-success mt-3'])?>
<?php ActiveForm::end() ?>