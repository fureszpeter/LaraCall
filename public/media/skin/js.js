/* éáűőúöüó */

jQuery(window).load(function() {
	jQuery('#msg .success').delay(5000).animate({
		'opacity':0,
	}, 500, function(){
		jQuery(this).animate({'height':0}, 250, function() {jQuery(this).css('display','none');});
	})
});

jQuery(document).ready(function() {
    jQuery('.phones .radios li span').click(function() {
        jQuery(this).parent('li').siblings('li').removeClass('selected');
        jQuery(this).parent('li').addClass('selected');
        jQuery('#default_phone').val(jQuery(this).html());
    });
    jQuery('.phones .selected').click();
	
	jQuery('.outer-submit input').click(function(e){
		e.preventDefault();
	});

});