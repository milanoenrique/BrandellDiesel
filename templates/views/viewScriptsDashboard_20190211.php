	<script>
        var require_date=[];
        var index_date=-1;
        var date_of_delivery = {};
        var aux_colorflag;
        var phonenumbergroup;
        var newPart_edit = [];
        var id = null;
        var parts_status_value = null ;
        var index_part          = -1;
        var idrequest           = null;
        var jobnumber           = null;
        var appuser             = null;
		var idspecialist        = null;
        var idrequesttype       = null;
        var idpriority          = null;
        var vidrequesttype      = null;
        var vidpriority         = null;
        var techName            = null;
        var techId              = null;
        var ro                  = null;
        var vin                 = null;
        var trans               = null;
        var engine              = null;
        var comments            = null;
		var iduser              = null;
        var startdate           = null;
        var enddate             = null;
        var vrequestdate        = null;
        var uniquepart2         = null;

        var parts               = [];
        var deletedParts        = [];
        var editedParts         = [];
        var newParts            = [];
        var ordParts            = [];

        var part                = [];
        var deletedPart         = [];
        var editedPart          = [];
        var newPart             = [];

        var JSONparts           = [];
        var JSONdeletedParts    = [];
        var JSONeditedtedParts  = [];
        var JSONnewParts        = [];

        var green               = null;
        var yellow              = null;
        var red                 = null;
        var orange              = null;

		var dashboard_data      = null;
        var filter              = 0;
		var audio               = 0;

        var ROW             	= null;
        var interval1           = null;
        var interval2           = null;
        var interval3           = null;

        $(document).ready(function(){



            $('.modal').on('shown.bs.modal',function(){
                clearRegularIntervals();
            });

            $('.modal').on('hide.bs.modal',function(){
                startRegularIntervals();
            });


    		iduser          = '<?php echo $techId; ?>'; //$("#modal-filter #techId").val();
            URL 			= "common/ws.php";
    		DATA            = null;
    		VALOR           = '';
    		if (iduser == ''){
                console.log('WARNING! Empty user');
    			window.location="/BrandellDiesel/index_tech.php";
            }

    		<?php if ($profile == 'TECH'): ?>
    				VALOR           = iduser;
    		<?php endif;?>

    		call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

    		    DATA = data;
    		    dashboard_data = data;

                $('#table-dashboard').bootstrapTable({
                    //data: DATA,
    				data: dashboard_data,
                    striped: true,
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
                                width: 1,
    							formatter : function(value)
                                {
                                    if(!value){return value;}
                                    else{

                                        var localDate = moment(value).local();
    									var deadlineDate = moment(value).format("MMM DD YYYY, hh:mm:ss a");
    									return deadlineDate;
                                    }
                                }
                            },
    						{
                                field: 'idrequesttype',
                                title: 'Type',
                                rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                width: 1,
    							formatter : function(value, row)
                                {
                                    var vPriority = value;
    								if (row.idpriority === "H") {
    									vPriority  = '<div style="color:red;">! '+ value + '</div>';
    								}
                                    return vPriority;
                                }
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
                                    if(!value){return "Unassigned";}
                                    else{return value;}
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
                                    if (value === "Y"){

                                        return '<a class="blink"><span class="fa fa-circle" aria-hidden="true" style="color:yellow;"></span></a>';

                                    }else if (value === "R"){

                                        return '<a class="blink"><span class="fa fa-circle" aria-hidden="true" style="color:red;"></span></a>';

                                    }else if (value === "G"){

                                        return '<a class=""><span class="fa fa-circle" aria-hidden="true" style="color:green;"></span></a>';

                                    }
                                    if(value==='O'){
                                        return '<a class="blink"><span class="fa fa-circle" aria-hidden="true" style="color:#ea8108;"></span></a>';
                                    }
                                    if(value==='RI'){
                                        return '<a class="blink"><span class="fa fa-circle" aria-hidden="true" style="color:#820d0d;"></span></a>';
                                    }
                                }
                            }

                            <?php if ($profile != 'TV'): ?>
    							,
                                {
                                    title: 'Actions',
                                    colspan: <?php if ($profile == 'TECH') {echo '1';} else {echo '5';}?>,
                                    align: 'center'
                                }

                            <?php endif;?>
                        ],
                        [
                            <?php if ($profile != 'TV'): ?>
                                <?php if ($profile != 'TECH'): ?>
                                    {
                                        field: 'assign',
                                        title: '',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1,
                                        clickToSelect: false,
                                        formatter : function(value, row)
                                        {
                                            var vAssign = '<a class=""><span class="fa fa-user" aria-hidden="true"></span></a>';
    										if (row.status === "Closed") {
    											vAssign = '<a class=""><span class="fa fa-user" aria-hidden="true" style="color: #999999;"></span></a>';
    										}
                                            return vAssign;
                                        }
                                    },
                                <?php endif;?>
                                {
										field:'details',
										title:'',
										align: 'center',
										valign: 'middle',
										width: 1,
										clickToSelect: false,
										formatter:function(value,row){
											var vdetails = '<a class=""><span class="fa fa- fa-cog" aria-hidden="true"></span></a>';
    										 
                                            return vdetails; 
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
    									var arr = value.split('|');
                                        var comment = arr[1];
                                        return '<a class="eye" title="Comment: '+comment+'"><span class="fa fa-eye"></span></a></abbr>'
                                    },
                                    cellStyle : function(value, row, index, field)
                                    {
                                        var arr = value.split('|');
                                        var comment = arr[1];
                                        //alert('pruebas:'+comment);
                                        //if(comment.length != 0)
    									if(comment != null && comment != undefined && comment.length != 0)
                                        {
                                            return {
                                                classes: 'cell-corner'
                                            };
                                        }
                                        else
                                        {
                                            return {
                                                classes: ''
                                            };

                                        }
                                    }
                                }
                                <?php if ($profile != 'TECH'): ?>
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
    										if (row.status === "Closed") {
    											vEdit = '<a class=""><span class="fa fa-pencil" aria-hidden="true" style="color: #999999;"></span></a>';
    										}
                                            return vEdit;
                                        }
                                    },
                                    /*{
                                        field: 'close',
                                        title: '',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1,
                                        clickToSelect: false,
                                        formatter : function(value, row)
                                        {
    										var vClose = '<a class=""><span class="fa fa- fa-check-square" aria-hidden="true"></span></a>';
    										if (row.status === "Closed") {
    											vClose = '<a class=""><span class="fa fa- fa-check-square" aria-hidden="true" style="color: #999999;"></span></a>';
    										}
                                            return vClose;
                                        }
                                    },*/
                                    {
                                        field: 'delete',
                                        title: '',
                                        align: 'center',
                                        valign: 'middle',
                                        width: 1,
                                        clickToSelect: false,
                                        formatter : function(value, row)
                                        {
    										var vDelete = '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
    										if (row.status === "Closed") {
    											vDelete = '<a class=""><span class="fa fa-trash" aria-hidden="true" style="color: #999999;"></span></a>';
    										}
                                            return vDelete;
                                        }
                                    }
                                <?php endif;?>

                            <?php endif;?>
                        ]
                    ],
                    onPageChange: function (number, size){
                        $('.blink').blink();
                    },
                    onClickCell: function (field, value, row){

                        if (field === "assign" && row.status != "Closed"){

    						if ('<?php echo $profile; ?>'!=='TECH') { // ($profile!='PARTSP')  Validate user type manager or specialist

                                $("#specialist").empty();
    							idusertype      = '';
    							rol             = 'PARTSP';
    							status          = 'A';
    							phoneNum        = '%';

    							URL = "common/users_list.php";
    							VALOR = idusertype + "|" + rol + "|" + status + "|" + phoneNum;
    							call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

    								users = data;
    								$.each(users, function(index)
    								{
    									$("#specialist").append('<li><a href="" data-fullname="'+ users[index].fullname +'" data-iduser="'+ users[index].iduser +'" data-rol="'+ users[index].rol +'" data-rolname="'+ users[index].rolname +'"  >' + users[index].fullname + '</a></li>');
    								});
    							});
    							idrequest = row.idrequest;
    							jobnumber = row.jobnumber;
    							$('#modal-assign #idRequest').val(idrequest);
    							$('#modal-assign #jobnumber').val(row.jobnumber);
    							$('#modal-assign').modal('show');
    							$('#modal-assign #buttonAssignPartsRequesition').prop('disabled', true);

                            }else{

    							if (field === "assign" && row.status == "Open"){
    								alert('The request you are trying to take is assigned');
    							}else{
    								idrequest = row.idrequest;
    								jobnumber = row.jobnumber;
    								$('#modal-assignsp #idRequest').val(idrequest);
    								$('#modal-assignsp #jobnumber').val(jobnumber);
    								$('#modal-assignsp #title').text("Do you want to take request " + jobnumber +"?");
    								$('#modal-assignsp').modal('show');
    							}
    						}
                        }else 
                        if(field === "view"){ // VIEW PRINT HERE

                            //console.log('Modal view showing')
    						// Copy from edit

                            DATA    = null;
                            parts   = [];

                            $('#modal-view').modal('show');
    						rederizsoftHideLoad( '#partsRequesition', '#cargar_data_edit' );
                            ROW = row;
                            $("#modal-view #idRequest").val(row.idrequest);
                            idrequest = row.idrequest;
                            URL             = "common/lookupParts.php";
                            METODO          = "";
                            VALOR           = idrequest;
                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

                                DATA    = data;
                                parts   = DATA.PARTS;
    							vOType = DATA.REQUESTS[0].idrequesttype;

                                if(DATA.REQUESTS[0].idpriority === "H"){
    								vOType='9';
    							}

    							var $radios = $('#modal-view input:radio[name=requestType]');
    							$radios.filter('[value='+vOType+']').prop('checked', true);
    							$radios.prop('disabled',true);


    							$(".modal-body #date-view").text(moment(DATA.REQUESTS[0].requestdate).format("MMM DD YYYY, hh:mm:ss a"));
    							$(".modal-body #view-techname").text(DATA.REQUESTS[0].techname);
    							//console.log(DATA.REQUESTS[0].techname);

                                $("#modal-view #view-ro").text(DATA.REQUESTS[0].ro);
                                $("#modal-view #view-vin").text(DATA.REQUESTS[0].vin);
                                $("#modal-view #view-trans").text(DATA.REQUESTS[0].trans);
                                $("#modal-view #view-engine").text(DATA.REQUESTS[0].engine);
                                $("#modal-view #view-comments").text(DATA.REQUESTS[0].reqcomment);

                                $('#modal-view #table-parts').bootstrapTable('destroy');
                                console.log(parts);
                                $('#modal-view #table-parts').bootstrapTable({

                                    data: parts,
                                    striped: true,
                                    columns:
                                    [
                                        [
                                            {
                                                field: 'seg',
                                                title: '<font color="#009207">*</font> SEG:',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'part',
                                                title: '<font color="#009207">*</font> PART:',
                                                align: 'center',
                                                valign: 'middle',
    											visible: false,
                                                width: 1
                                            },
                                            {
                                                field: 'description',
                                                title: '<font color="#009207">*</font> DESCRIPTION:',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'quantity',
                                                title: '<font color="#009207">*</font> QTY:',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'status',
                                                title: 'STATUS OF PART',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field:'comment_parts',
                                                title: 'COMMENT OF PARTS',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1,
                                            },
                                            {
                                                field: 'date_of_delivery',
                                                title: 'DATE OF DELIVERY',
                                                align:'center',
                                                valign:'middle',
                                                width: 1,
                                            }
                                           
                                            

                                        ]
                                    ]
                                });

    							// End copy from edit

    							iduser 	= $(".modal-view #view-techname").text();//$("#techId").val();

    							//**************FILTER DASHBOARD*******************
    							if (filter === 0) {
    								appuser		= $(".modal-body #techId").val();
    								VALOR   	= '';
    								<?php if ($profile == 'TECH'): ?>
    									VALOR 	= appuser;
    								<?php endif;?>

    								reloadDashboard(VALOR, 'common/ws.php');
    							} else {
    								iduser		= $("#modal-filter #techId").val();
    								startdate	= $("#modal-filter #startdate").val();
    								enddate		= $("#modal-filter #enddate").val();
    								jobnumber	= $("#modal-filter #jobnumber").val();
    								keyword		= $("#modal-filter #keyword").val();
    								URL			= "common/dashboard_search.php";
    								DATA		= null;
    								VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
    								reloadDashboard(VALOR, 'common/dashboard_search.php');
    							}
                            });
                        }else if(field === "edit" && row.status != "Closed"){
                            aux_colorflag = row.colorflag;
                            DATA    = null;
                            parts   = [];
    						var vOType = "";

                            $('#modal-edit').modal('show');
    						rederizsoftHideLoad( '#partsRequesition', '#cargar_data_edit' );
                            ROW = row;
                            $("#modal-edit #idRequest").val(row.idrequest);
                            idrequest = row.idrequest;
                            URL             = "common/lookupParts.php";
                            METODO          = "";
                            VALOR           = idrequest;
                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                                DATA    = data;
                                parts   = DATA.PARTS;
    							vOType = DATA.REQUESTS[0].idrequesttype;

                                if(DATA.REQUESTS[0].idpriority === "H"){
    								vOType='9';
    							}

    							var $radios = $('#modal-edit input:radio[name=requestType]');
    							$radios.filter('[value='+vOType+']').prop('checked', true);

    							//$('#modal-edit input:radio[name="requestType"]').val(vOType);

    							/*if(DATA.REQUESTS[0].idrequesttype === "Q"){ // ISKAR

                                    $("#modal-edit #requestType").prop('checked', true);}
                                else {
                                    $("#modal-edit #requestType").prop('checked', false);}*/

    							$("#modal-edit #edit-techName").val(DATA.REQUESTS[0].techname);
                                $("#modal-edit #edit-ro").val(DATA.REQUESTS[0].ro);
                                $("#modal-edit #edit-vin").val(DATA.REQUESTS[0].vin);
                                $("#modal-edit #edit-trans").val(DATA.REQUESTS[0].trans);
                                $("#modal-edit #edit-engine").val(DATA.REQUESTS[0].engine);
                                $("#modal-edit #edit-comments").val(DATA.REQUESTS[0].reqcomment);

                                $('#modal-edit #table-parts').bootstrapTable('destroy');
                                index_part = -1
                                $('#modal-edit #table-parts').bootstrapTable({
                                    data: parts,
                                    striped: true,
                                    columns:
                                    [
                                        [
                                            {
                                                field: 'seg',
                                                title: '<font color="#009207">*</font> SEG:',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'part',
                                                title: '<font color="#009207">*</font> PART:',
                                                align: 'center',
                                                valign: 'middle',
    											visible: false,
                                                width: 1
                                            },
                                            {
                                                field: 'description',
                                                title: '<font color="#009207">*</font> DESCRIPTION:',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'quantity',
                                                title: '<font color="#009207">*</font> QTY:',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field:'comment_parts',
                                                title: 'COMMENT OF PARTS',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1,
                                            },
                                            {
                                                field: 'ord',
                                                title: 'STATUS:',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1,
                                                clickToSelect: false,
                                                formatter: function(value){
                                                    //console.log("select: "+JSON.stringify(parts));

                                                        index_part = index_part+1;

                                                        if(row.assignedto!=null){
                                                            if(typeof parts[index_part].ord != 'undefined'){


                                                            var text;

                                                            if(parts[index_part].ord=='ordered'){
                                                                text = '<select id='+parts[index_part].part+' class="status_part"><option selected="true" value="ordered">Ordered</option><option value="received">Received</option><option value="canceled">Canceled</option></select>';


                                                            }
                                                            if(parts[index_part].ord=='received'){
                                                                text = '<select id='+parts[index_part].part+' class="status_part"><option value="ordered">Ordered</option><option value="received" selected="true">Received</option><option " value="canceled">Canceled</option></select>';
                                                            }
                                                            if(parts[index_part].ord=='canceled'){



                                                                    text = '<select id='+parts[index_part].part+'class="status_part"><option value="ordered">Ordered</option><option value="received">Received</option><option value="canceled" selected="true">Canceled</option></select>'
                                                            }
                                                            if(parts[index_part].ord=='1'){
                                                                text = '<select id='+parts[index_part].part+' class="status_part"><option value="1">Select an option</option><option value="ordered">Ordered</option><option value="received">Received</option><option value="canceled">Canceled</option></select>'
                                                            }
                                                            return text;



                                                        }else{
                                                            return '<select id='+parts[index_part].part+' class="status_part"><option value="">Select an option</option><option value="ordered">Ordered</option><option value="received">Received</option><option value="canceled">Canceled</option></select>';

                                                        }

                                                        }





                                                    }


                                            },
                                            {
                                                field:'date_of_delivery',
                                                title: 'DATE OF DELIVERY',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1,
                                                formatter: function(value){
                                                    
                                                    
                                                    var text;
                                                    if(row.assignedto!=null){
                                                        if(value!=null){
                                                            text = "<div class='col-lg-10 input-group date'><input type='text' id=part-"+parts[index_part].part+" disabled class='form-control fixdate' placeholder='Date of delivery' value="+value+"> <span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></div>";        
                                                        }else{
                                                            text = "<div class='col-lg-10 input-group date'><input type='text' id=part-"+parts[index_part].part+" disabled class='form-control fixdate' placeholder='Date of delivery'> <span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></div>";

                                                        }
                                                    

                                                    return text;

                                                    }
                                                    

                                                }
                                            },
                                            {
                                                field: 'delete',
                                                title: '',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1,
                                                clickToSelect: false,
                                                formatter : function()
                                                {
                                                    return '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
                                                }
                                            }
                                        ]
                                    ],
                                    onClickCell: function (field, value)
                                    {
                                        if(field === "delete")
                                        {
                                            newParts = parts.filter(function(el)
                                            {
                                                deletedParts.push(value);
                                                return el.delete !== value;
                                            });
                                            index_part= -1;

                                            $('.modal-body #table-parts').bootstrapTable('load', newParts);

                                            parts = newParts;
                                            //console.log(JSON.stringify(newParts, null, ' '));
                                        }
                                        if(field==="ord"){
                                            var x;
                                            $('#modal-edit').on('click','select.status_part',function(e){
                                                id = $(this).attr('id');
                                                //part_status_value = $(this).attr('val');
                                                x= ordParts.indexOf(id);
                                                if(x==-1){
                                                    ordParts.push(id,$('#'+id+' option:selected').val());
                                                    console.log("nuevo elemento");
                                                    console.log(ordParts);
                                                }
                                                else{

                                                    console.log("ya existe");
                                                    ordParts[x+1]=$('#'+id+' option:selected').val();
                                                    console.log(ordParts);

                                                    }


                                            });
                                            $('#modal-edit').on('change','select.status_part', function(e){
                                                var add_class=false;
                                                var y;
                                                if($(this).val()=='ordered'){
                                                    add_class='true'
                                                    $('#part-'+$(this).attr('id')).prop('disabled',false);
                                                }else{
                                                    $('#part-'+$(this).attr('id')).prop('disabled','disabled');
                                                }

                                                if (add_class){
                                                    y= require_date.indexOf($(this).attr('id'));
                                                    if (y==-1){
                                                        require_date.push($(this).attr('id'));
                                                    }
                                                    
                                                }
                                              });
                                        }
                                        if(field==='date_of_delivery'){
                                            $("#modal-edit #table-parts").on('click','.fixdate', function (e){
                                                $(this).on("dp.change",function(e){
                                                        index_date++;
                                                            
                                                            /*date_of_delivery[index_date] = $(this).attr('id');
                                                            index_date++;
                                                            date_of_delivery[index_date] = $(this).val();
                                                            console.log(date_of_delivery)*/
                                                            date_of_delivery[$(this).attr('id')] = $(this).val();
                                                            console.log(date_of_delivery);
                                                            
                                                        
                                                        
                                                       
                                                });
                                            });
                                        }
                                        
                                    }
                                });

    							//**************FILTER DASHBOARD*******************
    							if (filter === 0) {
    								appuser		= $(".modal-body #techId").val();
    								VALOR   	= '';
    								<?php if ($profile == 'TECH'): ?>
    									VALOR 	= appuser;
    								<?php endif;?>

    								reloadDashboard(VALOR, 'common/ws.php');
    							} else {
    								iduser		= $("#modal-filter #techId").val();
    								startdate	= $("#modal-filter #startdate").val();
    								enddate		= $("#modal-filter #enddate").val();
    								jobnumber	= $("#modal-filter #jobnumber").val();
    								keyword		= $("#modal-filter #keyword").val();
    								URL			= "common/dashboard_search.php";
    								DATA		= null;
    								VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
    								reloadDashboard(VALOR, 'common/dashboard_search.php');
    							}
                            });
                        }else if(field === "delete" && row.status != "Closed"){
                            //$(".modal-body #titulo").text("Are you sure to delete the record # " + row.idrequest);
    						$("#modal-delete #titulo").text("Do you want to delete request " + row.jobnumber + "?");
                            idrequest = row.idrequest;
    						if (row.status.toLowerCase()!='closed') {
    							$('#modal-delete').modal('show');
    						} else {
    							alert('You are trying to delete an request that it is closed.');
    						}
                        }else if( field === "close" && ( row.status === "Open" || row.status === "Unassigned" ) ){
                            $("#modal-close #titulo").text("Do you want to close request " + row.jobnumber + "?");
                            idrequest = row.idrequest;
    						if (row.assignedto) {
    							$('#modal-close').modal('show');
    						} else {
    							alert('You are trying to close a request that it is not assigned.');
    						}
                        }
                        else if(field === "details"){
                            $("#modal-details").modal("show");
                            DATA=null;
                            parts=[];
                            ROW = row;
                            idrequest = row.idrequest;
                            //alert(idrequest);
                            URL             = "common/lookuprequest.php";
                            METODO          = "";
                            VALOR           = idrequest;
                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

                                DATA    = data;
                                parts   = DATA.REQUESTS;
                                VALOR = '';
                                $('#table-parts-details').bootstrapTable('destroy');
                                $('#table-parts-details').bootstrapTable({
                                    data: parts,
                                    striped: true,
                                    columns:
                                    [
                                        [
                                            {
                                                field: 'ro',
                                                title: '#RO',
                                                align: 'center',
                                                valign: 'middle',
                                                width:  1

                                            },
                                            {
                                                field: 'reqstatusold',
                                                title: 'STATUS OLD',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'reqstatusnew',
                                                title: 'STATUS NEW',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'creation_date',
                                                title: 'CREATION DATE',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1,
                                                formatter : function(value)
                                        {
                                            if(!value){return value;}
                                            else{

                                                var localDate = moment(value).local();
                                                var deadlineDate = moment(value).format("MMM DD YYYY, hh:mm:ss a");
                                                return deadlineDate;
                                            }
                                        }
                                            },
                                            {
                                                field: 'comment',
                                                title: 'COMMENTS',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'appuser',
                                                title: 'USER',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },


                                        ]
                                    ]
                                });

                               
                            });
                            
                        }
                    }
                });
                $('.blink').blink();

            });



            URL             = 'common/listparts.php';
            DATA            = null;
            VALOR           = '';
            METODO          = '';
            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR,  function(data){
            DATA = data;
            console.log(DATA);

                //table-statuspart
                $('#table-statuspart').bootstrapTable({
                       data: DATA,
                       columns: [
                    {
                        field: 'jobnumber_part',
                        title: 'jobnumber',
                        align: 'center',
                        valign: 'middle',
                        width: 1,
                        formatter: function(value){
                            var link;
                            link = "<a href='#'>"+value+"</a>";
                            return link;
                        }
                        
                    }, {
                        field: 'seg_part',
                        title: 'SEG',
                        align: 'center',
                        valign: 'middle',
                        width: 1
                    }, {
                        field: 'description_part',
                        title: 'Description',
                        align: 'center',
                        valign: 'middle',
                        width: 1,
                        formatter: function(value){
                            var link;
                            link = "<a href='#'>"+value+"</a>";
                            return link;
                        }
                    },
                    {
                        field:'quantity_part',
                        title:'Quantity',
                        align: 'center',
                        valign: 'middle',
                        width: 1
                    },
                    {
                        field:'status_order_part',
                        title:'Status Order',
                        align: 'center',
                        valign: 'middle',
                        width: 1
                    },
                    {
                        field:'creation_date_part',
                        title:'Creation Date',
                        align: 'center',
                        valign: 'middle',
                        width: 1,
                        formatter : function(value)
                                {
                                    if(!value){return value;}
                                    else{

                                        var localDate = moment(value).local();
                                        var deadlineDate = moment(value).format("MMM DD YYYY, hh:mm:ss a");
                                        return deadlineDate;
                                    }
                                }

                    },
                    {
                        field:'last_update_part',
                        title:'Update Date',
                        align: 'center',
                        valign: 'middle',
                        width: 1,
                        formatter : function(value)
                                {
                                    if(!value){return value;}
                                    else{

                                        var localDate = moment(value).local();
                                        var deadlineDate = moment(value).format("MMM DD YYYY, hh:mm:ss a");
                                        return deadlineDate;
                                    }
                                }

                    }],
                    onClickCell: function(field,value,row){
                        if (field==='jobnumber_part'){
                            // VIEW PRINT HERE

                            //console.log('Modal view showing')
    						// Copy from edit

                            DATA    = null;
                            parts   = [];

                            $('#modal-view').modal('show');
    						rederizsoftHideLoad( '#partsRequesition', '#cargar_data_edit' );
                            ROW = row;
                            $("#modal-view #idRequest").val(row.idrequest);
                            idrequest = row.idrequest;
                            URL             = "common/lookupParts.php";
                            METODO          = "";
                            VALOR           = idrequest;
                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

                                DATA    = data;
                                parts   = DATA.PARTS;
    							vOType = DATA.REQUESTS[0].idrequesttype;

                                if(DATA.REQUESTS[0].idpriority === "H"){
    								vOType='9';
    							}

    							var $radios = $('#modal-view input:radio[name=requestType]');
    							$radios.filter('[value='+vOType+']').prop('checked', true);
    							$radios.prop('disabled',true);


    							$(".modal-body #date-view").text(moment(DATA.REQUESTS[0].requestdate).format("MMM DD YYYY, hh:mm:ss a"));
    							$(".modal-body #view-techname").text(DATA.REQUESTS[0].techname);
    							//console.log(DATA.REQUESTS[0].techname);

                                $("#modal-view #view-ro").text(DATA.REQUESTS[0].ro);
                                $("#modal-view #view-vin").text(DATA.REQUESTS[0].vin);
                                $("#modal-view #view-trans").text(DATA.REQUESTS[0].trans);
                                $("#modal-view #view-engine").text(DATA.REQUESTS[0].engine);
                                $("#modal-view #view-comments").text(DATA.REQUESTS[0].reqcomment);

                                $('#modal-view #table-parts').bootstrapTable('destroy');
                                console.log(parts);
                                $('#modal-view #table-parts').bootstrapTable({

                                    data: parts,
                                    striped: true,
                                    columns:
                                    [
                                        [
                                            {
                                                field: 'seg',
                                                title: '<font color="#009207">*</font> SEG:',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'part',
                                                title: '<font color="#009207">*</font> PART:',
                                                align: 'center',
                                                valign: 'middle',
    											visible: false,
                                                width: 1
                                            },
                                            {
                                                field: 'description',
                                                title: '<font color="#009207">*</font> DESCRIPTION:',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'quantity',
                                                title: '<font color="#009207">*</font> QTY:',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'status',
                                                title: 'STATUS OF PART',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field:'comment_parts',
                                                title: 'COMMENT OF PARTS',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1,
                                            },
                                            {
                                                field: 'date_of_delivery',
                                                title: 'DATE OF DELIVERY',
                                                align:'center',
                                                valign:'middle',
                                                width: 1,
                                            }
                                           
                                            

                                        ]
                                    ]
                                });

    							// End copy from edit

    							iduser 	= $(".modal-view #view-techname").text();//$("#techId").val();

    							//**************FILTER DASHBOARD*******************
    							if (filter === 0) {
    								appuser		= $(".modal-body #techId").val();
    								VALOR   	= '';
    								<?php if ($profile == 'TECH'): ?>
    									VALOR 	= appuser;
    								<?php endif;?>

    								reloadDashboard(VALOR, 'common/ws.php');
    							} else {
    								iduser		= $("#modal-filter #techId").val();
    								startdate	= $("#modal-filter #startdate").val();
    								enddate		= $("#modal-filter #enddate").val();
    								jobnumber	= $("#modal-filter #jobnumber").val();
    								keyword		= $("#modal-filter #keyword").val();
    								URL			= "common/dashboard_search.php";
    								DATA		= null;
    								VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
    								reloadDashboard(VALOR, 'common/dashboard_search.php');
    							}
                            });

                        }
                        if(field==='description_part'){
                            console.log(row.part);
                            DATA    = null;
                            parts   = [];
                            $('#modal-parts-log').modal('show');
                            URL             = "common/log_parts.php";
                            METODO          = "";
                            VALOR           = row.part;
                            $("#modal-parts-log #table-parts-log").bootstrapTable("destroy");
                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                                DATA= data.DETAILS;
                                var details = DATA;
                                
                                $("#modal-parts-log #table-parts-log").bootstrapTable({
                                    data: details,
                                    striped: true,
                                    columns:
                                    [
                                            {
                                                field: 'status_old',
                                                title: 'STATUS OLD',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'status_new',
                                                title: 'STATUS NEW',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'creation_date',
                                                title: 'CREATION DATE',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1,
                                                formatter : function(value)
                                                {
                                                    if(!value){return value;}
                                                    else{

                                                        var localDate = moment(value).local();
                                                        var deadlineDate = moment(value).format("MMM DD YYYY, hh:mm:ss a");
                                                        return deadlineDate;
                                                    }
                                                }
                                               

                                     
                                            },
                                            {
                                                field: 'comment',
                                                title: 'COMMENTS',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },
                                            {
                                                field: 'appuser',
                                                title: 'USER',
                                                align: 'center',
                                                valign: 'middle',
                                                width: 1
                                            },


                                        
                                    ]

                                });

                            });
                            
                        }
                       
                    }
                        
                                        
                    


                });
            });

           $('#tab-parts').click(function(){
            URL             = 'common/listparts.php';
            DATA            = null;
            VALOR           = '';
            METODO          = '';
            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR,  function(data){
            DATA = data;

                //table-statuspart
                $('#table-statuspart').bootstrapTable('load',DATA);

           });
        });

			var DATE = new Date();
			var options = {
				weekday: "long", year: "numeric", month: "short",
				day: "numeric", hour: "2-digit", minute: "2-digit"
			};
			$("#date").text(DATE.toLocaleTimeString("en-us", options));

			ion.sound(
            {
                sounds:
                [
                    {
                        name: "beep",
                        loop: 3	//Beeps 3 times
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

            /*------------------------------------------------BEGIN Intervalos*/

                function startRegularIntervals(){
    				//Refresh dashboard records
                    interval1= setInterval(
                        function(){
        					if (filter === 0)
                            {
        						DATA = null;
        						URL = "common/ws.php";
        						call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data)
        						{
        							DATA = data;
        							$('#table-dashboard').bootstrapTable('load', DATA);
        							$('.blink').blink();
        						});
        					}
        						var DATE = new Date();
        						var options = {
        							weekday: "long", year: "numeric", month: "short",
        							day: "numeric", hour: "2-digit", minute: "2-digit"
        						};
        						$("#date").text(DATE.toLocaleTimeString("en-us", options));

        					//}
                        },
                        10000 // 10 seg
                    );

        			interval2= setInterval(
                        function(){

        					iduser 	= $("#techId").val();
                            URL     = "common/dashboard_totals.php";
        					VALOR   = '';
        					<?php if ($profile == 'TECH'): ?>
        						VALOR           = iduser;
        					<?php endif;?>

                            //VALOR   = $("#techId").val();
                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

                                COLORS = data;
                                $.each(COLORS, function(index)
                                {
        							//Totales del header
        							if (COLORS[index].colorflag === "Y")
        							{
        								$("#yellow").text(" " + COLORS[index].quantity);
        							}
        							else if (COLORS[index].colorflag === "R")
        							{
        								$("#red").text(" " + COLORS[index].quantity);
        							}
        							else if (COLORS[index].colorflag === "G")
        							{
        								$("#green").text(" " + COLORS[index].quantity);
        							}
                                    else if (COLORS[index].colorflag === "O")
                                    {
                                        $("#orange").text(" " + COLORS[index].quantity);
                                    }
        					    });
                            });
                        },
                        10000
                    );


        			interval3= setInterval(
                        function(){

        					iduser 	= $("#techId").val();
                            URL     = "common/dashboard_totals.php";
        					VALOR   = '';
        					<?php if ($profile == 'TECH'): ?>
        						VALOR           = iduser;
        					<?php endif;?>

                            //VALOR   = $("#techId").val();
                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

                                COLORS = data;
                                $.each(COLORS, function(index)
                                {
                                    //if (COLORS[index].colorflag === "R" && '<?php echo $profile; ?>'!=='TECH' && '<?php echo $profile; ?>'!=='TV')
        							if (COLORS[index].colorflag === "R" && '<?php echo $profile; ?>'==='PARTSP')
                                    {
                                        if (COLORS[index].quantity !== 0 && audio === 0)
                                        {
                                            ion.sound.play("beep");
                                        }
                                    }

        					    });
                            });
                        },
                        300000  // Beep sound each 5 minutes
                    );


        			<?php if ($profile == 'TV'): ?>
        				interval3= setInterval(
                            function()
                            {
                                if (filter === 0)
                                {
                                    URL = "common/ws.php";
                                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data)
                                    {
                                        dashboard_data = data;
                                        $('#table-dashboard').bootstrapTable('load', dashboard_data);
                                        $('.blink').blink();
                                    });

                                    $("a:contains('›')").trigger("click")
                                }

                            },
                            10000
                        );
        			<?php endif;?>

                }

                function clearRegularIntervals(){


                    clearInterval(interval1);
                    clearInterval(interval2);
                }

                startRegularIntervals();

            /*------------------------------------------------END Intervalos*/



            iduser 	= $("#techId").val();
			URL     = "common/dashboard_totals.php";
			VALOR   = '';
			<?php if ($profile == 'TECH'): ?>
				VALOR           = iduser;
			<?php endif;?>

			//VALOR   = $("#techId").val();
            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

                COLORS = data;
                $.each(COLORS, function(index){
                    if (COLORS[index].colorflag === "Y")
                    {
                        $("#yellow").text(" " + COLORS[index].quantity);
                    }
                    else if (COLORS[index].colorflag === "R")
                    {
                        $("#red").text(" " + COLORS[index].quantity);
                    }
                    else if (COLORS[index].colorflag === "G")
                    {
                        $("#green").text(" " + COLORS[index].quantity);
                    }
                     else if (COLORS[index].colorflag === "O")
                    {
                        $("#orange").text(" " + COLORS[index].quantity);
                    }
                });
            });

    		$(function (){

                $('#datetimepickerStartDate').datetimepicker({
                    format: 'YYYY-MM-DD'
                });
                $('#datetimepickerEndDate').datetimepicker({
                    useCurrent: false,
                    format: 'YYYY-MM-DD'
                });
                $('#datetimepickerdeliveryDate').datetimepicker({
                    useCurrent: false,
                    format: 'YYYY-MM-DD'
                });

                $("#modal-edit #table-parts").on('click','.fixdate', function (e){
                if (!$(this).hasClass('haspicker')) {
                    
                $(this).datetimepicker({
                    useCurrent: false,
                    format: 'YYYY-MM-DD',
                    minDate: new Date()
                });
                $(this).datetimepicker('show');
                $(this).addClass('haspicker')
                }else{
                $(this).datetimepicker('show');
                }
                $(this).on("dp.change",function(e){
                        //date_of_delivery = $(this).val();
                });
                    
                });

                

                $('#modal-edit #table-parts .datetimepickerdeliveryDate').datetimepicker({
                    useCurrent: false,
                    format: 'YYYY-MM-DD'
                });



                $("#modal-edit  #datetimepickerdeliveryDate").on("dp.change", function (e){
                    $('#datetimepickerEndDate').data("DateTimePicker").minDate(e.date);
                    
                });
                $("#datetimepickerStartDate").on("dp.change", function (e){
                    $('#datetimepickerEndDate').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepickerEndDate").on("dp.change", function (e){
                    $('#datetimepickerStartDate').data("DateTimePicker").maxDate(e.date);
                });

                $("#modal-edit #table-parts #datetimepickerdeliveryDate").on("dp.change", function (e){
                    $('#datetimepickerEndDate').data("DateTimePicker").minDate(e.date);
                });
                
            });

    		//************************
    		//*********** Ini Send Message
            $( "#linkToMyModalSendMessage" ).click(function(){
                $(".modal-body #selectName").val("");
                $(".modal-body #msg-comments").val("");
                var $radiomsg = $('input:radio[name="optradio"]');

    		   if($radiomsg.is('checked') == false) {
                    $radiomsg.filter('[value=User]').prop('checked', true);
                   // $("#selectGroup").attr("style", "display: none"); 
    		   }

                //$("#myModalSendMessage #selectName").val("");
                //$("#myModalSendMessage #msg-comments").val("");
                //parts = [];
                $('.modal-body #table-parts').bootstrapTable("destroy");

                $('.modal-body #table-parts').bootstrapTable({
                    data: parts,
                    striped: true,
                    columns:
                    [
                        [
                            {
                                field: 'seg',
                                title: 'SEQ:',
                                align: 'center',
                                valign: 'middle',
                                width: 1
                            },
                            {
                                field: 'parts',
                                title: 'PARTS:',
                                align: 'center',
                                valign: 'middle',
                                width: 1
                            },
                            {
                                field: 'description',
                                title: 'DESCRIPTION:',
                                align: 'center',
                                valign: 'middle',
                                width: 1
                            },
                            {
                                field: 'qty',
                                title: 'QTY:',
                                align: 'center',
                                valign: 'middle',
                                width: 1
                            },
                            
                            {
                                field: 'ord',
                                title: 'ORD:',
                                align: 'center',
                                valign: 'middle',
                                width: 1
                            },
                            
                            {
                                field:'date_of_delivery',
                                title: 'DATE OF DELIVERY',
                                align: 'center',
                                valign: 'middle',
                                width: 1,
                            },
                            {
                                field:'comment_parts',
                                title: 'COMMENT OF PARTS',
                                align: 'center',
                                valign: 'middle',
                                width: 1,
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
                    onClickCell: function (field, value)
                    {
                        if(field === "delete")
                        {
                            newParts = parts.filter(function(el)
                            {
                                deletedParts.push(value);
                                return el.delete !== value;
                            });
                            $('.modal-body #table-parts').bootstrapTable('load', newParts);
                            parts = newParts;
                        }
                          if(field==="ord"){
                            var x;
                                $('#'+value+'').on('change',function(){
                                    console.log($('#'+value+' option:selected').val());
                                  x= ordParts.indexOf(value);
                                  if(x==-1){
                                    ordParts.push(value,$('#'+value+' option:selected').val());
                                    console.log("nuevo elemento");
                                    console.log(ordParts);
                                  }
                                  else{

                                    console.log("ya existe");
                                    ordParts[x+1]=$('#'+value+' option:selected').val();
                                    console.log(ordParts);

                                  }



                                });


                        }
                    }
                });

                $('#myModalSendMessage').modal('show');
            });
			
    		// Group or user send message option
			$("#selectSingle").attr("style", "display: none"); 
    		$("#selectGroup").attr("style", "display: initial"); 
    		/*$('input:radio[name="optradio"]').change(function(){
    			if ($(this).val() == "Group") {
    				$("#selectSingle").attr("style", "display: none"); 
    				$("#selectGroup").attr("style", "display: initial"); 
    				
    			}
    			else
    			{
    				$("#selectGroup").attr("style", "display: none");
    				$("#selectSingle").attr("style", "display: initial");
    			}
    		});	*/


    		$("#myModalSendMessage #buttonSendMessage").click(function(){

    			$('#myModalSendMessage #selectName').change(function(){
    				$('#labelMessage').val('');
    			});

    			$('#myModalSendMessage #msg-comments').change(function(){
    				$('#labelMessage').val('');
    			});

                if ($('#labelMessage').val() === null || $('#labelMessage').val() === '') {
    				$('#labelMessage').val('');
    			}


    			// if option is group
    			var msgto = null;
				msgto="Group";
				selectName 	= $("#myModalSendMessage #selectName").val();
    			/*if ($('input:radio[name="optradio"]:checked').val() == "Group"){
    				selectName 	= $("#myModalSendMessage #selectName").val();
    				msgto = "Group";
    			}else{
    				selectName 	= $("#myModalSendMessage #selectNameU").val();
    				msgto = "Single";
    			}*/

    			techName 	= '<?php echo $techName; ?>';
                comments    = $("#myModalSendMessage #msg-comments").val();

    			if ( (selectName === '' || selectName === null) || (comments === '' || comments === null)) {
    				alert('Please complete the mandatory fields to continue...!\nAll fields marked with * are required.');
    			} else {

    				var recipient = []; //getSelectValues(el);
    				if (msgto == "Group") {
    					var el = document.getElementsByTagName('select')[0];

    					DATA 		= null;
    					URL             = "common/getUsersGroup.php";
    					VALOR           = selectName;

    					call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
    						DATA = data['USERS'];
    					});
                        recipient = DATA;
    				}else{
    					var destiny = new Object();
    					destiny.fullname = selectName;
    					recipient.push(destiny);
    				}

    				// MULTIPLE MESSAGES
    				for (var j = 0; j < recipient.length; j++) {
    					selectName = recipient[j]['fullname'];
    					DATA 		= null;
    					URL             = "common/sendmessages.php";
    					VALOR           = selectName + "|" + comments + "|" + techName;

    					call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
    						//$('#myModalSendMessage').modal('hide');
    						DATA = data[0]['MENSAJE'];
    						$('#labelMessage').val(DATA);

    					});

    				} //MULTIPLE MESSAGGES END

					$('#myModalSendMessage').modal('hide');

    				if ($('#labelMessage').val() === null || $('#labelMessage').val() === '') {
    					alert('Error sending message. Please try again or contact the system administrator.');
    				} else {
    					alert('The message was sent successfully');
    					$("#myModalSendMessage #selectName").val('');
    					$("#myModalSendMessage #msg-comments").val('');
    				}
    				//**************FILTER DASHBOARD*******************
    				if (filter === 0) {
    					appuser		= $(".modal-body #techId").val();
    					VALOR   	= '';
    					<?php if ($profile == 'TECH'): ?>
    						VALOR 	= appuser;
    					<?php endif;?>

    					reloadDashboard(VALOR, 'common/ws.php');
    				} else {
    					iduser		= $("#modal-filter #techId").val();
    					startdate	= $("#modal-filter #startdate").val();
    					enddate		= $("#modal-filter #enddate").val();
    					jobnumber	= $("#modal-filter #jobnumber").val();
    					keyword		= $("#modal-filter #keyword").val();
    					URL			= "common/dashboard_search.php";
    					//DATA		= null;
    					VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
    					reloadDashboard(VALOR, 'common/dashboard_search.php');
    				}
    			}

            });
    		//*********** Fin Send Message//************************

			//*********** priority requestType
            $( "#linkToMyModalPartsRequesition" ).click(function(){
				if ( $(".modal-body #techid").val("")  === null || $(".modal-body #techid").val("") === "") {
    				console.log('Your session expire');
    				window.location.replace("http://reqparts.bdicalgary.com/BrandellDiesel/index.php");
				}

				$(".modal-body #requestType").removeAttr('checked');
				$(".modal-body #ro").val("");
				$(".modal-body #vin").val("");
				$(".modal-body #trans").val("");
				$(".modal-body #engine").val("");
				$(".modal-body #comments").val("");
				parts = [];
				$('.modal-body #table-parts').bootstrapTable("destroy");

				$('.modal-body #table-parts').bootstrapTable
				({
					data: parts,
					striped: true,
					columns:
					[
						[
							{
								field: 'seg',
								title: '<font color="#009207">*</font> SEQ:',
								align: 'center',
								valign: 'middle',
								width: 1
							},
							{
								field: 'parts',
								title: '<font color="#009207">*</font> PARTS:',
								align: 'center',
								valign: 'middle',
								visible: false,
								width: 1
							},
							{
								field: 'description',
								title: '<font color="#009207">*</font> DESCRIPTION:',
								align: 'center',
								valign: 'middle',
								width: 1
							},
							{
								field: 'qty',
								title: '<font color="#009207">*</font> QTY:',
								align: 'center',
								valign: 'middle',
								width: 1
							},
                            
                          
                            /*{
                                field: 'ord',
                                title: 'STATUS:',
                                align: 'center',
                                valign: 'middle',
                                width: 1,
                                clickToSelect: false,
                                 formatter: function(value){

                                   // return '<select id='+value+'><option value="">Select an option</option><option value="ordered">Ordered</option><option value="received">Received</option><option value="canceled">Canceled</option></select>';
                                   return '-';

                                },
                            },*/
                            {
                                field:'comments_parts',
                                title: 'COMMENT OF PARTS',
                                align: 'center',
                                valign: 'middle',
                                width: 1,
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
					onClickCell: function (field, value){
						if(field === "delete"){
							newParts = parts.filter(function(el){
								deletedParts.push(value);
								return el.delete !== value;
							});
							$('.modal-body #table-parts').bootstrapTable('load', newParts);
							parts = newParts;
						}
                        if(field==="ord"){
                            var x;
                                $('#'+value+'').on('change',function(){
                                    console.log($('#'+value+' option:selected').val());
                                  x= ordParts.indexOf(value);
                                  if(x==-1){
                                    ordParts.push(value,$('#'+value+' option:selected').val());
                                    console.log("nuevo elemento");
                                    console.log(ordParts);
                                  }
                                  else{

                                    console.log("ya existe");
                                    ordParts[x+1]=$('#'+value+' option:selected').val();
                                    console.log(ordParts);

                                  }



                                });


                        }
					}
				});

                function removeItemFromArr ( arr, item ) {
                    var i = arr.indexOf( item );

                    if ( i !== -1 ) {
                        arr.splice( i, 1 );
                    }
                }

				$('#myModalPartsRequesition').modal('show');
				rederizsoftHideLoad( '#partsRequesition', '#cargar_data_requesition' );
			});


			$("#myModalPartsRequesition #buttonSavePartsRequesition").click(function(){

				techName        = '<?php echo $techName; ?>';
				jobnumber       = $(".modal-body #ro").val();
				appuser         = $(".modal-body #new-techId").val();

				var $radiotype = $('.modal-body input:radio[name="requestType"]:checked');
				idrequesttype = $radiotype.val();

                if(aux_colorflag!="O"){
                    idpriority   = "N";
                }

				vPriority   = "Normal";
				if(idrequesttype == "Q"){
					vType   = "Quote";
				} else {
					if(idrequesttype == "O"){
						idrequesttype = "O";
						vType   = "Order";
					}
					else
					{
						idrequesttype = "O";
						vType   = "Order";
						idpriority   = "H";
						vPriority   = "911";
					}
				}

				ro              = $(".modal-body #ro").val();
				vin             = $(".modal-body #vin").val();
				trans           = $(".modal-body #trans").val();
				engine          = $(".modal-body #engine").val();
				comments        = $(".modal-body #comments").val();
				partsJSON   	= JSON.stringify(parts);

				// Required fields validations
				if (ro=='' || parts.length == 0  ){
						alert('Please complete the mandatory fields to continue...!\nAll fields marked with * are required.');
				}else{

					DATA = null;
					URL             = "common/createParts.php";
					METODO          = "request_insert";
					VALOR           = jobnumber + "|" + appuser + "|" + idrequesttype + "|" + idpriority + "|" + ro + "|" + vin + "|" + trans + "|" + engine + "|" + comments;
					call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                       
                        if(Array.isArray(data)){
                            alert("Error saving data");

                            $("#myModalPartsRequesition").modal('hide');

                        }else{
                            DATA = data;
                        
						if(DATA){
                            
							idrequest   = DATA;
							rederizsoftReady('A','#partsRequesition', 'common/sendMail.php?vRo='+encodeURIComponent(ro)+'&vtechName='+encodeURIComponent(techName)+'&vPriority='+encodeURIComponent(vPriority)+'&vType='+encodeURIComponent(vType)+'&vVin='+encodeURIComponent(vin)+'&vComments='+encodeURIComponent(comments)+'&vpartsJSON='+encodeURIComponent(partsJSON)+'&vDate='+encodeURIComponent(moment(DATE).format("MMM DD YYYY, hh:mm:ss a"))+'&vEngine='+encodeURIComponent(engine)+'&vID='+encodeURIComponent(idrequest)+'&vStatus=', '#cargar_data_requesition', 'consultar');

							if(parts.length !== 0){
								DATA        = null;
								METODO      = "request_parts_insert";
								partsJSON   = JSON.stringify(parts);
								VALOR       = idrequest + "|" + partsJSON + "|" + appuser + "|" + ordParts;
                                ordParts=[];
                                console.log(VALOR);
								call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
									DATA = data;
									if(DATA){
										parts = [];
										$('.modal-body #table-parts').bootstrapTable('load', parts);
										$('#myModalPartsRequesition').modal('hide');
										$('.nav.nav-tabs a[href=#tabdashboard]').tab('show');
										//**************FILTER DASHBOARD*******************
										if (filter === 0) {
											appuser		= $(".modal-body #new-techId").val();
											VALOR   	= '';
											<?php if ($profile == 'TECH'): ?>
												VALOR 	= appuser;
											<?php endif;?>

											reloadDashboard(VALOR, 'common/ws.php');
										} else {
											iduser		= $("#modal-filter #techId").val();
											startdate	= $("#modal-filter #startdate").val();
											enddate		= $("#modal-filter #enddate").val();
											jobnumber	= $("#modal-filter #jobnumber").val();
											keyword		= $("#modal-filter #keyword").val();
											URL			= "common/dashboard_search.php";
											DATA		= null;
											VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
											reloadDashboard(VALOR, 'common/dashboard_search.php');
										}
									}
								});
							}else{
								$('#myModalPartsRequesition').modal('hide');
							}
						}
						else
						{
						}

                        }
						
					});

				} // if required validation end
            });

            $("#myModalPartsRequesition #buttonAddParts").click(function(){
                ordParts=[];

			    //UNIQUE
				var N = 8, uniquepart = (Math.random().toString(36)+'00000000000000000').slice(2, N+2);
				//console.log(uniquepart);
				$("#myModalPartsRequesition #parts").val(uniquepart);

				if ($("#myModalPartsRequesition #parts").val()=='' || $("#myModalPartsRequesition #seg").val()=='' || $("#myModalPartsRequesition #description").val()=='' || $("#myModalPartsRequesition #qty").val()=='') {
					alert('Please complete the fields to continue...!\nAll fields marked with * are required.');
				} else {
                    date = parseInt($("#myModalPartsRequesition #dateofdelivery").val());
					part = {seg:$("#myModalPartsRequesition #seg").val(), parts:uniquepart, description:$("#myModalPartsRequesition #description").val(), qty:$("#myModalPartsRequesition #qty").val(), ord:$("#myModalPartsRequesition #parts").val(), delete:$("#myModalPartsRequesition #parts").val(), date_of_delivery:date, comments_parts:$("#myModalPartsRequesition #commentsparts").val()};
					parts.push(part);
                    uniquepart2=uniquepart;
					$("#myModalPartsRequesition #table-parts").bootstrapTable('load', parts);
					$("#myModalPartsRequesition #parts").val("");
					$("#myModalPartsRequesition #seg").val("");
					$("#myModalPartsRequesition #description").val("");
					$("#myModalPartsRequesition #qty").val("");
                    $("#myModalPartsRequesition #commentsparts").val('');
                    $("#myModalPartsRequesition #dateofdelivery").val('');
				}
            });

            $("#modal-edit #buttonAddPartsE").click(function(){
                index_part=-1;
			    //UNIQUE
				var N = 8, uniquepart = (Math.random().toString(36)+'00000000000000000').slice(2, N+2);
				console.log(idrequest);
				$("#modal-edit #edit-parts").val(uniquepart);
				if ($("#modal-edit #edit-parts").val()=='' || $("#modal-edit #edit-description").val()=='' || $("#modal-edit #edit-qty").val()=='') {
					alert('Please complete the fields to continue...!\nAll fields marked with * are required.');
				} else {
                    var date;
                    if($("#modal-edit #editdateofdelivery").val()==''){
                        date =null;                    
                    }else{
                        date = $("#modal-edit #editdateofdelivery").val();
                    }
                    
                    var qty_temp = $("#modal-edit #edit-qty").val();
                    
                    qty_temp= qty_temp.replace(/["]+/g, '');
                    
					newPart = {idrequest: idrequest, seg:$("#modal-edit #edit-seg").val(), part:$("#modal-edit #edit-parts").val(), description:$("#modal-edit #edit-description").val(), quantity:qty_temp, ord:'1',date_of_delivery:date, comment_parts:$("#modal-edit #commentspartsedit").val(), edit:$("#modal-edit #idRequest").val() + "|" + $("#modal-edit #edit-parts").val(), delete:$("#modal-edit #idRequest").val() + "|" + $("#modal-edit #edit-parts").val()};
					newPart_edit.push(newPart);
                    parts.push(newPart);
                    newPart = {};
                    
					$('#modal-edit #table-parts').bootstrapTable('load', parts);
					$("#modal-edit #edit-seg").val("");
					$("#modal-edit #edit-parts").val("");
					$("#modal-edit #edit-description").val("");
					$("#modal-edit #edit-qty").val("");
					$("#modal-edit #edit-ord").val("");
                    $("#modal-edit #commentspartsedit").val("");
                    $("#modal-edit #editdateofdelivery").val("");
				}
            });

            $("#buttonDeletePartsRequesition").click(function(){

                appuser         = $(".modal-body #new-techId").val();
                URL             = "common/deleteParts.php";
                DATA            = null;
                METODO          = "request_delete";
                VALOR           = idrequest + "|" + appuser;
                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    $('#modal-delete').modal('hide');
					//**************FILTER DASHBOARD*******************
					if (filter === 0) {
						appuser		= $(".modal-body #new-techId").val();
						VALOR   	= '';
						<?php if ($profile == 'TECH'): ?>
							VALOR 	= appuser;
						<?php endif;?>

						reloadDashboard(VALOR, 'common/ws.php');
					} else {
						iduser		= $("#modal-filter #techId").val();
						startdate	= $("#modal-filter #startdate").val();
						enddate		= $("#modal-filter #enddate").val();
						jobnumber	= $("#modal-filter #jobnumber").val();
						keyword		= $("#modal-filter #keyword").val();
						URL			= "common/dashboard_search.php";
						DATA		= null;
						VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
						reloadDashboard(VALOR, 'common/dashboard_search.php');
					}

					URL     = "common/dashboard_totals.php";
			        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
						COLORS = data;
						$.each(COLORS, function(index){

							if (COLORS[index].colorflag === "Y")
							{
								$("#yellow").text(" " + COLORS[index].quantity);
							}
							else if (COLORS[index].colorflag === "R")
							{
								$("#red").text(" " + COLORS[index].quantity);
							}
							else if (COLORS[index].colorflag === "G")
							{
								$("#green").text(" " + COLORS[index].quantity);
							}
                            else if (COLORS[index].colorflag === "O")
                            {
                                $("#orange").text(" " + COLORS[index].quantity);
                            }
					    });
					});
                });
            });

			$("#buttonCancelEdit").click(function(){
                $("#modal-edit #buttonSavePart").css("display", "none");
                $("#modal-edit #buttonCancelEdit").css("display", "none");
                $("#modal-edit #buttonAddPartsE").css("display", "block");
            });

			// Modal EDIT Button SAVE
			$("#modal-edit #buttonSave").click(function(){
                var z=0;
                
                require_date.forEach(function(element) {
                if ($('#part-'+element).val()==''){
                   z++;
                }
                });

                if(z>0){
                   alert("The Date of Delivery it's require for parts with status ordered");                              
                }
                else{
                techName       	= $("#modal-edit #edit-techName").val();
				idrequest       = $("#modal-edit #idRequest").val();
                jobnumber       = $("#modal-edit #edit-ro").val();
                appuser         = $("#modal-edit #edit-techId").val();

				var $radiotype = $('#modal-edit input:radio[name="requestType"]:checked');
				idrequesttype = $radiotype.val();
                if (aux_colorflag==="O"){

                    idpriority   = "O";
                    aux_colorflag =null;
                }	else{
                    idpriority = "N";
                    vPriority   = "Normal";
                }

                
				if(idrequesttype == "Q"){
					vType   = "Quote";
				} else {
					if(idrequesttype == "O"){
						idrequesttype = "O";
						vType   = "Order";
                        vPriority   = "Normal";
					}
					else
					{
						idrequesttype = "O";
						vType   = "Order";
						idpriority   = "H";
						vPriority   = "911";
					}
				}

                ro              = $("#modal-edit #edit-ro").val();
                vin             = $("#modal-edit #edit-vin").val();
                trans           = $("#modal-edit #edit-trans").val();
                engine          = $("#modal-edit #edit-engine").val();
                comments        = $("#modal-edit #edit-comments").val();
                DATA            = null;
                URL             = "common/editParts.php";
               
          
                
               

                    
                

                partsJSON   = JSON.stringify(parts)+"||"+ordParts+"*|||"+JSON.stringify(newPart_edit)+"||||"+JSON.stringify(date_of_delivery);
                date_of_delivery={};
                console.log(partsJSON);
                newPart_edit =[];

                
				rederizsoftReady('A','#partsRequesition', 'common/sendMail.php?vRo='+encodeURIComponent(ro)+'&vtechName='+encodeURIComponent(techName)+'&vPriority='+encodeURIComponent(vPriority)+'&vType='+encodeURIComponent(vType)+'&vVin='+encodeURIComponent(vin)+'&vComments='+encodeURIComponent(comments)+'&vpartsJSON='+encodeURIComponent(partsJSON)+'&vDate='+encodeURIComponent(moment(DATE).format("MMM DD YYYY, hh:mm:ss a"))+'&vEngine='+encodeURIComponent(engine)+'&vID='+encodeURIComponent(idrequest)+'&vStatus=', '#cargar_data_edit', 'consultar');
				METODO          = partsJSON;
                VALOR           = idrequest + "|" + jobnumber + "|" + appuser + "|" + idrequesttype + "|" + idpriority + "|" + ro + "|" + vin + "|" + trans + "|" + engine + "|" + comments;
                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    DATA = data;
                    //console.log(parts);
                    $('#modal-edit').modal('hide');
					//**************FILTER DASHBOARD*******************
					if (filter === 0) {
						appuser		= $(".modal-body #new-techId").val();
						VALOR   	= '';
						<?php if ($profile == 'TECH'): ?>
							VALOR 	= appuser;
						<?php endif;?>

						reloadDashboard(VALOR, 'common/ws.php');
					} else {
						iduser		= $("#modal-filter #techId").val();
						startdate	= $("#modal-filter #startdate").val();
						enddate		= $("#modal-filter #enddate").val();
						jobnumber	= $("#modal-filter #jobnumber").val();
						keyword		= $("#modal-filter #keyword").val();
						URL		= "common/dashboard_search.php";
						DATA		= null;
						VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
						reloadDashboard(VALOR, 'common/dashboard_search.php');
					}
                });
                ordParts  = [];
                id        =  null;
                }
                


                
            });

            $("#buttonClosePartsRequesition").click(function(){
				appuser         = $("#modal-close #close-techId").val();
                URL             = "common/closeRequest.php";
                DATA            = null;
                VALOR           = idrequest + "|" + appuser;
                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    $('#modal-close').modal('hide');
					//**************FILTER DASHBOARD*******************
					if (filter === 0) {
						appuser		= $(".modal-body #new-techId").val();
						VALOR   	= '';
						<?php if ($profile == 'TECH'): ?>
							VALOR 	= appuser;
						<?php endif;?>

						reloadDashboard(VALOR, 'common/ws.php');
					} else {
						iduser		= $("#modal-filter #techId").val();
						startdate	= $("#modal-filter #startdate").val();
						enddate		= $("#modal-filter #enddate").val();
						jobnumber	= $("#modal-filter #jobnumber").val();
						keyword		= $("#modal-filter #keyword").val();
						URL			= "common/dashboard_search.php";
						DATA		= null;
						VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
						reloadDashboard(VALOR, 'common/dashboard_search.php');
					}
					/*
                    filter = 0;
					URL = "common/ws.php";
					VALOR   = '';
					<?php if ($profile == 'TECH'): ?>
						VALOR 	= appuser;
					<?php endif;?>

                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data)
                    {
                        DATA = data;
                        $('#table-dashboard').bootstrapTable('load', DATA);
                    });
					*/
                });
            });

            $("#buttonAssignPartsRequesition").click(function(){
                appuser         = $("#modal-assign #assign-techId").val();
                //idspecialist    = $("#modal-assign #techId").val();
                URL             = "common/assignRequest.php";
                DATA            = null;
                VALOR           = idrequest + "|" + idspecialist + "|" + appuser;
                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    $('#modal-assign').modal('hide');
					//**************FILTER DASHBOARD*******************
					if (filter === 0) {
						appuser		= $(".modal-body #new-techId").val();
						VALOR   	= '';
						<?php if ($profile == 'TECH'): ?>
							VALOR 	= appuser;
						<?php endif;?>

						reloadDashboard(VALOR, 'common/ws.php');
					} else {
						iduser		= $("#modal-filter #techId").val();
						startdate	= $("#modal-filter #startdate").val();
						enddate		= $("#modal-filter #enddate").val();
						jobnumber	= $("#modal-filter #jobnumber").val();
						keyword		= $("#modal-filter #keyword").val();
						URL			= "common/dashboard_search.php";
						DATA		= null;
						VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
						reloadDashboard(VALOR, 'common/dashboard_search.php');
					}
                });
            });

			$(".filter").click(function(){

				$("#modal-filter #buttonApplyFilter").attr('data-tabletarget',$(this).attr('data-tabletarget'));
				$("#modal-filter #buttonApplyFilter").attr('data-filename',$(this).attr('data-filename'));

                $("#modal-filter .modal-title").text($(this).attr('data-title'));
                $("#modal-filter .modal-footdescription").text($(this).attr('data-descriptios'));


                $('#modal-filter').modal('show');
            });

            $("#buttonAssignPartsRequesitionSp").click(function(){

				//Assign PARTSP begin
				//alert('PARTSP begin');
				appuser         = '<?php echo $techId; ?>';
				idspecialist    = '<?php echo $techId; ?>';
				idrequest = $("#modal-assignsp #idRequest").val();
				URL             = "common/assignRequest.php";
				DATA            = null;
				VALOR           = idrequest + "|" + idspecialist + "|" + appuser;

                $('#modal-assignsp').modal('hide');

				call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
					VALOR   = '';
					<?php if ($profile == 'TECH'): ?>
                        VALOR 	= appuser;
					<?php endif;?>

					URL = "common/ws.php";
					call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
							DATA = data;
							$('#table-dashboard').bootstrapTable('load', DATA);
					});
				});

			    // Assign PARTSP end
            });

            // Advanced search
            $("#modal-filter #buttonApplyFilter").click(function(){

            	var tabletarget=$(this).attr('data-tabletarget');
            	var filename=$(this).attr('data-filename');

                iduser          = $("#modal-filter #techId").val();
                startdate       = $("#modal-filter #startdate").val();
                enddate         = $("#modal-filter #enddate").val();
                jobnumber       = $("#modal-filter #jobnumber").val();
				keyword       	= $("#modal-filter #keyword").val();

				if (startdate!='' && enddate== '' )
				{
					alert('Please, complete the end date.');
				}else{
					if (startdate=='' && enddate!= '' )
					{
						alert('Please, complete the start date.');
					}else{
						if ((startdate!='' && enddate!= '') || keyword!='' ) {
							if (checkDate(startdate) && checkDate (enddate) && difDates(startdate,enddate,90)){
								URL             = "common/"+filename+".php";
								DATA            = null;
								VALOR           = iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;

								call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
									filter = 1;
									dashboard_data = data;
									$(tabletarget).bootstrapTable('load', dashboard_data);
									
                                    $(document).find('#modal-filter').each(function(){
                                    $(this).modal('toggle')
                                   });
									$('.blink').blink();
								});
                            }
						}else{
							alert ('You need to specify at least one parameter.');
						}
					}

				}
            });

			$("#custom-toolbar #buttonApplyFilter").click(function(){
				VALOR   		= '';
				<?php if ($profile == 'TECH'): ?>
					VALOR 		= '<?php echo $techId; ?>';
				<?php endif;?>

                iduser          = VALOR;
				//nameuser      = '';
                startdate       = '';
                enddate         = '';
                jobnumber       = '';
				keyword       	= '';
                //URL             = "common/dashboard_search.php";
				URL             = "common/ws.php";
                DATA            = null;
                //VALOR           = iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
				VALOR           = iduser;
                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

                    filter = 0;
                    dashboard_data = data;
                    $('#table-dashboard').bootstrapTable('load', dashboard_data);
                    $('#modal-filter').modal('hide');
                    $('.blink').blink();
                });
				//$("#modal-filter #techName").val('<?php echo $techName ?>');
				$("#modal-filter #techId").val('<?php echo $techName ?>');
                $("#modal-filter #startdate").val('');
                $("#modal-filter #enddate").val('');
                $("#modal-filter #jobnumber").val('');
				$("#modal-filter #keyword").val('');
            });

    		// Admin Groups
    		$( "#adminGroups" ).click(function(){
    			DATA 		= null;
    			URL             = "common/getGroups.php";
    			VALOR           = null;

    			call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
    				groups = data['GROUPS'];
    			});

    			$('#modal-adminGroups #table-GroupsDashboard').bootstrapTable ({
                                data: groups,
                                striped: true,
                                columns:
                                [
                                    [
                                        {
                                            field: 'idgroup',
                                            title: '<font color="#009207">*</font> Id Group:',
                                            align: 'center',
                                            valign: 'middle',
                                            width: 1
                                        },
                                        {
                                            field: 'name',
                                            title: 'Name:',
                                            align: 'center',
                                            valign: 'middle',
                                            width: 1
                                        },
                                        {
                                            field: 'phone',
                                            title: 'Phone',
                                            align: 'center',
                                            valign: 'midle',
                                            width: 1
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
                                                return '<a class=""><span class="fa fa-pencil" aria-hidden="true"></span></a>';
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
                                onClickCell: function (field, value, row){

                    				if(field === "delete"){

                    					$('#modal-delgroup').modal('show');
                    					$("#modal-delgroup #titulo").text("Do you want to delete group " + row.name + "?");
                    					$("#modal-delgroup #delgroup-techId").val('<?php echo $techId; ?>');
                    					$("#modal-delgroup #idgroup").val(row.idgroup);

                    					$("#modal-delgroup #buttonDeleteGroup").click(function(){
                    								idgroup      = $("#modal-delgroup #idgroup").val();
                    								appuser     = $("#modal-delgroup #delgroup-techId").val();
                    								URL         = "common/group_delete.php";
                    								VALOR       = idgroup + "|" + appuser;
                    								//console.log(VALOR);

                    								call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    										URL         = "common/getGroups.php";
                    										VALOR       = null;

                    										call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    											groups = data['GROUPS'];
                    											$('#modal-adminGroups #table-GroupsDashboard').bootstrapTable('load', groups);
                    										});

                                                    });
                    								$('#modal-delgroup').modal('hide');

                    					}); /* Delete group end */

                    				}
                                    if(field === "edit"){
                                        console.log(newPart);
                                        $("#modal-adminGroups #name").val(row.name);
                                        $("#modal-adminGroups #phonenumber").val(row.phone);
                                        $("#modal-adminGroups #buttonEditGroup").css('display','block');
                                        $("#modal-adminGroups #buttonAddGroup").css('display','none');
                                        idgroup=row.idgroup;
                                    }
                                }

    			});


    			$('#modal-adminGroups').modal('show');
    		});

            $("#modal-adminGroups #buttonAddGroup").click(function(){
                
                phonenumbergroup = $("#modal-adminGroups #phonenumber").val();
                idgroup      = $("#modal-adminGroups #name").val();
                name     	= $("#modal-adminGroups #name").val();
                appuser     = $("#modal-adminGroups #admgr-techId").val();
                if (phonenumbergroup=='' ||name ==''){
                    alert ("Please complete the mandatory fields to continue...!\nAll fields marked with * are required.");
                    $("#modal-adminGroups #name").val('');
                    $("#modal-adminGroups #phonenumber").val('');
                }else{
                    URL         = "common/group_insert.php";
                    METODO      = "";
                    VALOR       = idgroup + "|" + name + "|" + appuser + "|" + phonenumbergroup;
                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    DATA = data;
                    if (DATA[0].RESULTADO === "0000"){
        				DATA 		= null;
        				URL         = "common/getGroups.php";
        				VALOR       = null;

                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                           	groups = data['GROUPS'];
                            $('#modal-adminGroups #table-GroupsDashboard').bootstrapTable('load', groups);
                            $("#modal-adminGroups #idGroup").val("");
                            $("#modal-adminGroups #name").val("");
                            $("#modal-adminGroups #phonenumber").val("");
			                alert ('The group was successfully created');
                        });
                    }else{

                        alert("Error trying to save the group. Please check the group information and try againg.");
                        $('#modal-adminGroups #table-groupsDashboard').bootstrapTable('load', groups);
                        $("#modal-adminGroups #idGroup").val("");
                        $("#modal-adminGroups #name").val("");
                    }
					//**************FILTER DASHBOARD*******************
					if (filter === 0) {
						appuser		= $(".modal-body #new-techId").val();
						VALOR   	= '';
						<?php if ($profile == 'TECH'): ?>
							VALOR 	= appuser;
						<?php endif;?>

						reloadDashboard(VALOR, 'common/ws.php');
					} else {
						iduser		= $("#modal-filter #techId").val();
						startdate	= $("#modal-filter #startdate").val();
						enddate		= $("#modal-filter #enddate").val();
						jobnumber	= $("#modal-filter #jobnumber").val();
						keyword		= $("#modal-filter #keyword").val();
						URL			= "common/dashboard_search.php";
						DATA		= null;
						VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
						reloadDashboard(VALOR, 'common/dashboard_search.php');
					}

                });

                }
                   

                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    DATA = data;
                    if (DATA.hasOwnProperty('RESULTADO')) {
                        if (DATA[0].RESULTADO === "0000"){
        				DATA 		= null;
        				URL         = "common/getGroups.php";
        				VALOR       = null;

                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                           	groups = data['GROUPS'];
                            $('#modal-adminGroups #table-GroupsDashboard').bootstrapTable('load', groups);
                            $("#modal-adminGroups #idGroup").val("");
                            $("#modal-adminGroups #name").val("");
			                alert ('The group was successfully created');
                        });
                    }else{

                        alert("Error trying to save the group. Please check the group information and try againg.");
                        $('#modal-adminGroups #table-groupsDashboard').bootstrapTable('load', groups);
                        $("#modal-adminGroups #idGroup").val("");
                        $("#modal-adminGroups #name").val("");
                    }
                    if (DATA[0].RESULTADO === "0000"){
        				DATA 		= null;
        				URL         = "common/getGroups.php";
        				VALOR       = null;

                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                           	groups = data['GROUPS'];
                            $('#modal-adminGroups #table-GroupsDashboard').bootstrapTable('load', groups);
                            $("#modal-adminGroups #idGroup").val("");
                            $("#modal-adminGroups #name").val("");
			                alert ('The group was successfully created');
                        });
                    }else{

                        alert("Error trying to save the group. Please check the group information and try againg.");
                        $('#modal-adminGroups #table-groupsDashboard').bootstrapTable('load', groups);
                        $("#modal-adminGroups #idGroup").val("");
                        $("#modal-adminGroups #name").val("");
                    }
                    if (DATA[0].RESULTADO === "0000"){
        				DATA 		= null;
        				URL         = "common/getGroups.php";
        				VALOR       = null;

                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                           	groups = data['GROUPS'];
                            $('#modal-adminGroups #table-GroupsDashboard').bootstrapTable('load', groups);
                            $("#modal-adminGroups #idGroup").val("");
                            $("#modal-adminGroups #name").val("");
			                alert ('The group was successfully created');
                        });
                    }else{

                        alert("Error trying to save the group. Please check the group information and try againg.");
                        $('#modal-adminGroups #table-groupsDashboard').bootstrapTable('load', groups);
                        $("#modal-adminGroups #idGroup").val("");
                        $("#modal-adminGroups #name").val("");
                    }

                    }
                    
                   
					//**************FILTER DASHBOARD*******************
					if (filter === 0) {
						appuser		= $(".modal-body #new-techId").val();
						VALOR   	= '';
						<?php if ($profile == 'TECH'): ?>
							VALOR 	= appuser;
						<?php endif;?>

						reloadDashboard(VALOR, 'common/ws.php');
					} else {
						iduser		= $("#modal-filter #techId").val();
						startdate	= $("#modal-filter #startdate").val();
						enddate		= $("#modal-filter #enddate").val();
						jobnumber	= $("#modal-filter #jobnumber").val();
						keyword		= $("#modal-filter #keyword").val();
						URL			= "common/dashboard_search.php";
						DATA		= null;
						VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
						reloadDashboard(VALOR, 'common/dashboard_search.php');
					}

                });
            });

            $("#modal-adminGroups #buttonEditGroup").click(function(){
                phonenumbergroup = $("#modal-adminGroups #phonenumber").val();
                name     	= $("#modal-adminGroups #name").val();
                appuser     = $("#modal-adminGroups #admgr-techId").val();
                if (phonenumbergroup=='' ||name ==''){
                    alert ("Please complete the mandatory fields to continue...!\nAll fields marked with * are required.");
                    $("#modal-adminGroups #name").val('');
                    $("#modal-adminGroups #phonenumber").val('');
                }else{
                    URL         = "common/group_edit.php";
                    METODO      = "";
                    VALOR       = idgroup + "|" + name + "|" + appuser + "|" + phonenumbergroup;
                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    DATA = data;
                    if (DATA[0].RESULTADO === "0000"){
        				DATA 		= null;
        				URL         = "common/getGroups.php";
        				VALOR       = null;

                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                           	groups = data['GROUPS'];
                            $('#modal-adminGroups #table-GroupsDashboard').bootstrapTable('load', groups);
                            $("#modal-adminGroups #idGroup").val("");
                            $("#modal-adminGroups #name").val("");
                            $("#modal-adminGroups #phonenumber").val("");
			                alert ('The group was successfully created');
                        });
                    }else{

                        alert("Error trying to save the group. Please check the group information and try againg.");
                        $('#modal-adminGroups #table-groupsDashboard').bootstrapTable('load', groups);
                        $("#modal-adminGroups #idGroup").val("");
                        $("#modal-adminGroups #name").val("");
                    }
					//**************FILTER DASHBOARD*******************
					if (filter === 0) {
						appuser		= $(".modal-body #new-techId").val();
						VALOR   	= '';
						<?php if ($profile == 'TECH'): ?>
							VALOR 	= appuser;
						<?php endif;?>

						reloadDashboard(VALOR, 'common/ws.php');
					} else {
						iduser		= $("#modal-filter #techId").val();
						startdate	= $("#modal-filter #startdate").val();
						enddate		= $("#modal-filter #enddate").val();
						jobnumber	= $("#modal-filter #jobnumber").val();
						keyword		= $("#modal-filter #keyword").val();
						URL			= "common/dashboard_search.php";
						DATA		= null;
						VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
						reloadDashboard(VALOR, 'common/dashboard_search.php');
					}

                });

                }
                   

                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    DATA = data;
                    if (DATA.hasOwnProperty('RESULTADO')) {
                        if (DATA[0].RESULTADO === "0000"){
        				DATA 		= null;
        				URL         = "common/getGroups.php";
        				VALOR       = null;

                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                           	groups = data['GROUPS'];
                            $('#modal-adminGroups #table-GroupsDashboard').bootstrapTable('load', groups);
                            $("#modal-adminGroups #idGroup").val("");
                            $("#modal-adminGroups #name").val("");
			                alert ('The group was successfully created');
                        });
                    }else{

                        alert("Error trying to save the group. Please check the group information and try againg.");
                        $('#modal-adminGroups #table-groupsDashboard').bootstrapTable('load', groups);
                        $("#modal-adminGroups #idGroup").val("");
                        $("#modal-adminGroups #name").val("");
                    }
                    if (DATA[0].RESULTADO === "0000"){
        				DATA 		= null;
        				URL         = "common/getGroups.php";
        				VALOR       = null;

                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                           	groups = data['GROUPS'];
                            $('#modal-adminGroups #table-GroupsDashboard').bootstrapTable('load', groups);
                            $("#modal-adminGroups #idGroup").val("");
                            $("#modal-adminGroups #name").val("");
			                alert ('The group was successfully created');
                        });
                    }else{

                        alert("Error trying to save the group. Please check the group information and try againg.");
                        $('#modal-adminGroups #table-groupsDashboard').bootstrapTable('load', groups);
                        $("#modal-adminGroups #idGroup").val("");
                        $("#modal-adminGroups #name").val("");
                    }
                    if (DATA[0].RESULTADO === "0000"){
        				DATA 		= null;
        				URL         = "common/getGroups.php";
        				VALOR       = null;

                        call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                           	groups = data['GROUPS'];
                            $('#modal-adminGroups #table-GroupsDashboard').bootstrapTable('load', groups);
                            $("#modal-adminGroups #idGroup").val("");
                            $("#modal-adminGroups #name").val("");
			                alert ('The group was successfully created');
                        });
                    }else{

                        alert("Error trying to save the group. Please check the group information and try againg.");
                        $('#modal-adminGroups #table-groupsDashboard').bootstrapTable('load', groups);
                        $("#modal-adminGroups #idGroup").val("");
                        $("#modal-adminGroups #name").val("");
                    }

                    }
                    
                   
					//**************FILTER DASHBOARD*******************
					if (filter === 0) {
						appuser		= $(".modal-body #new-techId").val();
						VALOR   	= '';
						<?php if ($profile == 'TECH'): ?>
							VALOR 	= appuser;
						<?php endif;?>

						reloadDashboard(VALOR, 'common/ws.php');
					} else {
						iduser		= $("#modal-filter #techId").val();
						startdate	= $("#modal-filter #startdate").val();
						enddate		= $("#modal-filter #enddate").val();
						jobnumber	= $("#modal-filter #jobnumber").val();
						keyword		= $("#modal-filter #keyword").val();
						URL			= "common/dashboard_search.php";
						DATA		= null;
						VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
						reloadDashboard(VALOR, 'common/dashboard_search.php');
					}

                });

            });

    		// Admin Users
    		$( "#adminUsers" ).click(function(){

                $('#modal-adminUsers #table-userDashboard').bootstrapTable("destroy");

                idusertype  = "";
                rol         = "";
                status      = "A";
    			phoneNum 	= "%";
                URL         = "common/users_list.php";
                VALOR       = idusertype + "|" + rol + "|" + status + "|" + phoneNum;
                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                    users = data;
    				//console.log(users);

                    $('#modal-adminUsers #table-userDashboard').bootstrapTable({
                        data: users,
                        striped: true,
                        columns:
                        [
                            [
                                {
                                    field: 'iduser',
                                    title: '<font color="#009207">*</font> Id User:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                },
                                {
                                    field: 'surname',
                                    title: 'Name:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                },
                                {
                                    field: 'lastname',
                                    title: 'Last Name:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }/*,
                                {
                                    field: 'password',
                                    title: 'Password:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                }*/,
                                {
                                    field: 'idusertype',
                                    title: 'Type:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                },
                                {
                                    field: 'status',
                                    title: 'Status:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                },
                                {
                                    field: 'rol',
                                    title: 'Rol:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                },
                                {
                                    field: 'rolname',
                                    title: 'Rol Name:',
                                    align: 'center',
                                    valign: 'middle',
    								visible: false,
                                    width: 1
                                },
                                /*{
                                    field: 'idgroup',
                                    title: 'Msg group:',
                                    align: 'center',
                                    valign: 'middle',
    								visible: false,
                                    width: 1
                                },
                                {
                                    field: 'groupname',
                                    title: 'Msg group:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1
                                },*/
    							{
    								field: 'groups',
                                    title: 'Groups:',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
    								formatter: function(data2){
    									var obj = JSON.parse(data2)
    									var lgroups = "";
    									if (obj == null)
    										obj = "";
    									for (i in obj)
    										{
    										  lgroups = lgroups + obj[i].name + "<br />";
    										}
    									return lgroups;
    								}
    							},
                                {
                                    field: 'edit',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value){
                                        return '<a class=""><span class="fa fa-pencil" aria-hidden="true"></span></a>';
                                    }
                                },
                                {
                                    field: 'delete',
                                    title: '',
                                    align: 'center',
                                    valign: 'middle',
                                    width: 1,
                                    clickToSelect: false,
                                    formatter : function(value){
                                        return '<a class=""><span class="fa fa-trash" aria-hidden="true"></span></a>';
                                    }
                                }
                            ]
                        ],
                        onClickCell: function (field, value, row){

                            if(field === "edit"){

    							$("#modal-adminUsers #idUser").attr('disabled',true);
    							URL         = "common/lookupUsertype.php";
                                call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                                    userTypes = data;
                                    $("#modal-adminUsers #idUserType").empty();
                                    var optionsUserTypes = $("#modal-adminUsers #idUserType");
                                    $.each(userTypes, function(){
                                        optionsUserTypes.append($("<option />").val(this.idusertype).text(this.typename));
                                    });

                                    URL         = "common/lookupUserrol.php";
                                    call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                                        userRoles = data;
                                        $("#modal-adminUsers #idRol").empty();
                                        var optionsUserTypes = $("#modal-adminUsers #idRol");
                                        $.each(userRoles, function()
                                        {
                                            optionsUserTypes.append($("<option />").val(this.idrol).text(this.name));
                                        });

                                        $("#modal-adminUsers #idUserType").val(row.idusertype);
                                        $("#modal-adminUsers #idRol").val(row.rol);

                                    });

    								// Loading group list

    								URL             = "common/getGroups.php";
    								VALOR           = null;

    								call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
    									groups = data['GROUPS'];
    									$("#modal-adminUsers #idGroup").empty();

    									var optionsGroups = $("#modal-adminUsers #idGroup");
                                        console.log(optionsGroups);
    									optionsGroups.append($("<option />").val("").text("-- None selected --"));
    									$.each(groups, function(){
    										optionsGroups.append($("<option />").val(this.idgroup).text(this.name));

    									});

    									// ID: Get current group
    									var obje = JSON.parse(row.groups);

    									var egroups = "";
    									if (obje == null)
    										obje = "";

    									var egroups = new Array();
                                        egroups.push(obje); //Issue cuando no tiene grupo seleccionado
    									for (i in obje)
    									{
    										egroups.push(obje[i].idgroup);
    									}
    										optionsGroups.val(egroups);
    									// ID: END
    								});
                                });

                                $("#modal-adminUsers #idUser").val(row.iduser);
                                $("#modal-adminUsers #surName").val(row.surname);
                                $("#modal-adminUsers #lastName").val(row.lastname);
                                $("#modal-adminUsers #password").val(row.password);
                                $("#modal-adminUsers #idUserType").val(row.idusertype);
                                $("#modal-adminUsers #idRol").val(row.rol);
    							$("#modal-adminUsers #phonenum").val(row.phonenum);
    							//$("#modal-adminUsers #idGroup").val(row.idgroup);
                                //appuser     = $("#modal-adminUsers #techId").val();

                                $("#modal-adminUsers #buttonAddUser").css("display", "none");
                                $("#modal-adminUsers #buttonEditUser").css("display", "block");
                                $("#modal-adminUsers #buttonCancelEdit").css("display", "block");

                            }else if(field === "delete"){

    							$('#modal-deluser').modal('show');
    							$("#modal-deluser #titulo").text("Do you want to delete user " + row.iduser + "?");
    							$("#modal-deluser #deluser-techId").val(row.iduser);
    							$("#modal-deluser #iduser").val(row.iduser);


    							$("#modal-deluser #buttonDeleteUser").click(function(){

    								iduser      = $("#modal-deluser #iduser").val();
    								appuser     = $("#modal-deluser #deluser-techId").val();
    								URL         = "common/users_delete.php";
    								VALOR       = iduser + "|" + appuser;

    								call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

    									idusertype  = "";
    									rol         = "";
    									status      = "A";
    									phoneNum 	= "%";
    									URL         = "common/users_list.php";
    									VALOR       = idusertype + "|" + rol + "|" + status + "|" + phoneNum;

    									call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
    										users = data;
    										$('#modal-adminUsers #table-userDashboard').bootstrapTable('load', users);
    									});

    								});
    					            $('#modal-deluser').modal('hide');

    							}); /* Delete user end */
                            }
                        }
                    });
                });

    			URL         = "common/lookupUsertype.php";
    			call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
    				userTypes = data;

                    $("#modal-adminUsers #idUserType").empty();
    				var optionsUserTypes = $("#modal-adminUsers #idUserType");

                    $.each(userTypes, function(){
    					optionsUserTypes.append($("<option />").val(this.idusertype).text(this.typename));
    				});


    				URL         = "common/lookupUserrol.php";
    				call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
    					userRoles = data;
    					//console.log(userRoles);
    					$("#modal-adminUsers #idRol").empty();
    					var optionsUserTypes = $("#modal-adminUsers #idRol");
    					$.each(userRoles, function(){
    						optionsUserTypes.append($("<option />").val(this.idrol).text(this.name));
    					});
    				});

                    // Loading group list

    				DATA 		= null;
    				URL             = "common/getGroups.php";
    				VALOR           = null;
    				call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
    					groups = data['GROUPS'];
    					//console.log(groups);
    					$("#modal-adminUsers #idGroup").empty();
    					var optionsGroups = $("#modal-adminUsers #idGroup");
    					optionsGroups.append($("<option />").val("").text("-- None selected --"));
    					$.each(groups, function(){
    						optionsGroups.append($("<option />").val(this.idgroup).text(this.name));
    					});
    					optionsGroups.val("");
    				});
    			});

                $('#modal-adminUsers').modal('show');
    			//**************FILTER DASHBOARD*******************
    			if (filter === 0) {
    				appuser		= $(".modal-body #new-techId").val();
    				VALOR   	= '';
    				<?php if ($profile == 'TECH'): ?>
    					VALOR 	= appuser;
    				<?php endif;?>

    				reloadDashboard(VALOR, 'common/ws.php');
    			} else {
    				iduser		= $("#modal-filter #techId").val();
    				startdate	= $("#modal-filter #startdate").val();
    				enddate		= $("#modal-filter #enddate").val();
    				jobnumber	= $("#modal-filter #jobnumber").val();
    				keyword		= $("#modal-filter #keyword").val();
    				URL			= "common/dashboard_search.php";
    				DATA		= null;
    				VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
    				reloadDashboard(VALOR, 'common/dashboard_search.php');
    			}

            });

            $("#modal-adminUsers #buttonAddUser").click(function(){

                iduser      = $("#modal-adminUsers #idUser").val();
                surname     = $("#modal-adminUsers #surName").val();
                lastname    = $("#modal-adminUsers #lastName").val();
                password    = $("#modal-adminUsers #password").val();
                idusertype  = $("#modal-adminUsers #idUserType").val();
                appuser     = $("#modal-adminUsers #adminu-techId").val();
                idrol       = $("#modal-adminUsers #idRol").val();
				phonenum    = $("#modal-adminUsers #phonenum").val();

				// ID 2017-09-05 Multiple Groups ADD
				var groups = $('select#idGroup').val();

				if (phonenum == "" && groups != "" && groups != undefined) {
					alert('To be a part of a group, you must have phone number.');
				}else{

					URL         = "common/users_insert.php";
					METODO      = "";
					VALOR       = iduser + "|" + surname + "|" + lastname + "|" + password + "|" + idusertype + "|" + appuser + "|" + idrol  + "|" + phonenum + "|" + groups;
					call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

						DATA = data;
						if (DATA[0].RESULTADO === "0000"){

							idusertype  = "";
							rol         = "";
							status      = "A";
							phoneNum 	= "%";
							URL         = "common/users_list.php";
							VALOR       = idusertype + "|" + rol + "|" + status + "|" + phoneNum;

							call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

								users = data;
								$('#modal-adminUsers #table-userDashboard').bootstrapTable('load', users);
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

							alert("The user was successfully created.");

                        }else{
                            if (DATA[0].RESULTADO === "23505"){
                                alert("Error trying to save the user. The login alredy exists in the database. Please use a different user name.");
                            }
                            else
                            {
                                alert("Error trying to save the user. Please check the user information and try againg.");
                            }


							$("#modal-adminUsers #idUser").val("");
							$("#modal-adminUsers #surName").val("");
							$("#modal-adminUsers #lastName").val("");
							$("#modal-adminUsers #password").val("");
							$("#modal-adminUsers #idUserType").val("");
							//$("#modal-adminUsers #adminu-techId").val("");
							$("#modal-adminUsers #idRol").val("");
							$("#modal-adminUsers #phonenum").val("");
							$("#modal-adminUsers #idGroup").val("");



						}
						//**************FILTER DASHBOARD*******************
						if (filter === 0) {
							appuser		= $(".modal-body #new-techId").val();
							VALOR   	= '';
							<?php if ($profile == 'TECH'): ?>
								VALOR 	= appuser;
							<?php endif;?>

							reloadDashboard(VALOR, 'common/ws.php');
						} else {
							iduser		= $("#modal-filter #techId").val();
							startdate	= $("#modal-filter #startdate").val();
							enddate		= $("#modal-filter #enddate").val();
							jobnumber	= $("#modal-filter #jobnumber").val();
							keyword		= $("#modal-filter #keyword").val();
							URL			= "common/dashboard_search.php";
							DATA		= null;
							VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
							reloadDashboard(VALOR, 'common/dashboard_search.php');
						}

					});
				}
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

            $("#modal-adminUsers #buttonEditUser").click(function(){

                iduser      = $("#modal-adminUsers #idUser").val();
                surname     = $("#modal-adminUsers #surName").val();
                lastname    = $("#modal-adminUsers #lastName").val();
                password    = $("#modal-adminUsers #password").val();
                idusertype  = $("#modal-adminUsers #idUserType").val();
                appuser     = $("#modal-adminUsers #adminu-techId").val();
                idrol       = $("#modal-adminUsers #idRol").val();
				phonenum    = $("#modal-adminUsers #phonenum").val();
				idgroup		= $("#modal-adminUsers #idGroup").val();

				// ID 2017-09-05 Multiple Groups ADD
				var groups = $('select#idGroup').val();
                URL         = "common/users_update.php";
                METODO      = "";
                VALOR       = iduser + "|" + surname + "|" + lastname + "|" + password + "|" + idusertype + "|" + appuser + "|" + idrol + "|" + phonenum + "|" + idgroup;

				if (phonenum == "" && groups != "" && groups != undefined) {
					alert('To be a part of a group, you must have phone number.');
				}else{
					call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
                        DATA = data;
                        if (DATA[0].RESULTADO === "0000"){

                            idusertype  = "";
							rol         = "";
							status      = "A";
							phoneNum 	= "%";
							URL         = "common/users_list.php";
							VALOR       = idusertype + "|" + rol + "|" + status + "|" + phoneNum;
                            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

                                users = data;
                                $('#modal-adminUsers #table-userDashboard').bootstrapTable('load', users);
                                $("#modal-adminUsers #idUser").val("");
                                $("#modal-adminUsers #surName").val("");
                                $("#modal-adminUsers #lastName").val("");
                                $("#modal-adminUsers #password").val("");
                                $("#modal-adminUsers #idUserType").val("");
                                //$("#modal-adminUsers #adminu-techId").val("");
                                $("#modal-adminUsers #idRol").val("");
								$("#modal-adminUsers #phonenum").val("");
								$("#modal-adminUsers #idGroup").val("");

                                $("#modal-adminUsers #buttonAddUser").css("display", "block");
                                $("#modal-adminUsers #buttonEditUser").css("display", "none");
                                $("#modal-adminUsers #buttonCancelEdit").css("display", "none");
                            });

                        }else{
                            alert("Error trying to save the user. Please check the user information and try againg.");
                        }

						//**************FILTER DASHBOARD*******************
						if (filter === 0) {
							appuser		= $(".modal-body #new-techId").val();
							VALOR   	= '';
							<?php if ($profile == 'TECH'): ?>
								VALOR 	= appuser;
							<?php endif;?>
							reloadDashboard(VALOR, 'common/ws.php');
						} else {
							iduser		= $("#modal-filter #techId").val();
							startdate	= $("#modal-filter #startdate").val();
							enddate		= $("#modal-filter #enddate").val();
							jobnumber	= $("#modal-filter #jobnumber").val();
							keyword		= $("#modal-filter #keyword").val();
							URL			= "common/dashboard_search.php";
							DATA		= null;
							VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
							reloadDashboard(VALOR, 'common/dashboard_search.php');
						}
						$("#modal-adminUsers #idUser").attr('disabled',false);

                    });
                }
            });

			$(document).on('click', '#specialist li a', function (e){
				idspecialist = $(this).attr('data-iduser');
				$("#modal-assign #titulo").text("Do you want to assign the request to " + $(this).attr('data-fullname') + "? ");
				$("#modal-assign #buttonAssignPartsRequesition").prop('disabled', false);
				e.preventDefault();
			});

        });

		function reloadDashboard(paramVALOR, paramUrl) {
			URL 	= paramUrl;
			DATA 	= null;
			VALOR 	= paramVALOR;
			iduser =  '<?php echo $techId; ?>';

			if ( iduser  === null||iduser === "") {
				//console.log('Your session expire');
				window.location.replace("http://reqparts.bdicalgary.com/BrandellDiesel/index.php");

            }else{
				//console.log ('Reload iduser:'|| iduser );
				call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
					dashboard_data = data;
					$('#table-dashboard').bootstrapTable('load', dashboard_data);
				});
			}
		}

        function sleep(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds){break;}
            }
		}

		function sendPDF (){

            techName       	= $("#modal-view #view-techname").text();
			idrequest       = $("#modal-view #idRequest").val();
            jobnumber       = $("#modal-view #view-ro").text();
            appuser         = $("#modal-view #techId").val();

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
            partsJSON   = JSON.stringify(parts);

			rederizsoftReady('A','#partsRequesition', 'common/sendMail.php?vRo='+encodeURIComponent(ro)+'&vtechName='+encodeURIComponent(techName)+'&vPriority='+encodeURIComponent(vPriority)+'&vType='+encodeURIComponent(vType)+'&vVin='+encodeURIComponent(vin)+'&vComments='+encodeURIComponent(comments)+'&vpartsJSON='+encodeURIComponent(partsJSON)+'&vDate='+encodeURIComponent(requestdate)+'&vEngine='+encodeURIComponent(engine)+'&vID='+encodeURIComponent(idrequest)+'&vStatus=', '#cargar_data_edit', 'consultar');
            /*METODO          = partsJSON;
            VALOR           = idrequest + "|" + jobnumber + "|" + appuser + "|" + idrequesttype + "|" + idpriority + "|" + ro + "|" + vin + "|" + trans + "|" + engine + "|" + comments;
            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data)
            {
                DATA = data;*/

                $('#modal-view').modal('hide');
				//**************FILTER DASHBOARD*******************
				if (filter === 0) {
					appuser		= $(".modal-body #new-techId").val();
					VALOR   	= '';
					<?php if ($profile == 'TECH'): ?>
						VALOR 	= appuser;
					<?php endif;?>

					reloadDashboard(VALOR, 'common/ws.php');
				} else {
					iduser		= $("#modal-filter #techId").val();
					startdate	= $("#modal-filter #startdate").val();
					enddate		= $("#modal-filter #enddate").val();
					jobnumber	= $("#modal-filter #jobnumber").val();
					keyword		= $("#modal-filter #keyword").val();
					URL		= "common/dashboard_search.php";
					DATA		= null;
					VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
					reloadDashboard(VALOR, 'common/dashboard_search.php');
				}
				//alert('Your PDF has been sent');
            //});
        }

		function dashboardCSV(){

            iduser          = $("#modal-filter #techId").val();
            startdate       = $("#modal-filter #startdate").val();
            enddate         = $("#modal-filter #enddate").val();
            jobnumber       = $("#modal-filter #jobnumber").val();
			keyword       	= $("#modal-filter #keyword").val();
            URL             = "common/dashboard_excel.php";
            DATA            = null;
            VALOR           = iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
            call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){

                filter = 1;
                dashboard_data = data;
				downloadCSV({ data: dashboard_data, filename: "dashboard.csv" });

				//**************FILTER DASHBOARD******************* ISKAR
				if (filter === 0) {
					appuser		= $(".modal-body #new-techId").val();
					VALOR   	= '';
					<?php if ($profile == 'TECH'): ?>
						VALOR 	= appuser;
					<?php endif;?>

					reloadDashboard(VALOR, 'common/ws.php');
				} else {
					iduser		= $("#modal-filter #techId").val();
					startdate	= $("#modal-filter #startdate").val();
					enddate		= $("#modal-filter #enddate").val();
					jobnumber	= $("#modal-filter #jobnumber").val();
					keyword		= $("#modal-filter #keyword").val();
					URL		= "common/dashboard_search.php";
					DATA		= null;
					VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
					reloadDashboard(VALOR, 'common/dashboard_search.php');
				}


            });
        };

		function dashboardPDF (action){

            iduser          = $("#modal-filter #techId").val();
            startdate       = $("#modal-filter #startdate").val();
            enddate         = $("#modal-filter #enddate").val();
            jobnumber       = $("#modal-filter #jobnumber").val();
			keyword       	= $("#modal-filter #keyword").val();
			loguser			= "<?php echo $techId; ?>";
            URL             = "common/dashboard_pdf.php";
            DATA            = null;
            VALOR           = iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword + "|" + loguser + "|" + action;
			VALOR			= encodeURIComponent(VALOR);

			if (action == 'view'){

				window.open (URL+"?v=" + VALOR );
				//**************FILTER DASHBOARD******************* ISKAR
				if (filter === 0) {
					appuser		= $(".modal-body #new-techId").val();
					VALOR   	= '';
					<?php if ($profile == 'TECH'): ?>
						VALOR 	= appuser;
					<?php endif;?>

					reloadDashboard(VALOR, 'common/ws.php');
				}else{
					iduser		= $("#modal-filter #techId").val();
					startdate	= $("#modal-filter #startdate").val();
					enddate		= $("#modal-filter #enddate").val();
					jobnumber	= $("#modal-filter #jobnumber").val();
					keyword		= $("#modal-filter #keyword").val();
					URL		= "common/dashboard_search.php";
					DATA		= null;
					VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
					reloadDashboard(VALOR, 'common/dashboard_search.php');
				}

			}else{
				call_Ajax_Jsonp(URL, METODO, VALOR, LOADER, ERROR, function(data){
					printJS('PDF/dashboard_'+ loguser +'.pdf');
				});
			}

			//**************FILTER DASHBOARD******************* ISKAR
			if (filter === 0) {
				appuser		= $(".modal-body #new-techId").val();
				VALOR   	= '';
				<?php if ($profile == 'TECH'): ?>
					VALOR 	= appuser;
				<?php endif;?>
				reloadDashboard(VALOR, 'common/ws.php');
			} else {
				iduser		= $("#modal-filter #techId").val();
				startdate	= $("#modal-filter #startdate").val();
				enddate		= $("#modal-filter #enddate").val();
				jobnumber	= $("#modal-filter #jobnumber").val();
				keyword		= $("#modal-filter #keyword").val();
				URL		= "common/dashboard_search.php";
				DATA		= null;
				VALOR		= iduser + "|" + startdate + "|" + enddate + "|" + jobnumber + "|" + keyword;
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

			}else if(e.which) {
				tecla = e.which;

			}else {
				return true;
			}

			if((tecla >= "67") && (tecla <= "622")){
				return false;
			}
		}

		function printpdf(){

			idrequest       = $("#modal-view #idRequest").val();
            jobnumber       = $("#modal-view #view-ro").text();
			printJS('PDF/request_'+ jobnumber +'_'+ idrequest +'.pdf');
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

		function downloadCSV(args) {
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
				}else{
					return true;
				}
			}else{
				return true; //if date is empty returns true too
			}
		}


		function difDates(f1,f2, maxtop){

			if (f1 == '' || f2=='')
				return true;
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
        $(document).ready(console.log(parts));

        $('.input-number').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });

        $('.dateofdelivery').keypress(function(evt){
                event.preventDefault();
        });
        

    </script>