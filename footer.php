	<script src="js/jquery.blink.js" type="text/javascript"></script>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo "$vPath" ?>js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo "$vPath" ?>js/bootstrap.min.js"></script>
    <!-- efectos -->
    <script src="<?php echo "$vPath" ?>js/effects.js"></script>
	
	<!-- validation -->
    <script src="<?php echo "$vPath" ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo "$vPath" ?>js/additional-methods.min.js"></script>
    <script type="text/javascript">
        $("#usunew").validate({
          rules: {
            nombre: "required",
            password: "required",
            email: {
              required: true,
              email: true
            }
          }
        });
    </script>
	
	<script src="<?php echo "$vPath" ?>js/fieldsAddRemove.js"></script>
	<script src="<?php echo "$vPath" ?>js/jquery-1.10.2.min.js"></script>
	
	<script src="<?php echo "$vPath" ?>js/divHideShow.js"></script>
	
	<script src="<?php echo "$vPath" ?>js/changeInnerHtmlSelect.js"></script>	
	
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
	