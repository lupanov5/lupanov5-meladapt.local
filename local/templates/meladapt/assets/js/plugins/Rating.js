"use strict";

/**
 * Звездный рейтинг
 */
class Rating {
    constructor(rater) {
        this.rater = rater;
    }

    init(){
        const $rating = document.querySelectorAll('[data-rating]');
        if(!$rating.length) return false;
        $rating.forEach((el) => {
            const myRater = this.rater(
                {
                    element: el,
                    rateCallback: function rateCallback(rating, done) {
                        let curRating = rating.toFixed(1),
                            $ratingInp = el.querySelector('[data-rating-input]');
                        $ratingInp.value = Number(curRating);
                        this.setRating(Number(curRating));
                        done();
                    },
                    step: 0.1,
                    starSize: 32,
                });
        });

    }
}

export default Rating;

