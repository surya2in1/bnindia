"use strict";
var group_id = $('#id').val(); 
var table = $('#group_members_table');
var new_group_members_table = $('#new_group_members_table');
var KTDatatablesDataSourceAjaxServer = function() {
	var initTable1 = function() {
		var i =0;

		// begin first group_members_table
		table.DataTable({
			// "lengthMenu": [[1, 25, 50, -1], [1, 25, 50, "All"]],
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			"order": [[ 0, 'asc' ]],
			"ajax": {
	            "url": $('#router_url').val()+"Groups/getGroupMembers/"+group_id,
	            "type": "POST",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
	        },
			columns: [  
				{data: 'customer_id'},
				{data: 'name'},
				{data: 'address'}, 
				{data: 'ticket_no'}, 
				{data: 'action', responsivePriority: -1},
			], 
			columnDefs: [{
		            "searchable": false ,
		            "targets": 0,
		            "orderable": false,
		            // "render": function (data, type, full,meta) {  
	                	// return meta.row + meta.settings._iDisplayStart + 1; 
	                // }
		        },
				{
					targets: -1,
					title: 'Action',
					orderable: false,
					render: function(data, type, full, meta) { 
						var config_superadmin_role = $('#config_superadmin_role').val();
						var user_role = $('#user_role').val(); 
						if(user_role== config_superadmin_role){ 
	                        return '\
								<button  type="button" class="btn btn-secondary remove_new_group_member" onclick="delete_group_user('+data+');" title="Delete"><i class="flaticon2-trash"></i></button>\
							';
						}else{
							return '\
								<button  type="button" class="btn btn-secondary remove_new_group_member" onclick="restrict_alert();" title="Delete"><i class="flaticon2-trash"></i></button>\
							';
						}

					},
				}, 
			],
		}); 
	}

	var group_form = function () {
		 var showErrorMsg = function(form, type, msg) {
	        var alert = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">\
				<div class="alert-text">'+msg+'</div>\
				<div class="alert-close">\
	                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
	            </div>\
			</div>');

	        form.find('.alert').remove();
	        //alert.prependTo(form);
	        //alert.animateClass('fadeIn animated');
	        KTUtil.animateClass(alert[0], 'fadeIn animated');
	        //alert.find('span').html(msg);
	    }
		 $('#submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
	        form.validate({
	     		// define validation rules
	            rules: {
	                group_number: {
	                        required: true,
	                        maxlength : 100
	                },
	                group_type: {
	                        required: true,
	                },
	                auction_day: {
	                        required: true,
	                },
	                chit_amount: {
	                        required: true,
	                        number:true,
	                        max : 100000000,
	                        min:1
	                },
	                late_fee: {
	                        required: true,
	                        number:true,
	                        max : 90,
	                        min:1
	                },
	                total_number: {
	                        required: true,
	                        number:true,
	                        max : 100000000,
	                        min:5,
	                        step: 5
	                },
	                premium: {
	                        required: true,
	                        number:true,
	                        max : 100000000,
	                        min:1
	                },
	                gov_reg_no: {
	                        required: true,
	                        maxlength : 100
	                },
	                no_of_months: {
	                        required: true,
	                        number:true,
	                        max : 100000,
	                        min:1
	                },
	                date:{
	                	required:true,
	                	max : 31,
	                    min:1
	                },
	                 group_code: {
	                        required: true,
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
	        });
			
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
		    // form.submit();
            form.ajaxSubmit({
                url: 'group_form/'+$('#id').val(),
                type:'POST',
                // beforeSend: function (xhr) { // Add this line
                //     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                // },
                success: function(response, status, xhr, $form) {
                    if(response>0){
                    	swal.fire({
		                    "title": "",
		                    "text": "The group has been saved successfully.",
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
                    	if(response == 'group_number_unique'){
                    		err= "Group number is duplicate, please change group number."
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

    var memberlist = function() { 
    	//Bloodhound typeahead
    	$('#customer_id_typeahead').typeahead(null, {
		  //name: 'best-pictures',
		  // display: 'customer_id',
		  display: function(data){ 
		  	 return data.customer_id+' – '+ucfirst(data.name);
		  	},
		  source: function show(q, cb, cba) {
		  	var values = $("input[name='members_ids[]']")
              .map(function(){return $(this).val();}).get();
              // alert(values); 
    		var mvalues = (values!='') ? values : 0;
	    	var group_id = $('#id').val(); 
		    var url = $('#router_url').val()+"Users/getMembers/"+q+"/"+group_id+"/"+mvalues;
		    $.ajax({ 
		    		url: url,
		    	    contentType: "application/json",
                    dataType:"json", 
                    data:$('#members_ids').val(),
                 })
		    .done(function(res) {
		     cba(res); 
		    })
		    .fail(function(err) {
		      console.log(err);
		    });
		  },
		    limit:10,
		  templates: {
		    empty: [
		      '<div class="empty-message">',
		        'No data',
		      '</div>'
		    ].join('\n'),
		     //suggestion: '<p><strong>{{value}}</strong> –</p>'
		    suggestion: function(data) { 
		    // console.log (data); 
			   var searchVal = data.customer_id+' – '+ucfirst(data.name); 
		       return '<p><strong>' + searchVal + '</strong> - ' ;
		    }
		  }
		}).bind('typeahead:selected', function(obj, selected, name) {  
		    $('#customer_id_typeahead').attr('cust_id',selected.id);
		    $('#customer_id_typeahead').attr('cust_name',selected.name);
		    $('#customer_id_typeahead').attr('address',selected.address);
		    $('#customer_id_typeahead').attr('customer_id',selected.customer_id);

		    //after select remove validations
		    $("#customer_id_typeahead").next("span").remove();
			$('#customer_id_typeahead').css('border','1px solid #e2e5ec');
		}).off('blur') 
		.on('typeahead:asyncrequest', function() {
	        $('#customer_id_typeahead').addClass('sLoading');
	    }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
	        $('#customer_id_typeahead').removeClass('sLoading');
	    });
    }
 
    var initNewGroupMembersTable= function() { 
		// begin first new_group_members_table
		new_group_members_table.DataTable({
			columnDefs: [{
		            "searchable": false ,
		            "targets": 0,
		            "orderable": false,
		            // "render": function (data, type, full,meta) {  
	             //    	return meta.row + meta.settings._iDisplayStart + 1 + '<input type="hidden" name="members_ids[]" id="members_ids" value="'+meta.row+'" />'; 
	             //    }
		        },
				{
					targets: -1,
					title: 'Action',
					orderable: false 
				}, 
			],
		});

	}

	return {

		//main function to initiate the module
		init: function() {
			initTable1(); 
			group_form();
			memberlist();
			initNewGroupMembersTable();
		},

	};

}();
function ucfirst(str){
	var str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
	    return letter.toUpperCase();
	}); 
	return str;
}

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();  
	$('#customer_id_typeahead').on( 'focus', function() {
          if($(this).val() === '') // you can also check for minLength 
              $(this).data().ttTypeahead.input.trigger('queryChanged', '');
      });

	var group_code = $('#id option:selected').text();
	if(group_code !=''){
		$('#list_label').html('<b>List of "'+group_code+'" group members:</b>');
	}
});

function calculate_premium(){
	var chit_amount = parseFloat($('#chit_amount').val());
	var total_member = parseInt($('#total_number').val());
	if(chit_amount > 0 && total_member > 0){
		var premium =  chit_amount/total_member;
		$('#premium').val(premium.toFixed(2));
	}else{
		$('#premium').val('');
	}
}

/**
*  Calculate no of month by selecting group type
*/
function calculate_no_of_months(){
	var chit_amount = parseFloat($('#chit_amount').val());
	var total_member = parseInt($('#total_number').val());
	if(chit_amount > 0 && total_member > 0){
		//calculate premium
		var premium =  chit_amount/total_member; 
		var total_months = chit_amount / premium;
		var group_type = $('#group_type').val();
		var no_of_months = Math.ceil(total_months);
		if(group_type == 'fortnight'){
			no_of_months = Math.ceil(total_months / 2);
		}else if(group_type=='weekly'){
			no_of_months = Math.ceil(total_months / 4);
		}else if(group_type=='daily'){
			no_of_months = 1;
		}
		$('#no_of_months').val(no_of_months);
	}
}

/*
* Add member to new group form table
*/
function add_member_to_new_group(){ 
	   var customer_id = $('#customer_id_typeahead').attr('customer_id');
		$("#customer_id_typeahead").next("span").remove();
		$('#btn_add_members').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);
	   if(customer_id != ''){
		   $('#new_group_members_table').DataTable().row.add([ 
	             $('#customer_id_typeahead').attr('customer_id')+'<input type="hidden" name="members_ids[]" id="members_ids" value="'+$('#customer_id_typeahead').attr('cust_id')+'" />',
	             $('#customer_id_typeahead').attr('cust_name'),
	             $('#customer_id_typeahead').attr('address'),
	             '<button  type="button" class="btn btn-secondary remove_new_group_member" onclick="removeNewGroupMember(this);" title="Delete"><i class="flaticon2-trash"></i></button>'
	        ]).draw( false );
		    $('#customer_id_typeahead').css('border','1px solid #e2e5ec');
		    $("#customer_id_typeahead").val('');
		    $("#customer_id_typeahead").attr('cust_id','');
    		$("#customer_id_typeahead").attr('customer_id','');
    		$("#customer_id_typeahead").attr('name','');
    		$("#customer_id_typeahead").attr('address','');
		    $('#btn_add_members').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
	   }else{
	   		$('#customer_id_typeahead').css('border-color','red');
			$("#customer_id_typeahead").after("<span style='color:red'>Please select member in list</span>");
			$('#btn_add_members').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
	   }
}
function restrict_alert(){
	swal.fire('You have not access to delete group members');
}
function removeNewGroupMember(thisval){  
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
        	$('#new_group_members_table').DataTable()
	        .row( $(thisval).parents('tr') )
	        .remove()
	        .draw();
    
            swal.fire(
		                'Deleted!',
		                'The member has been deleted.',
		                'success'
		            );
        } else if (result.dismiss === 'cancel') {
            swal.fire(
                'Cancelled',
                'Your data is safe :)',
                'error'
            )
        }
    });    
} 

/**
* add_member_to_existing_group
*/
function add_member_to_existing_group(){ 
	var group_id = $('#id').val(); 
	$('#customer_id_typeahead').css('border','1px solid #e2e5ec');
	$("#customer_id_typeahead").next("span").remove();
	if( $('#customer_id_typeahead').attr('cust_id') > 0 && group_id > 0){
		$('#btn_add_members').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);
		//add member user to meber_groups table
		$.ajax({
			   "url": $('#router_url').val()+"Users/addMemberUser",
	            "type": "POST",
	            "data": {'user_id':$('#customer_id_typeahead').attr('cust_id'),
	            			"group_id":group_id}
	        			,
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function(response, status, xhr, $form) {
                		$('#btn_add_members').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                		$("#customer_id_typeahead").val('');
                		$("#customer_id_typeahead").attr('cust_id','');
                		$("#customer_id_typeahead").attr('customer_id','');
                		$("#customer_id_typeahead").attr('name','');
                		$("#customer_id_typeahead").attr('address','');
                		if(response == 'exist_member_group'){
                			$('#customer_id_typeahead').css('border-color','red');
							$("#customer_id_typeahead").after("<span style='color:red'>This member already assign, please select another one.</span>");
                		}else if(response == 'full_group'){
                			//remove selected group from dropdown if group is full
                			swal.fire($('#id option:selected').text()+" group is full now, that's why removed from dropdown list");
                			$("#id option[value="+$('#id').val()+"]").remove(); 
                			refresh_member_table();
                		}else if(response == false){
                			$('#customer_id_typeahead').css('border-color','red');
							$("#customer_id_typeahead").after("<span style='color:red'>Some error has been occured, please try again.</span>");
                		}else{
    						table.DataTable().ajax.reload();
                		}
                }
			}); 
	}else{ 

		$('#customer_id_typeahead').css('border-color','red');
		$("#customer_id_typeahead").after("<span style='color:red'>Please select customer id in search list.</span>");
	}
}

/*
* 
**/
function delete_group_user(id){ 

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
			   "url": $('#router_url').val()+"MembersGroups/deleteGroupUser/"+id,
	            "type": "GET",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function(response, status, xhr, $form) {
                    if(response>0){
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

function refresh_member_table(){  
	var group_id = $('#id').val();
	$('#customer_id_typeahead').val(''); 
	if(group_id !=''){
		$('#list_label').html('<b>List of "'+$('#id option:selected').text()+'" group members:</b>');
	}else{
		group_id = 0;
		$('#list_label').html('<b>List of group members:</b>');
	}
	$('#group_members_table').DataTable().ajax.url($('#router_url').val()+"Groups/getGroupMembers/"+group_id).load();
}

function get_group_code(){
	var total_number = $('#total_number').val();
	var chit_amount = $('#chit_amount').val();
	var created_by = $('#created_by').val();
	$.ajax({
			   "url": $('#router_url').val()+"Groups/getGroupCode/"+total_number+"/"+created_by+"/"+chit_amount,
	            "type": "POST",
	            "data": {'user_id':$('#customer_id_typeahead').attr('cust_id'),
	            			"group_id":group_id}
	        			,
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function(response, status, xhr, $form) {
                		 $('#group_code').val(response);
                }
			}); 
}