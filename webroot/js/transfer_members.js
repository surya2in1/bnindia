"use strict";
var table = $('#kt_table_1');
var KTDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {

		// begin first table
		table.DataTable({
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			"ajax": {
	            "url": $('#router_url').val()+"Users/transferMembers",
	            "type": "POST",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
	        },
			columns: [ 
			    {data:'gr_code_ticket'},
				{data: 'chit_amount'},
				{data: 'no_of_months'},
				{data: 'premium'},
				{data: 'ticket_no'},
				{data:'member'},
				{data: 'no_of_installments'},
				{data: 'total_amt_payable'},
				{data: 'total_dividend'},  
				{data: 'actions', responsivePriority: -1},
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
											<button type="button" class="hide btn btn-bold btn-label-brand btn-sm" data-toggle="modal" data-target="#tr_user_modal" user_id='+data+' group_id='+full.group_id+'>Launch Modal</button>\
											<a href="#tr_user_modal" class="kt-nav__link" data-toggle="modal" onclick="map_modal_data('+data+','+full.group_id+');" >\
										 		<i class="kt-nav__link-icon flaticon2-trash"></i>\
										 		<span class="kt-nav__link-text">Transfer User</span>\
										 	</a>\
										</li>\
									</ul>\
								</div>\
							</div>\
						'; 
					},
				},
			],
		});
	};
 	
 	var transfer_member_form = function (){
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
	                new_group_users_list: {
	                        required: true 
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
		    transfer_group_user();

            // form.ajaxSubmit({
            //     url:  $('#router_url').val()+"Users/transferGroupUser",
            //     type:'POST',
            //     // beforeSend: function (xhr) { // Add this line
            //     //     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            //     // },
            //     success: function(response, status, xhr, $form) {
            //         if(response>0){
            //             swal.fire({
            //                 "title": "",
            //                 "text": "The member has been transferd successfully.",
            //                 "type": "success",
            //                 "confirmButtonClass": "btn btn-secondary",
            //                 "onClose": function(e) {
            //                      $('html, body').animate({
            //                         scrollTop: $("#kt_content").offset().top
            //                     }, 1000);
            //                     console.log('on close event fired!');
            //                 }
            //             });

            //             // similate 2s delay
            //             setTimeout(function() {
            //             	$('#tr_modal_cl').trigger('click');
            //                 //window.location.reload();
            //             }, 2000); 

            //         }else{
            //         	var err = 'Some error has been occured. Please try again.'; 
            //         	// similate 2s delay
            //         	setTimeout(function() {
    	       //              btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
    	       //              showErrorMsg(form, 'danger', err);
            //             }, 2000);                        
            //         }
            //     	$('html, body').animate({
            //             scrollTop: "0"
            //         }, 2000);
            //     }
            // });	
		});
	}
	return {

		//main function to initiate the module
		init: function() {
			initTable1(); 
			transfer_member_form();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();
});
function map_modal_data(user_id,group_id){
	$('#user_id').val(user_id);
	$('#group_id').val(group_id);
	var new_group_users_list = '<option value="">Select Member</option>';
	$.ajax({
		   "url": $('#router_url').val()+"Users/getTransferGroupUser/"+user_id+"/"+group_id,
            "type": "GET",
            beforeSend: function (xhr) { // Add this line
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(response, status, xhr, $form) {
            	var result = JSON.parse(response);
                if(result){ 
					 $.each(result, function( key, value ) {  
					  new_group_users_list += '<option value="'+value.id+'">'+ucfirst(value.member)+'</option>';
					});
                } 
				$('#new_group_users_list').html(new_group_users_list);
            }
		}); 
}
function trigger_function(modal_id){
	$('#'+modal_id).trigger('click');
}
function transfer_group_user(){ 
	swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, transfer it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then(function(result){ 
        if (result.value) { 
        	$.ajax({
			   "url": $('#router_url').val()+"Users/transferGroupUser",
	            "type": "POST",
	            "data": $('#transfer_member_form').serialize(),
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function(response, status, xhr, $form) {
                    if(response>0){
    					table.DataTable().ajax.reload();
                    	
                    	swal.fire(
			                'Transferd!',
			                'The member has been transferd.',
			                'success'
			            );
			            $('#tr_modal_cl').trigger('click');
                    }else{
                    	swal.fire(
			                'Cancelled',
			                'The member could not be transferd. Please, try again.',
			                'error'
			            );   
    	                $('#submit').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
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
            $('#submit').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
        }
    });
} 
 
 function ucfirst(str){
    var str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    }); 
    return str;
}