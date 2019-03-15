(function($) {

	var isMobileBreakpoint = function () {
		console.log($(window).width()+' vs '+window.mobileBreakpoint);
		if ($(window).width() <= window.mobileBreakpoint) {
			$('body').addClass('is-mobile-breakpoint');
		} else {
			$('body').removeClass('is-mobile-breakpoint');
		}
	}

	$(document).ready(function () {
		isMobileBreakpoint();	
		/*$('.menu-item-has-children > a').click(function (e) {
			e.preventDefault();
		});*/

		$('.menu-item-has-children').click(function () {
			//e.stopPropagation();
			//$(this).toggleClass('open');
			$(this).children('ul').slideToggle();
		});
		$('.menu-item-has-children > a').click(function (e) {
			if ($(this).parents('.is-mobile-breakpoint').length > 0) {
				console.log('is on mobile');
				console.log($(this).siblings('ul'));
				console.log($(this).siblings('ul').is(':visible'));
				if (!$(this).siblings('ul').is(':visible')) {
					console.log('should not click. just open submenu');
					$(this).parent().click();
					return false;
				} else {
					e.stopPropagation();
				}
				console.log('already open. it should click');
			}
			console.log('is not mobile. it should click');
		})
	});

	$(window).resize(function() {
		isMobileBreakpoint();
	});


	$(document).on('click', '.open-menu', function (e) {
		e.preventDefault();
		console.log('clicked');
		$('.rd-nav').slideToggle();
		$(this).toggleClass('open');
	});
})(jQuery)