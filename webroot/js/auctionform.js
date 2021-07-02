"use strict"; 
var table = $('#auctions_table'); 
var KTDatatablesDataSourceAjaxServer = function() { 
    var initTable1 = function() {

        // begin first table
        table.DataTable({
            // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            "ajax": {
                "url": "Auctions/index",
                "type": "POST",
                beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
            },
            columns: [
                {data: 'id'},
                {data: 'group_code'},
                {data: 'auction_no'},
                {data: 'auction_date'},
                {data: 'auction_highest_percent'},
                {data: 'winner'},
                {data: 'chit_amount'},
                {data: 'priced_amount'},
                {data: 'foreman_commission'}, 
                {data: 'total_subscriber_dividend'},
                {data: 'subscriber_dividend'},
                {data: 'net_subscription_amount'}, 
            ], 
            columnDefs: [ 
                {
                    targets: 3,
                    title: 'Action Date',
                    orderable: false,
                    render: function(data, type, full, meta) { 
                        var date = new Date(data);
                        return ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear();
                
                    },
                }, 
            ],
        });

    };
     
    var auctions_module = function () {
        var showErrorMsg = function(form, type, msg) {
            var alert = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">\
                <div class="alert-text">'+msg+'</div>\
                <div class="alert-close">\
                    <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
                </div>\
            </div>');

            form.find('.alert').remove(); 
            KTUtil.animateClass(alert[0], 'fadeIn animated'); 
        }
        $.validator.addMethod("lessThan",
            function (value, element, param) {
                  var $otherElement = $(param);
                  return parseInt(value, 10) < parseInt($otherElement.val(), 10);
        }, "Commission must be less than Chit Amount:."); 
        
         $.validator.addMethod("minCommission",
            function (value, element, param) {
                  var $otherElement = $(param);
                  return parseInt(value) >= parseFloat($otherElement.val()*(5/100));
        }, "Commission must be minimum 5% of Chit Amount:."); 
        
        $('#submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
            form.validate({
                ignoreTitle:true,
                // define validation rules
                rules: {
                    group_id: {
                            required: true, 
                    },
                    auction_winner_member: {
                            required: true, 
                    },
                    ticket_no: {
                            required: true, 
                             number:true,
                    },
                    auction_no: {
                            required: true,
                            number:true,
                            max : 100,
                            min:1
                    },
                    auction_date:{
                        required:true
                    },
                    auction_highest_percent: {
                            required: true,
                            number:true,
                            max : 100,
                            min:1
                    },
                    chit_amount: {
                            required: true,
                            number:true,
                            min:1
                    },
                    discount_amount: {
                            required: true,
                            number:true,
                            min:1
                    },
                    priced_amount: {
                            required: true,
                            number:true,
                            min:1
                    },
                    foreman_commission: {
                            required: true,
                            number:true,
                            //min:1000,
                            lessThan: "#chit_amount",
                            minCommission:"#chit_amount"
                    },
                    total_subscriber_dividend: {
                            number:true,
                    },
                    subscriber_dividend: {
                            number:true,
                    },
                    net_subscription_amount: {
                            required: true,
                            number:true,
                            min:1
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
                url: 'auction_form/'+$('#id').val(),
                type:'POST',
                // beforeSend: function (xhr) { // Add this line
                //     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                // },
                success: function(response, status, xhr, $form) {
                    if(response>0){
                        // similate 2s delay
                        swal.fire({
                            "title": "",
                            "text": "The auction has been saved successfully.",
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary",
                            "onClose": function(e) {
                                 $('html, body').animate({
                                    scrollTop: $("#kt_content").offset().top
                                }, 1000); 
                            }
                        });
                        
                        // similate 2s delay
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000); 

                    }else{
                         var err = 'Some error has been occured. Please try again.';
                        if(response != ''){ 
                            err= response;
                        } 

                         swal.fire({
                            "title": "",
                            "text": err,
                            "type": "error",
                            "confirmButtonClass": "btn btn-secondary",
                            "onClose": function(e) {
                                  btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                            showErrorMsg(form, 'danger', err);
                                 $('html, body').animate({
                                    scrollTop: $("#kt_content").offset().top
                                }, 1000); 
                            }
                        });                         
                    }
                    // $('html, body').animate({
                    //     scrollTop: "0"
                    // }, 2000);
                }
            }); 
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            initTable1();  
            auctions_module();
        },

    };
}();    

jQuery(document).ready(function() {
    KTDatatablesDataSourceAjaxServer.init();  
    if($('#id').val() > 0){
        $('#groups').trigger('change');
    }
    //$("#auction_date").datepicker().datepicker("setDate", new Date());

});

