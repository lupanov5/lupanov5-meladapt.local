"use strict";

import autosize from 'autosize';

// Автоматическое изменение высоты textarea при вводе текста
class AutoSizeTextarea {
    constructor() {}

    init($container){
        let $textarea = $container.querySelectorAll('[data-autosize-textarea]');

        if (!$textarea.length) return false;

        autosize($textarea);
    }
}

export default AutoSizeTextarea;

