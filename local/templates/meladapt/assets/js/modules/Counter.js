'use strict';
/**
 * Счётчик
 *
 * Опции:
 *  @plus - тип плюс, инкримент
 *  @minus - тип минус, декримент
 *  @update - тип изменение, для замены значения
 */


class Counter{
    constructor(cart) {
        this.cart = cart;
        this.options = {
            plus: 'plus',
            minus: 'minus',
            update: 'update',
        };

        this.events = ['change'];

        this.dataName = {
            counterInp: 'counter-inp',
            counterBtn: 'counter-btn',
            counter: 'counter',
            max: 'max',
            min: 'min',
        };

        this.className = {
            disabled: 'disabled',
            sending: 'sending',
        };

        this.$counterBtn = document.querySelectorAll(`[data-${this.dataName.counterBtn}]`);
        this.$counterInput = document.querySelectorAll(`[data-${this.dataName.counterInp}]`);

        this.init();
    }

    //Method for run all class methods
    init() {
        this.bindEvents();
    }

    //Method for all events
    bindEvents() {
        this.changeCountOnLoad();
        this.$counterBtn.forEach(($el) => {
            $el.addEventListener('click', this.changeCountBtn.bind(this));
        });
        this.events.forEach((evt) => {
            this.$counterInput.forEach(($el) => {
                $el.addEventListener(evt, this.changeCountInput.bind(this));
            });
        });
    }

    changeCountBtn(e) {
        e.preventDefault();
        e.stopPropagation();
        let $self = e.currentTarget,
            type = $self.getAttribute(`data-${this.dataName.counterBtn}`),
            $parent = $self.closest(`[data-${this.dataName.counterBtn}]`);

        if ($parent.classList.contains(this.className.sending) ||
            $self.classList.contains(this.className.disabled)) return false;

        if ($self.classList.contains(this.className.sending)) return false;

        if (type === this.options.plus) {
            this.changeCount(this.options.plus, $self);
            if ($self.closest('[data-cart]')) this.cart.calcTotals($self, 'update_plus');
        }
        if (type === this.options.minus) {
            this.changeCount(this.options.minus, $self);
            if ($self.closest('[data-cart]')) this.cart.calcTotals($self, 'update_minus');
        }
    }

