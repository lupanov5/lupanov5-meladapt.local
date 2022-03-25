'use strict';
/**
 * Всплывающий информер о  добавлении товара в корзину
 *
 * Опции:
 * @delay - задержка перед закрытием
 *
 * Опции:
 * @clickedClose - техническая опция
 * @informerTimeout - техническая опция
 *
 * Дата-атрибуты
 * @informer - дата-атрибут для контейнера
 * @informerTitle - дата-атрибут для заголовка товара
 * @informerCounter - дата-атрибут для количества товара
 * @informerPrice - дата-атрибут для цены товара
 * @informerClose - дата-атрибут для кнопки "закрыть информер"
 *
 * Классы:
 * @active - для показа информера
 */

class CartInformer{
    constructor() {
        this.options = {
            informerTimeout: null,
            delay: 2000,
            clickedClose: false
        };

        this.dataName = {
            informer: 'informer',
            informerTitle: 'informer-title',
            informerCounter: 'informer-counter',
            informerPrice: 'informer-price',
            informerClose: 'informer-close'
        };

        this.className = {
            active: 'active'
        };

        this.$informer = document.querySelector(`[data-${this.dataName.informer}]`);
        this.$informerClose = document.querySelectorAll(`[data-${this.dataName.informerClose}]`);

        this.init();
    }

    //Method for run all class methods
    init(){
        if(!this.$informer) return false;
        this.bindEvents();
    }

    //Method for all events
    bindEvents(){
        this.$informer.addEventListener('mouseover', this.saveInformerPosition.bind(this));
        this.$informer.addEventListener('mouseleave', this.closeInformerByMouseLeave.bind(this));
        this.$informerClose.forEach(($el) => {
            $el.addEventListener('click', this.closeInformerByClick.bind(this));
        });
    }

    saveInformerPosition() {
        clearTimeout(this.options.informerTimeout);
    }

    closeInformerByMouseLeave() {
        if (!this.options.clickedClose) {
            this.options.informerTimeout = setTimeout(() => {
                this.$informer.classList.remove(this.className.active);
            }, 500);
        }
    }

    closeInformerByClick(e) {
        e.preventDefault();
        e.stopPropagation();
        this.$informer.classList.remove(this.className.active);
        clearTimeout(this.options.informerTimeout);
        this.options.clickedClose = true;
    }

    /**
     * @param title
     * @param price
     * @param cnt
     */
    showInformer(title, price, cnt) {
        const $informer = this.$informer,
            $informerTitle = $informer.querySelector(`[data-${this.dataName.informerTitle}]`),
            $informerPrice = $informer.querySelector(`[data-${this.dataName.informerPrice}]`),
            $informerCnt = $informer.querySelector(`[data-${this.dataName.informerCounter}]`);
        $informerTitle.textContent = title;
        $informerPrice.textContent = $.nx.addSpaces(price);
        $informerCnt.textContent = cnt;
        $informer.classList.add(this.className.active);
        this.options.informerTimeout = setTimeout( () => {
            this.$informer.classList.remove(this.className.active);
        }, this.options.delay || 2000);
    }

}

export default CartInformer;