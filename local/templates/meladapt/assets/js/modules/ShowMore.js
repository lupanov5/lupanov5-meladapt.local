'use strict';
import Tabs from "../plugins/Tabs";
import HandyCollapse from "handy-collapse";

/**
 * Показать ещё
 */

class ShowMore{
    constructor(element, options) {
        this.dataName = {
            button: 'show-more',
            actionUrl: 'show-more-url',
            contentBox: 'load-content'
        };
        this.className = {
            sending: 'sending'
        };

        this.$button = element || document.querySelectorAll(`[data-${this.dataName.button}]`);

        this.options = {
            xhr: null
        };

        this.$contentBox = document.querySelector(`[data-${this.dataName.contentBox}]`);

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init(){
        this.bindsEvent();
    }

    //Method for all actions
    bindsEvent(){
        this.$button.forEach(($el) => {
            $el.addEventListener('click', this.showMoreRequest.bind(this));
        });
    }

    /**
     * Getting current selected value, getting current "page" value, putting preloader and calling ajax method
     * @param $target - target which was clicked
     * @param pageVal - current page value
     * @param selectedVal - selected option value
     */
    showMoreRequest(e){
        e.preventDefault();
        let $target = e.currentTarget,
            url = $target.getAttribute(`data-${this.dataName.actionUrl}`),
            pageVal = $target.getAttribute(`data-${this.dataName.button}`),
            data = {
                page: pageVal,
                ajax: 'show_more'
            };
        if ($target.classList.contains(this.className.sending)) return false;
        $target.classList.add(this.className.sending);
        $target.classList.add('disabled');
        $.nx.insertPreloader(this.$contentBox, false, 'btn');

        this.sendRequest(data, $target, url);

        new Tabs()
    }

    /**
     * Helper for send ajax on tab change
     * @param data - data for ajax send
     * @param $item - jquery element which was clicked
     * @param url - ajax url
     */
    sendRequest(data, $item, url){
        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data)
        })
        .then(res => res.json(), )
        .then(res => {
            $item.classList.remove(this.className.sending);
            $.nx.hidePreloader(this.$contentBox);
            $item.classList.remove('disabled');
            this.$contentBox.insertAdjacentHTML( 'beforeend', res.html)


            if (!res.isEnd) {
                $item.setAttribute(`data-${this.dataName.button}`, data.page + 1);
            } else {
                $item.setAttribute(`data-${this.dataName.button}`, data.page + 1);

                $item.classList.add('hidden');
            }
        })
        .catch(error => {
            $item.removeClass(this.className.sending);
            $.nx.hidePreloader(this.$contentBox);
            console.log(error);
        });
    }
}
export default ShowMore;

