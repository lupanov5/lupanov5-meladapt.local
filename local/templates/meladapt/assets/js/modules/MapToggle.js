'use strict';
/**
 * Переключение карты
 */

class MapToggle {
    constructor(element, options) {
        this.options = {
            hide: 'Скрыть карту',
            show: 'Показать карту'
        };

        this.dataName = {
            mapLink: 'map-link',
            mapLinkText: 'map-link-text',
            mapTarget: 'map-target'
        };

        this.className = {
            hidden: 'hidden',
        };

        this.$el = document.querySelectorAll(`[data-${this.dataName.mapLink}]`) || element;

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init() {
        this.bindEvents();
    }

    //Method for all events
    bindEvents() {
        this.$el.forEach(($el) => {
            $el.addEventListener('click', this.changeMapVisibility.bind(this));
        });
    }

    changeMapVisibility(e) {
        e.preventDefault();
        const $self = e.currentTarget,
            $text = $self.querySelector(`[data-${this.dataName.mapLinkText}]`),
            $mapTarget = document.querySelector(`[data-${this.dataName.mapTarget}]`);
        if ($mapTarget.classList.contains(this.className.hidden)) {
            $mapTarget.classList.remove(this.className.hidden);
            $text.textContent = this.options.hide;
        } else {
            $mapTarget.classList.add(this.className.hidden);
            $text.textContent = this.options.show;
        }
    }

}

export default MapToggle;