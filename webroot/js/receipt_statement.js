 
var KTFormControls = function() {
 	var receipt_form = function () {
		    
	        $( "#receipt_form" ).validate({
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
            		user_id: { required: function(element){
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
                 //display error alert on form submit
                invalidHandler: function(event, validator) {
                    var alert = $('#user_profile_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTop();
                },
                invalidHandler: function(event, validator) {
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

                    event.preventDefault();
                },
                submitHandler: function (form) {
                     var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
                    loading.show(); 
                    form.submit(); // submit the form 
                    setTimeout(function() {
                         loading.hide(); 
                    }, 2000);   
                }
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
	KTFormControls.init();
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