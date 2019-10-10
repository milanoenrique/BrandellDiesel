var URL                 = null;
var DATA                = null;
var METODO              = null;
var VALOR               = null;
var LOADER              = null;
var ERROR               = null;
var DATE                = null;

function call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, FN) {
    var auxdata;

    $.ajax({
        type: "GET",
        url: URL,
        data:
        {
            m: METODO,
            v: VALOR
        },
        dataType: "jsonp",
        jsonp: "callback",
        jsonpCallback: "JasonpCallback",
        async: false,
        beforeSend: function()
        {
            $(LOADER).css("display", "block");
            $(LOADER).css("padding-bottom", "15px");
        },
        complete: function()
        {
            $(LOADER).css("display", "none");
        },
        success: function(data)
        {

            FN(data);
            //FN(JSON.parse(data));
        },
        error: function () 
        {
            $(ERROR).css("display", "block");
            $(ERROR).html("<p style='padding:10px; color:red;'>No se pudo conectar, por favor intente nuevamente.</p>");
        }
    });
}