/**
 The theme js.
 */

jQuery(document).ready(function($) {
	// $ Works here. Used for wordpress.
 
	/**
	 * Map scroll fixer from
	 * http://jsfiddle.net/0u6v4jnp/
	 */
	// Disable scroll zooming and bind back the click event
	var onMapMouseleaveHandler = function(event) {
		var that = $(this);

		that.on('click', onMapClickHandler);
		that.off('mouseleave', onMapMouseleaveHandler);
		that.find('iframe').css("pointer-events", "none");
	};
	var onMapClickHandler = function(event) {
		var that = $(this);

		// Disable the click handler until the user leaves the map area
		that.off('click', onMapClickHandler);

		// Enable scrolling zoom
		that.find('iframe').css("pointer-events", "auto");

		// Handle the mouse leave event
		that.on('mouseleave', onMapMouseleaveHandler);
	};
	// Enable map zooming with mouse scroll when the user clicks the map
	$(".embed-responsive").on('click', onMapClickHandler);

	/**
	 * Scroll header
	 */
	$(window).scroll(function() {
		// find the li with class 'active' and remove it
		$("ul.menu-bottom li.active").removeClass("active");
		// get the amount the window has scrolled
		var scroll = $(window).scrollTop();
		// add the 'active' class to the correct li based on the scroll amount
		if (scroll >= 500) {
			$("nav.navbar").addClass("compact");
		} else {
			$("nav.navbar").removeClass("compact");
		}
	});
	console.log($('#wpadminbar').height());
});