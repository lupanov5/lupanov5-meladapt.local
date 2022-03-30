<footer class="footer">
    <div class="footer__bg">
        <img src="/local/templates/meladapt/assets/images/cloud.png" alt="cloud">
    </div>
    <div class="footer__wrap container">

        <div class="flex-row footer__top">
            <div class="flex-col md-6 sm-24 footer__brand">
                <a href="/" class="brand">
                    <img src="/local/templates/meladapt/assets/images/dark-logo.png"
                         alt="{$smarty.const.SITE_NAME}"
                         class="brand__img">
                </a>
            </div>
            <div class="flex-col md-12 sm-24 footer__menu">
                <ul class="main-menu">

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


                    <li class="main-menu__el" data-menu-el>
                        <a href="#" class="main-menu__link">
                            <span>Где купить</span>
                        </a>
                    </li>

                </ul>
            </div>
            <a href="" class="flex-col md-6 sm-24 link footer__instruction">
                <span>Инструкция по применению</span>
                <svg class="icon">
                    <use xlink:href="#icon-arrow-down"></use>
                </svg>
            </a>
            <div class="flex-col md-24 footer__warning">
                Имеются противопоказания – перед применением проконсультируйтесь со специалистом
                <!--<img src="/local/templates/meladapt/assets/images/warning.png" alt="">-->
            </div>
        </div>

        <div class="footer__middle">
            <div class="footer__shop">
                <img src="/local/templates/meladapt/assets/images/ozon.png" alt="ozon">
            </div>
            <div class="footer__contacts">
                <div class="nx-contacts__item">
                    <div class="nx-contacts__label">Секретариат</div>
                    <a href="tel:8486234109" class="nx-contacts__title">+7 (84862) 3-41-09</a>
                </div>
                <div class="nx-contacts__item">
                    <div class="nx-contacts__label">E-mail</div>
                    <a href="mailto:ozon@ozon-pharm.ru" class="nx-contacts__title">ozon@ozon-pharm.ru</a>
                </div>
                <div class="nx-contacts__item">
                    <div class="nx-contacts__label">Официальный сайт</div>
                    <a href="http://www.ozonpharm.ru" class="nx-contacts__title">www.ozonpharm.ru</a>
                </div>
            </div>
        </div>

        <div class="footer__bottom">
            <a href="#" class="footer__politics link" target="_blank" rel="noopener">
                © 2021 Фармацевтическая компания «ОЗОН», <span>Политика о конфиденциальности</span>
            </a>

            <a href="#" class="footer__link link" target="_blank" rel="noopener">
                <span>Согласие на обработку персональных данных</span>
            </a>

            <div class="footer__dnext">Разработка сайта —
                <a href="https://dnext.ru/" class="link" target="_blank" rel="noopener">
                    <span>Next</span>
                </a>
            </div>
        </div>

    </div>
</footer>


</div>
<?php require_once './blocks/modal.php'; ?>
<script src="/local/templates/meladapt/assets/app.min.js"></script>
</body>
</html>