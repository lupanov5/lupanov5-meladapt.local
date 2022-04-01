<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var array $arParams
 */
global $CURRENT_PROTO;
$CURRENT_PROTO = (\Bitrix\Main\Context::getCurrent()->getRequest()->isHttps() ? 'https' : 'http');
?>
<section style="height: 340px;
                padding-top: 60px;
                padding-bottom: 60px;
                max-width: 1200px;">
    <div style="height: 340px;
    width: 680px;
    margin: 0 auto 40px;
    border-radius: 30px;
    background-position: center;
    background-size: cover;
    padding: 40px;
    position: relative;
    overflow: hidden;
    background-image: url('<?= $CURRENT_PROTO . '://' . $arParams['SERVER_NAME'] ?>/local/templates/meladapt/assets/images/bg.jpg')">
        <a href="#" style="width: 220px;
                    display: block;
                    margin-bottom: 150px;
                        height: initial;">
            <img style="object-fit: contain;
                    display: block;
                    max-width: 100%;" src="<?= $CURRENT_PROTO . '://' . $arParams['SERVER_NAME'] ?><?= LOGO ?>">
        </a>

        <div style="max-width: 370px;">
            <div class="inner">
                <img style="object-fit: contain;
                                display: block;
                                max-width: 100%;" src="<?= $CURRENT_PROTO . '://' . $arParams['SERVER_NAME'] ?>/local/templates/meladapt/assets/images/product.png" alt="">
            </div>
        </div>
    </div>

<!--    <h2 style="margin: 0 auto 15px;-->
<!--                text-align: center;-->
<!--font-weight: 700;-->
<!--font-size: 30px;-->
<!--line-height: 35px;-->
<!--color: #202B56;">-->
<!--        Ваш вопрос принят-->
<!--    </h2>-->
    <div style="max-width: 520px;
                                    margin: 0 auto 30px;
                                    text-align: center;
                                    opacity: 0.5;"><!-- mail content -->