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
                    maxlength: 200
                },
                middle_name: {
                    required: true,
                    maxlength: 100
                },
                last_name: {
                    required: true,
                    maxlength: 100
                },
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
                accupation:{
                    lettersonly: true,
                    maxlength: 50
                },
                income_amt:{
                    number: true,
                    maxlength: 15
                },
                mobile_number:{
                    number: true,
                    maxlength: 10
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
            },
            // errorPlacement: function(error, element) {
                    // if (element.attr("name") == "profile_picture" ) {
                    //     $("#profile_picture-error").text('');
                    //     $("#profile_picture-error2").text($(error).text());
                    //     $('html, body').animate({
                    //         scrollTop: $("#kt_content").offset().top
                    //     }, 1000);
                    // }else{
                    //     $("#profile_picture-error2").text('');
                    // }
                // },

             messages: { 
                profile_picture: "File must be JPG, JPEG or PNG",
                address_proof: "File must be JPG, JPEG or PNG",
                photo_proof: "File must be JPG, JPEG or PNG",
                other_document: "File must be JPG, JPEG or PNG"
              },
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