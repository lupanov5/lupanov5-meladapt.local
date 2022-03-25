'use strict';
/**
 * Дейтпикер
 */

import flatpickr from "flatpickr";
import { Russian } from "flatpickr/dist/l10n/ru.js"

class DatePicker {
    constructor() {}

    init($container){
        let $date = $container.querySelectorAll('[data-date-input]');

        $date.forEach(($el) => {
            flatpickr($el, {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: Russian,
                disableMobile: true,
                onChange: () => {
                    const $label = $el.closest('[data-dynamic-label]');
                    $label.classList.add('focused');
                }
            });


        })
    }
}

export default DatePicker;