"use strict"; 
var KTDatatablesDataSourceAjaxServer = function() {
 	var receipt_form = function () {
		 var showErrorMsg = function(form, type, msg) {
	        var alert = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">\
				<div class="alert-text">'+msg+'</div>\
				<div class="alert-close">\
	                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
	            </div>\
			</div>');

	        form.find('.alert').remove();
	        alert.prependTo(form);
	        //alert.animateClass('fadeIn animated');
	        KTUtil.animateClass(alert[0], 'fadeIn animated');
	        alert.find('span').html(msg);
	    }
		 $('#submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
	        form.validate({
	     		// define validation rules
	            rules: {
	                search_by: {
	                        required: true, 
	                }, 
	                start:{
	                	required:true
	                }, 
	                end:{
	                	required:true
	                },
	                group_id: { required: function(element){
                            return ($("#search_by option:selected").val() == 'group_by' || $("#search_by option:selected").val() == 'member_by');
                            },  
            		},
            		members: { required: function(element){
                            return ($("#search_by option:selected").val() == 'member_by');
                            },
            		},
	            },
	            errorPlacement: function(error, element) {
	                var group = element.closest('.input-group');
	                if (group.length) {
	                    group.after(error.addClass('invalid-feedback'));
	                } else {
	                    element.after(error.addClass('invalid-feedback'));
	                }
	                 element.addClass('is-invalid');
	            },    
	        });
			
			if (!form.valid()) {
               swal.fire({
                    "title": "",
                    "text": "There are some errors in your submission. Please correct them.",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary",
                    "onClose": function(e) {
                         $('html, body').animate({
                            scrollTop: $("#kt_content").offset().top
                        }, 1000);
                        console.log('on close event fired!');
                    }
                });

	       		return;
            }	
            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);
		    // form.submit();
            form.ajaxSubmit({
                url: '/Reports/receiptStatement',
                type:'POST',
                // beforeSend: function (xhr) { // Add this line
                //     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                // },
                success: function(response, status, xhr, $form) {
                    if(response>0){
                        // similate 2s delay
                        setTimeout(function() {
                            btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                            showErrorMsg(form, 'success', 'The group has been saved successfully.');
                            window.location.reload();
                        }, 2000); 
                    }else{
                    	var err = 'Some error has been occured. Please try again.';
                    	 
                    	// similate 2s delay
                    	setTimeout(function() {
    	                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
    	                    showErrorMsg(form, 'danger', err);
                        }, 2000);                        
                    }
                	$('html, body').animate({
                        scrollTop: "0"
                    }, 2000);
                }
            });	
		});
    }
	return {

		//main function to initiate the module
		init: function() { 
			receipt_form();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();
});

function show_hide_type_div(){
	var search_by = $('#search_by').val();
	$('.search_by').addClass('hide-div'); 
	if(search_by == 'group_by' || search_by == 'member_by'){ 
		$('#group_id').val('');
	  	$('#group_div').removeClass('hide-div'); 
	} 
}

function show_members(){
	var search_by = $('#search_by').val();
	var group = $('#group_id').val();
	$('#member_div').addClass('hide-div'); 
	if(search_by == 'member_by' && group > 0){  
		$('#member_div').removeClass('hide-div');
	}
}
//Show groups after select member
$('#group_id').change(function(e) {

	//get selected member id
	var group_id = $(this).val(); 
	if($('#search_by').val() != 'member_by' ){
        return false;
    } 
	var member_options = '<option value="">Select Member</option>';
   
	if(group_id == ''){
        $('#members').html(member_options); 
        return false;
    }
	$('.bnspinner').removeClass('hide');
	$.ajax({
		   "url": $('#router_url').val()+"Payments/getMembersByGroupId",
            "type": "POST",
            "data": {
            			"group_id":group_id}
        			,
            beforeSend: function (xhr) { // Add this line
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(response, status, xhr, $form) {
            	$('.bnspinner').addClass('hide');
            	var result = JSON.parse(response);  
            	if(result !=''){
            		if((result.group_members)!=''){
	            		$.each(result.group_members, function( key, value ) {  
						  member_options += '<option value="'+value.user_id+'" data-ticket_no="'+value.ticket_no+'">'+value.name+'</option>';
						});
            		} 
            	} 
            	$('#members').html(member_options); 
            }
		}); 
});