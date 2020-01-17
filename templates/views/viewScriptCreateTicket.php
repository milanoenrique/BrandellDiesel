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
					$('#table-ticketsupport').bootstrapTable('destroy');
    	        	$('#table-ticketsupport').bootstrapTable({
        	      		data:response,
            	   		striped:true,
                		columns:
                		[
							[
								{
									field: 'created_by',
									title: 'User',
									align: 'center',
									valign: 'middle',
									width: 1,
									
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
									field: 'subject',
									title: 'Subject',
									align: 'center',
									valign: 'middle',
									width: 1,
									formatter:function(value){
										let text ='<a href="#">'+value+'</a>';
										return text;
									}
								}, 
							
								
							]
						],
						onClickCell: function (field, value, row){
							if(field=='subject'){
								$('#myModalViewTicket').modal('show');
								$('#myModalViewTicket #subject-view-ticket').text(row.subject);
								$('#myModalViewTicket #view-ticket-comments').text(row.description);
							}
						}
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
            
			$('#table-ticketsupport').bootstrapTable('destroy');
            $('#table-ticketsupport').bootstrapTable({
                data:response,
                striped:true,
                columns:
                [
							[
								{
									field: 'created_by',
									title: 'User',
									align: 'center',
									valign: 'middle',
									width: 1,
									
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
									field: 'subject',
									title: 'Subject',
									align: 'center',
									valign: 'middle',
									width: 1,
									formatter:function(value){
										let text ='<a href="#">'+value+'</a>'
										return text;
									},
									
								}, 
							
							
							]

							
				],
				onClickCell: function (field, value, row){
					if(field=='subject'){
						if(field=='subject'){
							$('#myModalViewTicket').modal('show');
							$('#myModalViewTicket #subject-view-ticket').text(row.subject);
							$('#myModalViewTicket #view-ticket-comments').text(row.description);
						}
					}
				}
            }            
            );
        }
    });
});
</script>