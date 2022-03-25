'use strict';
/**
 * Меню и сабменю
 */

//init
document.addEventListener("DOMContentLoaded", function () {
    const menu = new NxMenu();
});

class NxMenu{
    constructor(element, options) {
        this.options = {
            viewportWidth: window.innerWidth,
            submenuMobileWidth: 992,
            hasSubmenuHoverState: true,
        };

        this.className = {
            subMenuOpen: 'sub-menu-open',
            menuOpenBody: 'menu-open',
            menuOpen: 'open'
        };

        this.dataName = {
            menuEl: 'menu-el',
            nav: 'nav',
            menuToggle: 'mtoggle',
            submenu: 'submenu',
            submenuToggle: 'submenu-toggle',
            menuAction: 'menu'
        };

        this.$body = document.getElementsByTagName('body')[0];

        //main menu
        this.$menuItems = document.querySelectorAll(`[data-${this.dataName.menuEl}]`);
        this.$nav = document.querySelector(`[data-${this.dataName.nav}]`);
        this.$dds = $(this.$nav).find(`[data-${this.dataName.submenu}]`).parent();

        //submenu
        this.$submenuToggle = $(`[data-${this.dataName.submenuToggle}]`);
        this.$submenu = this.$submenuToggle.parent();
        this.$submenuSiblings = this.$submenu.siblings();

        this.mtoggle = element || document.querySelector(`[data-${this.dataName.menuToggle}]`);

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init(){
        if (!this.mtoggle) return false;
        this.bindEvents();
        const self = this;
        setTimeout(function() {
            self.reinitPluginsUsesInMenu();
        }, 0);
    }

    //Method for all events
    bindEvents(){
        //main menu
        this.mtoggle.addEventListener('click', this.toggleNavHandler.bind(this));
        document.addEventListener('mouseup', this.closeMenuOnMouseUp.bind(this));

        //submenu
        $(`[data-${this.dataName.submenuToggle}]`, document).on('click', this.toggleSubMenuhandler.bind(this));
        //Turn on hover state for submenu
        if (this.options.hasSubmenuHoverState){
            this.$submenu.on('mouseenter', (e) => {
                if($.nx.isTouch() || (this.options.viewportWidth < this.options.submenuMobileWidth)) return false;
                this.openSubmenu(e.currentTarget);
            });
            this.$submenu.on('mouseleave', (e) => {
                if($.nx.isTouch() || (this.options.viewportWidth < this.options.submenuMobileWidth)) return false;
                this.closeSubmenu(e.currentTarget);
            });
        }

        $(window).on('resize', () => {
            this.options.viewportWidth = window.innerWidth || 0;
            this.reinitPluginsUsesInMenu();
        });
    }

    /**
     * Nav toggle on click
     * @param e - event
     */
    toggleNavHandler(e){
        e.preventDefault();
        let $self = e.currentTarget;

        if($self.getAttribute(`data-${this.dataName.menuAction}`) === 'close'){
            this.mtoggle.classList.remove(this.className.menuOpen);
            this.$menuItems.forEach(el => el.classList.remove(this.className.menuOpen));
            this.$body.classList.remove(this.className.menuOpenBody);
        }else {
            this.mtoggle.classList.toggle(this.className.menuOpen);
            this.$menuItems.forEach(el => el.classList.toggle(this.className.menuOpen));
            this.$body.classList.toggle(this.className.menuOpenBody);
        }
        return false;
    }

    /**
     * Close nav when menu is not targer
     * @param e - event
     */
    closeMenuOnMouseUp(e){
        //main menu
        let isMtoggle = (!$(this.mtoggle).is(e.target) && $(this.mtoggle).has(e.target).length === 0),
            isMnav = (!$(this.$nav).is(e.target) && $(this.$nav).has(e.target).length === 0),
            bodyHasOpenClass = this.$body.classList.contains(this.className.menuOpenBody);

        if (bodyHasOpenClass && isMnav && isMtoggle) {
            this.$body.classList.remove(this.className.menuOpenBody);
            this.$dds.removeClass(this.className.subMenuOpen);
        }

        //submenu
        let isSubmenuToggleTarget = (!this.$submenuToggle.is(e.target) && this.$submenuToggle.has(e.target).length === 0),
          isSubmenuSiblingsTarget = (!this.$submenuSiblings.is(e.target) && this.$submenuSiblings.has(e.target).length === 0);
        if (isSubmenuToggleTarget && isSubmenuSiblingsTarget) {
            if (this.options.hasSubmenuHoverState && !$.nx.isTouch() && (this.options.viewportWidth > this.options.submenuMobileWidth)){
                this.$submenu.add(this.$submenuSiblings).removeClass(this.className.subMenuOpen);
            }
        }

        return false;
    }

    /**
     * Sub menu toggle on click or hover
     * @param e - event
     */
    toggleSubMenuhandler(e){
        if (!this.options.hasSubmenuHoverState) e.preventDefault();

        let $link = e.currentTarget,
            href = $link.getAttribute('href');
        const $currentSubmenu = $link.nextElementSibling.parentElement;
        const $currentSubmenuSiblibgs = Array.prototype.filter.call($currentSubmenu.parentNode.children, function(child){
            return child !== $currentSubmenu;
        });

        $currentSubmenuSiblibgs.forEach((el) => {
           el.classList.remove(this.className.subMenuOpen);
        });
        if (!$currentSubmenu) return false;

        //change location after second click on main menu element and remove top e.preventDefault()
        if (this.options.hasSubmenuHoverState && !$.nx.isTouch() && (this.options.viewportWidth > this.options.submenuMobileWidth)){
            if (href !== '#' && $currentSubmenu.classList.contains(this.className.subMenuOpen)){
                this.closeSubmenu($currentSubmenu);
                e.preventDefault();
                document.location.href = href;
                return false;
            }else{
                e.preventDefault();
            }
        }

        this.toggleSubmenuClass($currentSubmenu);

        return false;
    }

    /**
     * Sub menu class toggle helper
     * @param $submenu - jquery element with sub menu
     */
    toggleSubmenuClass($submenu){
        if (!$submenu.classList.contains(this.className.subMenuOpen)){
            this.openSubmenu($submenu);
        }else{
            this.closeSubmenu($submenu);
        }
        return false;
    }
    /**
     * Sub menu open helper
     * @param $submenu - jquery element with sub menu
     */
    openSubmenu($submenu){
        if (!$submenu.classList.contains(this.className.subMenuOpen)){
            $submenu.classList.add(this.className.subMenuOpen);
        }
        return false;
    }
    /**
     * Sub menu close helper
     * @param $submenu - jquery element with sub menu
     */
    closeSubmenu($submenu){
        if ($submenu.classList.contains(this.className.subMenuOpen)){
            $submenu.classList.remove(this.className.subMenuOpen);
        }
        return false;
    }

    // Reinit of the plugins, menu depending on the resolution or other conditions
    reinitPluginsUsesInMenu(){
        //reinit OverlayScrollbars
        let $customScroll = this.$nav.querySelector('[data-custom-scroll]'),
            instance = OverlayScrollbars($customScroll, { });

        if (this.options.viewportWidth < this.options.submenuMobileWidth){
            $.nx.initPlugins(this.$nav[0]);
        }else{
            if (instance) instance.destroy();
        }
    }
}

export default NxMenu;