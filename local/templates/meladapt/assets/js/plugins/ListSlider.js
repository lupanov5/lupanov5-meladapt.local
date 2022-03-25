"use strict";
/**
 * Слайдер с несколькими элементами
 */

import Swiper from 'swiper';

class ListSlider {
    constructor() {
        this.dataName = {
          listSlider: 'list-slider',
          listSliderNext: 'list-slider-next',
          listSliderPrev: 'list-slider-prev'
        };
    }

    init($container){
        let $listSlider = $container.querySelectorAll(`[data-${this.dataName.listSlider}]`);

        if (!$listSlider.length) return false;

        $listSlider.forEach((el) => {
            let $self = el,
                $next = $self.querySelector(`[data-${this.dataName.listSliderNext}]`),
                $prev = $self.querySelector(`[data-${this.dataName.listSliderPrev}]`);

            let listSlider = new Swiper(el, {
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
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    991: {
                        slidesPerView: 4,
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

export default ListSlider;