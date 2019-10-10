<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">       
        <link rel="shortcut icon" type="image/ico" href="" />
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap-table.css" rel="stylesheet" type="text/css"/>
        <link href="css/font-awesome.css" rel="stylesheet" />
        <!--link href="css/style.css" rel="stylesheet" type="text/css"/-->
        <!--[if lt IE 9]>
            <script src="../../js/html5shiv.min.js" type="text/javascript"></script>
            <script src="../../js/respond.min.js" type="text/javascript"></script>
        <![endif]-->       
    </head>
    <body>

        <div class="content-wrapper">
            <!--div class="container">
                <div class="row">
                    <div class="col-md-12" id="navbar">
                        <nav class="navbar navbar-default" >
                            <div class="container">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse">
                                        <span class="sr-only"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a href="index.php" class="navbar-brand active"></a>
                                </div>
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                    <ul class="nav navbar-nav navbar-left" id="ulModulos">
                                    </ul>
                                    <ul class="nav navbar-nav navbar-right" id="ulDerecha">
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="col-md-12">
                        <h4 class="page-head-line"></h4>
                    </div>
                </div>
            </div-->
            <div class="container">
                <div class="row" id="new">
                    <div class="col-xs-12">
                        <div class="col-xs-2">
                            <div class="thumbnail">
                                <!--div class="caption">
                                    <a href="new.php" class="btn btn-primary" role="button">New</a>
                                </div-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="text-align:center;padding-bottom: 30px;">
                                <div class="pull-left">
                                    BRANDELL DIESEL
                                </div>
                                <div id="date" class="pull-right">
                                    BRANDELL DIESEL
                                </div>
                            </div>
                            <div class="panel-body">
                                <table id="table-dashboard" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right"></table>
                            </div>
                        </div>				        	
                    </div>
                </div>
            </div>
        </div>
	<div class="push"></div>
        <!--footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 ">
                        &copy; 2016 | Todos los derechos reservados
                    </div>
                </div>
            </div>
        </footer-->
        <div id="modal-assign" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Assign To</h4>
                    </div>
                    <div class="modal-body">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-view" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">View</h4>
                    </div>
                    <div class="modal-body">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-edit" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit</h4>
                    </div>
                    <div class="modal-body">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-delete" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delete</h4>
                    </div>
                    <div class="modal-body">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-table.js" type="text/javascript"></script>
        <script src="locale/bootstrap-table-en-US.js" type="text/javascript"></script>
        <script src="js/jquery.blink.js" type="text/javascript"></script>
        <script>
            
            var DATA                = null;
            var METODO              = null;
            var VALOR               = null;
            var LOADER              = null;
            var ERROR               = null;
            var DATE                = null;
           
            function call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, FN) 
            {
                $.ajax
                ({
                    type: "GET",
                    url: "ws.php",
                    data:
                    {
                        m: METODO,
                        v: VALOR
                    },
                    dataType: "jsonp",
                    jsonp: "callback",
                    jsonpCallback: "JasonpCallback",
                    async: true,
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
           
            $(document).ready(function()
            {
                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                {
                    DATA = data;
                    
                    $('#table-dashboard').bootstrapTable
                    ({
                        data: DATA,
                        //undefinedText:'Not asigned',
                        columns: 
                        [
                            [
                                {
                                    field: 'jobnumber',
                                    title: 'Job Number',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }, 
                                {
                                    field: 'techname',
                                    title: 'Tech Name',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }, 
                                {
                                    field: 'status',
                                    title: 'Status',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }, 
                                {
                                    field: 'deadline',
                                    title: 'Dead Line',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }, 
                                {
                                    field: 'assignedto',
                                    title: 'Assigned To',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    formatter : function(value) 
                                    {
                                        if(!value)
                                        {
                                            return "Unassigned";
                                        }
                                        else
                                        {
                                            return value;
                                        }
                                    }
                                },
                                {
                                    field: 'colorflag',
                                    title: 'Status',
                                    rowspan: 2,
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value) 
                                    {
                                        if (value === "Y")
                                        {
                                            return '<a class="blink"><span class="fa fa-circle" aria-hidden="true" style="color:yellow;"></span></a>';   
                                        }
                                        else if (value === "R")
                                        {
                                            return '<a class="blink"><span class="fa fa-circle" aria-hidden="true" style="color:red;"></span></a>';   
                                        }
                                        else if (value === "G")
                                        {
                                            return '<a class="blink"><span class="fa fa-circle" aria-hidden="true" style="color:green;"></span></a>';   
                                        }
                                    } 
                                },
                                {
                                    title: 'ACCIONES',
                                    colspan: 5,
                                    align: 'center'
                                }
                            ],
                            [
                                {
                                    field: 'assign',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value) 
                                    {
                                        return '<a class=""><span class="fa fa-user"></span></a>';   
                                    } 
                                },
                                {
                                    field: 'view',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value) 
                                    {
                                        return '<a class=""><span class="fa fa-eye"></span></a>';   
                                    } 
                                },
                                {
                                    field: 'edit',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value) 
                                    {
                                        return '<a class=""><span class="fa fa-check" aria-hidden="true"></span></a>';   
                                    }
                                },
                                {
                                    field: 'delete',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value) 
                                    {
                                        return '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';   
                                    }
                                }
                            ]
                        ],
                        onPageChange: function (number, size) 
                        {
                            $('.blink').blink();
                        },
                        onClickCell: function (field, value, row) 
                        {
                            if (field === "assign")
                            { 
                                $('#modal-assign').modal('show'); 
                            }
                            else if(field === "view")
                            { 
                                $('#modal-view').modal('show'); 
                            }
                            else if(field === "edit")
                            { 
                                $('#modal-edit').modal('show'); 
                            }
                            else if(field === "delete")
                            { 
                                $('#modal-delete').modal('show'); 
                            }
                        }
                    });
                    $('.blink').blink();
                });
                
                DATE = new Date();
                $("#date").text(DATE);
                
                
                setInterval(function(){$('#table-dashboard').bootstrapTable('refresh'); }, 10000);
                
                
                

                
                

                //$("#date").text($.now());
                
                
                
            });
        </script>
    </body>
</html>




