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

						console.log(full.group_id);
						console.log(full);
						console.log(meta);
						return '\
							<div class="dropdown">\
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
									<i class="flaticon-more-1"></i>\
								</a>\
								<div class="dropdown-menu dropdown-menu-right">\
									<ul class="kt-nav">\
										<li class="kt-nav__item">\
											<a href="#" class="kt-nav__link" onclick="transfer_group_user('+data+','+full.group_id+');">\
										 		<i class="kt-nav__link-icon flaticon2-trash"></i>\
										 		<span class="kt-nav__link-text">Transfer User</span>\
										 	</a>\
										</li>\
										<li class="kt-nav__item">\
											<button type="button" class="hide btn btn-bold btn-label-brand btn-sm" data-toggle="modal" data-target="#tr_user_modal" user_id='+data+' group_id='+full.group_id+'>Launch Modal</button>\
											<a href="#tr_user_modal" class="kt-nav__link" data-toggle="modal" onclick="map_modal_data('+data+','+full.group_id+');" >\
										 		<i class="kt-nav__link-icon flaticon2-trash"></i>\
										 		<span class="kt-nav__link-text">Transfer User</span>\
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
function map_modal_data(user_id,group_id){
	$('#user_id').val(user_id);
	$('#group_id').val(group_id);
	$.ajax({
		   "url": $('#router_url').val()+"Users/getGroupsUsers/"+user_id+"/"+group_id,
            "type": "GET",
            beforeSend: function (xhr) { // Add this line
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(response, status, xhr, $form) {
                if(response>0){
					 
                }else{
                	                       
                } 
            }
		}); 
}
function trigger_function(modal_id){
	$('#'+modal_id).trigger('click');
}
function transfer_group_user(user_id,group_id){ 
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
			   "url": $('#router_url').val()+"Users/transferGroupUser/"+user_id+"/"+group_id,
	            "type": "GET",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function(response, status, xhr, $form) {
                    if(response>0){
    					table.DataTable().ajax.reload();
                    	
                    	swal.fire(
			                'Deleted!',
			                'The member has been transferd.',
			                'success'
			            );
                    }else{
                    	swal.fire(
			                'Cancelled',
			                'The member could not be transferd. Please, try again.',
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