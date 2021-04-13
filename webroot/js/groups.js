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
			"order": false,
			"ajax": {
	            "url": "Groups/index",
	            "type": "POST",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
	        },
			columns: [
				{data: 'group_number'},
				{data: 'group_code'},
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
											<a href="group_form/'+data+'" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-contract"></i>\
												<span class="kt-nav__link-text">Edit</span>\
											</a>\
										</li>\
										<li class="kt-nav__item">\
											<a href="groups/view/'+data+'" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-expand"></i>\
												<span class="kt-nav__link-text">View</span>\
											</a>\
										</li>\
									</ul>\
								</div>\
							</div>\
						';
						//Commented temparary		

						// <li class="kt-nav__item">\
						// 	<a href="#" class="kt-nav__link" onclick="deletegroup('+data+');">\
						// 		<i class="kt-nav__link-icon flaticon2-trash"></i>\
						// 		<span class="kt-nav__link-text">Delete</span>\
						// 	</a>\
						// </li>\
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
