"use strict";
/**
 * Отправка формы
 */

class NxRequest {
    constructor(element, options) {
        this.options = {
            allowSend: true,
            timeoutModalOkShow: 450,
        };

        this.className = {
            send: "sending",
            error: "error",
            success: "success",
            preloaderTheme: "btn",
            modal: "modal",
            modalOkVacancies: "#modal-vacancies-ok",
            modalServicesOk: '#modal-services-ok',
            modalOk: "#modal-ok"
        };

        this.dataName = {
            btn: "send-request",
            agreeInp: "agree-inp",
            numOnly: "num-only",
            numMax: "num-only-max",
            symbolsMax: "symbols-max",
            symbolsLength: "symbols-length",
            formGroup: "form-group",
            formError: "form-error",
            filterClear: "filter-clear",
        };

        this.$btn =
            element || document.querySelectorAll(`[data-${this.dataName.btn}]`);
        this.$agreeInp = document.querySelectorAll(
            `[data-${this.dataName.agreeInp}]`
        );
        this.$disabledItems = document.querySelectorAll(".disabled, [disabled]");
        this.$numOnly = document.querySelectorAll(
            `[data-${this.dataName.numOnly}]`
        );
        this.$numMax = document.querySelectorAll(`[data-${this.dataName.numMax}]`);
        this.$symbolsMax = document.querySelectorAll(
            `[data-${this.dataName.symbolsMax}]`
        );
        this.events = ["keydown", "keypress", "keyup"];
        this.sybmolsEvents = ["keyup", "change", "input", "paste"];
        this.filterClear = document.querySelectorAll(
            `[data-${this.dataName.filterClear}]`
        );

        this.filesList = "[data-files-list]";

        this.excludedFormItems =
            'input[type="radio"], input[type="checkbox"], input[type="hidden"]';
        this.cleanedFormItems = "input, textarea";

        this.erorrTemplate = '<div class="form-error"></div>';
        this.erorrElement = ".form-error";

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init() {
        this.bindsEvent();
    }

    //Method for all events
    bindsEvent() {
        // Отправка на сервер данных из формы обратной связи и их проверка
        this.$btn.forEach((el) => {
            el.addEventListener("click", this.sendRequest.bind(this));
        });
        // изменение значения для сопутствкющего инпута
        // check state of checkbox for send form
        this.$agreeInp.forEach((el) => {
            el.addEventListener("click", this.validateCheckbox.bind(this));
        });
        //Disabla button actions if it has disabled class or attr
        this.$disabledItems.forEach((el) => {
            el.addEventListener("click", this.disableAction.bind(this));
        });

        this.$numOnly.forEach(($el) => {
            $el.addEventListener("keydown", this.validateNumOnly.bind(this));
        });

        this.events.forEach((event) => {
            this.$numMax.forEach(($el) => {
                $el.addEventListener(event, this.validateNumMax.bind(this));
            });
        });

        this.sybmolsEvents.forEach((event) => {
            this.$symbolsMax.forEach(($el) => {
                $el.addEventListener(event, this.validateSymbolsMax.bind(this));
            });
        });
        this.filterClear.forEach((el) => {
            el.addEventListener("click", this.clearForm.bind(this));
        });
    }

    clearForm(e) {
        e.preventDefault();
        let btn = e.currentTarget,
            form = btn.closest("form");

        form.reset();
        $("[data-custom-select]")
            .val("")
            .trigger("change");
    }

    // Отправка на сервер данных из формы обратной связи и их проверка
    sendRequest(e) {
        e.preventDefault();
        let $btn = e.currentTarget,
            form = $btn.closest("form"),
            url = form.getAttribute("action") || "",
            type = $btn.getAttribute(`data-${this.dataName.btn}`),
            formData = new FormData(form);

        formData.append("ajax", type);

        if (!this.options.allowSend) return false;
        this.preventingResend($btn, "disallow");

        fetch(url, {
            method: "POST",
            body: formData,
        })
            .then((res) => res.json())
            .then((res) => {
                this.validateForm($btn, res);
                this.preventingResend($btn, "allow");
                console.log(res)
            })
            .catch((err) => {
                this.preventingResend($btn, "allow");
                console.log(err);
            });
    }

    //check state of checkbox for send form
    validateCheckbox(e) {
        let $agreeInp = e.currentTarget,
            $agreeBox = $agreeInp.closest("form"),
            $agreeBtn = $agreeBox.querySelector("[data-agree-btn]"),
            hasHref = $.nx.matches($agreeBtn, "[href]"),
            isChecked = $agreeInp.checked,
            dataHref = $agreeBtn.getAttribute("data-save-href");

        if (!hasHref) {
            $agreeBtn.disabled = !isChecked;
        } else {
            if (isChecked) {
                $agreeBtn.classList.remove("disabled");
                if (dataHref) $agreeBtn.setAttribute("href", dataHref);
            } else {
                $agreeBtn.classList.add("disabled");
                if (dataHref) $agreeBtn.setAttribute("href", "");
            }
        }
    }

    //Disable button actions if it has disabled class or attr
    disableAction(e) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    }

