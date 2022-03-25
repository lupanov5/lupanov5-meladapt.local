"use strict";
/**
 * Слайдер с миниатюрами
 */

import Swiper from 'swiper';

class GalSlider {
    constructor() {
        this.dataName = {
            gal: 'gal',
            history: 'history',
            galThumb: 'gal-thumb',
            galThumbSlide: 'gal-thumb-slide',
            galMain: 'gal-main',
            galNext: 'gal-next',
            galPrev: 'gal-prev'
        };

        this.className = {
          isDrag: 'is-drag',
          notVisible: 'not-visible',
          swiperActiveThumb:'swiper-active-thumb'
        };
    }

    init($container){
        let _this = this,
            $gal = $container.querySelectorAll(`[data-${this.dataName.gal}]`);

        if (!$gal.length) return false;

        $gal.forEach((el) => {
            let $self = el,
                dir = $self.getAttribute(`data-${this.dataName.gal}`),
                isHistory = $self.getAttribute(`data-${this.dataName.history}`),
                $thumb = $self.querySelector(`[data-${this.dataName.galThumb}]`),
                $thumbSlide = $self.querySelectorAll(`[data-${this.dataName.galThumbSlide}]`),
                $mainGal = $self.querySelector(`[data-${this.dataName.galMain}]`),
                $mainGalNext = $self.querySelector(`[data-${this.dataName.galNext}]`),
                $mainGalPrev = $self.querySelector(`[data-${this.dataName.galPrev}]`),
                dirXs = dir === 'vertical' ? 10 : 15,
                dirMd = dir === 'vertical' ? 10 : 15,
            //Init Swiper for thumbnails of main gallery
                galleryThumbs = new Swiper($thumb, {
                direction: dir || 'horizontal',
                spaceBetween: isHistory ? 0 : 10,
                slidesPerView: 'auto',
                loop: false,
                freeMode: true,
                speed: 300,
                resistanceRatio: 0.5,
                breakpoints: { //>=
                    768: {
                        spaceBetween: isHistory ? 0 : dirXs
                    },
                    992: {
                        spaceBetween: isHistory ? 0 : dirMd
                    }
                },
                on: {
                    init: function(){
                        this.update();
                        // AOS.refreshHard();
                    },
                    // slideChange: function(){
                    //     AOS.refreshHard();
                    // }
                }
            }),
            //Init Swiper for main gallery
            galleryTop = new Swiper($mainGal, {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: false,
                speed: 400,
                resistanceRatio: 0.5,
                navigation: {
                    nextEl: $mainGalNext,
                    prevEl: $mainGalPrev,
                },
                on: {
                    init: function(){
                        this.update();
                        $self.classList.remove(_this.className.notVisible);
                        _this.thumbScroll(galleryThumbs, this);
                    },
                    slideChange: function () {
                        _this.thumbScroll(galleryThumbs, this);
                    }
                }
            });

            //Add or remove dragging class into thumbnails wrapper
            galleryThumbs.on('touchStart transitionStart sliderMove', function () {
                this.$el.addClass(_this.className.isDrag);
            });
            galleryThumbs.on('touchEnd transitionEnd', function () {
                this.$el.removeClass(_this.className.isDrag);
            });

            //Update positins if thumbnail slide clicked
            $thumbSlide.forEach((el) => {
               el.addEventListener('click', (e) => {
                   e.preventDefault();
                   const $slide = e.currentTarget,
                         index = $.nx.indexInParent($slide);

                   if (galleryTop){
                       this.thumbScroll(galleryThumbs, galleryTop, index);
                       galleryTop.slideTo(index);
                   }
               });
            });
        });
    }

    /**
     * Update thumbnails wrapper position
     * @param sliderThumb
     * @param sliderMain
     * @param index
     * @returns {boolean}
     */
    thumbScroll (sliderThumb, sliderMain, index) {
        if (!sliderThumb && !sliderMain) return false;

        sliderThumb.activeIndex = index || sliderMain.activeIndex;

        let activeIndex = sliderThumb.activeIndex,
            dir = sliderThumb.params.direction,
            $activeThumb = sliderThumb.slides[activeIndex];

        if ((!sliderMain.el.offsetHeight || !sliderMain.el.offsetWidth) && (!sliderThumb.length)) return false;

        let sliderHeight = sliderMain.el.offsetHeight || 0,
            sliderWidth = sliderMain.el.offsetWidth || 0,
            sliderSize = (dir === 'horizontal') ? sliderWidth : sliderHeight,

            thumbSpaceBetween = parseInt(sliderThumb.params.spaceBetween),
            thumbCount = sliderThumb.slides.length,
            thumbHeight = $activeThumb.offsetHeight || 0,
            thumbWidth = $activeThumb.offsetWidth || 0,
            thumbSize = (dir === 'horizontal') ? thumbWidth : thumbHeight,

            thumbsSizeAll = (thumbSize + thumbSpaceBetween) * thumbCount,
            position = (sliderSize / 2) - (thumbSize / 2),
            scrollThumbSize = activeIndex * (thumbSize + thumbSpaceBetween) - position;


        if ((scrollThumbSize + sliderSize) > thumbsSizeAll) {
            scrollThumbSize = thumbsSizeAll - sliderSize - thumbSpaceBetween;
        }
        if (scrollThumbSize < 0) scrollThumbSize = 0;

        sliderThumb.wrapperEl.style.transitionDuration = '';
        sliderThumb.setTranslate(-scrollThumbSize);
        for (let i = 0; i < sliderThumb.slides.length; i++){
            sliderThumb.slides[i].classList.remove(this.className.swiperActiveThumb);
        }
        $activeThumb.classList.add(this.className.swiperActiveThumb);
    }
}

export default GalSlider;