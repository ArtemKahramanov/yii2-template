$(document).ready(function () {
    $('.btn--menu').click(function () {
        $('.menu').toggle(300);
    });
    $('.skill').click(function () {
        $(this).children('.skill__button').toggleClass('skill--open');
        $(this).children('.skill__content').toggle(350);
    });

});
// wow animation
new WOW().init();

$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function () {
        $('body,html').animate({scrollTop: 0}, 800);
    });
});


// var skill = document.querySelector('.skill');
// skill.addEventListener('click', function () {
//     var child = skill.querySelector('.skill__button');
//     var content = skill.querySelector('.skill__content');
//     console.log(child);
//     child.toggleClass('.skill--open');
//     content.toggle(350);
//
// });
