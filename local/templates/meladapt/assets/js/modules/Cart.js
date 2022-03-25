'use strict';
/**
 * Корзина
 *
 * Информер:
 * @informer - класс для показа информера при успешном добавлении в корзину.
 *
 * Опции:
 * @delay - задержка показа информера. Скорее всего лишний параметр в этом классе, закоменнтирован, если не пригодиться - удалить
 *
 * Дата-атрибуты товара:
 * @prod - дата-атрибут для контейнера с товаром
 * @prodTitle - дата-атрибут для заголовка товара
 * @prodCnt - дата-атрибут для количества товаров (используется при добавлении/ изменении количества товаров в корзине)
 * @prodAdd - дата-атрибут для добавления товара в корзину
 * @prodPrice - дата-атрибут для цены товара
 * @prodWeight - дата-атрибут для веса товара
 * @prodType - дата-атрибут для типа товара
 * @prodPriceTotal - дата-атрибут для суммарной цены товарa (товар умноженный на кол-во)
 * @prodWeightTotal - дата-атрибут для суммарного веса товарa (товар умноженный на кол-во)
 *
 * Дата-атрибуты комплекта:
 * @setItem - дата-атрибут для контейнера с комплектом
 * @setWeight - дата-атрибут для веса комплекта
 * @setDiscount - дата-атрибут для скидки за комплект
 * @setOldPrice - дата-атрибут для старой цены комплекта
 *
 * Дата-атрибуты корзины:
 * @cart - дата-атрибут для контейнера с корзиной
 * @cartEl - дата-атрибут для товара в корзине
 * @cartRemove - дата-атрибут для кнопки "убрать из корзины"
 * @cartCount - дата-атрибут для счётчика количества товаров в корзине
 * @cartPrice - дата-атрибут для цены в корзине (используется для комплектов)
 * @cartBtn - дата-атрибут для кнопки "отправить"
 * @cartTotalWeight - дата-атрибут для вывода общего веса содержимого корзины
 * @cartTotalPrice - дата-атрибут для вывода общей стоимости содержимого корзины
 *
 * Остальные дата-атрибуты:
 * @hCart - дата-атрибут для контейнера корзины в хедере
 * @totalCnt - дата-атрибут для вывода текста в блок с корзиной в хедере
 * @type - дата-атрибут для типа товара
 * @type - дата-атрибут для типа количества товара
 *
 * Классы:
 *  @active - вешается на активный элемент
 *  @deleted - вешается на удалённый элемент корзины, чтобы можно было его восстановить
 *  @disabled - вешается на кнопку чтобы её отключить
 *  @sending - вешается чтобы предотвратить повторную отправку формы
 *  @hcartEmpty - вешается на "корзину" в хедере чтобы убрать декоративный элемент во время отсутствия цифры
 */



class Cart{
    constructor(informer) {
        this.informer = informer;
        this.options = {
            delay: 2000,
        };

        this.dataName = {
            prod: 'prod',
            prodTitle: 'prod-title',
            prodCnt: 'prod-cnt',
            prodAdd: 'prod-add',
            prodPrice: 'prod-price',
            prodWeight: 'prod-weight',
            prodType: 'prod-type',
            prodPriceTotal: 'prod-price-total',
            prodWeightTotal: 'prod-weight-total',

            setItem: 'set-item',
            setWeight: 'set-weight',
            setDiscount: 'set-discount',
            setOldPrice: 'set-old-price',

            cart: 'cart',
            cartEl: 'cart-el',
            cartRemove: 'cart-remove',
            cartCount: 'cart-count',
            cartPrice: 'cart-price',
            cartBtn: 'cart-btn',
            cartTotalWeight: 'cart-total-weight',
            cartTotalPrice: 'cart-total-price',
            cartNote: 'cart-note',

            hCart: 'hcart',

            totalCnt: 'total-cnt',

            type: 'type',
            cnt: 'cnt'
        };

        this.className = {
            active: 'active',
            deleted: 'deleted',
            disabled: 'disabled',
            sending: 'sending',
            hcartEmpty: 'hcart-empty'
        };

        this.$addBtn = document.querySelectorAll(`[data-${this.dataName.prodAdd}]`);
        this.$removeBtn = document.querySelectorAll(`[data-${this.dataName.cartRemove}]`);

        this.init();
    }
    //Method for run all class methods
    init(){
        this.bindEvents();
    }

    bindEvents(){
        this.$addBtn.forEach(($el) => {
            $el.addEventListener('click', this.addToCart.bind(this));
        });

        this.$removeBtn.forEach(($el) => {
            $el.addEventListener('click', this.removeFromCart.bind(this));
        });
    }

