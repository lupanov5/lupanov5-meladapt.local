(function() {
    'use strict';
    /**
     * Динамический лейбл у форм
     */

    //init
    document.addEventListener( "DOMContentLoaded", function() {
        document.querySelectorAll('[data-dynamic-inp]').forEach(($el) => {
            let dynamicFormLabel = new NxDynamicFormLabel($el);
        });
    });

    class NxDynamicFormLabel{
        constructor(element, options) {
            this.options = {
                valLength: 0
            };

            this.className = {
                focused: 'focused'
            };

            this.dataName = {
                dynamicInp: 'dynamic-inp',
                dynamicLabel: 'dynamic-label'
            };

            this.el = element || document.querySelector(`[data-${this.dataName.dynamicInp}]`);

            this.$parent = this.el.closest(`[data-${this.dataName.dynamicLabel}]`);

            this.init();
        }

        //Method for run all class methods
        init(){
            if (!this.el) return false;
            this.bindEvents();
            this.switchFocusClass();
        }

        //Method for all events
        bindEvents(){
            this.el.addEventListener('focus', this.onElementFocusIn.bind(this));
            this.el.addEventListener('focusout', this.onElementFocusOut.bind(this));
            document.querySelectorAll(`[data-${this.dataName.dynamicLabel}]`).forEach(($el) => {
               $el.addEventListener('click', this.onLabelClick.bind(this));
            });
        }

        /**
         * Element event on focus in
         * @param e - event
         */
        onElementFocusIn(e){
            e.preventDefault();

            this.$parent.classList.add(this.className.focused);

            return false;
        }

        /**
         * Element event on focus out
         * @param e - event
         */
        onElementFocusOut(e){
            e.preventDefault();
            let $self = e.currentTarget;

            this.valLength = $self.value.length;

            this.switchFocusClass();

            return false;
        }

        /**
         * Element event on click
         * @param e - event
         */
        onLabelClick(e){
            e.preventDefault();
            const $self = e.currentTarget,
                  test = $self.querySelector(`[data-${this.dataName.dynamicInp}]`),
                  event = document.createEvent('HTMLEvents');
            event.initEvent('focus', true, false);
            test.dispatchEvent(event);
            return false;
        }

        // Element event on focus out
        switchFocusClass(){
            this.valLength = this.el.value.length;
            if (this.valLength > 0 || this.el.autofocus || this.el.getAttribute('placeholder') !== null) {
                this.$parent.classList.add(this.className.focused);
            } else {
                this.$parent.classList.remove(this.className.focused);
            }
        }
    }

})();