//Show members after select group
$('#groups').change(function(e) {
	//get selected member id
	var group_id = $(this).val(); 
    var member_options = '<option value="">Select Member</option>';
    $('#chit_amount').val('');
    $('#auction_no').val(0);
    $('#total_members').val(0);
    $('#premium').val(0);
    $('#group_type').val('');
    $('#ticket_no').val(0);
    $('#auction_highest_percent').val(0);
    if(group_id == ''){
        $('#auction_winner_member').html(member_options);
        return false;
    }
    $('.bnspinner').removeClass('hide');
    var selected_auction_member_id = $('#auction_member_id').val();
	$.ajax({
		   "url": $('#router_url').val()+"Auctions/getMembersByGrooupId",
            "type": "POST",
            "data": {
            			"group_id":group_id}
        			,
            beforeSend: function (xhr) { // Add this line
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(response, status, xhr, $form) { 
                var result = JSON.parse(response);
                if(result != ''){
                	if((result.group_members)!=''){
                		$.each((result.group_members), function( key, value ) { 
                         var selected = "";
                         if(selected_auction_member_id == value.user_id){
                            selected = "selected";
                         }
    					  member_options += '<option value="'+value.user_id+'" "'+selected+'" ticket_no='+value.ticket_no+'>'+value.name+'</option>';
    					});
                        if((result.groups)!=''){
                            $('#chit_amount').val(result.groups.chit_amount);
                            $('#total_members').val(result.groups.total_number);
                            $('#premium').val(result.groups.premium);
                            $('#group_type').val(result.groups.group_type);
                            get_group_auction_date(result.groups.id,result.groups.group_type,result.groups.auction_date);
                        }
                        if(result.auction_count){
                            $('#auction_no').val(result.auction_count);
                        }
                	} 
    	           $('#auction_winner_member').html(member_options);
                }
                $('.bnspinner').addClass('hide');
            }
		}); 
        if(selected_auction_member_id > 0){
            $('#auction_winner_member').trigger('change');
        }
});

//get selected group auction date
function get_group_auction_date(group_id,group_type,group_auction_date){
    $.ajax({
           "url": $('#router_url').val()+"Auctions/get_group_auction_date",
            "type": "POST",
            "data": {
                        "group_id":group_id,"group_type":group_type,"group_auction_date":group_auction_date}
                    ,
            beforeSend: function (xhr) { // Add this line
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function(response, status, xhr, $form) { 
                 
            }
        }); 
}

//Set calcustion after enter auction highest percent
function calculate_subscription_amount(){
    //get auction_highest_percent
    var auction_highest_percent = parseFloat($('#auction_highest_percent').val());  
    var chit_amount = parseFloat($('#chit_amount').val());   
    $('#discount_amount').val('');
    $('#priced_amount').val('');
    $('#total_subscriber_dividend').val('');
    $('#subscriber_dividend').val('');
    $('#net_subscription_amount').val('');
    $('#foreman_commission').val(0);
    
    if(auction_highest_percent >= 0 && chit_amount > 0){
        var admin_foreman_commission_in_percent = ($('#foreman_commission_in_percent').val() > 0) ? $('#foreman_commission_in_percent').val() : 5; 
        var foreman_commission = parseFloat(chit_amount * (admin_foreman_commission_in_percent/100));
        $('#foreman_commission').val(foreman_commission);
        var discount_amount = parseFloat(chit_amount * (auction_highest_percent/100));
        $('#discount_amount').val(discount_amount);

        var priced_amount = parseFloat(chit_amount - discount_amount);
        $('#priced_amount').val(priced_amount);

        var foreman_commission = parseFloat($('#foreman_commission').val());
        //alert('discount_amount '+discount_amount+' // foreman_commission = '+foreman_commission);
        if(discount_amount > foreman_commission){
            var total_subscriber_dividend = parseFloat(discount_amount - foreman_commission);    
        }else{
            var total_subscriber_dividend = parseFloat(foreman_commission-discount_amount);
        }
        
        $('#total_subscriber_dividend').val(total_subscriber_dividend);

        var total_members = $('#total_members').val();
        var subscriber_dividend = (total_members > 0) ? parseFloat(total_subscriber_dividend/total_members) : total_subscriber_dividend;
        $('#subscriber_dividend').val(subscriber_dividend);

        var premium = $('#premium').val();
        var net_subscription_amount = parseFloat(premium - subscriber_dividend);
        $('#net_subscription_amount').val(net_subscription_amount);
    } 
} 

function member_change(thisval){
    $('#ticket_no').val($(thisval).find(':selected').attr('ticket_no'));
}