    /**
     * Обновление значения в малой корзине в шапке
     * @param cnt - кол-во элементов в корзине
     */
    updateHeaderCart(cnt) {
        const $hcart = document.querySelector(`[data-${this.dataName.hCart}]`),
            $totalCnt = document.querySelector(`[data-${this.dataName.totalCnt}]`),
            $cartCnt = document.querySelector(`[data-${this.dataName.cartCount}]`);

        if(cnt) {
            $hcart.classList.remove(this.className.hcartEmpty);
        } else {
            $hcart.classList.add(this.className.hcartEmpty);
        }

        $totalCnt.textContent = cnt;
        if ($cartCnt) {
            $cartCnt.textContent = cnt;
        }
    }

    /**
     * Добавление товара в корзину
     * @param e
     * @returns {boolean}
     */
    addToCart(e) {
        e.preventDefault();
        e.stopPropagation();
        let $self = e.currentTarget,
            $prod = $self.closest(`[data-${this.dataName.prod}]`),
            prodID = $prod.getAttribute(`data-${this.dataName.prod}`),
            prodType = $prod.getAttribute(`data-${this.dataName.prodType}`),
            $prodInputs = $prod.querySelector('input'),
            $prodTitle = $prod.querySelector(`[data-${this.dataName.prodTitle}]`),
            prodTitle = $prodTitle.getAttribute(`data-${this.dataName.prodTitle}`),
            type = $self.getAttribute(`data-${this.dataName.type}`),
            $prodCount = $prod.querySelector(`[data-${this.dataName.prodCnt}`),
            prodCount = Number($prodCount.value) || 1,
            prodPrice, $prodPrice,
            isCart = document.querySelector(`[data-${this.dataName.cart}]`);
        if (!isCart){
            $prodPrice = $prod.querySelector(`[data-${this.dataName.prodPrice}]`);
            prodPrice = parseFloat($prodPrice.getAttribute(`data-${this.dataName.prodPrice}`)) || 0;
        }
        let prodTotalPrice = prodPrice * prodCount;

        if($self.classList.contains(this.className.sending) || $self.classList.contains(this.className.disabled)) {
            return false;
        }

        // todo перенести в success
        if (!isCart) {
            this.informer.showInformer(prodTitle, prodTotalPrice, Number($prodCount.value));
        } else {
            $prod.classList.remove(this.className.deleted);
            $prodInputs.disabled = true;
            $prodInputs.readoly = false;
            this.calcTotals($self, 'add');
        }

        const self = this;
        const data = {
            id: prodID,
            cnt: prodCount,
            type: prodType
        };
        fetch(`/cart/${type}/`, {
            method: 'POST',
            body: JSON.stringify(data)
        })
        .then(res => res.json(), )
        .then(res => {
            const result = JSON.parse(res);
            self.updateHeaderCart(result.cnt);
            if (isCart){
                $prod.classList.remove(this.className.deleted);
                $prodInputs.disabled = true;
                $prodInputs.readoly = false;
            }else{
                // self.informer.showInformer(prodTitle, prodTotalPrice, Number($prodCount.value), self.options.delay);
                self.informer.showInformer(prodTitle, prodTotalPrice, Number($prodCount.value));
            }
            // todo
            //calcTotals($this, 'add');
            // $this.removeClass('sending');
        })
        .catch(error => {
            console.log(error);
        });
    }

    /**
     * Удаление товара из корзины
     * @param e
     */
    removeFromCart(e) {
        e.preventDefault();
        e.stopPropagation();
        let $self = e.currentTarget,
            $cartEl = $self.closest(`[data-${this.dataName.cartEl}]`),
            prodType = $cartEl.getAttribute(`data-${this.dataName.prodType}`),
            type = $self.getAttribute(`data-${this.dataName.type}`),
            $prodInputs = $cartEl.querySelector('input'),
            prodID = $cartEl.getAttribute(`data-${this.dataName.prod}`);

        // todo success
        $cartEl.classList.add(this.className.deleted);
        $prodInputs.disabled = true;
        $prodInputs.readoly = false;
        this.calcTotals($self, 'delete');

        const data = {
            id: prodID,
            type: prodType,
            cnt: 0
        };
        fetch(`/cart/${type}/`, {
            method: 'POST',
            body: JSON.stringify(data)
        })
        .then(res => res.json(), )
        .then(res => {
            const result = JSON.parse(res);
            self.updateHeaderCart(result.cnt);
            $cartEl.classList.add(this.className.deleted);
            $prodInputs.disabled = true;
            $prodInputs.readoly = false;
            // пересчет общей суммы в малой корзине в шапке
            // todo
            //calcTotals($this, 'delete');
        })
        .catch(error => {
            console.log(error);
        });
    }

