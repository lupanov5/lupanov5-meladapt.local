'use strict';
/**
 * Прокрутка блока со списком товаров в "сравнении"
 */
class CompareTable {
    constructor(element, options) {
        this.options = {};

        this.dataName = {
          compareTableCol: 'compare-table-col',
          compareTableBody: 'compare-table-body',
          compareRow: 'compare-row'
        };

        this.$el = document.querySelector(`[data-${this.dataName.compareTableCol}]`);

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init(){
        this.bindEvents();
    }

    //Method for all events
    bindEvents(){
        if(!this.$el) return false;
        window.addEventListener('load', this.checkTableHeight.bind(this));
    }
    /**
     * Mouse and touch handler
     * @param e - event
     */
    checkTableHeight(e){
        const $table = this.$el,
            $compareTable =  document.querySelector(`[data-${this.dataName.compareTableBody}]`),
            $rowList = $table.querySelectorAll(`[data-${this.dataName.compareRow}]`);
        $rowList.forEach((el) => {
            let num = el.getAttribute(`data-${this.dataName.compareRow}`),
                $comparedEl = $compareTable.querySelector(`[data-compare-row="${num}"]`);
            let $elHeight = parseFloat(getComputedStyle(el, null).height.replace("px", "")),
            $compareElHeight = parseFloat(getComputedStyle($comparedEl, null).height.replace("px", ""));
            let maxHeight = $elHeight > $compareElHeight ? $elHeight : $compareElHeight;
            el.style.height = maxHeight + 'px';
            $comparedEl.style.height = maxHeight + 'px';
        });
    }
}

export default CompareTable;