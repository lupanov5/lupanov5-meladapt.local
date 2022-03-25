"use strict";
/**
 * Кастомный скроллбар
 */

import OverlayScrollbars from 'overlayscrollbars';

class ScrollbarCustom {
    constructor() {}

    init($container){
        let $scrollBox = $container.querySelectorAll('[data-custom-scroll]');

        if (!$scrollBox.length) return false;

        $scrollBox.forEach(($el) => {
            new OverlayScrollbars($el, {
                className: "os-theme-dnext",
                resize: "none",
                sizeAutoCapable: true,
                scrollbars : {
                    visibility: "visible",
                    autoHide: 'leave',
                    autoHideDelay: 300
                }
            });
        });
    }
}

export default ScrollbarCustom;