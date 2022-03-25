'use strict';

/**
 * Яндекс карты
 */

class Ymaps {
    constructor() {
        this.$map = document.querySelectorAll('[data-map]');
        this.init();
        this.options = {
            balloon: 'with-balloon',
        };
    }

    init() {
        if (!this.$map.length) return false;
        this.initYaMap();
        window.addEventListener('resize orientationchange', this.checkWindowSize.bind(this));
    }

    checkWindowSize() {
        if (window.innerWidth < 992) {
            this.placeMark.balloon.close();
        } else {
            this.placeMark.balloon.open();
        }
    }

    initYaMap() {
        this.BASE_URL = document.body.getAttribute('data-home');
        this.mapKey = this.$map[0].getAttribute('data-key');
        this.yaMapApiUrl = '//api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=' + this.mapKey;
        this.objectsMap = null;
        this.placeMark = null;

        $.ajax({
            url: this.yaMapApiUrl,
            dataType: 'script',
            success: this.yaMapRun.bind(this),
        });
    }

    yaMapRun() {
        const self = this;
        self.$map.forEach((el) => {
            let hasBalloon = el.getAttribute('data-map').length;
            ymaps.ready(() => {
                self.objectsMap = new ymaps.Map(el, {
                    center: [55.75399400, 37.62209300],
                    contols: ['zoomControl'],
                    zoom: 6,
                });
                self.createPlacemark(hasBalloon);
            });
        });
    }

    /**
     *
     * @param balloon Boolean
     */
    createPlacemark(balloon) {
        if (balloon) {
            this.placeMark = window.myPlacemark = new ymaps.Placemark(this.objectsMap.getCenter(), {
                balloonContent: this.createBalloon(),
            }, {
                balloonShadow: false,
                balloonLayout: this.createBalloonLayout(),
                balloonContentLayout: this.createBallonContentLayout(),
                balloonPanelMaxMapArea: 0,
                iconLayout: 'default#image',
                iconImageSize: [47, 60],
                iconImageOffset: [-34, -35],
                hideIconOnBalloonOpen: false,
                iconImageHref: this.BASE_URL + '/assets/images/icons/map-marker.svg',
            });
        } else {
            this.placeMark = window.myPlacemark = new ymaps.Placemark(this.objectsMap.getCenter(), {}, {
                iconLayout: 'default#image',
                iconImageSize: [32, 40],
                iconImageOffset: [-34, -35],
                iconImageHref: this.BASE_URL + '/assets/images/icons/map-marker.svg',
            });
        }

        this.setMap(balloon);
    }

    createBalloon() {
        const {phones, emails, title, address} = contactPoints;
        return `
        <div class="ballon__body">
            <div class="nx-balloon__content">
                <div class="nx-balloon__title">${title}</div>
                <div class="nx-contacts">
                    <div class="nx-contacts__item">
                        <div class="nx-contacts__label">Адрес:</div>
                        <div class="nx-contacts__text">${address}</div>
                    </div>
                    <div class="nx-contacts__item">
                        <div class="nx-contacts__label">Телефон:</div>
                        <div class="nx-contacts__text">${this.createBalloonList(phones, 'link')}</div>
                    </div>
                    <div class="nx-contacts__item">
                        <div class="nx-contacts__label">Электронная почта:</div>
                        <div class="nx-contacts__text">${this.createBalloonList(emails)}</div>
                    </div>
                </div>
           </div>
        </div>`;
    }

    createBalloonList(list, type) {
        return list.reduce((acc, cur) => {
            type ?
                acc += `<a href="tel:${cur.replace(/[^-0-9]/gim, '')}" class="nx-contacts__link">${cur}</a>` :
                acc += `<a href="mailto:${cur}" target="_blank" rel="nofollow noopener" class="nx-contacts__link">${cur}</a>`;
            return acc;
        }, '');
    }

    createBallonContentLayout() {
        return ymaps.templateLayoutFactory.createClass('$[properties.balloonContent]');
    }

    createBalloonLayout() {
        const MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
            '<div class="popover nx-balloon">' +
            '<a class="close" href="#"><svg class="close-icon"><use xlink:href="#icon-close"></use></svg></a>' +
            '<div class="arrow"></div>' +
            '$[[options.contentLayout observeSize minWidth=340 maxWidth=340 minHeight=340 maxHeight=340]]' +
            '</div>', {
                build: function() {
                    this.constructor.superclass.build.call(this);

                    this._$element = this.getParentElement().querySelector('.popover');

                    this.applyElementOffset();

                    this._$element.querySelector('.close').addEventListener('click', $.proxy(this.onCloseClick, this));
                },
                clear: function() {
                    const $closeBtn = this._$element.querySelector('.close');
                    $closeBtn.removeEventListener('click', $.proxy(this.onCloseClick, this));

                    this.constructor.superclass.clear.call(this);
                },
                onSublayoutSizeChange: function() {
                    MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);

                    if (!this._isElement(this._$element)) {
                        return;
                    }

                    this.applyElementOffset();

                    this.events.fire('shapechange');
                },
                applyElementOffset: function() {
                    this._$element.style.position = 'absolute';
                    this._$element.style.top = -(this._$element.offsetHeight / 2 - 20) + 'px';
                    this._$element.style.left = this._$element.offsetWidth / 10 + 'px';
                },
                onCloseClick: function(e) {
                    e.preventDefault();

                    this.events.fire('userclose');
                },
                getShape: function() {
                    if (!this._isElement(this._$element)) {
                        return MyBalloonLayout.superclass.getShape.call(this);
                    }

                    var position = this._$element.position();

                    return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle([
                        [position.left, position.top], [
                            position.left + this._$element.offsetWidth,
                            position.top + this._$element.offsetHeight +
                            this._$element.querySelector('.arrow').offsetHeight,
                        ],
                    ]));
                },
                _isElement: function(element) {
                    return element && element[0] && element.find('.arrow')[0];
                },
            });
        return MyBalloonLayout;
    }

    /**
     *
     * @param balloon boolean
     */
    setMap(balloon) {
        this.objectsMap.geoObjects.add(this.placeMark);
        this.objectsMap.behaviors.disable('scrollZoom');
        if (window.innerWidth >= 992 && balloon) {
            this.placeMark.balloon.open();
        }
        if ($.nx.isTouch()) this.objectsMap.behaviors.disable('drag');
        const position = this.objectsMap.getGlobalPixelCenter();
        window.addEventListener('resize', () => {
            this.setMapOffset(this.objectsMap, position);
        });
    }

    setMapOffset(map, position) {
        if (!position || !map) return false;
        if (window.innerWidth <= 768) {
            console.log('xs');
            map.setGlobalPixelCenter([position[0], position[1]]);
        } else {
            console.log('sm');
            map.setGlobalPixelCenter([position[0] + 120, position[1]]);
        }
    }
}

export default Ymaps;