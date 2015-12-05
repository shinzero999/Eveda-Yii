
$(document).ready(function() {

	$('html').removeClass('no-js');

	$('.tabs').tabify();

	$('#contact_form').ajaxForm({ target: '#contact_alert' });

	$(".lightbox").fancybox({
		loop       : true,
		fitToView  : true,
		mouseWheel : false,
		autoSize   : true,
		autoResize : true,
		closeClick : false,
		maxWidth   : 800,
		minHeight  : 150,
		maxHeight  : 700,
		overlay    : { showEarly  : true },
		padding    : 0,
		height  : 'auto',
		helpers : {
			title    : { type : 'inside' }, 
			css : { borderColor: '#FFF' }
		}
	});

	$('#top-link').click(function(e){
		$('html, body').animate({scrollTop:0}, 750, 'linear');
		e.preventDefault();
		return false;
	});

	$('a.next-tab').click(function(e){
		$('html, body').animate({scrollTop:0}, 750, 'linear');
		e.preventDefault();
		return false;
	});
	
	$('#slide-down').click(function(e){
		$('html, body').animate({scrollTop:450}, 750, 'linear');
		e.preventDefault();
		return false;
	});

	var window_width = $('.container').width();
	$(window).smartresize(function() {
		if ($('.container').width() != window_width) {
			window_width = $('.container').width();
			$('#menu #switch').removeClass('on');
			$('#menu').removeClass('mobile');
			$('.isotope').isotope("reLayout");
		}
	});

	$(window).scroll(function() {
		$el = $('#top-link');
		if ($(window).scrollTop() >= 200) {
			$el.fadeIn(250);
		} else {
			$el.fadeOut(250);
		}
	});




}); // end doc ready 










 




