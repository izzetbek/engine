$('.attachComment').click(function (e) {
    e.preventDefault();
    $(this).next('.attach-comment').toggleClass('hidden');
});