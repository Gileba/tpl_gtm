jQuery(".navigation .nav").ready(function () {
	$width = jQuery(".navigation .nav").width();
	jQuery(".navigation .nav .mod-menu__sub").width($width - 23);
	jQuery(".navigation .nav .mod-menu__sub .mod-menu__sub").width(($width / 6) * 5 - 23);
	$right = $width / 6;
	jQuery(".navigation .nav .mod-menu__sub .mod-menu__sub").css({ right: $right });
});
