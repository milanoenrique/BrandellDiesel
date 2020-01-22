<script>
	//Mostrar Modal
	var result=[];
	var expenditure;
	$(document).ready(function () {
		$.ajax({
			type: "get",
			url: "common/list_expenditure.php",
			dataType: "json",
			success: function (response) {
				result = response;
				$('#table-expenditure').bootstrapTable({
				data: response,
				striped: true,
				columns:
				[
							[
								{
									field: 'project_name',
									title: 'Project Name',
									rowspan: 2,
									align: 'center',
									valign: 'middle',
									width: 1,
								}, 
								{
									field: 'starting_date',
									title: 'Starting date',
									rowspan: 2,
									align: 'center',
									valign: 'middle',
									width: 1
								},
								{
									field: 'amount',
									title: 'Amount',
									rowspan: 2,
									align: 'center',
									valign: 'middle',
									width: 1
								}, 
								{
									field: 'requested',
									title: 'Requested',
									rowspan: 2,
									align: 'center',
									valign: 'middle',
									width: 1
								}, 
								{
									field: 'approved_date',
									title: 'Approved Date',
									rowspan: 2,
									align: 'center',
									valign: 'middle',
									width: 1,
									formatter : function(value) 
										{
											if(value=='infinity'){
												return '-';
											}else{
												return value;
											}   
										}
									
								},
								<?php if ($profile='Manager'): ?>
									{
										title: 'Actions',
										colspan: 4,
										align: 'center'
									}
								<?php endif; ?>
							],

							[
								<?php if ($profile!='TV'): ?>
									{
										field: 'id',
										title: '',
										align: 'center',
										valign: 'middle',
										width: 1,
										clickToSelect: false,
										formatter : function(value) 
										{
											var view = value;//arr[1];
											return '<a class="eye" title="id: '+view+'"><span class="fa fa-eye"></span></a>'   
										}
									}
									<?php if ($profile=='Manager'): ?>

										,{
											field: 'edit',
											title: '',
											align: 'center',
											valign: 'middle',
											width: 1,
											clickToSelect: false,
											formatter : function(value, row) 
											{
												var vEdit = '<a class=""><span class="fa fa-pencil" aria-hidden="true"></span></a>';
												
												return vEdit; 										
											}
										}
										,{
											field: 'delete',
											title: '',
											align: 'center',
											valign: 'middle',
											width: 1,
											clickToSelect: false,
											formatter : function(value, row){

												var vDelete = '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
												
												
												
												return vDelete;   
											}
										}

									<?php endif; ?>

								<?php endif; ?>
									
							],
				],
					onClickCell: function (field, value, row){

						if(field === "id"){ 
							printpdf_expenditure(value);
						
						}else if(field === "edit" && row.status != "C"){ 

							DATA    = null;

							$('#myModalAuthorizationExpenditure-Edit').modal('show');
							var id_expenditure = row.id;
							$.ajax({
								type: "POST",
								url: "common/show_expenditure.php",
								data: {'data':id_expenditure},
								dataType: "json",
								success: function (response) { 
									console.log(response);
									$('#myModalAuthorizationExpenditure-Edit  #id_expenditure').val(response[0].id);
									$('#myModalAuthorizationExpenditure-Edit  #project_name_edit').val(response[0].project_name);
									
									$('#myModalAuthorizationExpenditure-Edit  #project_description_edit').val(response[0].description);
									$('#myModalAuthorizationExpenditure-Edit  #start_date_edit').val(response[0].starting_date);
									$('#myModalAuthorizationExpenditure-Edit  #anticipated_date_edit').val(response[0].anticipated_date);
									$('#myModalAuthorizationExpenditure-Edit  #amount_request_edit').val(response[0].amount);
									$('#myModalAuthorizationExpenditure-Edit  #requested_by_edit').val(response[0].request_by);
									$('#myModalAuthorizationExpenditure-Edit  #request_signature_edit').val(response[0].request_signature);
									$('#myModalAuthorizationExpenditure-Edit  #date_signature_edit').val(response[0].date_request);
									$('#myModalAuthorizationExpenditure-Edit  #president_print_name_edit').val(response[0].president_name);
									$('#myModalAuthorizationExpenditure-Edit  #president_signature_edit').val(response[0].president_signature);
									$('#myModalAuthorizationExpenditure-Edit  #date_approved_president_edit').val(response[0].president_date_approved);
									$('#myModalAuthorizationExpenditure-Edit  #cfo_name_edit').val(response[0].cfo_name);
									$('#myModalAuthorizationExpenditure-Edit  #cfo_signature_edit').val(response[0].cfo_signature);
									$('#myModalAuthorizationExpenditure-Edit  #date_approved_cfo_edit').val(response[0].cfo_date_approved);
									if(response[0].support_documentation!=''){
										$('#myModalAuthorizationExpenditure-Edit #exp_edit_'+response[0].support_documentation+'').prop('checked', true);
									}
									
										
										let prefix = response[0].afe_number.substr(0,8);
										let afe_number =  response[0].afe_number.substr(8);
									$('#myModalAuthorizationExpenditure-Edit  #afe_prefix_edit').text(prefix);	
									$('#myModalAuthorizationExpenditure-Edit  #afe_number_edit').val(afe_number);	
								}
							});


						
					
						}else if(field === "delete" && row.status != "C"){ 
							$('#expendituremodal-delete .comfirmtext span').text(row.project_name);

							$('#delete-expenditure-button').attr('data-record',row.id);

							$('#expendituremodal-delete').modal('show');
							}
						}          
				});
			}
			});
		
	});
	
	$('#tab-expenditure').click(function(){
		$.ajax({
			type: "get",
			url: "common/list_expenditure.php",
			dataType: "json",
			success: function (response) {
				console.log(response);
				result = response;
				$('#table-expenditure').bootstrapTable('load',result);
				
			}
			});
		
		});
	
		
    $('#linkToAuthorizationExpenditure').click(function(){
		$('#amount_request').val(0);
		$.ajax({
			type: "get",
			url: "common/get_prefix.php",
			dataType: "JSON",
			success: function (response) {
				$('#afe-prefix').text(response);
			}
		});
       $('#myModalAuthorizationExpenditure').modal('show');
	   $('#project_name').val('');
	   $('#afe_number').val('');
	   $('#project_description').val('');
	   $('#start_date').val('');
	   $('#anticipated_date').val('');
	   $('#amount_request').val(0);
	   $('#requested_by').val('');
	   $('#request_signature').val('');
	   $('#date_signature').val('');
	   $('.documentation').val('');
	   $('#president_print_name').val('');
	   $('#president_signature').val('');
	   $('#date_approved_president').val('');
       $('#date_approved_cfo').val('');
	   $('#cfo_name').val('');
	   $('#cfo_signature').val('');

    });
	//Guardar nueva expenditure
	$('#myModalAuthorizationExpenditure #save-expenditure').click(function(){
		let require = true;
		$('#myModalAuthorizationExpenditure .require').each(function(){
			if($(this).val()=='' &&  require==true){
				require = false
			}else{
				require= true;
			}
		});
		if(require){
			$('#myModalAuthorizationExpenditure .fix-date').each(function(){
				if($(this).val()==''){
					$(this).val('infinity');
					console.log($(this).val());
				}
			})
			let new_expenditure;
			new_expenditure = {
				"project_name":$('#project_name').val(),
				"afe_number":$('#afe_number').val(),
				"description":$('#project_description').val(),
				"start_date":$('#start_date').val(),
				"anticipated_date":$('#anticipated_date').val(),
				"amount_request":$('#amount_request').val(),
				"request_by":$('#requested_by').val(),
				"request_signature":$('#request_signature').val(),
				"date_request":$('#date_signature').val(),
				"support_documentation":$('input:radio[name=optionsRadios]:checked').val(),
				"president_name":$('#president_print_name').val(),
				"president_signature":$('#president_signature').val(),
				"president_date_approved":$('#date_approved_president').val(),
				"cfo_name":$('#cfo_name').val(),
				"cfo_signature":$('#cfo_signature').val(),
				"cfo_date_approved":$('#date_approved_cfo').val(),
				"created_by":"<?php echo $_SESSION['getValidateUser']['idUser']; ?>",
				"updated_by":"<?php echo $_SESSION['getValidateUser']['idUser']; ?>"
			}
			$.ajax({
				type: "post",
				url: "common/create_expenditure.php",
				data: {"new_expenditure":new_expenditure},
				dataType: "json",
				success: function (response) {
					var id =response[0].id;
					$('#myModalAuthorizationExpenditure').modal('hide');
						$.ajax({
						type: "get",
						url: "common/list_expenditure.php",
						dataType: "json",
						success: function (response) {
							$('#table-expenditure').bootstrapTable('load',response);

						}
					});
					$.ajax({
						type: "get",
						url: "common/list_expenditure.php",
						dataType: "json",
						success: function (response) {
							$('.nav.nav-tabs a[href=#tabexpenditure]').tab('show');
							$.ajax({
								type: "get",
								url: "common/list_expenditure.php",
								dataType: "json",
								success: function (response) {
									result = response;
									$('#table-expenditure').bootstrapTable({
										data: response,
										striped: true,
										columns:
										[
													[
														{
															field: 'project_name',
															title: 'Project Name',
															rowspan: 2,
															align: 'center',
															valign: 'middle',
															width: 1,
														}, 
														{
															field: 'starting_date',
															title: 'Starting date',
															rowspan: 2,
															align: 'center',
															valign: 'middle',
															width: 1
														},
														{
															field: 'amount',
															title: 'Amount',
															rowspan: 2,
															align: 'center',
															valign: 'middle',
															width: 1
														}, 
														{
															field: 'requested',
															title: 'Requested',
															rowspan: 2,
															align: 'center',
															valign: 'middle',
															width: 1
														}, 
														{
															field: 'approved_date',
															title: 'Approved Date',
															rowspan: 2,
															align: 'center',
															valign: 'middle',
															width: 1,
															formatter : function(value) 
																{
																	if(value=='infinity'){
																		return '-';
																	}else{
																		return value;
																	}   
																}
															
														},
														<?php if ($profile='Manager'): ?>
															{
																title: 'Actions',
																colspan: 4,
																align: 'center'
															}
														<?php endif; ?>
													],

													[
														<?php if ($profile!='TV'): ?>
															{
																field: 'id',
																title: '',
																align: 'center',
																valign: 'middle',
																width: 1,
																clickToSelect: false,
																formatter : function(value) 
																{
																	var view = value;//arr[1];
																	return '<a class="eye" title="id: '+view+'"><span class="fa fa-eye"></span></a>'   
																}
															}
															<?php if ($profile=='Manager'): ?>

																,{
																	field: 'edit',
																	title: '',
																	align: 'center',
																	valign: 'middle',
																	width: 1,
																	clickToSelect: false,
																	formatter : function(value, row) 
																	{
																		var vEdit = '<a class=""><span class="fa fa-pencil" aria-hidden="true"></span></a>';
																		
																		return vEdit; 										
																	}
																}
																,{
																	field: 'delete',
																	title: '',
																	align: 'center',
																	valign: 'middle',
																	width: 1,
																	clickToSelect: false,
																	formatter : function(value, row){

																		var vDelete = '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
																		
																		
																		
																		return vDelete;   
																	}
																}

															<?php endif; ?>

														<?php endif; ?>
															
													],
										],
										onClickCell: function (field, value, row){

											if(field === "id"){ 
											
												$('#myModalAuthorizationExpenditure-view').modal('show');
												$.ajax({
													type: "POST",
													url: "common/show_expenditure.php",
													data: {'data':value},
													dataType: "json",
													success: function (response) {
														response[0].support_documentation = (response[0].support_documentation==null)?'':response[0].support_documentation;	
														$('#myModalAuthorizationExpenditure-view  #id_expenditure').val(response[0].id);
														$('#myModalAuthorizationExpenditure-view  #project_name_view').text(response[0].project_name);
														$('#myModalAuthorizationExpenditure-view  #afe_number_view').text(response[0].afe_number);
														$('#myModalAuthorizationExpenditure-view  #project_description_view').text(response[0].description);
														$('#myModalAuthorizationExpenditure-view  #start_date_view').text(response[0].starting_date);
														$('#myModalAuthorizationExpenditure-view  #anticipated_date_view').text(response[0].anticipated_date);
														$('#myModalAuthorizationExpenditure-view  #amount_request_view').text(response[0].amount);
														$('#myModalAuthorizationExpenditure-view  #requested_by_view').text(response[0].request_by);
														$('#myModalAuthorizationExpenditure-view  #request_signature_view').text(response[0].request_signature);
														$('#myModalAuthorizationExpenditure-view  #date_signature_view').text(response[0].date_request);
														$('#myModalAuthorizationExpenditure-view  #president_print_name_view').text(response[0].president_name);
														$('#myModalAuthorizationExpenditure-view  #president_signature_view').text(response[0].president_signature);
														$('#myModalAuthorizationExpenditure-view  #date_approved_president_view').text(response[0].president_date_approved);
														$('#myModalAuthorizationExpenditure-view  #cfo_name_view').text(response[0].cfo_name);
														$('#myModalAuthorizationExpenditure-view  #cfo_signature_view').text(response[0].cfo_signature);
														$('#myModalAuthorizationExpenditure-view  #date_approved_cfo_view').text(response[0].cfo_date_approved);
														$('#myModalAuthorizationExpenditure-view #documentation').text(response[0].support_documentation);
													}
													
												
												});
											}else if(field === "edit" && row.status != "C"){ 

												DATA    = null;

												$('#myModalAuthorizationExpenditure-Edit').modal('show');
												var id_expenditure = row.id;
												$.ajax({
													type: "POST",
													url: "common/show_expenditure.php",
													data: {'data':id_expenditure},
													dataType: "json",
													success: function (response) {
														$('#myModalAuthorizationExpenditure-Edit  #id_expenditure').val(response[0].id);
														$('#myModalAuthorizationExpenditure-Edit  #project_name_edit').val(response[0].project_name);
														$('#myModalAuthorizationExpenditure-Edit  #afe_number_edit').val(response[0].afe_number);
														$('#myModalAuthorizationExpenditure-Edit  #project_description_edit').val(response[0].description);
														$('#myModalAuthorizationExpenditure-Edit  #start_date_edit').val(response[0].starting_date);
														$('#myModalAuthorizationExpenditure-Edit  #anticipated_date_edit').val(response[0].anticipated_date);
														$('#myModalAuthorizationExpenditure-Edit  #amount_request_edit').val(response[0].amount);
														$('#myModalAuthorizationExpenditure-Edit  #requested_by_edit').val(response[0].request_by);
														$('#myModalAuthorizationExpenditure-Edit  #request_signature_edit').val(response[0].request_signature);
														$('#myModalAuthorizationExpenditure-Edit  #date_signature_edit').val(response[0].date_request);
														$('#myModalAuthorizationExpenditure-Edit  #president_print_name_edit').val(response[0].president_name);
														$('#myModalAuthorizationExpenditure-Edit  #president_signature_edit').val(response[0].president_signature);
														$('#myModalAuthorizationExpenditure-Edit  #date_approved_president_edit').val(response[0].president_date_approved);
														$('#myModalAuthorizationExpenditure-Edit  #cfo_name_edit').val(response[0].cfo_name);
														$('#myModalAuthorizationExpenditure-Edit  #cfo_signature_edit').val(response[0].cfo_signature);
														$('#myModalAuthorizationExpenditure-Edit  #date_approved_cfo_edit').val(response[0].cfo_date_approved);
														$('#myModalAuthorizationExpenditure-Edit #'+response[0].support_documentation+'').prop('checked', true);
															console.log(response[0].support_documentation);
													}
												});


											
										
											}else if(field === "delete" && row.status != "C"){ 
												$('#expendituremodal-delete .comfirmtext span').text(row.project_name);

												$('#delete-expenditure-button').attr('data-record',row.id);

												$('#expendituremodal-delete').modal('show');
												}
											}          
									});
								}
							});							
						}
					});
					var expenditure_pdf = ''
					$.ajax({
						type: "POST",
						url: "common/show_expenditure.php",
						data: {'data':id},
						dataType: "json",
						success: function (response) {
							 expenditure_pdf = response[0];
							 $.ajax({
								type: "post",
								url: "common/create_expenditurePdf.php",
								data: 	{
											"expenditure":expenditure_pdf,
											"action":"create",
											"id":id
										},
								dataType: "json",
								success: function (response) {
									
								}
							});
							 
						}
					});
					
				}
				
				
			});
			
			
		}else{
			alert('The field wit * are require');
		}



		
	});

	$('#myModalAuthorizationExpenditure #cancel-expenditure').click(function(){
		$('#myModalAuthorizationExpenditure').modal('hide');
	});

	$('#myModalAuthorizationExpenditure-Edit #save-expenditure_edit').click(function(){
		if($('#myModalAuthorizationExpenditure-Edit .require').val()!=''){
			$('#myModalAuthorizationExpenditure-Edit .fix-date').each(function(){
				if($(this).val()==''){
					$(this).val('infinity');
					console.log($(this).val());
				}
			})
				
			
			var edit_expenditure={};
			edit_expenditure = {
				"id":$('#id_expenditure').val(),
				"project_name":$('#project_name_edit').val(),
				"afe_number":$('#afe_prefix_edit').text()+$('#afe_number_edit').val(),
				"description":$('#project_description_edit').val(),
				"start_date":$('#start_date_edit').val(),
				"anticipated_date":$('#anticipated_date_edit').val(),
				"amount_request":$('#amount_request_edit').val(),
				"request_by":$('#requested_by_edit').val(),
				"request_signature":$('#request_signature_edit').val(),
				"date_request":$('#date_signature_edit').val(),
				"support_documentation":$('input:radio[name=optionsRadios]:checked').val(),
				"president_name":$('#president_print_name_edit').val(),
				"president_signature":$('#president_signature_edit').val(),
				"president_date_approved":$('#date_approved_president_edit').val(),
				"cfo_name":$('#cfo_name_edit').val(),
				"cfo_signature":$('#cfo_signature_edit').val(),
				"cfo_date_approved":$('#date_approved_cfo_edit').val(),
				"updated_by":"<?php echo $_SESSION['getValidateUser']['idUser']; ?>"
			}

			var edit_expenditure_pdf={};
			edit_expenditure_pdf = {
				"id":$('#id_expenditure').val(),
				"project_name":$('#project_name_edit').val(),
				"afe_number":$('#afe_prefix_edit').text()+$('#afe_number_edit').val(),
				"description":$('#project_description_edit').val(),
				"starting_date":$('#start_date_edit').val(),
				"anticipated_date":$('#anticipated_date_edit').val(),
				"amount":$('#amount_request_edit').val(),
				"request_by":$('#requested_by_edit').val(),
				"request_signature":$('#request_signature_edit').val(),
				"date_request":$('#date_signature_edit').val(),
				"support_documentation":$('input:radio[name=optionsRadios]:checked').val(),
				"president_name":$('#president_print_name_edit').val(),
				"president_signature":$('#president_signature_edit').val(),
				"president_date_approved":$('#date_approved_president_edit').val(),
				"cfo_name":$('#cfo_name_edit').val(),
				"cfo_signature":$('#cfo_signature_edit').val(),
				"cfo_date_approved":$('#date_approved_cfo_edit').val(),
				"updated_by":"<?php echo $_SESSION['getValidateUser']['idUser']; ?>"
			}
			$.ajax({
				type: "post",
				url: "common/edit_expenditure.php",
				data: {"edit_expenditure":edit_expenditure},
				dataType: "json",
				success: function (response) {
					$('#myModalAuthorizationExpenditure-Edit').modal('hide');
					$.ajax({
						type: "get",
						url: "common/list_expenditure.php",
						dataType: "json",
						success: function (response) {
							$('#table-expenditure').bootstrapTable('load',response);

						}
					});

				}
			});
			var expenditure_id = edit_expenditure.id;
			$.ajax({
				
				type: "post",
				url: "common/create_expenditurePdf.php",
				data: 	{
							"expenditure":edit_expenditure_pdf,
							"action":"edit",
							"id":expenditure_id
						},
				dataType: "json",
				success: function (response) {
					
				}
			});
			
		}else{
			alert('The field wit * are require');
		}
		
	});

	$('#myModalAuthorizationExpenditure-Edit #cancel-expenditure_edit').click(function(){
		$('#myModalAuthorizationExpenditure-Edit').modal('hide');
	});

	//Eliminar Expenditure

	$('#delete-expenditure-button').on('click',function(event){
                event.preventDefault();

                VALOR  = $(this).attr('data-record');
				$.ajax({
					type: "post",
					url: "common/delete-expenditure.php",
					data: {'data':VALOR},
					dataType: "json",
					success: function (response) {
						$('#table-expenditure').bootstrapTable('load',response);
						$('#expendituremodal-delete').modal('hide');
					}
				});
               
    });

	$('#cancel-expenditure_view').click(function(){
		$('#myModalAuthorizationExpenditure-view').modal('hide');

	});

    $(function () {
   var bindDatePicker = function() {
		$(".date").datetimepicker({
        format:'YYYY-MM-DD',
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			},
			useCurrent: false,
//            minDate: new Date()
		}).find('input:first').on("blur",function () {
			// check if the date is correct. We can accept dd-mm-yyyy and yyyy-mm-dd.
			// update the format if it's yyyy-mm-dd
			var date = parseDate($(this).val());

			if (! isValidDate(date)) {
				//create date based on momentjs (we have that)
				date = moment().format('YYYY-MM-DD');
			}

			$(this).val(date);
		});
	}
   
   var isValidDate = function(value, format) {
		format = format || false;
		// lets parse the date to the best of our knowledge
		if (format) {
			value = parseDate(value);
		}

		var timestamp = Date.parse(value);

		return isNaN(timestamp) == false;
   }
   
   var parseDate = function(value) {
		var m = value.match(/^(\d{1,2})(\/|-)?(\d{1,2})(\/|-)?(\d{4})$/);
		if (m)
			value = m[5] + '-' + ("00" + m[3]).slice(-2) + '-' + ("00" + m[1]).slice(-2);

		return value;
   }
   
   bindDatePicker();
 });

 function printpdf_expenditure(id){
			
			printJS('PDF/expenditure_'+ id +'.pdf');
		}	

function expenditureCSV(){
	iduser          = $("#modal-filter #techId").val();
    startdate       = $("#modal-filter #startdate").val();
    enddate         = $("#modal-filter #enddate").val();
    jobnumber       = $("#modal-filter #jobnumber").val();
	keyword       	= $("#modal-filter #keyword").val();
	VALOR           = iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
	$.ajax({
                        type: "get",
                        url: "common/exp-search.php",
                        data:{'v':VALOR},
                        dataType: "json",
                        success: function (response) {
							downloadCSV({ data: response, filename: "Expenditure.csv" });
                            

                        }
                    });
}
</script>