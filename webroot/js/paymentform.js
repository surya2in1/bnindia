"use strict"; 
var table = $('#payment_table'); 
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
                            }, number:true
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
                            },number:true
            		},
            		remark:{
	                	required:true,number:true
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
                url: 'payment_form/'+$('#id').val(),
                type:'POST',
                // beforeSend: function (xhr) { // Add this line
                //     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                // },
                success: function(response, status, xhr, $form) {
                    if(response>0){
                        swal.fire({
                            "title": "",
                            "text": "The payment has been saved successfully.",
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary",
                            "onClose": function(e) {
                                 $('html, body').animate({
                                    scrollTop: $("#kt_content").offset().top
                                }, 1000);
                                console.log('on close event fired!');
                            }
                        });
                        // similate 2s delay
                        setTimeout(function() {
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
			payment_form();
		},

	};
}();	

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();  
	getInstalmentNo();
});

function clear_fields(){
    $('#subscription_amount').val('0.00'); 
    $('#late_fee').val('0.00'); 
    $('#remark').val('0.00');
    $('#instalment_month').val('');
    $('#total_amount').val('0.00');
    $('#net_subscription_amount').val('0.00');
    $('#pending_amount').val('0.00');
    $('#auction_id').val('0.00'); 
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
    $('#group_late_fee').val('');
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
                    var auction_date = (result.groups.auctions) ? result.groups.auctions[0].auction_date : '';
                    $('#due_date').val(create_date_from_day(result.groups.date,auction_date));
                    $('#subscriber_ticket_no').val(result.ticket_no);
                    $('#group_late_fee').val(result.groups.late_fee);
            	} 
            	$('#members').html(member_options);
            }
		}); 
});

$('#received_by').change(function(e) {
	var received_by = $(this).val();
	$('.rec-by-div').addClass('hide-div');
    $('.rec-by-div').find(':input').each(function () {
         $(this).val('');
    });
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
                var pending_amount = result.pending_amount;
            	var subscription_amount = result.net_subscription_amount;
                //If pending amount is remainging for selected instalment then set pending amount for subscription rs
                if(pending_amount > 0 ){
                     subscription_amount = pending_amount;
                }

                //Calculate late fee
                var group_late_fee = $('#group_late_fee').val();
                var group_due_date = $('#due_date').val(); 
                var late_fee =0;

                if(group_late_fee > 0 && group_due_date != ''){
                    var CurrentDate = new Date(); 
                    if(new Date(group_due_date) < CurrentDate){
                        late_fee = (parseFloat(result.net_subscription_amount) * parseFloat(group_late_fee))/100;
                     }
                }
                
            	var remark = result.remark;
                var instalment_month = (result.auction_date) ? get_month_name(result.auction_date) : '';
                var total_amount = parseFloat(subscription_amount) + late_fee;

                $('#instalment_month').val(instalment_month); 
            	$('#remark').val((remark > 0) ? remark : '0.00');
            	$('#subscription_amount').val(subscription_amount); 
            	$('#late_fee').val(late_fee.toFixed(2)); 
                $('#total_amount').val(total_amount.toFixed(2));
                $('#net_subscription_amount').val(result.net_subscription_amount); 
                $('#pending_amount').val(pending_amount); 
                $('#auction_id').val(result.id); 
                calculate_total_amount();
            }
		}); 
}
function create_date_from_day(day,auction_date){
    var now_dt = new Date(auction_date);
    var month = (now_dt.getMonth()+1) < 10 ? '0'+(now_dt.getMonth()+1) : (now_dt.getMonth()+1);
    var day =  (day <10 ) ? '0'+day : day; 
    return month+'/'+day+'/'+now_dt.getFullYear();
    // return new Date(now_dt.getFullYear(), now_dt.getMonth(), day);
}
function get_month_name(dt){
    var mlist = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
    return mlist[new Date(dt).getMonth()];
}

function calculate_total_amount(){
    var subscription_amount = $('#subscription_amount').val();
    var net_subscription_amount = $('#net_subscription_amount').val();
    var pending_amount = $('#pending_amount').val();
    var late_fee = $('#late_fee').val();
    var total_amount = parseFloat(subscription_amount) + parseFloat(late_fee);
    $('#total_amount').val(total_amount.toFixed(2));
    if(pending_amount > 0){ 
        var pending_amount = (parseFloat(pending_amount) - parseFloat(subscription_amount)).toFixed(2);
    }else{
        var pending_amount = (parseFloat(net_subscription_amount) - parseFloat(subscription_amount)).toFixed(2);
    }
    $('#remark').val(pending_amount);
}
