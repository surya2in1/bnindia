"use strict"; 
var table = $('#group_members_table'); 
var KTDatatablesDataSourceAjaxServer = function() {
	var payment_form = function () {
		var showErrorMsg = function(form, type, msg) {
	        var alert = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">\
				<div class="alert-text">'+msg+'</div>\
				<div class="alert-close">\
	                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
	            </div>\
			</div>');

	        form.find('.alert').remove(); 
	        KTUtil.animateClass(alert[0], 'fadeIn animated'); 
	    }
	    $('#submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
	        form.validate({
	     		// define validation rules
	            rules: {
	                group_number: {
	                        required: true,
	                        maxlength : 100
	                },
	                chit_amount: {
	                        required: true,
	                        number:true,
	                        max : 100000000,
	                        min:1
	                },
	                total_number: {
	                        required: true,
	                        number:true,
	                        max : 100000000,
	                        min:1
	                },
	                premium: {
	                        required: true,
	                        number:true,
	                        max : 100000000,
	                        min:1
	                },
	                gov_reg_no: {
	                        required: true,
	                        maxlength : 100
	                },
	                no_of_months: {
	                        required: true,
	                        number:true,
	                        max : 100000,
	                        min:1
	                },
	                date:{
	                	required:true
	                }
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
                url: 'group_form/'+$('#id').val(),
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
                    	if(response == 'group_number_unique'){
                    		err= "Group number is duplicate, please change group number."
                    	}
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
			// initTable1();  
			payment_form();
		},

	};
}();	

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();  
	getInstalmentNo();
});

//Show groups after select member
$('#groups').change(function(e) {
	//get selected member id
	var group_id = $(this).val(); 
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
            	// var member_options = '';
            	if(result !=''){
            		if((result.group_members)!=''){
	            		$.each(result.group_members, function( key, value ) { 
						  member_options += '<option value="'+key+'">'+value+'</option>';
						});
            		}
            	} 
            	$('#members').html(member_options);
            }
		}); 
});

$('#received_by').change(function(e) {
	var received_by = $(this).val();
	$('.rec-by-div').addClass('hide-div');
	if(received_by == 1){ 
		$('.cash-div').removeClass('hide-div');
	}else if(received_by == 2){
		$('.cheque-div').removeClass('hide-div');
	}else if(received_by == 3){
		$('.direct-debit-div').removeClass('hide-div');
	}
});

//Show installment no.s after select group and member
function getInstalmentNo(){
	//get selected member id
	var group_id = $('#groups').val(); 
	var member_id = $('#members').val(); 
	var instalment_nos_options = '<option value="">Select Instalment No</option>';
	if(group_id == '' || member_id == ''){
        $('#instalment_no').html(instalment_nos_options);
        return false;
    } 
	$('.bnspinner-member').removeClass('hide');
	$.ajax({
		   "url": $('#router_url').val()+"Payments/getInstalmentNo",
            "type": "POST",
            "data": {"group_id":group_id,"member_id":member_id}
        			,
            beforeSend: function (xhr) { // Add this line
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(response, status, xhr, $form) {
            	$('.bnspinner-member').addClass('hide');
            	var result = JSON.parse(response); 
            	if(result !=''){ 
	            		$.each(result, function( key, value ) { 
						  instalment_nos_options += '<option value="'+value.auction_no+'" data-id="'+value.id+'">'+value.auction_no+'</option>';
						}); 
            	} 
            	$('#instalment_no').html(instalment_nos_options);
            }
		}); 
}

function getRemaingPayments(){
	var auction_id = $('#instalment_no').find(':selected').attr('data-id');
	 if(auction_id == ''){ 
        return false;
    } 
	$('.bnspinner-instalment').removeClass('hide');
	$.ajax({
		   "url": $('#router_url').val()+"Payments/getPaymentsInfo",
            "type": "POST",
            "data": {"auction_id":auction_id}
        			,
            beforeSend: function (xhr) { // Add this line
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(response, status, xhr, $form) {
            	$('.bnspinner-instalment').addClass('hide');
            	var result = JSON.parse(response);  
            }
		}); 
}