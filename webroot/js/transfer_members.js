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
											<a href="member-form/'+data+'" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-contract"></i>\
												<span class="kt-nav__link-text">Transfer Member</span>\
											</a>\
										</li>\
									</ul>\
								</div>\
							</div>\
						';
						//Commented temparary
						// <li class="kt-nav__item">\
						// 	<a href="#" class="kt-nav__link" onclick="deleteuser('+data+');">\
						// 		<i class="kt-nav__link-icon flaticon2-trash"></i>\
						// 		<span class="kt-nav__link-text">Delete</span>\
						// 	</a>\
						// </li>\
					},
				},
			],
		});
	};

	var member_form = function () {
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
	    $.validator.addMethod("validateGroups", function(value, element) {
	    	  $('#group_ids').children().each(function(i, opt){ 
            		if($(opt).attr('disabled')){ 
            			$(opt).removeAttr('disabled');
            			$(opt).prop('selected',true);
            			value.push($(opt).val()); 
		            }
		      }); 
            return value != '' ;
           }, "This field is required.");
           
         $.validator.addMethod("minAge", function(value, element, min) {
		    var today = new Date();
		    var birthDate = new Date(value);
		    var age = today.getFullYear() - birthDate.getFullYear();

		    if (age > min+1) {
		        return true;
		    }

		    var m = today.getMonth() - birthDate.getMonth();

		    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
		        age--;
		    }

		    return age >= min;
		}, "You must be at least 18 years of age!");
		
		 $('#submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
	        form.validate({
	     		// define validation rules
	            rules: {
	                //= Client Information(step 3)
	                customer_id: {
	                    required: true,
	                    maxlength: 200
	                },
	                first_name: {
	                    required: true,
	                    lettersonly: true,
	                    maxlength: 200
	                },
	                middle_name: {
	                    required: true,
	                    lettersonly: true,
	                    maxlength: 100
	                },
	                last_name: {
	                    required: true,
	                    lettersonly: true,
	                    maxlength: 100
	                },
	                //'group_ids[]':{
	                	//required: true,
	                	//validateGroups : true
	                //},
	                address:{
	                    maxlength: 300
	                },
	                city:{
	                    lettersonly: true,
	                    maxlength: 50
	                },
	                state:{
	                    lettersonly: true,
	                    maxlength: 50
	                },
	                occupation:{
	                    lettersonly: true,
	                    maxlength: 50
	                },
	                income_amt:{
	                    number: true,
	                    maxlength: 15
	                },
	                mobile_number:{
	                    number: true,
	                    maxlength: 10,
	                    minlength:10
	                },
	                nominee_name:{
	                    lettersonly: true,
	                    maxlength: 50
	                },
	                nominee_relation:{
	                    lettersonly: true,
	                    maxlength: 50
	                },
	                profile_picture: { extension: "png|jpe?g" },
	                address_proof: { extension: "png|jpe?g|pdf" },
	                photo_proof: { extension: "png|jpe?g|pdf" },
	                other_document: { extension: "png|jpe?g|pdf" },
	                date_of_birth:{
	                	minAge: 18
	                },
	                area_code:{
                        number: true,
                        maxlength: 5,
                        minlength: 2
                    },
                    pin_code:{
                        required: true,
                        number: true,
                        maxlength: 6,
                        minlength:6
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
	            //display error alert on form submit
	            invalidHandler: function(event, validator) {
	                var alert = $('#user_profile_msg');
	                alert.removeClass('kt--hide').show();
	                KTUtil.scrollTop();
	            },
	            messages: { 
	                profile_picture: "File must be JPG, JPEG or PNG",
	                address_proof: "File must be JPG, JPEG or PNG",
	                photo_proof: "File must be JPG, JPEG or PNG",
	                other_document: "File must be JPG, JPEG or PNG"
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
		    
		 //    var formData = new FormData();
			// formData.append('profile_picture', $('#profile_picture')[0].files[0]);
			// formData.append('address_proof', $('#address_proof')[0].files[0]);
			// formData.append('photo_proof', $('#photo_proof')[0].files[0]);
			// formData.append('other_document', $('#other_document')[0].files[0]);

		    // form.submit();
            form.ajaxSubmit({
                url: 'member-form/'+$('#id').val(),
                type:'POST',
                // beforeSend: function (xhr) { // Add this line
                //     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                // },
                success: function(response, status, xhr, $form) {
                    if(response>0){
                    	swal.fire({
		                    "title": "",
		                    "text": "The member has been saved successfully.",
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
                            // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                            // showErrorMsg(form, 'success', 'The member has been saved successfully.');
                            window.location.reload();
                        }, 2000); 
                    }else{
                    	var err = 'Some error has been occured. Please try again.';
                    	if(response == 'email_unique'){
                    		err= "Email is duplicate, please change email."
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
			member_form();
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