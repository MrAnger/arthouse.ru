// Скрипт отображающий дополнительные поля настройки у включенных полей работы
(function () {
    $('#post-enabled-field-list label input[type=checkbox]').change(function (e) {
        var $checkbox = $(this),
            $inputWrapper = $checkbox.closest('label').next('div');

        if ($checkbox.prop('checked')) {
            while ($inputWrapper.length) {
                $inputWrapper.removeClass('hidden');
                
                $inputWrapper = $inputWrapper.next('div');
            }
        } else {
            while ($inputWrapper.length) {
                $inputWrapper.addClass('hidden');

                $inputWrapper = $inputWrapper.next('div');
            }
        }
    });
})();