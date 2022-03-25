"use strict";
/**
 * Слайдер-обёртка для табов
 */
import Swiper from 'swiper';

class TabsSlider {
    constructor() {
        this.dataName = {
            tabsSlider: 'tabs-slider'
        }
    }

    init($container){
        let $tabsSlider = $container.querySelectorAll(`[data-${this.dataName.tabsSlider}]`);

        if (!$tabsSlider.length) return false;

        $tabsSlider.forEach((el) => {
            let tabsSlider = new Swiper(el, {
                slidesPerView: 'auto',
                loop: false,
                autoHeight: false,
                resistanceRatio: 0,
            });
        });
    }
}

export default TabsSlider
