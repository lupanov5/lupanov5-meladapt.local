"use strict";
/**
 * Слайдер цен для фильтра каталога
 */

import noUiSlider from "nouislider";

class RangeSlider {
    constructor(filter) {
        this.filter = filter;
    }

    init($container){
        let $uiSlider = $container.querySelectorAll('[data-ui-slider]');
        if (!$uiSlider.length) return false;

        $uiSlider.forEach(($el) => {
            let $slider = $el,
                step = Number($slider.getAttribute('data-step')) || 1,
                $wrapper = $slider.closest('[data-range]'),
                $min = $wrapper.querySelector('[data-ui-min]'),
                min = Number($min.getAttribute('data-ui-min')),
                $max = $wrapper.querySelector('[data-ui-max]'),
                max = Number($max.getAttribute('data-ui-max')),
                inputs = [$min, $max];

            noUiSlider.create($slider, {
                start: [min, max],
                connect: true,
                step: step,
                range: {
                    'min': min,
                    'max': max
                }
            });

            $slider.noUiSlider.on('update', (values, handle) => {
                inputs[handle].value = values[handle];
            });

            $slider.noUiSlider.on('set', () => {
                this.filter.prepareFilterSort();
            });

            inputs.forEach(function (input, handle) {
                input.addEventListener('change', function () {
                    $slider.noUiSlider.setHandle(handle, this.value);
                });
                input.addEventListener('keydown', function (e) {
                    let values = $slider.noUiSlider.get(),
                        value = Number(values[handle]),
                        steps = $slider.noUiSlider.steps(),
                        step = steps[handle],
                        position;
                    switch (e.which) {
                        case 13:
                            $slider.noUiSlider.setHandle(handle, this.value);
                            break;
                        case 38:
                            position = step[1];
                            if (position === false) {
                                position = 1;
                            }
                            if (position !== null) {
                                $slider.noUiSlider.setHandle(handle, value + position);
                            }
                            break;
                        case 40:
                            position = step[0];
                            if (position === false) {
                                position = 1;
                            }
                            if (position !== null) {
                                $slider.noUiSlider.setHandle(handle, value - position);
                            }
                            break;
                    }
                });
            });
        });
    }
}

export default RangeSlider;