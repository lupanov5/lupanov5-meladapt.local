"use strict";
/**
 * В основном тут собраны хелперы
 */
import easyScroll from 'easy-scroll';

class Nx {
    constructor() {
        this.$body = document.getElementsByTagName('body')[0];

        this.plugins = {
            container: document,
            initialize: []
        };

        this.className = {
            hasTouch: 'has-touch',
            msiUser: 'msi-user'
        };

        this.init();
    }

    //Method for run all class methods
    init(){
        this.bindsEvent();
        this.wrapTableIntoDiv();
        this.loadSvgSprite();
    }

    //Method for all events
    bindsEvent(){
        document.addEventListener( "DOMContentLoaded", () => {
            const $scrollBtn = document.querySelector('[data-scrolltop]');
            if($scrollBtn) {
                $scrollBtn.addEventListener('click', this.scrollTop.bind(this));
            }
            this.isTouch();
            this.isIE();
            this.initPlugins();
        });

        window.addEventListener('resize', () => {
            this.isTouch();
            this.isIE();
        });
    }

    /**
     * Trigger init method in all class instance
     * @param $container - container in dom for find plugin container
     */
    initPlugins($container){
        if (!this.plugins.initialize.length || !this.plugins.container && !$container) return false;

        for (let i = 0; i < this.plugins.initialize.length; i++){
            this.plugins.initialize[i].init($container || this.plugins.container);
        }
    }

    /**
     * Add new instance class for plugin init
     * @param newPlugin - object or array
     */
    addPlugin(newPlugin) {
        if (Array.isArray(newPlugin)) {
            for (let i = 0; i < newPlugin.length; i++) {
                this.plugins.initialize.push(newPlugin[i]);
            }
        } else {
            this.plugins.initialize.push(newPlugin);
        }
    }

    /**
     * Scroller to the top
     * @param e - event
     * @param speed - scroll speed
     */
    scrollTop(e, speed) {
        e.preventDefault();
        easyScroll({
            'scrollableDomEle': window,
            'direction': 'top',
            'duration': 500,
            'easingPreset': 'linear'
        });
    }

    /**
     * Получить текущие координаты элемента относительно документа
     * @param el -dom element
     * @returns {{top: number, left: number}}
     */
    getOffset (el) {
        const box = el.getBoundingClientRect();

        return {
            top: box.top + window.pageYOffset - document.documentElement.clientTop,
            left: box.left + window.pageXOffset - document.documentElement.clientLeft
        };
    }

    /**
     * Scroller to the element
     * @param btn - dom element which was clicked
     * @param offset - offset top after scroll
     * @param speed - scroll speed
     * @param hash - save to window.location.hash
     */
    smoothScroll(btn, offset, speed, hash) {
        let target = btn.hash,
            $target = document.querySelector(target);

        if (!$target) return false;

        let top = $.nx.getOffset($target).top;

        easyScroll({
            'scrollableDomEle': window,
            'direction': 'bottom',
            'duration': 300,
            'easingPreset': 'linear',
            'scrollAmount': top - (offset || 0)
        });
    }

    /**
     * Возвращает серилизованную строку для форм
     * @param formData
     * @returns {string}
     */
    getQueryString(formData){
        let pairs = [];
        for (let [key, value] of formData.entries()) {
            pairs.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
        }
        return pairs.join('&');
    }


    /**
     * Wrap table into div
     * @param $el - dom jquery element
     */
    wrapTableIntoDiv($el) {
        let $contentBox = $el || document.querySelectorAll('.text, [data-table-wrap]');

        if (!$contentBox.length) return false;

        // $contentBox.forEach((el) => {
        //     let $table = el.querySelector('table'),
        //         wrapEl = '<div class="table-wrap"/>';
        //     //if ($table) $table.wrap(wrapEl);
        //     this.wrap($table, wrapEl);
        // });
        this.wrap('[data-table-wrap]', 'div')
    }

    wrap(query, tag) {
        const $tableWrap = document.querySelectorAll(query),
            $tableList = [];
        $tableWrap.forEach((el) => {
            $tableList.push(...el.querySelectorAll('table'));
        });
        $tableList.forEach(elem => {
            const div = document.createElement(tag);
            div.classList.add('table-wrap');
            console.log(elem);
            elem.parentElement.insertBefore(div, elem);
            div.appendChild(elem);
        });
    };

