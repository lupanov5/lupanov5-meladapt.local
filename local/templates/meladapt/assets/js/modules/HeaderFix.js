'use strict';

/**
 * Фиксирование шапки при скроле
 */
class  HeaderFix{
    constructor(element, options) {
        this.options = {};

        this.className = {
            fixed: 'fixed',
            animate: 'animate'
        };

        this.dataName = {
            header: 'header'
        };

        this.$header = document.querySelector(`[data-${this.dataName.header}]`);
        this.offset = 300;

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init() {
        this.bindEvents();
    }

    //Method for all events
    bindEvents() {
        window.addEventListener('scroll', this.headerFixOnScroll.bind(this));
    }

    headerFixOnScroll() {
        if (window.innerWidth >= 768) {
            if (window.pageYOffset > this.offset) {
                this.$header.classList.add(this.className.fixed);
            } else {
                this.$header.classList.remove(this.className.fixed);
            }
        }
    }
}

export default HeaderFix;