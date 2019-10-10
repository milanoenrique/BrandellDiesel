	<script>

		var recordtype;
		var showmodal;

        var writeupidwriteup            = null;
        var writeupemployee           	= null;
        var writeupappuser              = null;
		var writeupsupervisor        	= null;
        var writeupdate       	        = null;
        var writeuptradelevel           = null;
        var writeupviolationtype        = null;
        var writeuplastwarn	            = null;
        var writeuppreviouswarn         = null;
        var writeupwarnings             = null;
        var writeupwpstatement          = null;
        var writeupstartdate            = null;
        var writeupenddate              = null;
                     
        var writeupparts                = [];
        var writeupdeletedParts         = [];
        var writeupeditedParts          = [];
        var writeupnewParts             = [];

        var JSONwriteupparts            = [];
        var JSONwriteupdeletedParts     = [];
        var JSONeditedtedParts          = [];
        var JSONwriteupnewParts         = [];
        
        var writeupgreen               = null;
        var writeupyellow              = null;
        var red                 = null;
		
		var writeupdashboard_data      = null;
        var filter              = 0;
		var audio               = 0;
		var reloadtime			= 10000;
                    
        var ROW             	= null;
					           
        $(document).ready(function(){
			
			$('.modal.in').on('focus',function(){
				reloadtime = 5000000;
				
			});
			$('body,html').off('bind','input',function(){
				reloadtime = 10000;
				
			});
        						
			iduser          = '<?php echo $techId; ?>'; //$("#writeupmodal-filter #techId").val();
			METODO			= 'dashboard_ini'
			URL 			= "common/ws_wp.php";
			DATA            = null;
			VALOR           = '';
			if (iduser == ''){
				window.location="/BrandellDiesel/index_tech.php";
			}

			<?php if ($profile=='TECH'):?>
					VALOR           = iduser;
			<?php endif; ?>

			call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

				DATA = data;
				writeupdashboard_data = data;

                $('#table-writeups').bootstrapTable({

					data: writeupdashboard_data,
                    striped: true,
                    columns: 
                    [
                        [
                            {
                                field: 'writeupdate',
                                title: 'Date',
                                rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                width: 1,
								formatter : function(value) 
                                {
                                    if(!value)
                                    {
										return value;
                                    }
                                    else
                                    {
                                        var localDate = moment(value).local();
										var deadlineDate = moment(value).format("MMM DD YYYY");
										return deadlineDate;
                                    }
                                }
                            }, 
                            {
                                field: 'writeupemployee',
                                title: 'Employee',
                                rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                width: 1
                            },
                            {
                                field: 'department',
                                title: 'Department',
                                rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                width: 1
                            }, 
                            {
                                field: 'writeupviolationtype',
                                title: 'Type of violation',
                                rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                width: 1
                            }, 
							{
                                field: 'writeupwarnings',
                                title: 'Warnings',
                                rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                width: 1,
								formatter : function(value, row) 
                                {
                                    var vWarning = value;
									if (vWarning == "3") { 
										vWarning  = '<div style="color:red;">! '+ value + '</div>'; 											
									} 
                                    return vWarning; 											
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
                                    field: 'view',
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
    										if (row.status === "C") { 
    											vEdit = '<a class=""><span class="fa fa-pencil" aria-hidden="true" style="color: #999999;"></span></a>'; 											
    										} 
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

                                            if (row.status === "A") {
    										var vDelete = '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
                                            }else{
    										var vDelete = '<a class=""><span class="fa fa-trash" aria-hidden="true" style="color: #999999;"></span></a>'; 
                                            }											
    										
                                            return vDelete;   
                                        }
                                    }
        				        <?php endif; ?>

                            <?php endif; ?>

                        ]
                    ],
                    onPageChange: function (number, size){
                        $('.blink').blink();
                    },
                    onClickCell: function (field, value, row){

                        if(field === "view"){ 
							printpdf_writeup(value);							
                        }else if(field === "edit" && row.status != "C"){ 

                            DATA    = null;

                            $('#modal-editwriteup').modal('show');
                            ROW = row;
                            $("#modal-editwriteup #editidRequest").val(row.view);
                            idrequest = row.view;
                            
                            URL             = "common/writeUpsGet.php";
                            METODO          = "";
                            VALOR           = idrequest;
                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                                DATA    = data.WRITEUP;

                                $(".messageCheckbox").removeAttr('checked');						
								$("#modal-editwriteup #editwriteupemployee").val(DATA.writeupemployee);
								$("#modal-editwriteup #editwriteupdate").val(DATA.writeupdate);

                                if($("#modal-editwriteup #editwriteupemployee").val()!==null && $("#modal-editwriteup #editwriteupemployee").val()!==undefined && $("#modal-editwriteup #editwriteupemployee").val().length>0){
                                    $("#modal-editwriteup #editwriteupemployee").attr('disabled', 'disabled');
                                }else{
                                    $("#modal-editwriteup #editwriteupemployee").removeAttr("disabled");
                                }
								$("#modal-editwriteup #editwriteupsupervisor").val(DATA.writeupsupervisor);						
								$("#modal-editwriteup #editwriteuptradelevel").val(DATA.writeuptradelevel);
								$("#modal-editwriteup #editwriteuplastwarn").val(DATA.writeuplastwarn);
								$("#modal-editwriteup #editwriteuppreviouswarn").val(DATA.writeuppreviouswarn);
								$("#modal-editwriteup #editwriteupwpstatement").val(DATA.writeupwpstatement);		
								$("#modal-editwriteup #editdepartment").val(DATA.writeupdepartment);
								$("#modal-editwriteup #editsenioritydate").val(DATA.writeupsenioritydate);	
								RadionButtonSelectedValueSet("writeupwarnings",DATA.writeupwarnings);
								RadionButtonSelectedValueSet("disaction",DATA.writeupdisaction);						
								$("#modal-editwriteup .txtothers").attr("style", "display: none"); 
								$('#modal-editwriteup input[name="writeid"]').val(DATA.writeupidwriteup);
								var auxdata=DATA.writeupviolationtype.split(',');

								for (var i = 0; i < auxdata.length; i++) {
									$('#modal-editwriteup #selectViolationType [value="'+auxdata[i]+'"]').prop("checked", true);
                                    if(auxdata[i].indexOf('Others:')!=-1){
                                        $('#modal-editwriteup #selectViolationType [value="Others"]').prop("checked", true);
                                        $("#modal-editwriteup .txtothers").val(auxdata[i].replace(/Others:/g,""));
                                        $("#modal-editwriteup .txtothers").attr("style", "display: initial");
                                    }
								}
								
								rederizsoftHideLoad( '#modal-editwriteup', '#cargar_data_writeup' );


                            });  
                        }else if(field === "delete" && row.status != "C"){ 

                            $('#writeupmodal-delete .comfirmtext span').text(row.writeupemployee);

                            $('#deletewriteup').attr('data-record',row.view);
                            $('#deletewriteup').attr('data-user',iduser);    

                            $('#writeupmodal-delete').modal('show');
                        }
                    }
                });				
            });

        /* ******************** DASHBOARD WRITE UP ENDS *********************************** */
            
		var DATE = new Date();
		var options = {
			weekday: "long", year: "numeric", month: "short",
			day: "numeric", hour: "2-digit", minute: "2-digit"
		};
		$("#date").text(DATE.toLocaleTimeString("en-us", options));
		
		ion.sound({

            sounds: 
            [
                {
                    name: "beep",
                    loop: 30
                }
            ],
            path: "sounds/",
            preload: true,
            volume: 1.0
        });

		playRadio = function() {
			ion.sound.play("beep");
			ion.sound.playing = true;
			audio = 0;
		}

		stopRadio = function() {
			ion.sound.stop("beep");
			ion.sound.playing = false;
			audio = 1;
		}
		
		$(".fa-volume-up").click(function () {
			if (audio === 0) {
				stopRadio();
			} else {
				playRadio();
			}
		});
		
            
			
			$(function (){

                $('#datetimepickerStartDate').datetimepicker(
                {
                    format: 'YYYY-MM-DD'
                });
                $('#datetimepickerEndDate').datetimepicker(
                {
                    useCurrent: false,
                    format: 'YYYY-MM-DD'
                });
                $('#datetimepickerWriteUpDate').datetimepicker(
                {
                    format: 'YYYY-MM-DD'
                });					
                $('#datetimepickerLastWarnDate').datetimepicker(
                {
                    format: 'YYYY-MM-DD'
                });  
                $('#datetimepickerPreviousWarnDate').datetimepicker(
                {
                    format: 'YYYY-MM-DD'
                });  		
                $('#datetimepickerSeniorityDate').datetimepicker(
                {
                    format: 'YYYY-MM-DD'
                }); 					
                $("#datetimepickerStartDate").on("dp.change", function (e) 
                {
                    $('#datetimepickerEndDate').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepickerEndDate").on("dp.change", function (e) 
                {
                    $('#datetimepickerStartDate').data("DateTimePicker").maxDate(e.date);
                });

                $('#editdatetimepickerStartDate').datetimepicker(
                {
                    format: 'YYYY-MM-DD'
                });
                $('#editdatetimepickerEndDate').datetimepicker(
                {
                    useCurrent: false,
                    format: 'YYYY-MM-DD'
                });
                $('#editdatetimepickerWriteUpDate').datetimepicker(
                {
                    format: 'YYYY-MM-DD'
                });					
                $('#editdatetimepickerLastWarnDate').datetimepicker(
                {
                    format: 'YYYY-MM-DD'
                });  
                $('#editdatetimepickerPreviousWarnDate').datetimepicker(
                {
                    format: 'YYYY-MM-DD'
                });  		
                $('#editdatetimepickerSeniorityDate').datetimepicker(
                {
                    format: 'YYYY-MM-DD'
                }); 					
                $("#editdatetimepickerStartDate").on("dp.change", function (e) 
                {
                    $('#editdatetimepickerEndDate').data("DateTimePicker").minDate(e.date);
                });
                $("#editdatetimepickerEndDate").on("dp.change", function (e) 
                {
                    $('#editdatetimepickerStartDate').data("DateTimePicker").maxDate(e.date);
                });

            });						

		
	
			// Group or user send message option
			$('body, html').on('change','.messageCheckbox',function(){


                if ($(this).val() == "Others") {

                    if ($(this).prop('checked')) {
                        $(".txtothers").attr("style", "display: initial");
                    }else{
                        $(".txtothers").attr("style", "display: none"); 
                    } 
                                          
                } 
 
			});	

			//*********************** WRITE UPS OPEN MODAL****************************************
            $( "#linkTomyModalWriteUp" ).click(function(){
				if ( $(".modal-body #techid").val("")  === null || $(".modal-body #techid").val("") === "") {
					window.location.replace("http://reqwriteupparts.bdicalgary.com/BrandellDiesel/index.php");
				}

					$(".messageCheckbox").removeAttr('checked');						
					$("#myModalWriteUp #writeupemployee").val("");
					$("#myModalWriteUp #writeupdate").val("");
					$("#myModalWriteUp #writeupsupervisor").val("");						
					$("#myModalWriteUp #writeuptradelevel").val("");
					$("#myModalWriteUp #writeuplastwarn").val("");
					$("#myModalWriteUp #writeuppreviouswarn").val("");
					$("#myModalWriteUp #writeupwpstatement").val("");		
					$("#myModalWriteUp #department").val("");
					$("#myModalWriteUp #senioritydate").val("");	
					RadionButtonSelectedValueSet("writeupwarnings","1");
					RadionButtonSelectedValueSet("disaction","Y");
					$("#myModalWriteUp .txtothers").val(""); 							
					$("#myModalWriteUp .txtothers").attr("style", "display: none"); 						
					
					$('#myModalWriteUp').modal('show');
					rederizsoftHideLoad( '#myModalWriteUp', '#cargar_data_writeup' );
			});

			//*********************** WRITE UPS INSERT ****************************************
			$(".buttonSaveWriteUp").click(function(){

				recordtype=$(this).data('typerecord');

				switch(recordtype){
					case 'update':
			        	URL             = "common/updateWriteUp.php";
			        	METODO          = "writeup_update";
			        	var completestr='edit';
			        	var writeid= '|'+$('#modal-editwriteup input[name="writeid"]').val();
			        	showmodal='#modal-editwriteup';
			        break;
			        case 'saveclose':
			        	URL             = "common/updateWriteUp.php";
			        	METODO          = "writeup_saveclose";
			        	var completestr='edit';
			        	var writeid= '|'+$('#modal-editwriteup input[name="writeid"]').val();
			       		showmodal='#modal-editwriteup';
			        break;
			        default:
			        	URL             = "common/createWriteUp.php";
			        	METODO          = "writeup_insert";
			        	var completestr='';
			        	var writeid= '';
			        	showmodal='#myModalWriteUp';

				}

				writeupappuser        	= '<?php echo $techId; ?>';
				writeupemployee       	= $(showmodal+" #"+completestr+"writeupemployee").val();
				writeupdate		= $(showmodal+" #"+completestr+"writeupdate").val();
				writeupsupervisor      = $(showmodal+" #"+completestr+"writeupsupervisor").val();						
				writeuptradelevel      = $(showmodal+" #"+completestr+"writeuptradelevel").val();
				writeuplastwarn		= $(showmodal+" #"+completestr+"writeuplastwarn").val();
				writeuppreviouswarn	= $(showmodal+" #"+completestr+"writeuppreviouswarn").val();
				writeupwpstatement		= $(showmodal+" #"+completestr+"writeupwpstatement").val();
				department		= $(showmodal+" #"+completestr+"department").val();
				senioritydate	= $(showmodal+" #"+completestr+"senioritydate").val();

				var $radiotype = $(showmodal+' input:radio[name="disaction"]:checked');	
				disaction = $radiotype.val();						
				var $radiotype = $(showmodal+' input:radio[name="writeupwarnings"]:checked');	
				writeupwarnings = $radiotype.val();	

				var checkbox = document.querySelector('.messageCheckbox');
				var writeupviolationtype = "";
                var txtothers=$(showmodal+" .txtothers").val();

				$('.messageCheckbox:checked').each(function() {
				   writeupviolationtype = writeupviolationtype + $(this).val() + ",";
				});
				if (txtothers != undefined || txtothers != "") {
					writeupviolationtype = writeupviolationtype.replace("Others", 'Others:'+$(showmodal+" .txtothers").val());
				}
				
				// Required fields validations                   
				if (writeupemployee=='' || writeupdate=='' || writeupsupervisor=='' || writeupviolationtype==''){ 
					alert('Please complete the mandatory fields to continue...!\nAll fields marked with * are required.'); 
				}else{ 					
					if (checkDate(writeupdate) && checkDate(senioritydate) && checkDate(writeuplastwarn) && checkDate(writeuppreviouswarn)) {
																	
						DATA = null;

						VALOR  = writeupdate + "|" + writeupemployee + "|" + department + "|" + writeupsupervisor + "|" + senioritydate + "|" + writeuptradelevel + "|" + disaction + "|" + writeupviolationtype + "|" + writeuplastwarn + "|" + writeuppreviouswarn + "|" + writeupwarnings + "|" + writeupwpstatement + "|" + writeupappuser+writeid;

						call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
							DATAW = data;
							VALOR  = VALOR  + "|print" + "|" + DATAW;
							DATA = null;
							URL             = "common/writeup_pdf.php";									

							call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

									writeupidwriteup   = DATAW;
									VALOR   	= '';
									METODO		= 'dashboard_ini'
									reloadDashboardWriteUp(VALOR, METODO, 'common/ws_wp.php');
									printpdf_writeup(writeupidwriteup);									
									$(showmodal+'').modal('hide');
									$('.nav.nav-tabs a[href=#tabwriteups]').tab('show');
								
							});	
						});  
					}
				}

			});


            $('#deletewriteup').on('click',function(event){
                event.preventDefault();

                VALOR  = $(this).attr('data-record') + "|" + $(this).attr('data-user');
                URL    = "common/deleteWriteUp.php";
                METODO = "writeup_delete";                                 

                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

                    VALOR       = '';
                    METODO      = 'dashboard_ini';
                    $('#writeupmodal-delete').modal('hide');

                    reloadDashboardWriteUp(VALOR, METODO, 'common/ws_wp.php');                                 
                    $('.nav.nav-tabs a[href=#tabwriteups]').tab('show');
                    
                });

            });

						
        	// ************************* WRITE UP INSERT END *********************************         
        
            $("#buttonDeletePartsRequesition").click(function(){
                writeupappuser         = $(".modal-body #writeupidwriteup").val();
                URL             = "common/deleteParts.php";
                DATA            = null;
                METODO          = "request_delete";
                VALOR           = idrequest + "|" + writeupappuser;
                
                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    $('#modal-delete').modal('hide');
					//**************FILTER DASHBOARD*******************
					if (filter === 0) {
						writeupappuser		= $(".modal-body #writeupnew-techId").val();
						VALOR   	= '';
						<?php if ($profile=='TECH'): ?>
							VALOR 	= writeupappuser;
						<?php endif; ?>
						reloadDashboard(VALOR, 'common/ws.php');
					} else {
						iduser		= $("#writeupmodal-filter #techId").val();
						writeupstartdate	= $("#writeupmodal-filter #writeupstartdate").val();
						writeupenddate		= $("#writeupmodal-filter #writeupenddate").val();
						jobnumber	= $("#writeupmodal-filter #jobnumber").val();
						keyword		= $("#writeupmodal-filter #keyword").val();
						URL			= "common/dashboard_search.php";
						DATA		= null;
						VALOR		= iduser + "|" + writeupstartdate + "|" + writeupenddate + "|" + jobnumber + "|" + keyword;
						reloadDashboard(VALOR, 'common/dashboard_search.php');
					}
					
					URL     = "common/dashboard_totals.php";
			        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

						COLORS = data;
						$.each(COLORS, function(index){                        
							if (COLORS[index].colorflag === "Y"){
								$("#writeupyellow").text(" " + COLORS[index].quantity);
							}else if (COLORS[index].colorflag === "R"){
								$("#red").text(" " + COLORS[index].quantity);
							}else if (COLORS[index].colorflag === "G"){
								$("#writeupgreen").text(" " + COLORS[index].quantity);
							}
						});
					});

                }); 
            }); 


			$("#writeupfilter").click(function(){
                $('#writeupmodal-filter').modal('show');
            });                
				
			$("#custom-toolbarwriteups #buttonApplyFilterwriteups").click(function(){
				VALOR   		= '';
				<?php 
				if ($profile=='TECH') {
				?>
					VALOR 		= '<?php echo $techId; ?>';
				<?php
				}
				?>
                iduser          = VALOR;
                writeupstartdate       = '';
                writeupenddate         = '';
                jobnumber       = '';
				keyword       	= '';
				URL             = "common/ws_wp.php";
                DATA            = null;
				VALOR           = iduser;
                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                {
                    filter = 0;	
                    writeupdashboard_data = data;
                    $('#table-writeups').bootstrapTable('load', writeupdashboard_data);
                    $('#modal-filter').modal('hide');
                    $('.blink').blink();
                });	
				$("#modal-filter #techId").val('<?php echo $techName ?>');
                $("#modal-filter #startdate").val('');
                $("#modal-filter #enddate").val('');
                $("#modal-filter #jobnumber").val('');
				$("#modal-filter #keyword").val('');					
            });
                
               
            $("#modal-adminUsers #buttonCancelEdit").click(function(){

                    $("#modal-adminUsers #buttonAddUser").css("display", "block");
                    $("#modal-adminUsers #buttonEditUser").css("display", "none");
                    $("#modal-adminUsers #buttonCancelEdit").css("display", "none");
					$("#modal-adminUsers #idUser").attr('disabled',false);
                    
                    $("#modal-adminUsers #idUser").val("");
                    $("#modal-adminUsers #surName").val("");
                    $("#modal-adminUsers #lastName").val("");
                    $("#modal-adminUsers #password").val("");
                    $("#modal-adminUsers #idUserType").val("");
                    //$("#modal-adminUsers #adminu-techId").val("");
                    $("#modal-adminUsers #idRol").val("");
					$("#modal-adminUsers #phonenum").val("");
					$("#modal-adminUsers #idGroup").val("");
            });
            
		});
		
		function reloadDashboardWriteUp(paramVALOR, paramMETODO, paramUrl) {
			URL 	= paramUrl;
			DATA 	= null;
			VALOR 	= paramVALOR;
			METODO	= paramMETODO; 
			iduser =  '<?php echo $techId; ?>';

			if ( iduser  === null||iduser === "") {
				//console.log('Your session expire');
				window.location.replace("http://reqwriteupparts.bdicalgary.com/BrandellDiesel/index.php");
			}
			else
			{ 
				call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
				{
				writeupdashboard_data = data;
				console.log(writeupdashboard_data);
				$('#table-writeups').bootstrapTable('load', writeupdashboard_data);
				});
			}
		}
		
		function sleep(milliseconds) {
		  var start = new Date().getTime();
		  for (var i = 0; i < 1e7; i++) {
			if ((new Date().getTime() - start) > milliseconds){
			  break;
			}
		  }
		}

		function sendPDF (){

                techName       	= $("#modal-view #view-techname").text();
				idrequest       = $("#modal-view #idRequest").val();
                jobnumber       = $("#modal-view #view-ro").text();
                writeupappuser         = $("#modal-view #techId").val();
				//console.log('idreuqest: '+idrequest)
               
				if($("#modal-view #requestType").is(':checked')){
                    idrequesttype   = "Q";
					vType = "Quote";
                } else {
                    idrequesttype   = "O";
					vType = "Order";
                }
                
                if($("#modal-view #priority").is(':checked')){
                    idpriority   = "H";
					vPriority = "911";
                } else {
                    idpriority   = "N";
					vPriority = "Normal";
                }
                
                ro              = $("#modal-view #view-ro").text();
                vin             = $("#modal-view #view-vin").text();
                trans           = $("#modal-view #view-trans").text();
                engine          = $("#modal-view #view-engine").text();
                comments        = $("#modal-view #view-comments").text();
				requestdate 	= moment($("#modal-view #date-view").text()).format("MMM DD YYYY hh:mm:ss a");
                
                DATA            = null;
                
                URL             = "common/editParts.php";
                writeuppartsJSON   = JSON.stringify(writeupparts);
				//console.log(writeuppartsJSON);
				//console.log('VALORES: RO '+ ro + ' VIN ' + vin + ' ENGINE '+ engine + ' RO ' + idrequest + ' techname ' + techName + ' Priority '+ vPriority+ ' Type ' + vType+ ' Comments ' + comments );
				
				rederizsoftReady('A','#writeuppartsRequesition', 'common/sendMail.php?vRo='+encodeURIComponent(ro)+'&vtechName='+encodeURIComponent(techName)+'&vPriority='+encodeURIComponent(vPriority)+'&vType='+encodeURIComponent(vType)+'&vVin='+encodeURIComponent(vin)+'&vComments='+encodeURIComponent(comments)+'&vwriteuppartsJSON='+encodeURIComponent(writeuppartsJSON)+'&vDate='+encodeURIComponent(requestdate)+'&vEngine='+encodeURIComponent(engine)+'&vID='+encodeURIComponent(idrequest)+'&vStatus=', '#cargar_data_edit', 'consultar');
                /*METODO          = writeuppartsJSON;
                VALOR           = idrequest + "|" + jobnumber + "|" + writeupappuser + "|" + idrequesttype + "|" + idpriority + "|" + ro + "|" + vin + "|" + trans + "|" + engine + "|" + comments;
                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data) 
                {
                    DATA = data;*/
                    //console.log(writeupparts);
                    $('#modal-view').modal('hide');
					//**************FILTER DASHBOARD*******************
					if (filter === 0) {
						writeupappuser		= $(".modal-body #writeupnew-techId").val();
						VALOR   	= '';
						<?php 
						if ($profile=='TECH') {
						?>
							VALOR 	= writeupappuser;
						<?php
						}
						?>
						reloadDashboard(VALOR, 'common/ws.php');
					} else {
						iduser		= $("#writeupmodal-filter #techId").val();
						writeupstartdate	= $("#writeupmodal-filter #writeupstartdate").val();
						writeupenddate		= $("#writeupmodal-filter #writeupenddate").val();
						jobnumber	= $("#writeupmodal-filter #jobnumber").val();
						keyword		= $("#writeupmodal-filter #keyword").val();
						URL		= "common/dashboard_search.php";
						DATA		= null;
						VALOR		= iduser + "|" + writeupstartdate + "|" + writeupenddate + "|" + jobnumber + "|" + keyword;
						reloadDashboard(VALOR, 'common/dashboard_search.php');
					}
					//alert('Your PDF has been sent');
                //});   
        }
		
		function dashboardCSV(){

            iduser          = $("#writeupmodal-filter #techId").val();
            writeupstartdate       = $("#writeupmodal-filter #writeupstartdate").val();
            writeupenddate         = $("#writeupmodal-filter #writeupenddate").val();
            jobnumber       = $("#writeupmodal-filter #jobnumber").val();
			keyword       	= $("#writeupmodal-filter #keyword").val();
            URL             = "common/dashboard_excel.php";
            DATA            = null;
            VALOR           = iduser + "|" + writeupstartdate + "|" + writeupenddate + "|" + jobnumber + "|" + keyword;
            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                filter = 1;
                writeupdashboard_data = data;				
				downloadCSV({ data: writeupdashboard_data, filename: "dashboard.csv" });	

				//**************FILTER DASHBOARD******************* ISKAR
				if (filter === 0) {
					writeupappuser		= $(".modal-body #writeupnew-techId").val();
					VALOR   	= '';
					<?php 
					if ($profile=='TECH') {
					?>
						VALOR 	= writeupappuser;
					<?php
					}
					?>
					reloadDashboard(VALOR, 'common/ws.php');
				} else {
					iduser		= $("#writeupmodal-filter #techId").val();
					writeupstartdate	= $("#writeupmodal-filter #writeupstartdate").val();
					writeupenddate		= $("#writeupmodal-filter #writeupenddate").val();
					jobnumber	= $("#writeupmodal-filter #jobnumber").val();
					keyword		= $("#writeupmodal-filter #keyword").val();
					URL		= "common/dashboard_search.php";
					DATA		= null;
					VALOR		= iduser + "|" + writeupstartdate + "|" + writeupenddate + "|" + jobnumber + "|" + keyword;
					reloadDashboard(VALOR, 'common/dashboard_search.php');
				}
		
				
            }); 				
        }

		function dashboardPDF (action){

            iduser          = $("#writeupmodal-filter #techId").val();
            writeupstartdate       = $("#writeupmodal-filter #writeupstartdate").val();
            writeupenddate         = $("#writeupmodal-filter #writeupenddate").val();
            jobnumber       = $("#writeupmodal-filter #jobnumber").val();
			keyword       	= $("#writeupmodal-filter #keyword").val();
			loguser			= "<?php echo $techId; ?>";				
            URL             = "common/dashboard_pdf.php";
            DATA            = null;
            VALOR           = iduser + "|" + writeupstartdate + "|" + writeupenddate + "|" + jobnumber + "|" + keyword + "|" + loguser + "|" + action;
			VALOR			= encodeURIComponent(VALOR);
			
			if (action == 'view')
				{				
					window.open (URL+"?v=" + VALOR );
					//**************FILTER DASHBOARD******************* ISKAR
				if (filter === 0) {
					writeupappuser		= $(".modal-body #writeupnew-techId").val();
					VALOR   	= '';
					<?php 
					if ($profile=='TECH') {
					?>
						VALOR 	= writeupappuser;
					<?php
					}
					?>
					reloadDashboard(VALOR, 'common/ws.php');
				} else {
					iduser		= $("#writeupmodal-filter #techId").val();
					writeupstartdate	= $("#writeupmodal-filter #writeupstartdate").val();
					writeupenddate		= $("#writeupmodal-filter #writeupenddate").val();
					jobnumber	= $("#writeupmodal-filter #jobnumber").val();
					keyword		= $("#writeupmodal-filter #keyword").val();
					URL		= "common/dashboard_search.php";
					DATA		= null;
					VALOR		= iduser + "|" + writeupstartdate + "|" + writeupenddate + "|" + jobnumber + "|" + keyword;
					reloadDashboard(VALOR, 'common/dashboard_search.php');
				}

			}else{ 
				call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){   	
					printJS('PDF/dashboard_'+ loguser +'.pdf');
				}); 										
			}

			//**************FILTER DASHBOARD******************* ISKAR
			if (filter === 0) {
				writeupappuser		= $(".modal-body #writeupnew-techId").val();
				VALOR   	= '';
				<?php 
				if ($profile=='TECH') {
				?>
					VALOR 	= writeupappuser;
				<?php
				}
				?>
				reloadDashboard(VALOR, 'common/ws.php');
			} else {
				iduser		= $("#writeupmodal-filter #techId").val();
				writeupstartdate	= $("#writeupmodal-filter #writeupstartdate").val();
				writeupenddate		= $("#writeupmodal-filter #writeupenddate").val();
				jobnumber	= $("#writeupmodal-filter #jobnumber").val();
				keyword		= $("#writeupmodal-filter #keyword").val();
				URL		= "common/dashboard_search.php";
				DATA		= null;
				VALOR		= iduser + "|" + writeupstartdate + "|" + writeupenddate + "|" + jobnumber + "|" + keyword;
				reloadDashboard(VALOR, 'common/dashboard_search.php');
			}					
		}
			
		function clearObj(vObj,vEntity) {    
			// Clean up object section for future use
			if (vObj != null && vObj != '') { 
				//alert($( "input.form-control" ).val());
				//$( "input.class" ).val('');	
			} else {
				//alert('');
			}
			return true;
		}
			
		function Onlynumbers(e){

			var tecla=new Number();
			if(window.event) {
				tecla = e.keyCode;
			}
			else if(e.which) {
				tecla = e.which;
			}
			else {
				return true;
			}
			if((tecla >= "67") && (tecla <= "622")){
				return false;
			}
		}

		function printpdf(){

			idrequest       = $("#modal-view #idRequest").val();
            jobnumber       = $("#modal-view #view-ro").text();
			//alert('PDF/request_'+ jobnumber +'_'+ idrequest +'.pdf');
			printJS('PDF/request_'+ jobnumber +'_'+ idrequest +'.pdf');
		}			
	
		// Print Write Up PDF
		function printpdf_writeup(inid){
			idrequest       = $("#modal-view #idRequest").val();
			printJS('PDF/writeup_'+ inid +'.pdf');
		}		
	

		// Return an array of the selected option values
		// select is an HTML select element
		function getSelectValues(select) {
		  var result = [];
		  var options = select && select.options;
		  var opt;

		  for (var i=0, iLen=options.length; i<iLen; i++) {
			opt = options[i];

			if (opt.selected) {
			  result.push(opt.value || opt.text);
			}
		  }
		  return result;
		}

		/* EXPORT CSV */
		
		function convertArrayOfObjectsToCSV(args) {
			var result, ctr, keys, columnDelimiter, lineDelimiter, data;

			data = args.data || null;
			if (data == null || !data.length) {
				return null;
			}

			columnDelimiter = args.columnDelimiter || ';';
			lineDelimiter = args.lineDelimiter || '\n';

			keys = Object.keys(data[0]);

			result = '';
			result += keys.join(columnDelimiter);
			result += lineDelimiter;

			data.forEach(function(item) {
				ctr = 0;
				keys.forEach(function(key) {
					if (ctr > 0) result += columnDelimiter;

					result += item[key];
					ctr++;
				});
				result += lineDelimiter;
			});

			return result;
		}

		function downloadCSV(args){

			var data, filename, link;
			var csv = convertArrayOfObjectsToCSV({
				data: args.data
			});
			if (csv == null) return;

			filename = args.filename || 'export.csv';

			if (!csv.match(/^data:text\/csv/i)) {
				csv = 'data:text/csv;charset=utf-8,' + csv;
			}
			data = encodeURI(csv);

			link = document.createElement('a');
			link.setAttribute('href', data);
			link.setAttribute('download', filename);
			link.click();
		}		
		
		
		function checkDate(indate){

			if (indate !== undefined && indate !== '') {	
				//Validate format
				var date1 = new Date(indate);
				//Date exists?
				if (isNaN(date1)){
			
					alert("Incorrect date value, please check.");
					return false;
			
				}else{return true;}
			
			}else{ return true; }//if date is empty returns true too	
		}
			
		
		function difDates(f1,f2, maxtop){

			if (f1 == '' || f2==''){
				return true;
			}
			else{
				var adate1 = f1.split('/'); 
				var adate2 = f2.split('/'); 
				var fdate1 = new Date(adate1); 
				var fdate2 = new Date(adate2); 
				var dif = fdate2 - fdate1;
				var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
				if (dias <= maxtop){
				 	return true;
				}else{
					alert('The range of dates must be less than ' + maxtop + ' days');
					return false;
				}
			}				 
			
		}		
				
	
		function RadionButtonSelectedValueSet(name, SelectdValue) {
			$('input[name="' + name+ '"][value="' + SelectdValue + '"]').prop('checked', true);
		}
		
    </script>