    // load async svg sprite
    loadSvgSprite() {
        const svgUrl = `/local/templates/meladapt/assets/svg.min.html`,
            xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function (data) {
            if (xhr.readyState !== 4) return;
            let div = document.createElement('div');
            div.classList.add('svg-icons');
            div.innerHTML = String(data.currentTarget.responseText);
            document.body.appendChild(div);
        };
        xhr.open('GET', svgUrl);
        xhr.send();
    }

    /**
     * Method removes spaces in string
     * @param str - string
     * @returns {string}
     */
    removeSpaces(str) {
        let strRegExp = /\s+/g;

        if (typeof str === 'string') {
            str = str.replace(strRegExp, '');
        } else {
            str = String(str).replace(strRegExp, '');
        }
        return str;
    }

    /**
     * Method adds spaces in string
     * @param str - string
     * @returns {string}
     */
    addSpaces(str) {
        let strRegExp = /(\d)(?=(\d\d\d)+([^\d]|$))/g;

        if (typeof str === 'string') {
            str = str.replace(strRegExp, '$1 ');
        } else {
            str = String(str).replace(strRegExp, '$1 ');
        }
        return str;
    }

    /**
     * Method saves element position in dom
     * @param element - dom element
     */
    saveLocation(element) {
        let loc = {},
            item = element.previousElementSibling;

        loc.element = element;

        if (item.length) {
            loc.prev = item;
        } else {
            loc.parent = element.parentNode;
        }

        return loc;
    }

    /**
     * Method restore element position in dom
     * @param loc - dom element
     */
    restoreLocation(loc) {
        if (loc.parentNode) {
            loc.parentNode.insertBefore(loc.element, parent.firstChild);
        } else {
            loc.previousElementSibling.insertAdjacentElement('afterend', loc.element);
        }
    }

