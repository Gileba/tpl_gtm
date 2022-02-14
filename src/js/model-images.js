function myFunction(imgs, mainimg) {
	// Get the expanded image
	var expandImg = document.getElementById(mainimg);

	// Use the same src in the expanded image as the image being clicked on from the grid
	expandImg.src = imgs.src;
}
