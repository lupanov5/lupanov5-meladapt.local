'use strict';
/**
 * Переключение пароля (текст/звёздочки)
 */

class PasswordToggle{
    constructor(element, options) {
        this.dataName = {
            passwordWr: 'password-wr',
            passwordInput: 'password-input',
            passwordLink: 'password-link'
        };

        this.$el = element || document.querySelectorAll(`[data-${this.dataName.passwordLink}]`);

        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init(){
        this.bindsEvent();
    }

    //Method for all actions
    bindsEvent(){
        this.$el.forEach(($el) => {
            $el.addEventListener('click', this.passwordToggle.bind(this));
        });
    }
    passwordToggle(e) {
        e.preventDefault();
        e.stopPropagation();
        let $self = e.currentTarget,
            $passwordWr = $self.closest(`[data-${this.dataName.passwordWr}]`),
            $passwordInput = $passwordWr.querySelector(`[data-${this.dataName.passwordInput}]`);

        if ($passwordInput.getAttribute('type') === 'password'){
            $passwordInput.classList.add('view');
            $passwordInput.setAttribute('type', 'text');
        } else {
            $passwordInput.classList.remove('view');
            $passwordInput.setAttribute('type', 'password');
        }

    }
}
export default PasswordToggle;


