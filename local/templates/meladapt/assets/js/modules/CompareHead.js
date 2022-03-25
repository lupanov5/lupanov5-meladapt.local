'use strict';
/**
 * Прокрутка блока со списком товаров в "сравнении" при появляющегося при прокрутке страницы вниз перетаскиванием
 */
class CompareHead {
    constructor(element, options) {
        this.options = {
        };

        this.dataName = {
            compareHead: 'compare-head',
            compareBody: 'compare-body'
        };

        this.className = {
            show: 'show'
        };

        this.$el = document.querySelector(`[data-${this.dataName.compareHead}]`);

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init(){
        this.bindEvents();
    }

    //Method for all events
    bindEvents(){
        if(!this.$el) return false;
        window.addEventListener('scroll', this.checkCompareHead.bind(this));
    }
    /**
     * Mouse and touch handler
     * @param e - event
     */
    checkCompareHead(e){
        const compareBody = document.querySelector(`[data-${this.dataName.compareBody}]`),
            coordsBottom = compareBody.getBoundingClientRect().bottom;
        if(coordsBottom >= 0) {
            this.$el.classList.remove(this.className.show);
        } else {
            this.$el.classList.add(this.className.show);
        }
    }
}

export default CompareHead;