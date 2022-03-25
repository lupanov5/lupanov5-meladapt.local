"use strict";
/**
 * Обычный слайдер на одно изображение
 */

import Swiper from 'swiper';

class CommonSlider {
    constructor() {
        this.dataName = {
            commonSlider: 'common-slider',
            commonSliderPrev: 'common-slider-prev',
            commonSliderNext: 'common-slider-next'
        }
    }

    init($container){
        let $commonSlider = $container.querySelectorAll(`[data-${this.dataName.commonSlider}]`);

        if (!$commonSlider.length) return false;

        $commonSlider.forEach((el) => {
            let $self = el,
                $next = el.querySelector(`[data-${this.dataName.commonSliderNext}]`),
                $prev = el.querySelector(`[data-${this.dataName.commonSliderPrev}]`);

            let commonSlider = new Swiper(el, {
                slidesPerView: 1,
                spaceBetween: 40,
                loop: false,
                autoHeight: false,
                navigation: {
                    nextEl: $next,
                    prevEl: $prev,
                },
                breakpoints: {
                    // when window width is >=
                    768: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    },
                    991: {
                        slidesPerView: 1,
                        spaceBetween: 30
                    },
                }
                // autoplay: {
                //     delay: 7000,
                //     disableOnInteraction: false,
                // },
            });
        });
    }
}

export default CommonSlider;