<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 */
$footer = \dnext\Models\Home\Settings::instance()->getFirstElement();
$feedback = \dnext\Models\Feedback\Settings::instance()->getFirstElement();
?>
<footer class="footer">
    <div class="footer__bg">
        <img alt="cloud"
             src="<?= \dnext\Helpers\FilesHelper::getImageById($footer['BACKGROUND_IMAGE_FOOTER']['VALUE']) ?>">
    </div>
    <div class="footer__wrap container">
        <div class="flex-row footer__top">
            <div class="flex-col md-6 sm-24 footer__brand">
                <a href="/" class="brand"> <img alt=""
                                                src="<?= \dnext\Helpers\FilesHelper::getImageById($footer['LOGOTYPE_1_FOOTER']['VALUE']) ?>"
                                                class="brand__img"> </a>
            </div>
            <div class="flex-col md-12 sm-24 footer__menu">
                <ul class="main-menu">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottom",
                        array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "bottom",
                            "USE_EXT" => "N",
                            "CHECKBOX" => $footer['CHECKBOX_BUY']['VALUE'],
                        )
                    ); ?>
                </ul>
            </div>
            <?php if (!empty($footer['FILE_PROMO']['VALUE']) && !empty($footer['TEXT_LINK_INSTRUCTION_FOOTER']['VALUE'])): ?>
                <a href="<?= \dnext\Helpers\FilesHelper::getFilePathById($footer['FILE_PROMO']['VALUE'])['PATH'] ?>"
                   class="flex-col md-6 sm-24 link footer__instruction" target="_blank">
                    <span><?= $footer['TEXT_LINK_INSTRUCTION_FOOTER']['VALUE'] ?></span>
                    <svg class="icon">
                        <use xlink:href="#icon-arrow-down"></use>
                    </svg>
                </a>
            <?php endif; ?>
            <div class="flex-col md-24 footer__warning">
                <?= $footer['TEXT_LINK_CONTRA_FOOTER']['VALUE'] ?>
                <!--<img src="/local/templates/meladapt/assets/images/warning.png" alt="">-->
            </div>
        </div>
        <div class="footer__middle">
            <?php if (!empty($footer['LOGOTYPE_2_FOOTER']['VALUE'])): ?>
                <div class="footer__shop">
                    <img alt="ozon"
                         src="<?= \dnext\Helpers\FilesHelper::getImageById($footer['LOGOTYPE_2_FOOTER']['VALUE']) ?>">
                </div>
            <?php endif; ?>
            <div class="footer__contacts">
                <?php if (!empty($footer['PHONE_FOOTER']['VALUE'])): ?>
                    <div class="nx-contacts__item">
                        <div class="nx-contacts__label">
                            <?= $footer['PHONE_TITLE_FOOTER']['VALUE'] ?>
                        </div>
                        <a href="tel:<?= \dnext\Helpers\Generic::getCleanPhoneNumber($footer['PHONE_FOOTER']['VALUE']) ?>"
                           class="nx-contacts__title"><?= $footer['PHONE_FOOTER']['VALUE'] ?></a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($footer['EMAIL_FOOTER']['VALUE'])): ?>
                    <div class="nx-contacts__item">
                        <div class="nx-contacts__label">
                            <?= $footer['EMAIL_TITLE_FOOTER']['VALUE'] ?>
                        </div>
                        <a href="mailto:<?= $footer['EMAIL_FOOTER']['VALUE'] ?>"
                           class="nx-contacts__title"><?= $footer['EMAIL_FOOTER']['VALUE'] ?></a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($footer['SITE_FOOTER']['VALUE'])): ?>
                    <div class="nx-contacts__item">
                        <div class="nx-contacts__label">
                            <?= $footer['SITE_TITLE_FOOTER']['VALUE'] ?>
                        </div>
                        <a href="http://<?= $footer['SITE_FOOTER']['VALUE'] ?>"
                           class="nx-contacts__title"><?= $footer['SITE_FOOTER']['VALUE'] ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="footer__politics" >
                <?= $footer['TEXT_COPYRIGHT_1_FOOTER']['VALUE'] ?>
                <a href="/privacy_policy/" class="link" target="_blank" rel="noopener">
                    <span><?= $footer['TEXT_COPYRIGHT_2_FOOTER']['VALUE'] ?></span>
                </a>
            </div>
            <a href="/consent/" class="footer__link link" target="_blank"
               rel="noopener"><?= $footer['TEXT_PERSONAL_DATA_FOOTER']['VALUE'] ?></a>
            <div class="footer__dnext">
                Разработка сайта — <a href="https://dnext.ru/" class="link" target="_blank" rel="noopener">
                    Next </a>
            </div>
        </div>
    </div>
</footer>


<div id="question"
     aria-hidden="true"
     class="modal micromodal-slide"
     tabindex="-1">
    <div class="modal__overlay" tabindex="-1" data-custom-close>
        <div class="modal__wrapper">
            <a href="#"
               class="modal__close"
               aria-label="Close modal"
               data-custom-close>
                <i class="mdi mdi-close"></i>
            </a>
            <div class="modal__container" role="dialog" aria-modal="true">


                <div class="h5 modal__title"><?= $feedback['TITLE']['VALUE'] ?></div>

                <form action="/request/question.php">
                    <div class="flex-row">
                        <div class="flex-col xs-24 form-group" data-form-group>
                            <span class="form-group__text"><?= $feedback['TITLE_NAME']['VALUE'] ?></span>
                            <label class="nx-dynamic-label" data-dynamic-label>
                                <input type="text" class="nx-dynamic-label__input" name="name" data-dynamic-inp>
                                <span class="nx-dynamic-label__text"><?= $feedback['DESC_NAME']['VALUE'] ?></span>
                            </label>
                        </div>
                        <div class="flex-col xs-24 form-group" data-form-group>
                            <span class="form-group__text"><?= $feedback['TITLE_EMAIL']['VALUE'] ?></span>
                            <label class="nx-dynamic-label" data-dynamic-label>
                                <input type="text" class="nx-dynamic-label__input" name="email" data-dynamic-inp>
                                <span class="nx-dynamic-label__text"><?= $feedback['DESC_EMAIL']['VALUE'] ?></span>
                            </label>
                        </div>
                        <div class="flex-col xs-24 form-group" data-form-group>
                            <span class="form-group__text"><?= $feedback['TITLE_COMMENT']['VALUE'] ?></span>
                            <label class="nx-dynamic-label" data-dynamic-label>
                            <textarea class="nx-dynamic-label__input" name="comment" rows="1" data-dynamic-inp
                                      data-autosize-textarea></textarea>
                                <span class="nx-dynamic-label__text"><?= $feedback['DESC_COMMENT']['VALUE'] ?></span>
                            </label>
                        </div>
                        <button type="submit" class="btn modal__btn" data-send-request>
                            <?= $feedback['TEXT_BUTTON']['VALUE'] ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<div class="modal modal--ok micromodal-slide" id="modal-ok" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-custom-close="modal-feedback-ok">
        <div class="modal__wrapper">
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-feedback-ok-title">
                <div class="modal__content">
                    <h2 class="modal__title" id="modal-feedback-ok-title">
                        <?= $feedback['TITLE_SUCCESS']['VALUE'] ?>
                    </h2>
                    <p class="modal__description">
                        <?= $feedback['DESC_SUCCESS']['VALUE'] ?>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>