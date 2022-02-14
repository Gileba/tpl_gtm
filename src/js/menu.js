jQuery(".navigation .menu").ready(function () {
	$width = jQuery(".navigation .menu").width();
	jQuery(".navigation .menu .nav-child").width($width - 23);
	jQuery(".navigation .menu .nav-child .nav-child").width(($width / 6) * 5 - 23);
	$right = $width / 6;
	jQuery(".navigation .menu .nav-child .nav-child").css({ right: $right });
});
