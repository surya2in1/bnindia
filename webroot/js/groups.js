"use strict";
		var table = $('#group_table');
var KTDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {

		// begin first table
		table.DataTable({
			// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			"ajax": {
	            "url": "Groups/index",
	            "type": "POST",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
	        },
			columns: [
				{data: 'group_number'},
				{data: 'chit_amount'},
				{data: 'total_number'},
				{data: 'premium'},
				{data: 'gov_reg_no'},
				{data: 'date'},
				{data: 'no_of_months'},
				{data: 'status'},
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
											<a href="groups/view/'+data+'" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-expand"></i>\
												<span class="kt-nav__link-text">View</span>\
											</a>\
										</li>\
										<li class="kt-nav__item">\
											<a href="group_form/'+data+'" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-contract"></i>\
												<span class="kt-nav__link-text">Edit</span>\
											</a>\
										</li>\
										<li class="kt-nav__item">\
											<a href="#" class="kt-nav__link" onclick="deletegroup('+data+');">\
												<i class="kt-nav__link-icon flaticon2-trash"></i>\
												<span class="kt-nav__link-text">Delete</span>\
											</a>\
										</li>\
									</ul>\
								</div>\
							</div>\
						';

					},
				},
				{
					targets: -2,
					render: function(data, type, full, meta) {
						var 
						status = {
							2: {'title': 'Disable', 'state': 'primary'},
							1: {'title': 'Available', 'state': 'success'},
							0: {'title': 'Full', 'state': 'danger'}
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
							'<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
					},
				}
			],
		});

	};

	var group_form = function () {
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
			initTable1();
			group_form();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();
});
function deletegroup(id){ 

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
			   "url": "Groups/delete/"+id,
	            "type": "GET",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function(response, status, xhr, $form) {
                	if(response == 'group_associated_with_members'){
                		swal.fire(
			                'Cancelled',
			                'Sorry we can not be delete this group. This group is associated with members.',
			                'error'
			            );
                	}else if(response>0){
    					table.DataTable().ajax.reload();
                    	
                    	swal.fire(
			                'Deleted!',
			                'The group has been deleted.',
			                'success'
			            );
                    }else{
                    	swal.fire(
			                'Cancelled',
			                'The group could not be deleted. Please, try again.',
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

function calculate_premium(){
	var chit_amount = parseFloat($('#chit_amount').val());
	var total_member = parseInt($('#total_number').val());
	if(chit_amount > 0 && total_member > 0){
		var premium =  chit_amount/total_member;
		$('#premium').val(premium.toFixed(2));
	}else{
		$('#premium').val('');
	}
}