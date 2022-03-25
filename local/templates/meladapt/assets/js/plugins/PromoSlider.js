"use strict";
/**
 * Промо слайдер (для главной страницы)
 */

import Swiper from 'swiper';

class PromoSlider {
    constructor() {
        this.dataName = {
            promoSlider: 'promo-slider',
            promoNext: 'promo-next',
            promoPrev: 'promo-prev',
            promoDots: 'promo-dots'
        };

        this.bulletTemplate = '<span class="swiper-pagination-bullet nx-promo-slider__bullet"></span>';
    }

    init($container){
        let $promoSlider = $container.querySelectorAll(`[data-${this.dataName.promoSlider}]`);

        if (!$promoSlider.length) return false;

        $promoSlider.forEach((el) => {
            let promoSlider = new Swiper(el, {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: false,
                autoHeight: false,
                resistanceRatio: 0.5,
                navigation: {
                    nextEl: `[data-${this.dataName.promoNext}]`,
                    prevEl: `[data-${this.dataName.promoPrev}]`,
                },
                pagination: {
                    el: `[data-${this.dataName.promoDots}]`,
                    type: 'bullets',
                    clickable: true,
                    bulletActiveClass: 'active',
                    renderBullet: () => this.bulletTemplate
                },
                // on: {
                //     init: function(){
                //         AOS.refreshHard();
                //     },
                //     slideChange: function(){
                //         AOS.refreshHard();
                //     }
                // },
                // autoplay: {
                // 	delay: 7000,
                // 	disableOnInteraction: false,
                // },
            });
        });

    }
}

export default PromoSlider;
