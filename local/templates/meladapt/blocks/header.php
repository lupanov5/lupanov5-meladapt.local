<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="author" content="Контент">
    <meta name="keywords" content="keywords">
    <meta name="description" content="description">

    <title>Меладапт</title>

    <link rel="icon" type="image/png" href="/local/templates/meladapt/favicon.png">
    <link rel="stylesheet" href="/local/templates/meladapt/assets/vendor.css">
    <link rel="stylesheet" href="/local/templates/meladapt/assets/app.min.css">

    <meta property="og:title" content="title"/>
    <meta property="og:description" content="description"/>
    <meta property="og:image" content="favicon.png">

</head>
<body>

<header class="header" data-header>
    <div class="header__wrap">
        <div class="container header__container">
            <div class="header__mtoggle">
                <a href="#" class="mtoggle" data-mtoggle>
                    <span class="mtoggle__icon"></span>
                </a>
            </div>

            <div class="header__brand">
                <a href="/" class="brand">
                    <img src="/local/templates/meladapt/assets/images/logo.png"
                         alt="{$smarty.const.SITE_NAME}"
                         class="brand__img">
                </a>
            </div>

            <div class="spacer"></div>

            <div class="header__nav">
                <nav class="mnav" data-nav>
                    <div class="mnav__wrap">
                        <div class="mnav__menu">
                            <ul class="main-menu">
                                <li class="main-menu__el" data-menu-el>
                                    <a href="#" class="main-menu__link">
                                        <span>Главная</span>
                                    </a>
                                </li>

                                <li class="main-menu__el" data-menu-el>
                                    <a href="#" class="main-menu__link">
                                        <span>О продукте</span>
                                    </a>
                                </li>

                                <li class="main-menu__el" data-menu-el>
                                    <a href="/local/templates/meladapt/pages/questions.php" class="main-menu__link">
                                        <span>Вопрос-ответ</span>
                                    </a>
                                </li>

                                <a href="#buy" class="btn btn_brd mnav__btn">Где купить</a>



                            </ul>

                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

<div class="wrapper">