<?php
session_start();
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
</head>

<body>

    <div id="wrapper">
	
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header page-scroll">
					<a class="navbar-brand" href="logout.php?logout"><font color='#04B404'>Brandell Diesel Inc.</font></a>
				</div>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">               
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php?logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="account.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard TV</a>
                        </li>
                        <li>
                            <a href="account.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard parts</a>
                        </li>
						<li>
                            <a href="account.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard tech</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tables</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <br>
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-xs-10">
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
            <!-- /.row -->
            
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
	
	 <script src="js/jquery-1.11.2.min.js"></script>

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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>