    /**
     * Обновление значения счетчика для комплектов в корзине
     * @param list - список комплектов
     * @param val - текущее кол-во комплектов в корзине
     */
    changeSetCnt(list, val) {
        list.forEach((el) => {
            el.textContent = val;
        });
    }

    /**
     * Обновление значения цены для комплектов в корзине
     * @param list - список комплектов
     * @param val - текущее значение цены для комплектов
     */
    changeSetPrice(list,val) {
        list.forEach((el) => {
            const prodPrice = $.nx.removeSpaces(el.closest(`[data-${this.dataName.setItem}]`).querySelector(`[data-${this.dataName.cartPrice}]`).getAttribute(`data-${this.dataName.cartPrice}`));
            el.textContent = $.nx.addSpaces(Number(prodPrice) * Number(val));
        });
    }

    /**
     * Обновление значения веса для комплекта
     * @param list - список комплектов
     * @param val - текущее значение веса для козины
     */
    changeSetWeight(list,val) {
        list.forEach((el) => {
            const prodWeight = $.nx.removeSpaces(el.closest(`[data-${this.dataName.setItem}]`).getAttribute(`data-${this.dataName.setWeight}`)),
                tempWeight = Number(prodWeight) * Number(val);
            el.textContent = $.nx.addSpaces(tempWeight.toFixed(2));
        });
    }

    /**
     * Изменение значения скидки комплекта
     * @param el - элемент скидки
     * @param val - значение скидки
     */
    changeSetDiscount(el, val) {
        el.textContent = $.nx.addSpaces(el.getAttribute(`data-${this.dataName.setDiscount}`) * val);
    }

    /**
     * Обновление значения цены для комплекта
     * @param price - цена комплекта
     * @param oldPrice - старая цена комплекта
     * @param val - значение для установки
     */
    changeSetTotalPrice(price, oldPrice, val) {
        price.textContent = $.nx.addSpaces(price.getAttribute(`data-${this.dataName.prodPrice}`) * val);
        oldPrice.textContent = $.nx.addSpaces(oldPrice.getAttribute(`data-${this.dataName.setOldPrice}`) * val);
    }

    /**
     * Вычисление суммарных значений для комплекта
     * @param cnt - текущее значение счетчика для комплекта
     * @param price - значение цена для товара в комплекте
     * @param weight - значение веса для товара в комплекте
     * @param discount - значение скидки для комплекта
     * @param totalPrice - значение цены комплекта
     * @param oldPrice - значение старой цены для комлекта
     * @param val - новое значение счетчика комплекта
     */
    calcSetTotals(cnt, price, weight, discount, totalPrice, oldPrice, val) {
        this.changeSetCnt(cnt, val);
        this.changeSetPrice(price, val);
        this.changeSetWeight(weight, val);
        this.changeSetDiscount(discount, val);
        this.changeSetTotalPrice(totalPrice, oldPrice, val);
    }

    /**
     * Изменение счетчика для товара в корзине
     * @param $object
     * @returns {boolean}
     */
    cartTotalsUpdate($object) {
        let $obj = $object,
            $prod = $obj.closest(`[data-${this.dataName.cartEl}]`),
            type = $prod.getAttribute(`data-${this.dataName.type}`),
            prodType = $prod.getAttribute(`data-${this.dataName.prodType}`),
            prodId = $prod.getAttribute(`data-${this.dataName.prod}`),
            $prodCnt = $prod.querySelector(`[data-${this.dataName.prodCnt}]`),
            prodCnt = parseInt($prodCnt.value);

        if($obj.classList.contains(this.className.sending) || prodCnt < 1) {
            return false;
        }

        const data = {
            id: prodId,
            type: prodType,
            cnt: prodCnt
        };

        fetch(`/cart/${type}/`, {
            method: 'POST',
            body: JSON.stringify(data)
        })
        .then(res => res.json(), )
        .then(res => {
            const result = JSON.parse(res);
            self.updateHeaderCart(result.cnt);
        })
        .catch(error => {
            console.log(error);
        });
    }

