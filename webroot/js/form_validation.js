// Class definition

var KTFormControls = function () {
    // Private functions

    var user_profile = function () {
        $( "#user_profile" ).validate({
            // define validation rules
            rules: {
                //= Client Information(step 3)
                first_name: {
                    required: true,
                    maxlength: 20
                },
                middle_name: {
                    required: true,
                    maxlength: 20
                },
                last_name: {
                    required: true,
                    maxlength: 20
                },
                city:{
                    lettersonly: true
                },
                city:{
                    lettersonly: true
                },
                state:{
                    lettersonly: true
                },
                accupation:{
                    lettersonly: true
                },
                income_amt:{
                    number: true
                },
                mobile_number:{
                    number: true,
                    maxlength: 10
                },
                nominee_name:{
                    lettersonly: true
                },
                nominee_relation:{
                    lettersonly: true
                },
                profile_picture: { extension: "png|jpe?g" }
            },
            errorPlacement: function(error, element) {
                    if (element.attr("name") == "profile_picture" ) {
                        $("#profile_picture-error").text('');
                        $("#profile_picture-error2").text($(error).text());
                        $('html, body').animate({
                            scrollTop: $("#kt_content").offset().top
                        }, 1000);
                    }else{
                        $("#profile_picture-error2").text('');
                    }
                },

            messages: { inputimage: "File must be JPG, JPEG or PNG, less than 1MB" },
            //display error alert on form submit
            invalidHandler: function(event, validator) {
                swal.fire({
                    "title": "",
                    "text": "There are some errors in your submission. Please correct them.",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary",
                    "onClose": function(e) {
                        console.log('on close event fired!');
                    }
                });

                event.preventDefault();
            },

            submitHandler: function (form) {
                //alert('sdf');exit;
                form.submit(); // submit the form
                // swal.fire({
                //     "title": "",
                //     "text": "Form validation passed. All good!",
                //     "type": "success",
                //     "confirmButtonClass": "btn btn-secondary"
                // });

                // return false;
            }
        });
    }

    return {
        // public functions
        init: function() {
            user_profile();
        }
    };
}();

jQuery(document).ready(function() {
    KTFormControls.init();
});