"use strict"; 
var table = $('#due_payment_table'); 
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
    
     var initTable1 = function() {
        var i =0;
        var group_id = $('#groups').val();
        var member_id = $('#members').val();

        // SUM PLUGIN
        jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
            return this.flatten().reduce( function ( a, b ) {
                 if ( typeof a === 'string' ) {
                    a = a.replace(/[^\d.-]/g, '') * 1;
                }
                if ( typeof b === 'string' ) {
                    b = b.replace(/[^\d.-]/g, '') * 1;
                } 
                return a + b;
            }, 0 );
        } );

        // begin first group_members_table
        table.DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            "order": [[ 0, 'asc' ]],
            "ajax": {
                "url": $('#router_url').val()+"Payments/getDuePayments/"+group_id+"/"+member_id,
                "type": "POST", 
                beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
            },
            columns: [   
                {data: 'auction_no'},
                {data: 'instalment_month'},
                {data: 'net_subscription_amount'}, 
                {data: 'due_amount'}, 
                {data: 'due_late_fee'},
                {data: 'total_amount'}
            ],  
            "fnDrawCallback": function() {
                var api = this.api()
                var json = api.ajax.json();  
                if(json.iTotalRecords > 0){
                    $('.due_payment_tfoot').removeClass('hide-div');
                    $(api.column(5).footer()).html('Total = '+json.total_due_amount);
                }else{
                    $('.due_payment_tfoot').addClass('hide-div');
                }
            }, 
            "footerCallback": function ( row, data, start, end, display ) {
                // console.log(row);
                // var api = this.api(),
                //         columns = [ 4]; // Add columns here
                    
                //     for (var i = 0; i < columns.length; i++) {
                //     $('tfoot th').eq(columns[i]).html('Total: ' + api.column(columns[i], {filter: 'applied'}).data().sum() + '<br>');
                //     // $('tfoot th').eq(columns[i]).append('Page: ' + api.column(columns[i], { filter: 'applied', page: 'current' }).data().sum());
                //   }
                
                // var api = this.api(), data;
     
                // converting to interger to find total
                // var intVal = function ( i ) {
                //     return typeof i === 'string' ?
                //         i.replace(/[\$,]/g, '')*1 :
                //         typeof i === 'number' ?
                //             i : 0;
                // };
     
                // computing column Total of the complete result 
                // var monTotal = api
                //     .column( 1 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return intVal(a) + intVal(b);
                //     }, 0 );
                    
                // var tueTotal = api
                //         .column( 2 )
                //         .data()
                //         .reduce( function (a, b) {
                //             return intVal(a) + intVal(b);
                //         }, 0 );
                        
                //     var wedTotal = api
                //         .column( 3 )
                //         .data()
                //         .reduce( function (a, b) {
                //             return intVal(a) + intVal(b);
                //         }, 0 );
                        
                //  var thuTotal = api
                //         .column( 4 )
                //         .data()
                //         .reduce( function (a, b) {
                //             return intVal(a) + intVal(b);
                //         }, 0 ); 

                // // Total over this page
                // var pageTotal = api
                //     .column( 4, { page: 'all'} )
                //     .data()
                //     .reduce( function (a, b) {
                //         return intVal(a) + intVal(b);
                //     }, 0 );
                    
                // // Update footer by showing the total with the reference of the column index 
                // $( api.column( 0 ).footer() ).html('Total');
                // $( api.column( 1 ).footer() ).html(monTotal);
                // $( api.column( 2 ).footer() ).html(tueTotal);
                // $( api.column( 3 ).footer() ).html(wedTotal);
                // $( api.column( 4 ).footer() ).html(thuTotal); 
                
                //  // Update footer
                // jQuery( api.column( 4 ).footer() ).html(
                //    // '$'+pageTotal +' ( $'+ total +' total)'
                //    pageTotal.toFixed( 2 )
                // );
            },
        }); 
    } 
 
	return {
		//main function to initiate the module
		init: function() {
			payment_form();
            initTable1();   
		},

	};
}();	

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();  
    var group_id = $('#groups').val(); 
    if(group_id> 0){
        $('#groups').trigger('change');  
    }
    if($('#received_by').val() >0){
        $('#received_by').trigger('change');  
    }
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
    $('#due_date').val(''); 
}
//Show groups after select member
$('#groups').change(function(e) {
	//get selected member id
	var group_id = $(this).val(); 
	var member_options = '<option value="">Select Member</option>';
    var instalment_nos_options = '<option value="">Select Instalment No</option>';
    table.DataTable().ajax.url($('#router_url').val()+"Payments/getDuePayments/0/0").load();
    $('#group_due_date').val('');
    $('#group_late_fee').val('');
    $('#subscriber_ticket_no').val('');
    clear_fields();
	if(group_id == ''){
        $('#members').html(member_options);
        $('#instalment_no').html(instalment_nos_options);
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
                var payment_member_id = $('#payment_member_id').val();
            	if(result !=''){
            		if((result.group_members)!=''){
	            		$.each(result.group_members, function( key, value ) { 
                            var selected = '';
                            if(payment_member_id == value.user_id){
                                selected = 'selected';
                            }
						  member_options += '<option value="'+value.user_id+'" '+selected+' data-ticket_no="'+value.ticket_no+'">'+value.name+'</option>';
						});
            		}
                    var auction_date = (result.groups.auctions) ? result.groups.auctions[0].auction_date : '';
                    $('#group_due_date').val(result.groups.date);
                    $('#group_late_fee').val(result.groups.late_fee);
            	} 
            	$('#members').html(member_options);
                 if(payment_member_id>0){
                    $('#members').trigger('change'); 
                 }
            }
		}); 
});

