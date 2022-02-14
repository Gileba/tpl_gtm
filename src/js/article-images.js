jQuery(window).on("load", function () {
	var min_height = -1;

	jQuery(".single-image > img").each(function () {
		if (jQuery(this).height() < min_height || min_height == -1) {
			min_height = jQuery(this).height();
		}
	});

	jQuery(".single-image > img").each(function () {
		jQuery(this).height(min_height);
	});
});
