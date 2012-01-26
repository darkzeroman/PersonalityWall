function shuffle() {
	$('.cover').unbind('click');
	$('.cover').fadeOut();
	$(".pic").not('.cover').each(function() {
		var left = Math.floor(Math.random() * (stage_width - 150));
		var top = Math.floor(Math.random() * stage_height);
		var rot = Math.floor(Math.random() * 80) - 40;
		myAnimate(this, left, top, rot);
	});
};

function grid() {
	$('.cover').fadeOut();
	$('.cover').unbind('click');
	var maxCols = Math.floor(stage_width / 110);
	$('.pic').not('.cover').each(function(index, value) {
		var row = index % maxCols;
		var col = Math.floor(index / maxCols);
		var rot = 0;
		var left = row * 113;
		var top = col * 120;
		myAnimate(this, left, top, rot);
	});
};

function sort() {
	$('.cover').unbind('click');
	$('.cover').fadeIn();
	$.each(list, function(index, value) {
		var left = 35 + (stage_width) / (list.length) * (index);
		var top = Math.floor(Math.random() * stage_height);
		$(value).each(function() {
			if ($(this).is('.cover')) {
				rot = 0;
				myAnimate(this, left, top, rot);
			} else {
				rot = Math.floor(Math.random() * 80) - 40;
				myAnimate(this, left, top, rot);
			}
			;
		});
	});
	updateCoversZ();
};

function gridSort() {
	$('.cover').unbind('click');
	$('.cover').fadeIn(); // fade the covers
	$.each(list, function(index, value) {
		left = 113 * index + (stage_width - list.length * 117) / 2;
		myAnimate($(value).filter('.cover'), left, 0, 0); // moving the covers
		// to top position
		$(value).filter('.cover').fadeIn();
		$(value).not('.cover').each(function(index2, value2) {
			rot = 0;
			left = 113 * index + (stage_width - list.length * 117) / 2;
			var top = 115 + (120 * index2);
			myAnimate(this, left, top, rot);
		});
	});
};

function browse() {
	sort();
	$('.cover').unbind('click');
	$('.cover').each(function(index, value) {
		$(this).bind('click', function() {
			hasClicked(this.title);
		})
	});
};

function hasClicked(title) {
	// alert("."+title);
	$('.' + title).unbind('click');
	$.each(list, function(index, value) {
		var left = 0;
		var top = 0;
		$(value).each(function(index2, value2) {
			if ($(this).is('.' + title)) {
				left = stage_width / 2;
				top = stage_height / 2;
				rot = 0;
				myAnimateNoRotate(this, left, top);
			} else {
				left = -100;
				top = index * 115;
				rot = 0;
				myAnimate(this, left, top, rot);
				;
			}
			;
		});
	});
	$('.' + title).not('.cover').each(

			function(index, value) {
				var left = Math.floor(Math.random() * stage_width / 2)
						- stage_width / 4;
				var top = Math.floor(Math.random() * stage_height)
						- stage_height / 2;
				left = stage_width / 2 + left;
				top = stage_height / 2 + top;
				var rot = Math.floor(Math.random() * 80) - 40;
				myAnimate(value, left, top, rot);
			});
};

function myAnimateNoRotate(obj, left, top) {
	$(obj).animate({
		left : left,
		top : top,
		// added in case CSS3 is standard
		zIndex : 1
	}, 1000, function() {
	});
};

function myAnimate(obj, left, top, rot) {
	$(obj).animate({
		left : left,
		top : top,
		rotate : rot + 'deg',
		// using the plugin
		'-webkit-transform' : 'rotate(' + rot + 'deg)',
		// safari
		'-moz-transform' : 'rotate(' + rot + 'deg)',
		// firefox
		'tranform' : 'rotate(' + rot + 'deg)',
		// CSS3
		zIndex : 1
	}, 1000, function() {
	});
};

function updateCoversZ() { /* Executed on image click */
	$.each(list, function(index, value) {
		var maxZ = 0; /* Find the max z-index property: */
		// alert(value);
		$(value).each(function() {
			var thisZ = parseInt($(this).css('zIndex'))
			if (thisZ > maxZ)
				maxZ = thisZ;
		});
		$(value + 'Cover').css({
			zIndex : maxZ + 1
		});
		// alert(maxZ);
	});
};