    //Ввод только цифр
    validateNumOnly(e) {
        if (
            e.which !== 8 &&
            e.which !== 9 &&
            e.which !== 116 &&
            e.which !== 46 &&
            (e.which < 48 || e.which > 57) &&
            (e.which < 96 || e.which > 105) &&
            (e.which < 37 || e.which > 40)
        ) {
            e.preventDefault();
            return false;
        }
    }

    //Проверка на максимальное число
    validateNumMax(e) {
        let $self = e.currentTarget,
            val = Number($self.value);
        var max = Number($self.getAttribute(`data-${this.dataName.numMax}`));

        if (val >= max) $self.value = max;
    }

    //Проверка на максимальное число
    validateSymbolsMax(e) {
        let $self = e.currentTarget,
            val = $self.value,
            valLength = val.length,
            maxCount = $self.getAttribute(`data-${this.dataName.symbolsMax}`),
            $maxCountBox = $self
                .closest(`[data-${this.dataName.formGroup}]`)
                .querySelector(`[data-${this.dataName.symbolsLength}]`);

        if (valLength > maxCount) {
            $self.value = $self.value.substring(0, maxCount);
        } else {
            $maxCountBox.textContent = `${valLength}/${maxCount}`;
        }
    }

    // Предотвращение повторной отправки, до ответа от сервера
    preventingResend($btn, type) {
        switch (type) {
            case "disallow":
                if ($btn.classList.contains(this.className.send)) return false;
                $btn.classList.add(this.className.send);
                $.nx.insertPreloader($btn, false, this.className.preloaderTheme);
                this.options.allowSend = false;
                break;
            case "allow":
                $btn.classList.remove(this.className.send);
                $.nx.hidePreloader($btn);
                this.options.allowSend = true;
                break;
        }

        return this.options.allowSend;
    }
    prepareSuccessModal(modalData) {
        const $modalOkTitle = modalData.$modal.querySelector("[data-modal-title]");
        const $modalOkText = modalData.$modal.querySelector("[data-modal-text]");

        if (modalData.text) {
            $modalOkText.classList.remove("hidden");
            $modalOkText.textContent = modalData.text;
        } else {
            $modalOkText.classList.add("hidden");
            $modalOkText.textContent = "";
        }

        $modalOkTitle.textContent = modalData.title;
    }
    // Получение от сервера ошибок валидации и их обработка
    validateForm($btn, response) {
        let type = $btn.getAttribute(`data-${this.dataName.btn}`),
            $form = $btn.closest("form"),
            $customSelect = $($form).find('[data-custom-select]'),
            $formGroup = $form.querySelectorAll(`[data-${this.dataName.formGroup}]`),
            $errorBox = $form.querySelectorAll(this.erorrElement),
            $modal = $btn.closest(".modal"),
            $modalOk = null;

        if (typeof response !== "object") response = $.parseJSON(response);
        $formGroup.forEach(($el) => {
            $el.classList.remove(this.className.error);
            $el.classList.add(this.className.success);
        });

        $errorBox.forEach((error) => {
            error.remove();
        });

        if (!$.nx.isEmpty(response)) {
            for (let inpName in response) {
                if (response.hasOwnProperty(inpName)) {
                    let $target = $form.querySelectorAll(
                        'input[name="' +
                        inpName +
                        '"], textarea[name="' +
                        inpName +
                        '"], select[name="' +
                        inpName +
                        '"]'
                    );
                    if (!$target.length) return false;
                    $($target)
                        .closest(`[data-${this.dataName.formGroup}]`)
                        .addClass(this.className.error)
                        .removeClass(this.className.success)
                        .append($(this.erorrTemplate).html(response[inpName]));
                }
            }
        } else {
            switch (type) {
                case "callback":
                    $modalOk = $(this.className.modalOk);
                    this.prepareSuccessModal({
                        $modal: $modalOk,
                        title: "Спасибо за обращение",
                        text: "Мы свяжемся в вами в ближайшее время",
                    });
                    break;
                default:
                    $modalOk = document.querySelector(this.className.modalOk);
            }

            if ($modalOk) {
                if($modal) {
                    $modal.setAttribute('aria-hidden', 'true');
                    $modal.classList.remove('is-open');
                }

                setTimeout(function() {
                    MicroModal.show($modalOk.id, {
                        closeTrigger: "data-custom-close",
                        openClass: "is-open",
                        disableScroll: true,
                    });
                }, this.options.timeoutModalOkShow);
            }

            $form.querySelectorAll(this.filesList).forEach((el) => {
                el.innerHTML = "";
            });
            $($form)
                .find(this.cleanedFormItems)
                .not(this.excludedFormItems)
                .val("");
        }
    }
}

export default new NxRequest();