    /**
     * Обновления суммарных значений в корзине
     * @param btn - элемент на котором произошло событие
     * @param type - тип события (добавить, удалить итд)
     * @returns {boolean}
     */
    calcTotals(btn, type) {
        let $btn = btn,
            $prod = $btn.closest(`[data-${this.dataName.prod}]`),
            cnt = parseInt($prod.querySelector(`[data-${this.dataName.prodCnt}]`).value) || parseInt($prod.querySelector(`[data-${this.dataName.prodAdd}]`).getAttribute(`data-${this.dataName.cnt}`)) || 1,
            curPrice = parseInt($.nx.removeSpaces($prod.querySelector(`[data-${this.dataName.prodPrice}]`).getAttribute(`data-${this.dataName.prodPrice}`))),
            $totalPrice =  document.querySelector(`[data-${this.dataName.cartTotalPrice}]`),
            oldPrice = parseInt($.nx.removeSpaces($totalPrice.textContent)),

            newSum = 0,
            weightSum = 0,
            cartTotalCnt = 0,

            $cart = document.querySelector(`[data-${this.dataName.cart}]`),
            $cartWeight = document.querySelector(`[data-${this.dataName.cartTotalWeight}]`),
            $cartProds = $cart.querySelectorAll(`[data-${this.dataName.prod}]:not(.${this.className.deleted})`),
            $cartProdsAll = $cart.querySelectorAll(`[data-${this.dataName.prod}]`),
            $cartBtn = document.querySelector(`[data-${this.dataName.cartBtn}]`),
            $cartTotalCnt = document.querySelector(`[data-${this.dataName.cartCount}]`),
            $cartNote = document.querySelectorAll(`[data-${this.dataName.cartNote}]`);


        if (!$prod) return false;

        switch (type) {
            case 'add':
                newSum = oldPrice + (cnt * curPrice);
                break;
            case 'delete':
                newSum = oldPrice - (cnt * curPrice);
                break;
            case 'update_plus':
                newSum = oldPrice + curPrice;
                break;
            case 'update_minus':
                newSum = oldPrice - curPrice;
                break;
            case 'update':
                $cartProds.forEach((el) => {
                   let $self = el,
                       cartProdCnt = parseInt($self.querySelector(`[data-${this.dataName.prodCnt}]`).value),
                       cartProdPrice = parseInt($.nx.removeSpaces($self.querySelector(`[data-${this.dataName.prodPrice}]`).getAttribute(`data-${this.dataName.prodPrice}`)));
                    newSum += cartProdPrice * cartProdCnt;
                });
                break;
            // default:
        }

        $cartProdsAll.forEach((el) => {
           let $self = el,
               cartProdWeight = Number($self.getAttribute(`data-${this.dataName.prodWeight}`)),
               cartProdPrice = Number($.nx.removeSpaces($self.querySelector(`[data-${this.dataName.prodPrice}]`).getAttribute(`data-${this.dataName.prodPrice}`))),
               type = $self.getAttribute(`data-${this.dataName.prodType}`),
               prodPriceTotal= el.querySelector(`[data-${this.dataName.prodPriceTotal}]`),
               prodWeightTotal = el.querySelector(`[data-${this.dataName.prodWeightTotal}]`),
               cartProdCnt = 0;
           if(type === 'set') {
               let setProdList = $self.querySelectorAll(`[data-${this.dataName.setItem}]`).length;
               cartProdCnt = parseInt($self.querySelector(`[data-${this.dataName.prodCnt}]`).value) * setProdList;
           } else {
               cartProdCnt = parseInt($self.querySelector(`[data-${this.dataName.prodCnt}]`).value);
           }

           let tempTotalWeight = cartProdWeight * Number(cartProdCnt),
               tempTotalPrice = cartProdPrice * Number(cartProdCnt);
           if(prodWeightTotal) prodWeightTotal.textContent = $.nx.addSpaces(tempTotalWeight.toFixed(2));
           if(prodPriceTotal) prodPriceTotal.textContent = $.nx.addSpaces(tempTotalPrice);

            if ($self.classList.contains(this.className.deleted)){
                cartProdWeight = 0;
                cartProdCnt = 0;
            }

            weightSum += cartProdWeight * cartProdCnt;
            cartTotalCnt += cartProdCnt;

            $cartWeight.textContent = weightSum.toFixed(2);
            $cartTotalCnt.textContent = cartTotalCnt;
            $.nx.writeDecline($cartNote, cartTotalCnt);
        });

        $totalPrice.textContent = $.nx.addSpaces(newSum);

        if(!$cartProds.length) {
            $cartBtn.classList.add(this.className.disabled);
            $cartBtn.disabled = true;
        } else {
            $cartBtn.classList.remove(this.className.disabled);
            $cartBtn.disabled = false;
        }
    }
}
export default Cart;