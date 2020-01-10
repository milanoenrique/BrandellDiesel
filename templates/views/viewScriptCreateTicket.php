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
            url: "common/mailticket.php",
            data: {
                "subject": $('#subject-ticket').val(),
                "comments": $('#ticket-comments').val()
            },
            dataType: "json",
            success: function (response) {
                
            }
        });
	$('#myModalCreateTicket').modal('hide');
    }
    
});
</script>