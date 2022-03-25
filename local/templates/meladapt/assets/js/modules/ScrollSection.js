'use strict';
/**
 * Скролл к секции
 */
class ScrollSection {
    constructor(element, options) {
        this.options = {
            tabs: 'tabs'
        };

        this.dataName = {
            scrollBtn: 'scroll-btn',
            scrollTarget: 'scroll-target'
        };

        this.scrollBtn = document.querySelectorAll(`[data-${this.dataName.scrollBtn}]`);

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init(){
        this.bindEvents();
    }

    //Method for all events
    bindEvents(){
        this.scrollBtn.forEach((el) => {
           el.addEventListener('click', this.scrollToElement.bind(this));
        });
    }

    scrollToElement(e) {
        e.preventDefault();
        e.stopPropagation();
        let $self = e.currentTarget,
            isTabs = $self.getAttribute(this.dataName.scrollBtn) === this.options.tabs;
        if(isTabs) {
            const $scrollTarget = document.querySelector(`[data-${this.dataName.scrollTarget}]`),
                event = document.createEvent('HTMLEvents');
            event.initEvent('click', true, false);
            $scrollTarget.dispatchEvent(event);
        }
        $.nx.smoothScroll($self, 90);
    }

}

export default ScrollSection;