"use strict";

import { CountUp } from 'countup.js';

// Анимация чисел в виде счетчика
class NumberAnimate {
    constructor() {
        this.options = {
            startValue: 0,
            smartEasingThreshold: Infinity,
            separator: ' ',
            duration: 1.5,
            useEasing: false
        };

        this.dataName = {
            animNum: 'anim-num',
            animSpeed: 'anim-speed'
        };

        this.className = {
            showed: 'showed'
        };

        this.init();
    }

    init(){
        this.bindEvents();
    }

    bindEvents(){
        document.addEventListener('DOMContentLoaded', this.animateNumbers.bind(this));
        window.addEventListener('scroll', this.animateNumbers.bind(this));
    }

    animateNumbers(){
        const $animNum = document.querySelectorAll(`[data-${this.dataName.animNum}]`);

        if (!$animNum.length) return false;

        $animNum.forEach((el) => {
            let $num = el,
                maxNum = $num.getAttribute(`data-${this.dataName.animNum}`);

            if (typeof maxNum === 'string') {
                maxNum = maxNum.replace(/[^0-9]/gim, '');
            }

            if ($.nx.isElementInViewport($num) && !$num.classList.contains(this.className.showed)) {
                $num.classList.add(this.className.showed);
                const countUp = new CountUp($num, maxNum,{
                    startVal: this.options.startValue,
                    smartEasingThreshold: this.options.smartEasingThreshold,
                    separator: this.options.separator,
                    duration: this.options.duration,
                    useEasing: this.options.useEasing
                });
                countUp.start();
            }
        });

    }
}

export default NumberAnimate;
