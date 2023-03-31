<h1>Show Action</h1>

<?php
// $this->title = 'Show';
?>

<?php $this->beginBlock('block1'); ?>
    <h1>Заголовок страницы</h1>
<?php $this->endBlock(); ?>

<?php foreach ($adm as $value) {
    echo $value->name."<br>";
}
?>
<button class="btn btn-success mt-3" id="btn">Click me!</button>

<?php //$this->registerJsFile('@web/js/scripts.js',['depends' => 'yii\web\YiiAsset'])?>
<?php //$this->registerJs("$('.container').append('<p>SHOW!!</p>');",\yii\web\View::POS_LOAD) ?>
<?php //$this->registerCss('.container{background:#ccc;}') ?>

<?php


$js = <<<JS
    $('#btn').on('click', function(){
        $.ajax({
            url: 'index.php?r=post/index',
            data: {test: '123'},
            type: 'POST',
            success: function(res){
                console.log(res);
            },
            error: function(){
                alert("Error!");
            }
        });
    });
JS;

$this->registerJs($js);

?>