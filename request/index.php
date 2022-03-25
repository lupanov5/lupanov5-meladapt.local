<?php

$ajax = $_POST['ajax'];
$html = '<li class="list__item list__item_shop">
                <div class="list__head list__head_shop">
                    <img src="/local/templates/meladapt/assets/images/shop-3.png" alt="shop">
                </div>
                <div class="list__title list__title_shop">Яндекс.Маркет</div>
            </li>
            <li class="list__item list__item_shop">
                <div class="list__head list__head_shop">
                    <img src="/local/templates/meladapt/assets/images/shop-4.png" alt="shop">
                </div>
                <div class="list__title list__title_shop">Вита</div>
            </li>
            <li class="list__item list__item_shop">
                <div class="list__head list__head_shop">
                    <img src="/local/templates/meladapt/assets/images/shop-5.png" alt="shop">
                </div>
                <div class="list__title list__title_shop">Планета здоровья</div>
            </li>
            <li class="list__item list__item_shop">
                <div class="list__head list__head_shop">
                    <img src="/local/templates/meladapt/assets/images/shop-6.png" alt="shop">
                </div>
                <div class="list__title list__title_shop">Uteka.ru</div>
            </li>
            <li class="list__item list__item_shop">
                <div class="list__head list__head_shop">
                    <img src="/local/templates/meladapt/assets/images/shop-7.png" alt="shop">
                </div>
                <div class="list__title list__title_shop">Asna.ru</div>
            </li>
            <li class="list__item list__item_shop">
                <div class="list__head list__head_shop">
                    <img src="/local/templates/meladapt/assets/images/shop-8.png" alt="shop">
                </div>
                <div class="list__title list__title_shop">Магнит-Аптека</div>
            </li>';

echo json_encode([
    'url' => "/request/blogs.php",
    'html' => $html,
    'isEnd' => false
]);