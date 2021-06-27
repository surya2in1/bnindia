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
	                payment_head_id: {
	                        required: true, 
	                },
	                paid_to_name: {
	                        required: true 
	                },
	                total_amount:{
	                	required:true,
	                	number:true
	                },
	                gst:{
	                	required:true,
	                	number:true
	                },
	                less_tds:{
	                	required:true,
	                	number:true
	                },
	                total_amount_paid_rs:{
	                	required:true,
	                	number:true
	                },
	                cheque_transaction_no:{
	                	required:true,
	                	number:true
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
                url: 'other_payment_form/'+$('#id').val(),
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
                "url": $('#router_url').val()+"OtherPayments/index",
                "type": "POST", 
                beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
            },
            columns: [   
                {data: 'payment_head'},
                {data: 'date'},
                {data: 'paid_to_name'}, 
                {data: 'total_amount'}, 
                {data: 'gst'},
                {data: 'less_tds'},
                {data: 'total_amount_paid_rs'},
                {data: 'cheque_transaction_no'},
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
											<a href="other_payment_form/'+data+'" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-contract"></i>\
												<span class="kt-nav__link-text">Edit</span>\
											</a>\
										</li>\
										<li class="kt-nav__item">\
                							<a href="OtherPayments/view/'+data+'" class="kt-nav__link">\
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
});

$('.calc').change(function(e) {
         var sum = 0;
    	//iterate through each textboxes and add the values
    	$(".txt").each(function() {
       		//add only if the value is number
    		if(!isNaN(this.value) && this.value.length!==0) {
    			sum += parseFloat(this.value);
    		}
    
    	});
    	sum  = sum - parseFloat($('#less_tds').val());
    	//.toFixed() method will roundoff the final sum to 2 decimal places
    	$("#total_amount_paid_rs").val(sum.toFixed(2));
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
			   "url": $('#router_url').val()+"OtherPayments/deletePayment/"+payment_id,
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