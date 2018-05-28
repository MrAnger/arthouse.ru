(function ($) {

})(jQuery);

function getCaretPosition(ctrl) {
    // IE < 9 Support
    if (document.selection) {
        ctrl.focus();
        var range = document.selection.createRange();
        var rangelen = range.text.length;
        range.moveStart ('character', -ctrl.value.length);
        var start = range.text.length - rangelen;
        return {'start': start, 'end': start + rangelen};
    }
    // IE >=9 and other browsers
    else if (ctrl.selectionStart || ctrl.selectionStart == '0') {
        return {'start': ctrl.selectionStart, 'end': ctrl.selectionEnd};
    } else {
        return {'start': 0, 'end': 0};
    }
}

function setCaretPosition(ctrl, start, end) {
    // IE >= 9 and other browsers
    if (ctrl.setSelectionRange) {
        ctrl.focus();
        ctrl.setSelectionRange(start, end);
    }
    // IE < 9
    else if (ctrl.createTextRange) {
        var range = ctrl.createTextRange();
        range.collapse(true);
        range.moveEnd('character', end);
        range.moveStart('character', start);
        range.select();
    }
}

// Скрипт позволяющий вводить правильные URL в поля для ввода текста
$(document).on('input', '.url-input', function (e) {
    var $el = $(this),
        value = $el.val(),
        caretPosition = getCaretPosition(this);

    // Убираем лишние ненужные символы
    if (/[^\w\-_]/.test(value)) {
        $el.val(value.replace(/[^\w\-_]/ig, ''));

        setCaretPosition(this, caretPosition.start - 1, caretPosition.end - 1);
    }
});