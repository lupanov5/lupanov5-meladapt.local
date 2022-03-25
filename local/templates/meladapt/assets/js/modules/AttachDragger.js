'use strict';

/**
 * Прокрутка блока перетаскиванием (используется в основном для таблиц);
 *
 * Дата-атрибуты:
 * @data-attach-dragger - дата-атрибут для блока, который будет перетаскиваться
 *
 * Все опции технические
 */

class AttachDragger {
    constructor(element, options) {
        this.options = {
            attachment: false,
            lastPosition: null,
            position: null,
            difference: null,
        };

        this.events = ['mousedown', 'mouseup', 'mousemove', 'touchmove', 'touchstart', 'touchend'];

        this.$el = document.querySelectorAll(`[data-attach-dragger]`);

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init() {
        this.bindEvents();
    }

    //Method for all events
    bindEvents() {
        document.addEventListener('mouseup', () => this.options.attachment = false);
        this.events.forEach((event) => {
            this.$el.forEach((el) => {
                el.addEventListener(event, this.scrollHandler.bind(this));
            });
        });
    }

    /**
     * Mouse and touch handler
     * @param e - event
     */
    scrollHandler(e) {
        let $box = e.currentTarget,
            isMultiple = $box.getAttribute('data-attach-dragger') === 'multiple';

        $box = isMultiple ? this.$el : e.currentTarget;

        if (e.type === 'mousedown') {
            this.options.attachment = true;
            this.options.lastPosition = [e.clientX, e.clientY];
        }

        if (e.type === 'touchstart') {
            this.options.attachment = true;
            this.options.lastPosition = [e.touches[0].clientX, e.touches[0].clientY];
        }

        if (e.type === 'mouseup' || e.type === 'touchend') this.options.attachment = false;

        if ((e.type === 'mousemove' || e.type === 'touchmove') && this.options.attachment === true) {

            if (e.type === 'mousemove') this.options.position = [e.clientX, e.clientY];
            if (e.type === 'touchmove') this.options.position = [e.touches[0].clientX, e.touches[0].clientY];

            let diffX = this.options.position[0] - this.options.lastPosition[0],
                diffY = this.options.position[1] - this.options.lastPosition[1];
            this.options.difference = [diffX, diffY];

            if (isMultiple) {
                $box.forEach((el) => {
                    el.scrollLeft = el.scrollLeft - this.options.difference[0];
                    el.scrollTop = el.scrollTop - this.options.difference[1];
                });
            } else {
                $box.scrollLeft = $box.scrollLeft - this.options.difference[0];
                $box.scrollTop = $box.scrollTop - this.options.difference[1];
            }

            if (e.type === 'mousemove') this.options.lastPosition = [e.clientX, e.clientY];
            if (e.type === 'touchmove') this.options.lastPosition = [e.touches[0].clientX, e.touches[0].clientY];
        }
    }
}

export default AttachDragger;