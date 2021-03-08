"use strict";
var group_id = $('#id').val();
var table = $('#group_members_table');
var new_group_members_table = $('#new_group_members_table');
var KTDatatablesDataSourceAjaxServer = function() {
	var initTable1 = function() {

		// begin first group_members_table
		table.DataTable({
			// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			"ajax": {
	            "url": $('#router_url').val()+"Groups/getGroupMembers/"+group_id,
	            "type": "POST",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
	        },
			columns: [
				{data: 'id'},
				{data: 'customer_id'},
				{data: 'name'},
				{data: 'address'}, 
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
	                chit_amount: {
	                        required: true,
	                        number:true,
	                        max : 100000000,
	                        min:1
	                },
	                total_number: {
	                        required: true,
	                        number:true,
	                        max : 100000000,
	                        min:1
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
                        // similate 2s delay
                        setTimeout(function() {
                            btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                            showErrorMsg(form, 'success', 'The group has been saved successfully.');
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
    	$('#kt_typeahead_4').typeahead(null, {
		  //name: 'best-pictures',
		  display: 'customer_id',
		  source: function show(q, cb, cba) {
		    var url = $('#router_url').val()+"Users/getMembers/"+q;
		    $.ajax({ url: url,contentType: "application/json",
                            dataType:"json", })
		    .done(function(res) {
		     cba(res); 
		    })
		    .fail(function(err) {
		      alert(err);
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
		      return '<p><strong>' + data.customer_id + '</strong> - ' ;
		    }
		  }
		}).bind('typeahead:selected', function(obj, selected, name) {
		    var selected_id = selected.id;
		    $('#kt_typeahead_4').attr('customer_id',selected_id);
		}).off('blur'); 
         
    }
 
    var initNewGroupMembersTable= function() { 
		// begin first new_group_members_table
		new_group_members_table.DataTable();

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

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();
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
		if(group_type == 'forthnight'){
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
* Add member to group form table
*/
function add_member_grop(){ 
	   $('#new_group_members_table').DataTable().row.add( [
             '.1',
             '.2',
             '.3',
             '.4',
             '<button  type="button" class="btn btn-secondary remove_new_group_member" onclick="removeNewGroupMember(this);"><i class="flaticon2-trash"></i></button>'
        ]).draw( false );;
}
function removeNewGroupMember(thisval){
	$('#new_group_members_table').DataTable()
        .row( $(thisval).parents('tr') )
        .remove()
        .draw();
}
// $('#new_group_members_table tbody').on( 'click', 'a.remove_new_group_member', function () {
// 	alert(11);
//     new_group_members_table
//         .row( $(this).parents('tr') )
//         .remove()
//         .draw();
// } );
