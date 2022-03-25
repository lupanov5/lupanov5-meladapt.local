import IMask from 'imask';


/**
* Инициализация multi inputmask с async запросом
* Dependencies:
*/
;(function(){
    'use strict';

    $(function () {
        let phoneMask = new NxPhoneMask();
    });

    class NxPhoneMask {
        constructor($element, options){
            this.$el = $element || document.querySelectorAll('[data-phone-mask]');

            this.options = {
                jsonUrl: `/assets/phone-codes.json?${new Date().getTime()}`,
                setCursorToTextEnd: false
            };

            this.maskOpts = {
                match: /[0-9]/,
                replace: '#',
                mask: '+{7}(000)000-00-00',
                listKey: "mask"
            };

            this.init();

            $.extend(true, this, this, options);
        }

        //Method for run all class methods
        init() {
            if (!this.$el.length) return false;

            this.loadJsonPhones();
            this.bindEvents();
        }

        //Method for all events
        bindEvents() {
            if (this.options.setCursorToTextEnd) {
                this.$el.forEach(($el) => {
                   $el.addEventListener('keyup', this.setCursorToTextEnd.bind(this));
                });
            }
        }

        // Input mask init after json phones loaded
        loadJsonPhones() {
            $.getJSON(this.options.jsonUrl)
                .done((data)=>{
                    //this.maskOpts.mask = $.masksSort(data, ['#'], /[0-9]|#/, "mask");
                    this.$el.forEach(($el) => {
                       IMask($el, this.maskOpts);
                    });
                })
                .fail((err)=>{
                    console.log(`Phone mask json load: ${err.statusText}`, err);
                });
        }

        /**
         * The cursor puts at the end of the entered text in input
         * @param e - event
         */
        setCursorToTextEnd(e) {
            let initialVal = $(e.currentTarget).val();
            $(e.currentTarget).val(initialVal);
        }
    }
})();