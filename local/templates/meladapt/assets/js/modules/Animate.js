"use strict";

/**
 * Активация анимации при скролле
 */

const WOW = require('wowjs')

class Animate {
    constructor() {
        this.dataName = 'animate'

        this.animate = document.querySelectorAll(`[data-${this.dataName}]`)

        this.init()
    }


    init(){
        if(!this.animate.length) return false

        this.animate.forEach(el => {
            let animateType = el.dataset.animate
            switch(animateType) {
                case "fadeIn":
                    let fadeIn = new WOW.WOW({
                        live: false,
                        boxClass:     'wow-fadeIn',      // animated element css class (default is wow)
                        animateClass: 'fadeIn', // animation css class (default is animated)
                        offset:       100, // distance to the element when triggering the animation (default is 0)
                        mobile:       false
                    })
                    fadeIn.init()
                    break
                case "slideRight":
                    let slideRight = new WOW.WOW({
                        live: false,
                        boxClass:     'wow-slideRight',      // animated element css class (default is wow)
                        animateClass: 'slideRight', // animation css class (default is animated)
                        offset:       100,          // distance to the element when triggering the animation (default is 0)
                        mobile:       false
                    });
                    slideRight.init();
                    break
                case "slideLeft":
                    let slideLeft = new WOW.WOW({
                        live: false,
                        boxClass:     'wow-slideLeft',      // animated element css class (default is wow)
                        animateClass: 'slideLeft', // animation css class (default is animated)
                        offset:       100,          // distance to the element when triggering the animation (default is 0)
                        mobile:       false
                    });
                    slideLeft.init();
                    break
            }
        })
    }
}

export default Animate;
