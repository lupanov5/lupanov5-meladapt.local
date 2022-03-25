//Сериализация формы с файлами
(function($) {
    $.fn.serializefiles = function() {
        let obj = $(this);
        /* ADD FILE TO PARAM AJAX */
        let formData = new FormData();
        $.each($(obj).find("input[type='file']"), function(i, tag) {
            $.each($(tag)[0].files, function(i, file) {
                formData.append(tag.name, file);
            });
        });
        let params = $(obj).serializeArray();
        $.each(params, function (i, val) {
            formData.append(val.name, val.value);
        });
        return formData;
    };
})(jQuery);