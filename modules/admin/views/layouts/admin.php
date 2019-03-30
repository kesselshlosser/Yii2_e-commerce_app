<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AdminLtePluginAsset;

AdminLtePluginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head><!--/head-->
<div class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
          <?= $content ?> <!-- Displays the index.php file content-->
    <?php $this->endBody() ?>
</div>
</html>
<?php $this->endPage() ?>
