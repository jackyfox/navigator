<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<img src="" class="img-thumbnail" alt="">
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="https://profinavigator.ru/img/layouts/logo.png" class="logo-site"/>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        //['label' => 'Home', 'url' => ['site/index']],
        ['label' => 'Организации', 'url' => ['organisation/index']],
        ['label' => 'События', 'url' => ['event/index']],
        ['label' => 'Адреса', 'url' => ['address/index']],
        ['label' => 'Профессии', 'url' => ['profession/index']],
        ['label' => 'Типы организаций', 'url' => ['type/index']],
        ['label' => 'Компитенции', 'url' => ['competence/index']],
        //['label' => 'Люди', 'url' => ['personality/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode('ГОРОДСКАЯ ИНФОРМАЦИОННАЯ СИСТЕМА «НАВИГАТОР ПРОФЕССИЙ САНКТ-ПЕТЕРБУРГА»') ?> <?= date('Y') ?></p>

        <p class="pull-right">navigator@adtspb.ru</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script type="text/javascript">
	tinymce.init({ selector:'textarea' });

        var is_safari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

    

    if(is_safari) {

        var img_page = document.getElementsByTagName('img'); 
        images_page = [];

        for (var i = 0; i < img_page.length; i++) {

            images_page.push(img_page[i].src);

            if(~images_page[i].indexOf('www.dropbox.com')) {
                var src_img = img_page[i].src;
                src_img = src_img.slice(0, -4);
                src_img = src_img+"raw=1";
                
                img_page[i].src = src_img;
            }
            else {
                
            }
        }

        if($('.header_page_img').length == 1) {

        var img_logo = $('#logo_company').attr('src');
        var img_bg = $('.header_page_img').css('background');

        if (~img_bg.indexOf('www.dropbox.com')) { 

            img_bg = img_bg.replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
            img_bg = img_bg.slice(0, -4);
            img_bg = img_bg+"raw=1";

            $('.header_page_img').css({
                background: 'url('+img_bg+')',
                backgroundAttachment: 'fixed',
                backgroundSize: 'cover'
            });

        } else {
            
        }

        if (~img_bg.indexOf('www.dropbox.com')) {
            
            img_logo = img_logo.slice(0, -4);
            img_logo = img_logo+"raw=1"; 
            $('#logo_company').attr('src',img_logo);

        } else {
            
        }

        }
    }
</script>
<style>
    .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus {
        background-color: rgba(8, 107, 154, 0.22) !important;
    }
    .breadcrumb {
        margin-top: 50px;
    }
    .navbar-header {
        background: #fff !important;
        padding-left: 17px;
        padding-bottom: 25px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }
    .navbar-inverse {
        background-color: #162a41 !important;
        border-color:  transparent !important;
    }
    .logo-site {
        width: 58px;
        height: 53px;

    }
    .navbar {
        padding-bottom: 20px;
    }
    ul.navbar-nav {
        margin-top:  18px;
    }
    .organisation-search {
        padding: 20px;
        background: #faf9fa;
        border:  1px dashed #d6d1d7;
        margin-bottom: 20px;
    }
    .form-group {
        border: 1px dashed #aaa;
        padding: 10px;
        background: #f7f7f7;
    }
    .postImg {
        margin: 20px;
    }
</style>
