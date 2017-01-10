jQuery(document).ready(function(e) {
	jQuery('#wrapper').css({'top':jQuery('.head-h').height()});
	jQuery('#wrapper').css({'bottom':jQuery('.foot-h').height()});

});


var myScroll;
function loaded () {
	myScroll = new IScroll('#wrapper', {
		//preventDefault为false这行就是解决onclick失效问题

                //为true就是阻止事件冒泡,所以onclick没用

        preventDefault:false,
		scrollbars: true,
		mouseWheel: true,
		interactiveScrollbars: true,
		shrinkScrollbars: 'scale',
		fadeScrollbars: true,
		
	/*	checkDOMChanges:true,*/
		
	});

}
document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);













