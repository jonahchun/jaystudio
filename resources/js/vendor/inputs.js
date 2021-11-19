$(document).ready(function () {
    let formInput = $('.js-form-input');

    formInput.each(function () {
        if ($(this).val()) {
            $(this).addClass('active');
            $(this).parent().children('.js-form-label').addClass('active');
        }
    });

    formInput.on('keydown', function () {
        setFieldActive($(this));
    });

    formInput.focus(function () {
        setFieldActive($(this));
    });

    formInput.focusout(function () {
        unsetFieldActive($(this));
    });

});

function setFieldActive(input) {
    const activeLabel = input.parent().children('.js-form-label');

    activeLabel.addClass('active');
}

function unsetFieldActive(input) {
    const activeLabel = input.parent().children('.js-form-label');

    if (input.val().length === 0) {
        activeLabel.removeClass('active');
    }
}
