<div id="question"
     aria-hidden="true"
     class="modal micromodal-slide"
     tabindex="-1">
    <div class="modal__overlay" tabindex="-1" data-custom-close>
        <div class="modal__wrapper">
            <a href="#"
               class="modal__close"
               aria-label="Close modal"
               data-custom-close>
                <i class="mdi mdi-close"></i>
            </a>
            <div class="modal__container" role="dialog" aria-modal="true">


                <div class="h5 modal__title">Задать вопрос</div>

                <form action="/request/question.php">
                    <div class="flex-row">
                        <div class="flex-col xs-24 form-group" data-form-group>
                            <span class="form-group__text">Как к вам обращаться?</span>
                            <label class="nx-dynamic-label" data-dynamic-label>
                                <input type="text" class="nx-dynamic-label__input" name="name" data-dynamic-inp>
                                <span class="nx-dynamic-label__text">Имя или псевдоним</span>
                            </label>
                        </div>
                        <div class="flex-col xs-24 form-group" data-form-group>
                            <span class="form-group__text">Ваш e-mail</span>
                            <label class="nx-dynamic-label" data-dynamic-label>
                                <input type="text" class="nx-dynamic-label__input" name="email" data-dynamic-inp>
                                <span class="nx-dynamic-label__text">E-mail</span>
                            </label>
                        </div>
                        <div class="flex-col xs-24 form-group" data-form-group>
                            <span class="form-group__text">Опишите свой вопрос в этом поле</span>
                            <label class="nx-dynamic-label" data-dynamic-label>
                            <textarea class="nx-dynamic-label__input" name="comment" rows="1" data-dynamic-inp
                                      data-autosize-textarea></textarea>
                                <span class="nx-dynamic-label__text">Расскажите, что вас тревожит или вызывает затруднения</span>
                            </label>
                        </div>
                        <div class="nx-actions__item">
                            <div class="form-group note">
                                <div class="checkbox">
                                    <input type="checkbox" id="agree-feedback" name="agree-feedback" class="nx-actions__agree-checkbox hidden" data-agree-inp>
                                    <label class="checkbox__text nx-actions__agree-label" for="agree-feedback">Я согласен на обработку персональных данных
                                        и ознакомлен с <a href="/<?= LANGUAGE_ID ?>/policy/" class="link"><span>Политикой конфиденциальности</span></a></label>
                                </div>
                            </div>
                        </div>
                        <div class="nx-actions__item nx-actions__item_btn">
                            <button type="submit" class="btn modal__btn" data-agree-btn disabled data-send-request="main">
                                Отправить
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
