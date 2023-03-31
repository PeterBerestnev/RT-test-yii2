<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    
    <div class="wrap">
        <div class="container">
            <ul class="nav nav-pills pt-3 pb-3">
                <li class="nav-item nav-link bg-primary">
                    <?=  Html::a('Главная','/web/',['class'=>'text-light text-decoration-none'])?>
                </li>
                <li class="nav-item nav-link ">
                    <?= Html::a('Статьи',['post/index'],['class'=>'text-decoration-none'])?>
                </li>
                <li class="nav-item nav-link">
                    <?= Html::a('Статья',['post/show'],['class'=>'text-decoration-none'])?>
                </li>
            </ul>

            <?php 
            if( isset( $this->blocks['block1'] ) ):?>
                <?php echo $this->blocks['block1'] ?>
            <?php endif; ?>
            <?= $content ?>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
