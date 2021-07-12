
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
	                date: {
	                        required: true 
	                },
	                group_id: {
	                        required: true, 
	                },
	                auction_id: {
	                        required: true 
	                },
	                auction_winner: {
	                        required: true, 
	                },
	                auction_date:{
	                	required:true
	                },
	                chit_amount:{
	                	required:true,
	                	number:true
	                },
	                foreman_commission:{
	                	required:true,
	                	number:true
	                },
	                total_subscriber_dividend:{
	                	required:true,
	                	number:true
	                },
	                gst:{
	                	required:true,
	                	number:true
	                },
	                total:{
	                	required:true,
	                	number:true
	                }, 
	                cheque_dd_no:{
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
                url: 'payment-voucher-form/'+$('#id').val(),
                type:'POST',
                // beforeSend: function (xhr) { // Add this line
                //     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                // },
                success: function(response, status, xhr, $form) {
                    if(response>0){
                        swal.fire({
                            "title": "",
                            "text": "The payment voucher has been saved successfully.",
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
            "order":'',
            //"order": [[ 0, 'asc' ]],
            "ajax": {
                "url": $('#router_url').val()+"PaymentVouchers/index",
                "type": "POST", 
                beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
            },
            columns: [   
                {data: 'date'},
                {data: 'member'},
                {data: 'resaon'},
                {data: 'group_code'},
                {data: 'auction_no'},  
                {data: 'total'},
                {data: 'gst'},
                {data: 'total_subscriber_dividend'}, 
                {data: 'cheque_dd_no'},
                {data: 'action', responsivePriority: -1},
            ], 
            columnDefs: [
				{
					targets: -1,
					title: 'Actions',
					orderable: false,
					render: function(data, type, full, meta) {
						return '\
							<div class="dropdown">\
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
									<i class="flaticon-more-1"></i>\
								</a>\
								<div class="dropdown-menu dropdown-menu-right">\
									<ul class="kt-nav">\
										<li class="kt-nav__item">\
											<a href="payment-voucher-form/'+data+'" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-contract"></i>\
												<span class="kt-nav__link-text">Edit</span>\
											</a>\
										</li>\
										<li class="kt-nav__item">\
                							<a href="PaymentVouchers/view/'+data+'" class="kt-nav__link">\
                								<i class="kt-nav__link-icon flaticon2-expand"></i>\
                								<span class="kt-nav__link-text">View</span>\
                							</a>\
                						</li>\
                						<li class="kt-nav__item">\
                							<a href="#" class="kt-nav__link" onclick="delete_payment('+data+');">\
                								<i class="kt-nav__link-icon flaticon2-trash"></i>\
                								<span class="kt-nav__link-text">Delete</span>\
                							</a>\
                						</li>\
									</ul>\
								</div>\
							</div>\
						';
						//Commented temparary
						
					},
				},
			],
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
    var payment_group_id = $('#payment_group_id').val(); 
    if(payment_group_id> 0){
        //alert('payment_group_id '+payment_group_id);
        $('#groups').trigger('change');  
    }
});

////////////////////////////////////////////////////////******************************************************************///////////////////////////////////////////////////////////
//Show auctions after select groups
$('#groups').change(function(e) {
	//get selected member id
	var group_id = $(this).val(); 
	var auction_options = '<option value="">Select Auction No</option>';
	$('.grbnspinner').removeClass('hide');
	$.ajax({
		   "url": $('#router_url').val()+"Payments/getAuctionsByGroupId",
            "type": "POST",
            "data": {
            			"group_id":group_id,"payment_voucher_id": $('#id').val()}
        			,
            beforeSend: function (xhr) { // Add this line
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(response, status, xhr, $form) {
            	$('.grbnspinner').addClass('hide');
            	var result = JSON.parse(response);
            	var payment_auction_id= $('#payment_auction_id').val();
            	if(result !=''){
            		$.each(result, function( key, value ) { 
            		    var selected='';
            		    if(payment_auction_id == key){
            		        selected='selected';
            		    }
                       auction_options += '<option value='+key+' '+selected+'>'+value+'</option>';
					});
            	} 
            	
            	$('#auction_id').html(auction_options);
            	if(payment_auction_id > 0){
            	    $('#auction_id').trigger('change');
            	}
            }
		}); 
});

//Show member after select auction
$('#auction_id').change(function(e) {
	//get selected member id
	var auction_id = $(this).val(); 
	var member_options = '<option value="">Select Member</option>';
	$('.bnspinner').removeClass('hide');
	$.ajax({
		   "url": $('#router_url').val()+"Payments/getAuctionDetails",
            "type": "POST",
            "data": {
            			"auction_id":auction_id}
        			,
            beforeSend: function (xhr) { // Add this line
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(response, status, xhr, $form) {
            	$('.bnspinner').addClass('hide');
            	var result = JSON.parse(response);
            	if(result !=''){
            	   $('#auction_winner').val(result.auction_winner);     
            	   $('#user_id').val(result.user.id); 
            	   var date = new Date(result.auction_date);
            	   $('#auction_date').val(result.auction_dt); 
            	   $('#chit_amount').val(result.chit_amount); 
            	   $('#foreman_commission').val(result.foreman_commission); 
            	   $('#total_subscriber_dividend').val(result.total_subscriber_dividend); 
            	   var total_members = (result.group.total_number) > 0 ?  result.group.total_number : 0;
            	   var gst =  parseFloat((parseFloat(result.chit_amount)*(18/100))/total_members).toFixed(2);
            	   $('#gst').val(gst); 
            	   var sum = 0;
            		//iterate through each textboxes and add the values
            		$(".txt").each(function() {
                   		//add only if the value is number
            			if(!isNaN(this.value) && this.value.length!==0) {
            				sum += parseFloat(this.value);
            			}
            
            		});
            		sum = parseFloat((result.chit_amount)) - sum;
            		//.toFixed() method will roundoff the final sum to 2 decimal places
            		$("#total").val(sum.toFixed(2));
            	} 
            }
		}); 
});

function delete_payment(payment_id){ 

	swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then(function(result){ 
        if (result.value) {
        	$.ajax({
			   "url": $('#router_url').val()+"PaymentVouchers/deletePayment/"+payment_id,
	            "type": "GET",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function(response, status, xhr, $form) {
                    if(response>0){
    					table.DataTable().ajax.reload();
                    	
                    	swal.fire(
			                'Deleted!',
			                'The payment has been deleted.',
			                'success'
			            );
                    }else{
                    	swal.fire(
			                'Cancelled',
			                'The payment could not be deleted. Please, try again.',
			                'error'
			            );                        
                    } 
                }
			}); 
            // result.dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
        } else if (result.dismiss === 'cancel') {
            swal.fire(
                'Cancelled',
                'Your data is safe :)',
                'error'
            )
        }
    });
} 