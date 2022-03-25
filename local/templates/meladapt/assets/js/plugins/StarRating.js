"use strict";
/**
 * Рейтинг со "звёздами"
 */
import 'bootstrap-star-rating';

class StarRating {
    constructor() {
        this.init();
    }

    init(){
        this.bindEvents();
    }

    bindEvents(){
        document.addEventListener('DOMContentLoaded', this.initStarRating.bind(this));
    }

    initStarRating(){
        const $starRating = $('[data-star-rating]');

        if (!$starRating.length) return false;
        $starRating.on('rating:hover', function(event, value, caption, target) {
            console.log(value, caption, target);
        });
        $starRating.each((i, e) => {
            $(e).rating({
                emptyStar: '<i class="star-rating__empty mdi mdi-star-outline"></i>',
                filledStar: '<i class="star-rating__fill mdi mdi-star"></i>',
                step: 0.1,
                size: 'sm',
                showCaption: false,
                clearCaption:"Не оценивалось",
                starCaptions:{
                    0.1: '0.1 Звезды',
                    0.2: '0.2 Звезды',
                    0.3: '0.3 Звезды',
                    0.4: '0.4 Звезды',
                    0.5: 'Пол Звезды',
                    0.6: '0.6 Звезды',
                    0.7: '0.7 Звезды',
                    0.8: '0.8 Звезды',
                    0.9: '0.9 Звезды',
                    1: 'Одна Звезда',
                    1.1: '1.1 Звезды',
                    1.2: '1.2 Звезды',
                    1.3: '1.3 Звезды',
                    1.4: '1.4 Звезды',
                    1.5: 'Полторы Звезды',
                    1.6: '1.6 Звезды',
                    1.7: '1.7 Звезды',
                    1.8: '1.8 Звезды',
                    1.9: '1.9 Звезды',
                    2: 'Две Звезды',
                    2.1: '2.1 Звезды',
                    2.2: '2.2 Звезды',
                    2.3: '2.3 Звезды',
                    2.4: '2.4 Звезды',
                    2.5: 'Две с половиной Звезды',
                    2.6: '2.6 Звезды',
                    2.7: '2.7 Звезды',
                    2.8: '2.8 Звезды',
                    2.9: '2.9 Звезды',
                    3: 'Три Звезды',
                    3.1: '3.1 Звезды',
                    3.2: '3.2 Звезды',
                    3.3: '3.3 Звезды',
                    3.4: '3.4 Звезды',
                    3.5: 'Три с половиной Звезды',
                    3.6: '3.6 Звезды',
                    3.7: '3.7 Звезды',
                    3.8: '3.8 Звезды',
                    3.9: '3.9 Звезды',
                    4: 'Четыре Звезды',
                    4.1: '4.1 Звезды',
                    4.2: '4.2 Звезды',
                    4.3: '4.3 Звезды',
                    4.4: '4.4 Звезды',
                    4.5: 'Четыре с половиной Звезды',
                    4.6: '4.6 Звезды',
                    4.7: '4.7 Звезды',
                    4.8: '4.8 Звезды',
                    4.9: '4.9 Звезды',
                    5: 'Пять Звезд',

                }
            });
        });
    }
}

export default StarRating;