    /**
     *
     * @param direction
     * @param obj
     * @returns {boolean}
     */
    changeCount(direction, obj) {
        const $counter = obj.closest(`[data-${this.dataName.counter}]`),
            isSet = $counter.closest('[data-prod]').getAttribute('data-prod-type') === 'set',
            $btns = $counter.querySelectorAll(`[data-${this.dataName.counterBtn}]`),
            $input = $counter.querySelector(`[data-${this.dataName.counterInp}]`),
            $plus = $counter.querySelector(`[data-${this.dataName.counterBtn}="${this.options.plus}"]`),
            $minus = $counter.querySelector(`[data-${this.dataName.counterBtn}="${this.options.minus}"]`),
            max = parseInt($input.getAttribute(`data-${this.dataName.max}`)),
            min = 1,
            current_value = parseInt($input.value);
        let setCnt = null, setPrice = null, setWeight = null, setDiscount = null, setTotalPrice = null,
            setOldPrice = null;
            if(isSet) {
                setCnt = $counter.closest('[data-prod]').querySelectorAll('[data-set-counter]');
                setPrice = $counter.closest('[data-prod]').querySelectorAll('[data-set-price-total]');
                setWeight = $counter.closest('[data-prod]').querySelectorAll('[data-set-weight-total]');
                setDiscount = $counter.closest('[data-prod]').querySelector('[data-set-discount]');
                setTotalPrice = $counter.closest('[data-prod]').querySelector('[data-prod-price]');
                setOldPrice = $counter.closest('[data-prod]').querySelector('[data-set-old-price]');
            }
        let new_value = min;

        if (direction === this.options.plus) {
            new_value = current_value + 1;
        } else if (direction === this.options.update) {
            new_value = current_value;
        } else if (direction === this.options.minus) {
            new_value = current_value - 1;
        }

        if (direction !== this.options.update) {
            if (new_value < min) {
                return false;
            } else if (new_value === min && new_value < max) {
                obj.classList.add(this.className.disabled);
                $input.value = new_value;
                if(isSet) {
                    this.cart.calcSetTotals(setCnt, setPrice, setWeight, setDiscount, setTotalPrice, setOldPrice, new_value);
                }

            } else if (new_value === min && new_value === max) {
                obj.classList.add(this.className.disabled);
                $input.value = new_value;
                if(isSet) {
                    this.cart.calcSetTotals(setCnt, setPrice, setWeight, setDiscount, setTotalPrice, setOldPrice, new_value);
                }

            } else if (new_value < max) {
                if (new_value > 1 || max > new_value) {
                    $btns.forEach((el) => {
                        el.classList.remove(this.className.disabled);
                    });
                }
                $input.value = new_value;
                if(isSet) {
                    this.cart.calcSetTotals(setCnt, setPrice, setWeight, setDiscount, setTotalPrice, setOldPrice, new_value);
                }

            } else if (new_value >= max) {
                $plus.classList.add(this.className.disabled);
                $input.value = new_value;
                if(isSet) {
                    this.cart.calcSetTotals(setCnt, setPrice, setWeight, setDiscount, setTotalPrice, setOldPrice, new_value);
                }

            } else {
                $btns.forEach((el) => {
                   el.classList.remove(this.className.disabled)
                });
                $input.value = new_value;
                if(isSet) {
                    this.cart.calcSetTotals(setCnt, setPrice, setWeight, setDiscount, setTotalPrice, setOldPrice, new_value);
                }
            }
        } else if (direction === this.options.update) {
            if (new_value < min) {
                return false;
            }
            if (new_value >= max) {
                $input.value = max;
                Array.prototype.filter.call($btns, () => {
                   document.querySelectorAll(`[data-${this.dataName.counterBtn}="${this.options.minus}]`).forEach((el) => {
                      el.classList.add(this.className.disabled);
                   });
                });
            }
            if (new_value < max && new_value > min) {
                Array.prototype.filter.call($btns, () => {
                   document.querySelectorAll(`[data-${this.dataName.counterBtn}="${this.options.minus}]`).forEach((el) => {
                      el.classList.remove(this.className.disabled);
                   });
                });
                Array.prototype.filter.call($btns, () => {
                   document.querySelectorAll(`[data-${this.dataName.counterBtn}="${this.options.minus}]`).forEach((el) => {
                      el.classList.remove(this.className.disabled);
                   });
                });
            } else if (new_value === min) {
                Array.prototype.filter.call($btns, () => {
                   document.querySelectorAll(`[data-${this.dataName.counterBtn}="${this.options.minus}]`).forEach((el) => {
                      el.classList.remove(this.className.disabled);
                   });
                });
                Array.prototype.filter.call($btns, () => {
                   document.querySelectorAll(`[data-${this.dataName.counterBtn}="${this.options.minus}]`).forEach((el) => {
                      el.classList.add(this.className.disabled);
                   });
                });
            }
        }

        if(document.querySelector('[data-cart]')) {
            this.cart.cartTotalsUpdate($counter);
        }
    }

    changeCountInput(e) {
        e.preventDefault();
        var $this = e.currentTarget,
            $parent = $this.closest('[data-counter]'),
            inpVal = parseInt($this.value),
            maxInpVal = parseInt($this.getAttribute('data-max')),
            minInpVal = (!isNaN($this.getAttribute('data-min'))) ? parseInt($this.getAttribute('data-min')) : 1;

        if($parent.classList.contains('sending') || $this.classList.contains('disabled')) return false;

        if (inpVal == 'undefined' || inpVal <= minInpVal || inpVal == "" || isNaN(inpVal) ) {
            $this.value = minInpVal;
        }

        if(e.which !== 8 && e.which !== 9 && e.which !== 116 && e.which !== 46 && (e.which < 48 || e.which > 57) && (e.which < 96 || e.which > 105)) return false;

        this.changeCount('update',e.currentTarget);

        if (document.querySelector('[data-cart]')) this.cart.calcTotals($this, 'update');
    }

    changeCountOnLoad() {
        const $cntInput = document.querySelectorAll(`[data-${this.dataName.counterInp}]`);

        if (!$cntInput.length) return false;

        $cntInput.forEach((el, i) => {
            const $self = el,
                $minus = $self.closest(`[data-${this.dataName.counter}]`).
                    querySelector(`[data-${this.dataName.counterBtn}="minus"]`),
                $plus = $self.closest(`[data-${this.dataName.counter}]`).
                    querySelector(`[data-${this.dataName.counterBtn}="plus"]`),
                $maximum = parseInt($self.getAttribute(`data-${this.dataName.max}`)),
                val = parseInt($self.value);

            if (val <= 1 && val >= $maximum) {
                $minus.classList.add(this.className.disabled);
            } else if (val >= $maximum) {
                $plus.classList.add(this.className.disabled);
            } else if (val <= 1) {
                $minus.classList.add(this.className.disabled);
            } else {
                $minus.classList.remove(this.className.disabled);
                $plus.classList.remove(this.className.disabled);
            }
        });
    }

}

export default Counter;