$('.slider-1').not(".slick-initialized").slick({
	autoplay: true,
	autoplaySpeed:3000,
	dots:true,
	prevArrow:".site-slider .slider-btn .prev",
	nextArrow:".site-slider .slider-btn .next"
});
$('.slider-2').not(".slick-initialized").slick({
	prevArrow:".site-slider-2 .prev",
	nextArrow:".site-slider-2 .next",
	slidesToShow:5,
	slidesToScroll:1,
	autoplaySpeed:3000
});