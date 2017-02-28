$(function () {
	var elWrap = $('#slider'),
		el =  elWrap.find('img'),
		indexImg = 1,
		indexMax = el.length;
	
	function change () {
		el.fadeOut(0);
		el.filter(':nth-child('+indexImg+')').fadeIn(500);
	}	
		
	function autoCange () {	
		indexImg++;
		if(indexImg > indexMax) {
			indexImg = 1;
		}			
		change ();
	}	
	var interval = setInterval(autoCange, 3000);

	elWrap.mouseover(function() {
		clearInterval(interval);
	});
	elWrap.mouseout(function() {
		interval = setInterval(autoCange, 3000);
	});
	
	elWrap.append('<span class="next"></span><span class="prev"></span>');
	
	$('span.next').click(function() {
		indexImg++;
		if(indexImg > indexMax) {
			indexImg = 1;
		}
		change ();
	});
	$('span.prev').click(function() {
		indexImg--;
		if(indexImg < 1) {
			indexImg = indexMax;
		}
		change ();
	});	
});