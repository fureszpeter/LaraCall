function parallax() {
	var scrollPosition = $(window).scrollTop();
	$('#parallax').css('top',(0 - (scrollPosition * 0.3))+'px' ); // bg image moves at 30% of scrolling speed
	$('#hero').css('opacity',((100 - scrollPosition/2) *0.01));
}
$(document).ready(function() {

	/*	Parallax Background
	================================================== */

	$(window).on('scroll', function(e) {
		parallax();
	});
	
	/*	Local Scroll
	================================================== */
	
	jQuery('.navbar').localScroll({
			offset: -60,
			duration: 500
		});
		
	/*	Active Menu
	================================================== */
		
	jQuery(function() {
		var sections = jQuery('section');
		var navigation_links = jQuery('nav a');
		sections.waypoint({
		handler: function(direction) {
			var active_section;
			active_section = jQuery(this);
			if (direction === "up") active_section = active_section.prev();
			var active_link = jQuery('nav a[href="#' + active_section.attr("id") + '"]');
			navigation_links.parent().removeClass("active");
			active_link.parent().addClass("active");
			active_section.addClass("active-section");
		},
		offset: '35%'
		});
	});
	
	/*	Animation with Waypoints
	================================================== */
	
	jQuery('.animate').waypoint(function() {
	     var animation = jQuery(this).attr("data-animate");
	     jQuery(this).addClass(animation);
	     jQuery(this).addClass('animated');
	}, { offset: '80%' });
	
	/*	Pretty Photo
	================================================== */
	
	jQuery('#gallery a').attr('rel', 'prettyPhoto');
	jQuery("a[rel^='prettyPhoto']").prettyPhoto();
	
	/*	Bootstrap Carousel
	================================================== */
	
	jQuery('.carousel').carousel()
	

});


function indexformvalid($formid) {
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	x = 0;
	cb = 0;
	jQuery($formid+' input.required').each( function() {
		if (jQuery(this).attr('type') == 'radio') {
			if (!jQuery('input[type="radio"][name="'+jQuery(this).attr('name')+'"]').is(':checked')){
				x++;
				jQuery(this).addClass('inputerror');
				jQuery($formid+' label[for="'+jQuery(this).attr('name')+'"], '+$formid+' div.label[data-for="'+jQuery(this).attr('name')+'"]').addClass('inputerror');
			}
		}
		else if (jQuery(this).attr('type') == 'checkbox') {
			if (!jQuery(this).is(':checked')) {
				jQuery(this).addClass('inputerror');
				cb++;
			}
		}
		else if (jQuery(this).val() == ""){
			x++;
			jQuery(this).addClass('inputerror');
		}
	});
	if (x > 0) {
		errormessage('Kérlek tölts ki minden mezőt!', $formid);
		return false;
	}
	else if (cb > 0) {
		errormessage('Kérlek fogadd el a Felhasználási Feltételeket!', $formid);
		return false;
	}
	//possible fault: if there is no email field, script chokes here
	else if (jQuery($formid+' input[type="email"].required').length > 0 && !regex.test(jQuery($formid+' input[type="email"].required').val())) {
		errormessage('Kérlek adj meg egy helyes email címet!', $formid);
		return false;
	}
	return true;
}

function errormessage(a, $formid) {
	$this = jQuery($formid+' .error');
	$this.stop().css({
		'opacity':'1'
	}).html(a);
	$this.delay(2000).animate({
		'opacity':0
	}, 3000);
}
