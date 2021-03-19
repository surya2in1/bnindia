$('#members').change(function(e) {
	//get selected member id
	var member_id = $(this).val(); 
	$.ajax({
		   "url": $('#router_url').val()+"Payments/getGroupsByMemberId",
            "type": "POST",
            "data": {
            			"member_id":member_id}
        			,
            beforeSend: function (xhr) { // Add this line
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(response, status, xhr, $form) {
            	var group_options = '';
            	if(JSON.parse(response)!=''){
            		$.each(JSON.parse(response), function( key, value ) { 
					  group_options += '<option value="'+key+'">'+value+'</option>';
					});
            	} 
            	$('#groups').html(group_options);
            }
		}); 
});