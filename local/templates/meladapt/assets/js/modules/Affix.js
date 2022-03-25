'use strict';
/**
 * Фиксирование блока внутри трека при прокрутке страницы
 * Общая схема:
 *
 * |--------------------affixParent-------------------|
 * ||--------------------||-----affixWrap------------||
 * ||--------------------||---|affixBlock        |---||
 * ||---|affixBlock-1|---||---||affixEl-1 active||---||
 * ||--------------------||---||affixEl-2       ||---||
 * ||--------------------||--------------------------||
 * ||---|affixBlock-2|---||--------------------------||
 * |------------------data-stop-affix-----------------|
 *
 * Опции:
 * @topPos - отступ сверху в фиксированом состоянии, в пикселях, задать при необходимости.
 *
 * Технические опции:
 * @affixHeight - высота блока, вычисляется автоматически
 * @headerHeight - высота хедера, вычисляется автоматически
 * @servContentHeight - высота блока-контейнера, вычисляется автоматически
 *
 * Обязятельные дата-атрибуты
 * @affixBlock - дата-атрибут для скроллещегося блока
 * @affixWrap - дата-атрибут для блока-трека, внутри которого лежит скроллещийся блок
 * @affixParent - дата-атрибут для блока-контейнера, внутри которого лежит блок-трек
 * @data-stop-affix - дата-атрибут для фиксации скроллещегося блока в полностью проскролленом состоянии
 *
 * Необязательные дата-атрибуты
 * @affixBox - дата-атрибут для блока с контентом, который должен лежать внутри блока-контейнера, параллельно блоку-треку,
 *             для переключения активного класса на элемента внутри скроллещегося блока.
 * @affixEl - дата-атрибут для элемента, лежащего внутри скроллещегося блока. При нахождении на одном уровне с
 *            блоком с контентом получает активный класс.
 *
 * Классы:
 *  @fixed - скроллещийся блок зафиксирован относительно окна
 *  @absolute - скроллещийся блок зафиксирован внизу трека
 *
 *  @active - вешается на активный элемент, лежащий внутри скроллещегося блока
 *
 *  @static - возможно рудимент проверить работает ли без него, если работает то удалить.
 */

class Affix {
    constructor(element, options) {
        this.options = {
            affixHeight: 0,
            headerHeight: 0,
            topPos: 0,
            servContentHeight: 0,
        };

        this.dataName = {
            affixBlock: 'affix-block',
            affixWrap: 'affix-wrap',
            affixParent: 'affix-parent',

            affixBox: 'affix-box',
            affixEl: 'affix-el',

            header: 'header',
        };

        this.className = {
            fixed: 'fixed',
            absolute: 'absolute',
            active: 'active',
            // static: 'static'
        };

        this.$el = document.querySelector(`[data-${this.dataName.affixBlock}]`);
        this.$stopAffix =   document.querySelector('[data-stop-affix]') || 0;
        this.$header = document.querySelector(`[data-${this.dataName.header}]`);
        this.$servContent = document.querySelector(`[data-${this.dataName.affixParent}]`);

        this.events = ['load', 'resize', 'orientationchange'];

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init(){
        if(!this.$el) return false;
        this.bindEvents();
    }

    //Method for all events
    bindEvents(){
        this.events.forEach((evt) => {
            window.addEventListener(evt, this.checkAffix.bind(this));
        });
        window.addEventListener('scroll', this.checkSticky.bind(this));
    }

    checkAffix() {
        this.options.affixHeight = this.$el.offsetHeight ;
        this.options.headerHeight = this.$header.offsetHeight ;
        this.options.servContentHeight = this.$servContent.offsetHeight || 0;

        setTimeout(() => {
            if (!this.$el.classList.contains(this.className.fixed)) this.options.topPos = this.$el.getBoundingClientRect().top + window.scrollY - this.options.headerHeight || 0;
            if (this.options.servContentHeight >= this.$el.offsetHeight) {
                this.stickyPos(this.options.headerHeight, this.options.topPos, this.$el, this.$stopAffix, this.options.servContentHeight);
            }
        }, 200);
    }

    checkSticky() {
        if (this.options.servContentHeight >= this.$el.offsetHeight) this.stickyPos(this.options.headerHeight, this.options.topPos, this.$el, this.$stopAffix,
            this.options.servContentHeight);

        if(window.innerWidth > 991) {
            const $sections = document.querySelectorAll(`[data-${this.dataName.affixBox}]`);
            $sections.forEach((el) => {
                let top = $(el).offset().top - 100,
                    bottom = top + parseFloat(getComputedStyle(el, null).height.replace("px", "")),
                    scroll = $(window).scrollTop(),
                    id = el.getAttribute('id');
                if (scroll > top && scroll < bottom) {
                    document.querySelectorAll(`[data-${this.dataName.affixEl}]`).forEach((el) => {
                        el.classList.remove(this.className.active);
                    });
                    document.querySelector(`a[href="#${id}"]`).parentNode.classList.add(this.className.active);
                }
            });
        }
    }

    stickyPos(hh, topPos, $affixBlock, $stopAffixBox, servContentheight,) {
        if (window.innerWidth < 992) {
            this.$el.classList.remove(`${this.className.fixed},${this.className.absolute}`);
            this.$el.removeAttribute('style');
            return false;
        }
        var docScrollTop = $(document).scrollTop(),
            $affixWrap = document.querySelector(`[data-${this.dataName.affixWrap}]`),
            affixWrapW = $($affixWrap).width(),
            affixBlockHeight = $($affixBlock).outerHeight(true),
            stopAffixTop = $stopAffixBox.getBoundingClientRect().top + window.scrollY - hh,
            affixListHeight = $('[data-affix-list]').height();

        if (servContentheight <= affixBlockHeight) {
            // $affixWrap.classList.remove(this.className.static);
            $($affixBlock).removeClass(`${this.className.fixed} ${this.className.absolute}`).removeAttr('style');
            return false;
        }
        if (affixListHeight < 812) {
            $affixBlock.removeClass(`${this.className.fixed} ${this.className.absolute}`);
            return false;
        }
        if (docScrollTop > topPos && docScrollTop < stopAffixTop - affixBlockHeight) {
            $affixBlock.classList.add(this.className.fixed);
            $affixBlock.classList.remove(this.className.absolute);
            $affixBlock.style.cssText = `top: ${hh}px; width: ${affixWrapW}px; bottom: 'auto'`;
            // $affixBlock.classList.remove(this.className.static);
        } else if (docScrollTop >= (stopAffixTop - affixBlockHeight)) {
            $affixBlock.classList.remove(this.className.fixed);
            $affixBlock.classList.add(this.className.absolute);
            $affixBlock.style.cssText = `top: 'auto'; width: ${affixWrapW}px; bottom: ${0}px`;
            // $affixBlock.classList.add(this.className.static);
        } else {
            $affixBlock.classList.remove(this.className.fixed);
            $affixBlock.removeAttribute('style');
        }
    }

}

export default Affix;