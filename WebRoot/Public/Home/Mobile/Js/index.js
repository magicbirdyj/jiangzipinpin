var swiper = new Swiper('.swiper-container', {
	pagination: '.swiper-pagination',
	autoplay:1200,
	loop:true
});

$(document).ready(function(e) {
    $('.close').click(function(e) {
        $('.pop').hide();
	$('.big-shade-all').hide();
    });
});













