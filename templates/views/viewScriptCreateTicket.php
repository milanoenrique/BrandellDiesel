<script>

$('#linkToTicketSupport').click(function () { 
    
    $('#myModalCreateTicket').modal('show');
    $('#subject-ticket').val('');
    $('#ticket-comments').val('');
});

$('#buttonSendTicket').click(function(){
    if($('#subject-ticket').val()==''||$('#ticket-comments').val()==''){
        alert('The field with * are required');
    }else{
		$.ajax({
            type: "post",
            url: "common/create_ticket.php",
            data: {
                "subject": $('#subject-ticket').val(),
                "comments": $('#ticket-comments').val()
            },
            dataType: "json",
            success: function (response) {
				$.ajax({
        		type: "get",
        		url: "common/list_ticketsupport.php",
        		dataType: "json",
        		success: function (response) {
            		console.log(response);
					$('#myModalCreateTicket').modal('hide');
					$('.nav.nav-tabs a[href=#tabticketsupport]').tab('show');
					
    	        	$('#table-ticketsupport').bootstrapTable({
        	      		data:response,
            	   		striped:true,
                		columns:
                		[
							[
								{
									field: 'subject',
									title: 'Subject',
									align: 'center',
									valign: 'middle',
									width: 1,
								}, 
								{
									field: 'description',
									title: 'Description',
									align: 'center',
									valign: 'middle',
									width: 1
								},
							
								{
									field: 'created_at',
									title: 'Date',
									align: 'center',
									valign: 'middle',
                                   	width: 1,
                                   	formatter:function(value){
                                       	var localDate = moment(value).local();
    									var Date = moment(value).format("MMM DD YYYY, hh:mm:ss a");
    									return Date;
                                   	}
								}, 
								{
									field: 'created_by',
									title: 'User',
									align: 'center',
									valign: 'middle',
									width: 1,
								}
								
							]
						]
            		});
					$.ajax({
						type: "post",
						url: "common/mailticket.php",
						
						data: {
							"subject": $('#subject-ticket').val(),
							"comments": $('#ticket-comments').val()
						},
						dataType: "json",
						success: function (response) {
							
						}
					});
        		}
    		});
	        }
        });
		

     
		
	
    }
    
});


$('#tab-ticketsupport').click(function(){
    $.ajax({
        type: "get",
        url: "common/list_ticketsupport.php",
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#table-ticketsupport').bootstrapTable({
                data:response,
                striped:true,
                columns:
                [
							[
								{
									field: 'subject',
									title: 'Subject',
									align: 'center',
									valign: 'middle',
									width: 1,
								}, 
								{
									field: 'description',
									title: 'Description',
									align: 'center',
									valign: 'middle',
									width: 1
								},
								
								{
									field: 'created_at',
									title: 'Date',
									align: 'center',
									valign: 'middle',
                                    width: 1,
                                    formatter:function(value){
                                        var localDate = moment(value).local();
    									var Date = moment(value).format("MMM DD YYYY, hh:mm:ss a");
    									return Date;
                                    }
								}, 
								{
									field: 'created_by',
									title: 'User',
									align: 'center',
									valign: 'middle',
									width: 1,
									   
                                
									
								}
								
							]

							
				]
            }            
            );
        }
    });
});
</script>