<?php
		include_once("includes/functions.php");
?>
	<!-- Inicio Datos Basicos del Paciente  -->
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
	<!-- Fin Datos Basicos  -->
	
	<!-- Inicio Button trigger modal -->
	<!-- Inicio Modal -->
	<div class="modal" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Delete</h4>
				</div>
				<div class="modal-body">
					<div class="col-sm-16">
						<div class="widget-box">
							<div class="widget-body">
								<div class="modal-body datagrid table-responsive" >
									<center>
										<div class="panel-body" id="sendMessage">
											<p>Are you sure to delete the Job Number: "JOB000250"?</p>
										</div>
									</center>											 
								</div>
							</div>
						</div>
					</div>
				</div> 
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Delete</button>			
				</div>				
			</div>
		</div>
	</div>
	
	<div class="modal" id="myModalSendMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Send Message</h4>
				</div>
				<div class="modal-body">
					<div class="col-sm-16">
						<div class="widget-box">
							<div class="widget-body">
								<div class="modal-body datagrid table-responsive" >
									<center>
										<div class="panel-body" id="sendMessage">
											
										</div>
									</center>											 
								</div>
							</div>
						</div>
					</div>
				</div>                            
			</div>
		</div>
	</div>
	
	<div class="modal" id="myModalPartsRequesition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> New Parts Requesition</h4>
				</div>
				<div class="modal-body">
					<div class="col-sm-16">
						<div class="widget-box">
							<div class="widget-body">
								<div class="modal-body datagrid table-responsive" >
									<center>
										<div class="panel-body" id="partsRequesition">
											
										</div>
									</center>											 
								</div>
							</div>
						</div>
					</div>
				</div>      
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save</button>			
				</div>					
			</div>
		</div>
	</div>
	<!-- Fin Modal -->											  
	<!-- Fin Button trigger modal -->