$('#received_by').change(function(e) {
	var received_by = $(this).val();
	$('.rec-by-div').addClass('hide-div');
    $('.rec-by-div').find(':input').each(function () {
         $(this).val('');
    });
	if(received_by == 2){
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
    $('#subscriber_ticket_no').val('');
	if(group_id == '' || member_id == ''){
        $('#instalment_no').html(instalment_nos_options);
        table.DataTable().ajax.url($('#router_url').val()+"Payments/getDuePayments/0/0").load();
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
                $('#subscriber_ticket_no').val($('#members').find(':selected').attr('data-ticket_no'));
            	var result = JSON.parse(response); 
                var payment_instalment_no = $('#payment_instalment_no').val();
            	if(result !=''){ 
	            		$.each(result, function( key, value ) { 
                            var selected = '';
                            if(payment_instalment_no == value.auction_no){
                                selected = 'selected';
                            }
						   instalment_nos_options += '<option value="'+value.auction_no+'" '+selected+' data-id="'+value.id+'" data-instalment_month="'+value.instalment_month+'"  data-due_late_fee="'+value.due_late_fee+'" data-due_date="'+value.due_date+'">'+value.auction_no+'</option>';
						}); 
            	} 
            	$('#instalment_no').html(instalment_nos_options);
                if(payment_instalment_no>0){
                    $('#instalment_no').trigger('change'); 
                }
            }
		}); 
        table.DataTable().ajax.url($('#router_url').val()+"Payments/getDuePayments/"+group_id+"/"+member_id).load();
}

function getRemaingPayments(){
	var auction_id = $('#instalment_no').find(':selected').attr('data-id');
    var user_id = $('#members').val(); 
    clear_fields();
	 if(auction_id == ''){ 
        return false;
    } 
	$('.bnspinner-instalment').removeClass('hide');
	$.ajax({
		   "url": $('#router_url').val()+"Payments/getPaymentsInfo",
            "type": "POST",
            "data": {"auction_id":auction_id,"user_id":user_id}
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
                var g_due_date = $('#group_due_date').val();
                var auction_date = (result.auction_date) ? (result.auction_date) :'';
                //var get_group_due_dt = create_date_from_day(g_due_date,auction_date);
                var get_group_due_dt = $('#instalment_no').find(':selected').data('due_date');
                $('#due_date').val(get_group_due_dt);
                var group_due_date = $('#due_date').val(); 
                var late_fee =$('#instalment_no').find(':selected').data('due_late_fee'); 
             	var remark = result.remark;
                var instalment_month = $('#instalment_no').find(':selected').data('instalment_month'); 
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
