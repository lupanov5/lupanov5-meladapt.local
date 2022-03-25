'use strict';

/**
 * Переключения доставки на этаж
 */
class DeliveryTypeToggle {
    constructor(element, options) {
        this.options = {
            floor: 'floor'
        };

        this.dataName = {
            deliveryTypeInput: 'delivery-type-input',
            deliveryInfo: 'delivery-info'
        };

        this.className = {
            visible: 'visible',
        };

        this.$el = element || document.querySelectorAll(`[data-${this.dataName.deliveryTypeInput}]`);

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init(){
        this.bindEvents();
    }

    //Method for all events
    bindEvents(){
        if(!this.$el.length) return false;
        this.$el.forEach(($el) => {
            $el.addEventListener('change', this.deliveryTypeToggle.bind(this));
        });
    }
    /**
     * Toggle delivery block visibility
     * @param e - event
     */
    deliveryTypeToggle(e) {
        const $self = e.currentTarget,
            deliveryInfo = document.querySelector(`[data-${this.dataName.deliveryInfo}]`),
            value = $self.value;
        value === this.options.floor ?
            deliveryInfo.classList.add(this.className.visible) :
            deliveryInfo.classList.remove(this.className.visible)
    }

}

export default DeliveryTypeToggle;