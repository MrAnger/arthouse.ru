(function ($) {
    // Запрос на удаления изображения
    $(document).on('click', '.js-image-delete', function (e) {
        e.preventDefault();

        var $el = $(this);

        if (confirm("Вы точно хотите удалить это изображение?")) {
            $.post($el.data('url'), function () {
                pjaxContainerRefresh($el);
            });
        }
    });

    // Модалка редактирование текстов изображения
    (function () {
        var $modal = $('#modal-image-update'),
            $form = $modal.find('form');

        // Во время открытия модалки - отображаем нужные значения
        $modal.on('show.bs.modal', function (e) {
            var $relatedTarget = $(e.relatedTarget);

            $form.find('input[type=text][name*=title]').val($relatedTarget.data('title'));
            $form.find('input[type=text][name*=description]').val($relatedTarget.data('description'));

            $form.attr('action', $relatedTarget.data('url'));
        });

        // Во время закрытия модалки - очищает инпуты
        $modal.on('hide.bs.modal', function (e) {
            $form.find('input[type=text]').val('');
        });

        $form.on('beforeSubmit', function (e) {
            e.preventDefault();

            $.post($form.attr('action'), $form.serialize(), function (response) {
                if (response == true) {
                    $modal.modal("hide");

                    pjaxContainerRefresh($('#image-list'));
                }
            })
                .fail(function (error) {
                    console.log(error);
                });

            return false;
        });
    })();

    /**
     * Скрипт инициализирующий сортировку изображений
     */
    function initImagesSortable() {
        var $images = $("#image-list tbody"),
            sortUrl = $images.closest('#image-list').data('url-sort');

        if (!$images.length) {
            return true;
        }

        $images.sortable({
            update: function (event, ui) {
                var $item = ui.item,
                    order = $item.index() + 1;

                $.get(sortUrl, {imageId: $item.data('id'), order: order}, function (response) {
                    if (!response) {
                        pjaxContainerRefresh($images);
                    }
                }).fail(function (error) {
                    console.log(error);

                    pjaxContainerRefresh($images);
                });
            }
        }).disableSelection();
    }

    // Здесь пишем изначальные инициализаторы на странцие
    $(document).ready(function () {
        initImagesSortable();

        $(document).on('pjax:success', function () {
            initImagesSortable();
        })
    });
})(jQuery);

/**
 * Скрипт запускающий обновления pjax контейнера по одному из эллементов внутри него
 * */
function pjaxContainerRefresh($element) {
    var $pjax = $element.closest('.js-pjax');

    if ($pjax.length) {
        $.pjax({
            url: location.href,

            container: '#' + $pjax.attr('id'),
            scrollTo: false,
            timeout: 8000,
            replace: true,
            push: false
        });
    }
}

function getCaretPosition(ctrl) {
    // IE < 9 Support
    if (document.selection) {
        ctrl.focus();
        var range = document.selection.createRange();
        var rangelen = range.text.length;
        range.moveStart('character', -ctrl.value.length);
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