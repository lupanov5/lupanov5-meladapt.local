/*
* CookiePolicyPopup
* Класс управляет отображением popup с текстом политики сбора cookies на всех страницах
* при закрытии popup сохраняет cookie на время cookieExpiration
* по истечении времени cookieExpiration будет показан popup до очередного закрытия
*
* Примечания:
* - для мультиязычных сайтов сохраняет отдельные cookie
* - чтобы получить язык атрибут lang, тега html должен быть установлен
*/

'use strict';

class CookiePolicyPopup {
    constructor(element, options) {
        this.options = {
        };

        this.className = {
            hidden: 'hidden'
        };

        this.dataName = {
            cookiePopup: 'cookie-popup',
            cookieBtn: 'cookie-btn'
        };

        // Мкльтиязычность: ролучить язык страницы для поствикса в имя cookie
        this.$lang = document.querySelector('html').getAttribute('lang');
        this.$lang = (this.$lang) ? this.$lang: "";

        this.customParams = {
            cookieExpiration: 30*24*60*60,  // Срок жизни cookie в секундах
            cookieName: 'HideCookiePolicyPopup'+this.$lang
        };

        // найти блок с сообщением
        this.$popup = document.querySelector(`[data-${this.dataName.cookiePopup}]`);
        // повесить обработчик на кнопку
        this.$btn = document.querySelector(`[data-${this.dataName.cookieBtn}]`);

        $.extend(true, this, this, options);

        this.init();
    }

    // инициализируем функции
    init(){
        if (!this.$popup || !this.$btn) return; // если элементы попап и button не найдены то выполнение скрипта прерывается

        this.showPopup(); // функция отображения popup
        this.bindEvents(); // функция обработки закрытия
    }

    showPopup() {
        if ($.nx.getCookie(this.customParams.cookieName)) {
            this.$popup.classList.add(this.className.hidden);
        } else {
            this.$popup.classList.remove(this.className.hidden);
        }
    }

    bindEvents(){
        this.$btn.addEventListener('click', this.closePopup.bind(this));
    }

    closePopup(e) {
        let cookieOptions = {
            expires: this.customParams.cookieExpiration,
            path: "/"
        };
        $.nx.setCookie(this.customParams.cookieName, false, cookieOptions);
        this.$popup.classList.add(this.className.hidden);
    }
}
export default CookiePolicyPopup;

// ипортируем функцию в app.js и создаем объект new Function();
