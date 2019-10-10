/****************************************************/
/* rederizsoft - cp									*/
/* rederizsoftdeveloper@gmail.com					*/
/* www.rederizsoft.com								*/
/****************************************************/

function rederizsoftReady( vIdEntidad, vDiv, vPagePHP, vCargarData, vAction ) {
	$(document).ready(function () {
		rederizsoftShowLoad( vDiv, vCargarData );
		var mywindow = $(vDiv).load(vPagePHP + vIdEntidad, " ", function () {
			rederizsoftHideLoad( vDiv, vCargarData );
		});
	});
}

function rederizsoftShowLoad( vDiv, vCargarData ) {
	$(document).ready(function () {
		$("#result").hide("slow");
		$(vCargarData).show("slow");
	});
}

function rederizsoftHideLoad( vDiv, vCargarData ) {
	$(document).ready(function () {
		$(vDiv).show("slow");
		$(vCargarData).hide("slow");
	});
}	