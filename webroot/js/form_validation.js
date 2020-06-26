// Class definition

var KTFormControls = function () {
    // Private functions

    var login_form = function () {
        $( "#login_form" ).validate({
            // define validation rules
            rules: {
                //= Client Information(step 3)
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    maxlength: 8
                }
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
                //form[0].submit(); // submit the form
                swal.fire({
                    "title": "",
                    "text": "Form validation passed. All good!",
                    "type": "success",
                    "confirmButtonClass": "btn btn-secondary"
                });

                return false;
            }
        });
    }

    return {
        // public functions
        init: function() {
            login_form();
        }
    };
}();

jQuery(document).ready(function() {
    KTFormControls.init();
});