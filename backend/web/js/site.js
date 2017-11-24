$('.variants').on("change", ".is_correct", function () {
    if (this.checked) {
        $(this).closest('.box').addClass('box-success');
    } else {
        $(this).closest('.box').removeClass('box-success');
    }
});

$('#add-variant').on('click', function (e) {
    e.preventDefault();
    $('#test-question-form').attr('action', $(this).data('action')).submit();
});

$('.remove-item').on('click', function (e) {
    e.preventDefault();
    $.get({
        url: $(this).data('action')
    });
    $(this).closest('.item').remove();
});

$('.attachComment').click(function (e) {
    e.preventDefault();
    $(this).next('.attach-comment').toggleClass('hidden');
});