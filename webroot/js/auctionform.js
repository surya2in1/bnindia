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
                            min:5000,
                            lessThan: "#chit_amount"
                    },
                    total_subscriber_dividend: {
                            required: true,
                            number:true,
                            min:1
                    },
                    subscriber_dividend: {
                            required: true,
                            number:true,
                            min:1
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
    if(group_id == ''){
        $('#auction_winner_member').html(member_options);
        return false;
    }
    $('.bnspinner').removeClass('hide');
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
                $('.bnspinner').addClass('hide');
                var result = JSON.parse(response);
                if(result != ''){
                	if((result.group_members)!=''){
                		$.each((result.group_members), function( key, value ) { 
    					  member_options += '<option value="'+key+'">'+value+'</option>';
    					});
                        if((result.groups)!=''){
                            $('#chit_amount').val(result.groups.chit_amount);
                            $('#total_members').val(result.groups.total_number);
                            $('#premium').val(result.groups.premium);
                        }
                        if(result.auction_count){
                            $('#auction_no').val(result.auction_count);
                        }
                	} 
    	           $('#auction_winner_member').html(member_options);
                }
            }
		}); 
});

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
    if(auction_highest_percent > 0 && chit_amount > 0){
        var discount_amount = parseFloat(chit_amount * (auction_highest_percent/100));
        $('#discount_amount').val(discount_amount);

        var priced_amount = parseFloat(chit_amount - discount_amount);
        $('#priced_amount').val(priced_amount);

        var foreman_commission = $('#foreman_commission').val();
        var total_subscriber_dividend = parseFloat(discount_amount - foreman_commission);
        $('#total_subscriber_dividend').val(total_subscriber_dividend);

        var total_members = $('#total_members').val();
        var subscriber_dividend = (total_members > 0) ? parseFloat(total_subscriber_dividend/total_members) : total_subscriber_dividend;
        $('#subscriber_dividend').val(subscriber_dividend);

        var premium = $('#premium').val();
        var net_subscription_amount = parseFloat(premium - subscriber_dividend);
        $('#net_subscription_amount').val(net_subscription_amount);
    } 
} 