;(function ($, undefined) {
    'use strict';
    /**
     * Табы
     */

    //init
    document.addEventListener("DOMContentLoaded",  () => {
        document.querySelectorAll('[data-nx-tabs]').forEach(($el) => {
           let tabs = new NxTabs($el);
        });
    });

    class NxTabs{
        constructor(element, options) {
            this.dataName = {
                toggle: 'nx-tabs',
                actionUrl: 'nx-url',
                id: 'load-id',
                wrapper: 'nx-tabs-wrapper',
                ajaxContent: 'ajax-content'
            };
            this.className = {
                active: 'active',
                sending: 'sending'
            };

            this.toggle = element || document.querySelector(`[data-${this.dataName.toggle}]`);
            this.wrapper = this.toggle.closest(`[data-${this.dataName.wrapper}]`);

            this.options = {
                ajaxUrl: this.toggle.getAttribute(`data-${this.dataName.actionUrl}`),
                xhr: null
            };

            this.$contentBox = this.wrapper.querySelector(`[data-${this.dataName.ajaxContent}]`);

            $.extend(true, this, this, options);

            this.init();
        }

        //Method for run all class methods
        init(){
            if (!this.toggle) return false;
            this.bindsEvent();
        }

        //Method for all events
        bindsEvent(){
            this.toggle.addEventListener('click', this.toggleTabHandler.bind(this));
        }

        /**
         * Tab switcher on click
         * @param e - event
         */
        toggleTabHandler(e) {
            e.preventDefault();
            let $target = e.currentTarget,
                $parent = $target.parentNode,
                type = $target.getAttribute(`data-${this.dataName.toggle}`),
                href = $target.getAttribute('href');

            switch (type){
                // type for content load from ajax
                case "content-load":
                    this.loadContent($target);
                    $($parent).addClass(this.className.active).siblings().removeClass(this.className.active);
                break;
                // default simple tabs
                default:
                    if (href && href !== '#') $(href).addClass(this.className.active).siblings().removeClass(this.className.active);
                    $($parent).addClass(this.className.active).siblings().removeClass(this.className.active);
            }

            return false;
        }

        /**
         * Class and preloader switcher before send ajax
         * @param $target - target which was clicked
         * TODO need testing
         */
        loadContent($target) {
            let idCat = $target.getAttribute(`data-${this.dataName.id}`),
                type = $target.getAttribute(`data-${this.dataName.toggle}`),
                $parent = $target.parentNode,
                $sibl = $($parent).siblings(),
                $allItems = $($parent).add($sibl),
                isSending = $allItems.hasClass(this.className.sending),
                isActive = $parent.classList.contains(this.className.active);
                let data = {
                    ajax: type,
                    id: idCat
                };

            // Предотвращение повторной отправки, до ответа от сервера
            if (isActive || isSending) return false;

            $allItems.addClass(this.className.sending);
            $.nx.insertPreloader(this.$contentBox, false, 'btn');

            if( this.options.xhr != null ) {
                this.options.xhr.abort();
                this.options.xhr = null;
                $parent.removeClass(this.className.sending).siblings().removeClass(this.className.sending);
            }

            this.options.xhr = this.sendRequest(data, $allItems);
        }

        /**
         * Helper for send ajax on tab change
         * @param data - data for ajax send
         * @param $item - jquery element which was clicked
         */
        sendRequest(data, $item){
            $.ajax({
                type: "POST",
                url: this.options.ajaxUrl || '',
                data: data,
                success: (res) => {
                    this.$contentBox.html(res);
                    $item.removeClass(this.className.sending);
                },
                error: (qXHR, textStatus, errorThrown) => {
                    $item.removeClass('sending');
                    $.nx.hidePreloader(this.$contentBox);
                    console.log(qXHR, textStatus, errorThrown);
                }
            });
        }
    }
})(jQuery);