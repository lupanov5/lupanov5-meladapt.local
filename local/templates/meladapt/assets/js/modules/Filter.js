'use strict';

/**
 * Фильтр
 */
class Filter {
    constructor(element, options) {
        this.options = {
            direction: 'direction',
            num: 'num',
        };

        this.dataName = {
            filterToggle: 'filter-toggle',
            filter: 'filter',
            filterFade: 'filter-fade',
            filterClose: 'filter-close',
            filterInput: 'filter-input',
            filterCnt: 'filter-cnt',
            filterForm: 'filter-form',
            filterItem: 'filter-item',
            filterCount: 'filter-count',

            range: 'range',
            rangeInput: 'range-inp',
            rangeMainInput: 'ui-slider',
            rangeMin: 'ui-min',
            rangeMax: 'ui-max',

            min: 'min',
            max: 'max',

            output: 'output',
            sort: 'sort',
            name: 'name'
        };

        this.className = {
            filterOpen: 'filter-open',
            active: 'active',
        };

        this.$el = element || document.querySelectorAll(`[data-${this.dataName.filterToggle}]`);
        this.$filterFade = document.querySelector(`[data-${this.dataName.filterFade}]`);
        this.$filterForm = document.querySelectorAll(`[data-${this.dataName.filterForm}]`);
        this.$output = document.querySelectorAll(`[data-${this.dataName.output}]`);
        this.$filterClose = document.querySelector(`[data-${this.dataName.filterClose}]`);
        this.$inputList = document.querySelectorAll(`[data-${this.dataName.filterInput}]`);
        this.$range = document.querySelectorAll(`[data-${this.dataName.rangeInput}]`);
        this.$sort = document.querySelector(`[data-${this.dataName.sort}]`);

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init() {
        this.bindEvents();
    }

    //Method for all events
    bindEvents() {
        if (!this.$el.length) {
            return false;
        }

        this.$el.forEach(($el) => {
            $el.addEventListener('click', this.filterToggle.bind(this));
        });
        this.$inputList.forEach(($el) => {
            $el.addEventListener('change', this.prepareFilterSort.bind(this));
        });
        this.$filterForm.forEach(($el) => {
            $el.addEventListener('submit', this.prepareLocationChange.bind(this));
        });
        this.$output.forEach(($el) => {
            $el.addEventListener('click', this.prepareLocationChange.bind(this));
        });
        this.$range.forEach(($el) => {
            $el.addEventListener('change', this.prepareFilterSort.bind(this));
        });
        this.$sort.addEventListener('click', this.prepareLocationChange.bind(this));
        this.$filterFade.addEventListener('click', this.filterToggle.bind(this));
        this.$filterClose.addEventListener('click', this.filterToggle.bind(this));
    }

    /**
     * Подготовка к фильтрации
     */
    prepareFilterSort() {
        const {url, formData} = this.createData();
        this.sendFilterRequest(url, formData);
    }

    /**
     * Переключение активного класса для блоков с кол-вом элементов на странце
     * @param el - элемент на котором произошeл клик
     */
    toggleOutputValue(el) {
        this.$output.forEach(($el) => {
            $el.classList.remove(this.className.active);
        });
        el.classList.add('active');
    }

    /**
     * Подготовка к фильтрации в случае если не требуется аякс запрос
     * @param e
     */
    prepareLocationChange(e) {
        e.preventDefault();
        const $self = e.currentTarget;
        if($self.getAttribute(`data-${this.dataName.output}`)) {
            this.toggleOutputValue($self);
        }

        const {url} = this.createData();

        this.changeLocation(url);
    }

    /**
     * Создание данных для фильтрации
     * @returns {{formData: string, url: string}}
     */
    createData() {
        const {checkedArr, rangeArr, sortVal, outputValue} = this.createFilterProps();
        const {url, formData} = this.createUlr(checkedArr, rangeArr, sortVal, outputValue);
        return {url, formData};
    }

    /**
     * Применение фильтра без аякса
     * @param url
     */
    changeLocation(url) {
        window.location.href = url;
    }

    /**
     * Изменение видимости блока с фильтром
     * @param e - event
     */
    filterToggle(e) {
        e.preventDefault();
        const $body = document.getElementsByTagName('body')[0];
        if($body.classList.contains(this.className.filterOpen)) {
            $body.classList.remove(this.className.filterOpen)
        } else {
            $body.classList.add(this.className.filterOpen);
        }
    }

    /**
     * Создание массива для инпутов
     * @returns {{name, value}[]}
     */
    createValuesArr() {
        const $checkedList = document.querySelectorAll(`[data-${this.dataName.filterInput}]:checked`);

        return Array.from($checkedList).map((el) => {
            const {name, value} = el;
            return {name, value};
        });
    }

    /**
     * Создание массива для ползунков
     * @returns {any[]}
     */
    createRangeArr() {
        const $rangeInputs = document.querySelectorAll(`[data-${this.dataName.range}]`);

        return Array.from($rangeInputs).map((el) => {
            const $input = el.querySelector(`[data-${this.dataName.rangeMainInput}]`),
                defaultMin = $input.getAttribute(`data-${this.dataName.min}`),
                defaultMax = $input.getAttribute(`data-${this.dataName.max}`),
                min = $.nx.removeSpaces(el.querySelector(`[data-${this.dataName.rangeMin}]`).value),
                max = $.nx.removeSpaces(el.querySelector(`[data-${this.dataName.rangeMax}]`).value),
                name = $input.getAttribute('data-name'),
                isMin = Number(min) > Number(defaultMin),
                isMax = Number(max) < Number(defaultMax);
            if (isMin || isMax) {
                return {name, min, max};
            }
        }).filter(el => el);
    }

    /**
     * Получение текущего значения сортировки
     * @returns {*}
     */
    createSortValue() {
        return document.querySelector(`[data-${this.dataName.sort}]`).value;
    }

    /**
     * Получение текущего значения кол-ва элементов на странице
     * @returns {string}
     */
    createOutputValue() {
        return document.querySelector(`[data-${this.dataName.output}].${this.className.active}`).
            getAttribute(`data-${this.dataName.output}`);
    }

    /**
     * Создание всех необходимых значений для фильтрации
     * @returns {{sortVal: *, rangeArr: any[], outputValue: string, checkedArr: {name, value}[]}}
     */
    createFilterProps() {
        const checkedArr = this.createValuesArr(),
            rangeArr = this.createRangeArr(),
            sortVal = this.createSortValue(),
            outputValue = this.createOutputValue();

        return {checkedArr, rangeArr, sortVal, outputValue};
    }

    /**
     * Создание страки со значенями ползунков
     * @param arr - массив значение ползунков
     * @returns {string}
     */
    createRangeStr(arr) {
        let str = '';
        arr.forEach((el) => {
            str += `${el.name}[min]=${el.min}&${el.name}[max]=${el.max}&`;
        });
        return str;
    }

    /**
     * Создание строки со значениями инпутов
     * @param arr - массив значений инпутов
     * @returns {string}
     */
    createStr(arr) {
        let str = '';
        arr.forEach((el) => {
            str += `${el.name}=${el.value}&`;
        });
        return str;
    }

    /**
     * Создание строки со значениями для филтрации
     * @param str - строка
     * @param prop - свойство
     * @returns {string}
     */
    createUrlProperty(str, prop) {
        return `${str}=${prop}&`;
    }

    /**
     * Создание url для запроса фильтрации
     * @param arr - массив инпутов
     * @param rangeArr - массив ползунков
     * @param sort - значение сортировки
     * @param num - значение кол-ва элементов на странице
     * @returns {{formData: string, url: string}}
     */
    createUlr(arr, rangeArr, sort, num) {
        let url = '?',
            formData = '';

        url += this.createUrlProperty(this.options.direction, sort);
        url += this.createUrlProperty(this.options.num, num);

        if (rangeArr.length) {
            formData += this.createRangeStr(rangeArr);
            url += this.createRangeStr(rangeArr);
        }
        if (arr.length) {
            formData += this.createStr(arr);
            url += this.createStr(arr);
        }
        url = url.substring(0, url.length - 1);
        return {
            url,
            formData,
        };
    }

    /**
     * Отправка аякс запроса фильтрации
     * @param url - адрес запроса
     * @param data - данные запроса
     */
    sendFilterRequest(url, data) {
        fetch(url, {
            method: 'POST',
            body: data
        })
        .then(res => res.json(), )
        .then(res => {
            console.log(res);
        })
        .catch(error => {
            //console.log(error);
            const responseTest = {
                count: '10',
                elements: {
                    0: {
                        id: 1,
                        type: 'checkbox',
                        active: false,
                        values: {
                            0: {
                                id: 'checkbox-1',
                                active: true,
                                cnt: '5'
                            },
                            1: {
                                id: 'checkbox-2',
                                active: false,
                                cnt: '0'
                            },
                            3: {
                                id: 'checkbox-3',
                                active: true,
                                cnt: '0'
                            },
                            4: {
                                id: 'checkbox-4',
                                active: true,
                                cnt: '999'
                            }
                        }
                    },
                    1: {
                        id: 1,
                        type: 'checkbox',
                        active: true,
                        values: {
                            0: {
                                id: 7,
                                active: true,
                                cnt: '0'
                            }
                        }
                    },
                    2: {
                        id: 2,
                        type: 'radio',
                        active: true,
                        values: {
                            0: {
                                id: 7,
                                active: true,
                                cnt: '999'
                            }
                        }
                    }
                }
            };

            this.redrawFilterInputs(responseTest);
        });
    }

    /**
     * Пересчет кол-ва активных инпутов для фильтрации
     * @param response ответ запроса на фильтрацию
     */
    redrawFilterInputs(response) {
        const {elements, count} = response,
            filterCnt = document.querySelector(`[data-${this.dataName.filterCnt}]`),
            items = elements;
        filterCnt.textContent = count;
        for (let key of Object.keys(items)) {
            let values = items[key].values;
            for(let j of Object.keys(values)) {
                const item = values[j];
                const $input = document.querySelector(`[data-name="${item.id}"]`);
                if($input) {
                    const $filterItem = $input.closest(`[data-${this.dataName.filterItem}]`),
                        $filterCnt = $filterItem.querySelector(`[data-${this.dataName.filterCount}]`);
                    $input.disabled = item.active;
                    $filterCnt.textContent = `(${item.cnt})`;
                }
            }
        }
    }
}

export default Filter;