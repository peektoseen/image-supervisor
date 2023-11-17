$(function () {

    $('.js-moderate-btn').on('click', function (event) {
        $(".loading-spinner").show();
        $(".js-moderate-btn,.lead").hide();
        $.post('/api', {
            action: $(event.target).data('action'),
            url: $('.js-image').attr('src'),
        }).then(function (data) {
            $('.js-image').attr('src', data.url);
        })
    })

    $('.js-image').on('error', function (event) {
        $(event.target).attr('src', 'https://placehold.co/600x500');
        $('.lead').show();
        $(".loading-spinner").hide();
        event.stopPropagation();
    })

    $('.js-image').on('load', function (event) {
        $(".loading-spinner").hide();
        $(".js-moderate-btn").show();
    });

});