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
	                group_id: {
	                        required: true, 
	                },
	                user_id: {
	                        required: true, 
	                },
	                instalment_no: {
	                        required: true 
	                },
	                instalment_month: {
	                        required: true 
	                },
	                due_date:{
	                	required:true
	                },
	                date:{
	                	required:true
	                },
	                subscriber_ticket_no:{
	                	required:true,
	                	number:true
	                },
	                subscription_amount:{
	                	required:true,
	                	number:true
	                },
	                late_fee:{
	                	required:true,
	                	number:true
	                },
	                received_by:{
	                	required:true
	                }, 
	                cash_received_date: { required: function(element){
                            return $("#received_by option:selected").val() == 1;
                            }
            		},
            		cheque_no: { required: function(element){
                            return $("#received_by option:selected").val() == 2;
                            }
            		},
            		cheque_date: { required: function(element){
                            return $("#received_by option:selected").val() == 2;
                            }
            		},
            		cheque_bank_details: { required: function(element){
                            return $("#received_by option:selected").val() == 2;
                            }
            		},
            		cheque_drown_on: { required: function(element){
                            return $("#received_by option:selected").val() == 2;
                            }
            		},
            		direct_debit_date: { required: function(element){
                            return $("#received_by option:selected").val() == 3;
                            }
            		},
            		direct_debit_transaction_no: { required: function(element){
                            return $("#received_by option:selected").val() == 3;
                            }
            		},
            		remark:{
	                	required:true
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

function clear_fields(){
    $('#subscription_amount').val(''); 
    $('#late_fee').val(''); 
    $('#remark').val('');
    $('#instalment_month').val('');
    $('#total_amount').val('');
}
//Show groups after select member
$('#groups').change(function(e) {
	//get selected member id
	var group_id = $(this).val(); 
	var member_options = '<option value="">Select Member</option>';
	if(group_id == ''){
        $('#members').html(member_options);
        return false;
    }
    $('#due_date').val('');
    $('#subscriber_ticket_no').val('');
    clear_fields();
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
                    $('#due_date').val(result.groups.date);
                    $('#subscriber_ticket_no').val(result.ticket_no);
                    
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
    clear_fields();
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
    clear_fields();
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
            	var subscription_amount = result.net_subscription_amount;
            	var late_fee = result.late_fee;
            	var remark = result.remark;
                var instalment_month = (result.instalment_month) ? result.instalment_month : 1;
                var total_amount = result.total_amount;
            	$('#subscription_amount').val(subscription_amount); 
            	$('#late_fee').val(late_fee); 
            	$('#remark').val(remark);
                $('#instalment_month').val(instalment_month);
                $('#total_amount').val(total_amount);
            }
		}); 
}