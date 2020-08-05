"use strict";
var KTDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {
		var table = $('#group_table');

		// begin first table
		table.DataTable({
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
						return `
                        <span class="dropdown">
                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                              <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>
                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                            </div>
                        </span>
                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-edit"></i>
                        </a>`;
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
        $( "#group_form" ).validate({
            // define validation rules
            rules: {
                group_number: {
                        required: true,
                        maxlength : 10
                },
                chit_amount: {
                        required: true,
                        number:true,
                        max : 10
                },
                total_number: {
                        required: true,
                        number:true,
                        max : 10
                },
                premium: {
                        required: true,
                        number:true,
                        max : 10
                },
                gov_reg_no: {
                        required: true,
                        maxlength : 10
                },
                no_of_months: {
                        required: true,
                        number:true,
                        max : 12
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

            //display error alert on form submit
            invalidHandler: function(event, validator) {
                var alert = $('#change_password_msg');
                alert.removeClass('kt--hide').show();
                KTUtil.scrollTop();
            },
            //display error alert on form submit
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
            }
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