    /**
     * Method checks element visability in view port
     * @param el - dom element
     * @returns {boolean}
     */
    isElementInViewport (el) {
        //if (typeof jQuery === "function" && el instanceof jQuery) el = el[0];

        let rect = el.getBoundingClientRect();

        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    /**
     * Method checks object for emptiness
     * @param object - oblect for check
     * @returns {boolean}
     */
    isEmpty(object) {
        for (let prop in object) {
            if (object.hasOwnProperty(prop)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Method checks touch screen in deveces
     * @returns {boolean}
     */
    isTouch() {
        let touch = ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch;

        if (touch) {
            this.$body.classList.add(this.className.hasTouch);
        } else {
            this.$body.classList.remove(this.className.hasTouch);
        }

        return touch;
    }

    /**
     * Method checks user agent, and return true if agent is any IE
     * @returns {boolean}
     */
    isIE(){
        let ie = document.documentMode || /Edge/.test(navigator.userAgent);

        if (ie) {
            this.$body.classList.add(this.className.msiUser);
        } else {
            this.$body.classList.remove(this.className.msiUser);
        }

        return ie;
    }

    /**
     * Method returns a cookie with the name "name" if there is, if not, then undefined
     * @param name - cookie name
     * @returns cookie_name or undefined
     */
    getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    /**
     * Set cookie
     * @param name - cookie name
     * @param value - cookie value
     * @param options - An object with additional properties for setting cookies
     *   expires - Cookie expiration time. It is interpreted differently depending on the type:
     *     Number - the number of seconds before the expiration. For example, expires: 3600 - cookie per hour.
     *     Date Object - Expiration Date.
     *     If expires in the past, then the cookie will be deleted.
     *     If expires is absent or 0, then the cookie will be set as a session one and will disappear when the browser is closed.
     *   path - cookie path.
     *   domain - cookie domain.
     *   secure - If true, only send the cookie over a secure connection..
     */
    setCookie(name, value, options) {
        options = options || {};

        let expires = options.expires;

        if (typeof expires == "number" && expires) {
            let d = new Date();
            d.setTime(d.getTime() + expires * 1000);
            expires = options.expires = d;
        }
        if (expires && expires.toUTCString) {
            options.expires = expires.toUTCString();
        }

        value = encodeURIComponent(value);

        let updatedCookie = name + "=" + value;

        for (let propName in options) {
            updatedCookie += "; " + propName;
            let propValue = options[propName];
            if (propValue !== true) {
                updatedCookie += "=" + propValue;
            }
        }
        document.cookie = updatedCookie;
    }

    /**
     * Method delete cookie
     * @param name - название cookie,
     */
    deleteCookie(name) {
        this.setCookie(name, {}, { expires: -1, path: '/' });
    }

    /**
     * Declines a word according to a number
     * Call: decline(count, ['найдена', 'найдено', 'найдены']);
     * @param number - the number with which you want to decline the word
     * @param titles - array of inclined word variants
     * @returns {string} - returns a suitable word
     */
    decline(number, titles) {
        let cases = [2, 0, 1, 1, 1, 2];
        return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
    }

    /**
     * Records the current declension of a word when changing a number
     * @param obj - jquery oblect with (ex)data-words="найдена, найдено, найдены"
     * @param cnt - (int)number
     */
    writeDecline(obj, cnt) {
        let $decline = obj;
        if (!$decline.length) return false;
        $decline.forEach((el) => {
            let $dec = el,
                decWords = $dec.getAttribute('data-words'),
                arr = decWords.split(',');
            $dec.textContent = this.decline(cnt, arr);
        });
    }

    indexInParent(node) {
        let children = node.parentNode.childNodes,
            num = 0;
        for (let i = 0; i < children.length; i++) {
            if (children[i] === node) return num;
            if (children[i].nodeType === 1) num++;
        }
        return -1;
    }

    /**
     * inserts a preloader into content with various css modifiers
     * @param obj - dom jquery object for preloader
     * @param replace - {bool}
     *   true - replace all inner html
     *   false - insert preloder at end (save html)
     * @param theme (not necessary) - css modificator
     */
    insertPreloader(obj, replace, theme) {
        let $obj = obj,
            additClass = theme ? 'nx-preloader_'+theme : '',
            preloaderEl = '[data-preloader]',
            hiddenClass = 'hidden',
            preloaderHtml =
                `<div class="nx-preloader ${additClass}" data-preloader><div class="nx-preloader__el"></div></div>`;

        if ($obj.querySelector(preloaderEl) !== null) {
            $obj.querySelector(preloaderEl).classList.remove(hiddenClass);
        } else {
            if (replace) {
                $obj.innerHTML = preloaderHtml;
            }else{
                $obj.insertAdjacentHTML('beforeend', preloaderHtml);
            }
        }
    }

    /**
     * Hide preloader
     * @param obj - jquery oblect with preloader
     * @param del - {boolean}
     *   true - preloader delete from DOM
     *   false or empty - preloader added class hidden
     */
    hidePreloader(obj, del) {
        let $obj = obj,
            preloaderEl = '[data-preloader]',
            hiddenClass = 'hidden';

        if ($obj.querySelector(preloaderEl)) {
            $obj.querySelector(preloaderEl).classList.add(hiddenClass);
            if(del) $obj.querySelector(preloaderEl).parentNode.removeChild($obj);
        }
    }

    /**
     * Gets the key number
     * @param event
     * @returns {*} - key number
     */
    getChar(event) {
        if (event.which === null) {
            if (event.keyCode < 32) return null;
            return String.fromCharCode(event.keyCode); // IE
        }
        if (event.which !== 0 && event.charCode !== 0) {
            if (event.which < 32) return null;
            return String.fromCharCode(event.which); // остальные
        }
        return null; // специальная клавиша
    }

    matches (el, selector) {
        return (el.matches || el.matchesSelector || el.msMatchesSelector || el.mozMatchesSelector || el.webkitMatchesSelector || el.oMatchesSelector).call(el, selector);
    };

    /**
     * Scrollbar width
     * @returns {number}
     */
    scrollbarWidth() {
        let w1 = window.offsetWidth,
            w2 = window.clientWidth;
        return (w1 - w2);
    }
}

export default Nx;

