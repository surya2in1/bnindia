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
	            "url": "AllUsers/index",
	            "type": "POST",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
	        },
			columns: [ 
			    {data:'name'},
				{data: 'email'},
				{data: 'first_name'},
				{data: 'last_name'},
				{data: 'gender'},
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
											<a href="Users/superadminlogin/'+data+'" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-expand"></i>\
												<span class="kt-nav__link-text">Check User Data</span>\
											</a>\
										</li>\
									</ul>\
								</div>\
							</div>\
						'; 
					},
				},
				{
					targets: -3,
					render: function(data, type, full, meta) {
						var status = {
							'female': {'title': 'Female', 'class': 'kt-badge--brand'},
							'male': {'title': 'Male', 'class': ' kt-badge--info'},
							'other': {'title': 'Other', 'class': ' kt-badge--brand'},
							// 3: {'title': 'Canceled', 'class': ' kt-badge--primary'},
							// 4: {'title': 'Success', 'class': ' kt-badge--success'},
							// 5: {'title': 'Info', 'class': ' kt-badge--danger'},
							// 6: {'title': 'Danger', 'class': ' kt-badge--danger'},
							// 7: {'title': 'Warning', 'class': ' kt-badge--warning'},
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
					},
				},
				{
					targets: -2,
					render: function(data, type, full, meta) {
						var status = {
							1: {'title': 'Active', 'state': 'success'},
							0: {'title': 'Inactive', 'state': 'danger'}
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
							'<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
					},
				},
				{
					targets: -4,
					render: function(data, type, full, meta) {
						return  data.charAt(0).toUpperCase() + data.slice(1);
					},
				},
				{
					targets: -5,
					render: function(data, type, full, meta) {
						return  data.charAt(0).toUpperCase() + data.slice(1);
					},
				},
				{
					targets: -7,
					render: function(data, type, full, meta) {
						return  data.charAt(0).toUpperCase() + data.slice(1);
					},
				},
			],
		});
	};
  
	return {

		//main function to initiate the module
		init: function() {
			initTable1(); 
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();
}); 
