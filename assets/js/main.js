(function($) {

	"use strict";

	if ($.fn.tooltip) { $('[data-toggle="tooltip"]').tooltip(); } // guard: Bootstrap 5 drops the jQuery tooltip plugin

	// $('#exampleModalCenter').modal('show')

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

})(jQuery);