"use strict";

// Модалка
import MicroModal from 'micromodal';

/**
 * Плагин для модалок
 * https://github.com/Ghosh/micromodal
 * openTrigger - атрибут для открытия модалки
 * closeTrigger - атрибут для закрытия модалки
 * openClass - класс для открытой модалки
 */
class Modal {
    constructor() {
        this.$el = document.querySelectorAll('[data-custom-close]');
    }

    init(){
        if(!this.$el.length) return false;

        MicroModal.init({
            openTrigger: 'data-custom-open',
            closeTrigger: 'data-custom-close',
            openClass: 'is-open',
            disableScroll: true,
            disableFocus: false,
            awaitOpenAnimation: false,
            awaitCloseAnimation: false,
            debugMode: true
        });
    }
}

export default Modal;

