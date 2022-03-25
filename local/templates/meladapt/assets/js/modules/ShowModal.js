'use strict';
/**
 * Показать/скрыть модалку
 */

class ShowModal{
    constructor(element, options) {
        this.dataName = {
            modalBtn: 'modal-btn'
        };

        this.attrs = {
            id: 'id',
            href: 'href'
        };

        this.$modalBtn = document.querySelectorAll(`[data-${this.dataName.modalBtn}]`);

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init(){
        this.bindsEvent();
        //this.clearModal();
    }

    //Method for all actions
    bindsEvent(){
        this.$modalBtn.forEach((el) => {
           el.addEventListener('click', this.showModal.bind(this));
        });
    }
    showModal(e) {
        e.preventDefault();
        e.stopPropagation();
        let $self = e.currentTarget,
            type = $self.getAttribute(`data-custom-open`),
            $modal = document.querySelector(`#${type}`);
            let inputId = $modal.querySelector(`[data-${this.attrs.id}]`);
        inputId.value = $self.getAttribute(`data-${this.attrs.id}`);
    }
}
export default ShowModal;


