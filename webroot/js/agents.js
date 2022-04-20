"use strict";
var table = $('#agents_table');
var KTDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {

		// begin first table
		table.DataTable({
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			"order": [[ 6, 'asc' ]],
			"ajax": {
	            "url": "Agents/index",
	            "type": "POST",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
	        },
			columns: [ 
			    {data:'agent_code'},
				{data: 'email'},
				{data: 'name'},
				{data: 'mobile_number'},
				{data: 'bank_name'},
				{data: 'account_no'},
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
											<a href="agent-form/'+data+'" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-contract"></i>\
												<span class="kt-nav__link-text">Edit</span>\
											</a>\
										</li>\
										<li class="kt-nav__item">\
                							<a href="agents/view/'+data+'" class="kt-nav__link">\
                								<i class="kt-nav__link-icon flaticon2-expand"></i>\
                								<span class="kt-nav__link-text">View</span>\
                							</a>\
                						</li>\
										<li class="kt-nav__item">\
											<a href="#" class="kt-nav__link" onclick="deleteagent('+data+');">\
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
					targets: -5,
					render: function(data, type, full, meta) {
						return  data.charAt(0).toUpperCase() + data.slice(1);
					},
				},
			],
		});
	};

	var agent_form = function () {
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
		
		$.validator.addMethod("letterswithspace", function(value, element) {
	    	   return this.optional(element) || /^[a-z][a-z\s]*$/i.test(value); 
           }, "Letters only please");
           

		 $('#submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
	        form.validate({
	     		// define validation rules
	            rules: { 
	                agent_code: {
	                    required: true,
	                    maxlength: 200
	                },
	                name: {
	                    required: true,
	                    letterswithspace: true,
	                    maxlength: 200
	                },
	                address:{
	                	required: true,
	                    maxlength: 500
	                },
	                mobile_number:{
	                	required: true,
	                    number: true,
	                    maxlength: 10,
	                    minlength:10
	                },
	                email: {
	                    required: true,
	                    maxlength: 100
	                },
	                address_proof: { required: '#check_upload_addr:blank',extension: "png|jpe?g" },
	                pan_card: { required: '#check_upload_pan:blank',extension: "png|jpe?g|pdf" },
	                photo: { required: '#check_upload_photo:blank',extension: "png|jpe?g|pdf" },
	                educational_proof: { required: '#check_upload_edu:blank',extension: "png|jpe?g|pdf" },
	                bank_name:{
	                	required: true,
	                    letterswithspace: true,
	                    maxlength: 500
	                },
	                account_no:{
	                    required: true,
                        number: true,
                        maxlength: 30,
                        minlength:1
	                },
	                ifsc_code:{
	                	required: true,
	                	maxlength: 100
	                }, 
                    branch_name:{
	                	required: true,
	                	maxlength: 100
	                }, 
	                bank_address:{
	                	required: true,
	                	maxlength: 100
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
	            messages: { 
	                address_proof: "File must be JPG, JPEG or PNG",
	                pan_card: "File must be JPG, JPEG or PNG",
	                photo: "File must be JPG, JPEG or PNG",
	                educational_proof: "File must be JPG, JPEG or PNG"
	            }, 
	        });
		//	var selected = $("#group_ids :selected").map((_,e) => e.value).get();
		//	form.append( 'group_ids',  selected);
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
		      
            form.ajaxSubmit({
                url: 'agent-form/'+$('#id').val(),
                type:'POST', 
                success: function(response, status, xhr, $form) {
                    if(response>0){
                    	var agent_code = $('#agent_code').val();
                    	swal.fire({
		                    "title": "",
		                    "text": "The agent "+agent_code+" has been saved successfully.",
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
			initTable1();
			agent_form();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();
});

function deleteuser(id){ 

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
			   "url": "Users/delete/"+id,
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
			                'The member has been deleted.',
			                'success'
			            );
                    }else{
                    	swal.fire(
			                'Cancelled',
			                'The member could not be deleted. Please, try again.',
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

function get_agent_code(id){
	var name = $('#name').val();
	$('#agent_code').val('');
	if(name.trim()){
		$('.bnspinner').removeClass('hide');
		$.ajax({
			   "url": $('#router_url').val()+"Agents/getAgentCode",
	            "type": "POST",
	            "type": "POST",
                "data": {"name":name,"id":id}
        			,
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function(response, status, xhr, $form) { 
                	$('.bnspinner').addClass('hide');
                	$('#agent_code').val(response);
                }
			}); 
	}
}

function deleteagent(agent_id){ 

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
			   "url": $('#router_url').val()+"Agents/deleteAgent/"+agent_id,
	            "type": "GET",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function(response, status, xhr, $form) {
                    if(response>0){
    					table.DataTable().ajax.reload();
                    	
                    	swal.fire(
			                'Deleted!',
			                'The agent has been deleted.',
			                'success'
			            );
                    }else{
                    	swal.fire(
			                'Cancelled',
			                'The agent could not be deleted. Please, try again.',
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