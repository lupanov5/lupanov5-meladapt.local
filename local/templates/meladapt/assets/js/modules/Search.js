'use strict';
/**
 * Поиск
 */
class Search {
    constructor(element, options) {
        this.options = {
        };

        this.className = {
            open: 'search-open'
        };

        this.dataName = {
            searchToggle: 'search-toggle',
        };

        this.$el = element || document.querySelectorAll(`[data-${this.dataName.searchToggle}]`);

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init(){
        this.bindEvents();
    }

    //Method for all events
    bindEvents(){
        this.$el.forEach(($el) => {
            $el.addEventListener('click', this.toggleSearch.bind(this));
        });
        document.addEventListener('click', this.closeSearchOnMouseUp.bind(this));
    }

    /**
     * Switches active class for form search
     * @param e - event
     */
    toggleSearch(e) {
        e.preventDefault();
        e.stopPropagation();
        let $self = e.currentTarget,
            type = $self.getAttribute(`data-${this.dataName.searchToggle}`),
            hash = $self.getAttribute('href'),
            $target = document.querySelector(hash);

        if (type === 'close') {
            $target.classList.remove(this.className.open);
        } else {
            $target.classList.toggle(this.className.open);
        }
    }

    /**
     * Closes search on document click
     * @param e - event
     */
    closeSearchOnMouseUp(e) {
        let $allSearches = document.querySelectorAll(`.${this.className.open}`),
            $closestSearchOpen = e.target.closest(`.${this.className.open}`);

        if (!$closestSearchOpen && $allSearches.length) {
            $allSearches.forEach(($s) => {
                $s.classList.remove(this.className.open)
            });
        }
    }

}

export default Search;