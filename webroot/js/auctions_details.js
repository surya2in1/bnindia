var KTFormControls = function() {
 	var report_form = function () {
		    
	        $( "#report_form" ).validate({
	     		// define validation rules
	            rules: {
	                group_id: {
	                        required: true, 
	                }, 
                    start:{
                        required:true
                    }, 
                    end:{
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
                 //display error alert on form submit
                invalidHandler: function(event, validator) {
                    var alert = $('#user_profile_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTop();
                },
                invalidHandler: function(event, validator) {
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

                    event.preventDefault();
                },
                submitHandler: function (form) {
                     var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
                    loading.show(); 
                    form.submit(); // submit the form 
                    setTimeout(function() {
                         loading.hide(); 
                    }, 2000);   
                }
	        });  
    }
	return {

		//main function to initiate the module
		init: function() { 
			report_form();
		},

	};

}();

jQuery(document).ready(function() {
	KTFormControls.init();
});