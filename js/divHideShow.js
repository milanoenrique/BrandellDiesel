$(document).ready(function() {

	$('.containerDiv').hide();
	$('.btn-group button').click(function(){
		var target = "#" + $(this).data("target");
		$(".containerDiv").not(target).hide();
		$(target).show();
	});

});	
