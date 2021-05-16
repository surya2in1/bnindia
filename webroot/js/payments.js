"use strict"; 
var table = $('#payment_table'); 
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
                "url": "Payments/index",
                "type": "POST",
                beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
            },
            columns: [  
                {data: 'receipt_no'},
                {data: 'date'},
                {data: 'group_code'},
                {data: 'member'}, 
                {data: 'subscriber_ticket_no'},
                {data: 'instalment_no'},
                {data: 'instalment_month'},
                {data: 'due_date'},
                {data: 'subscription_amount'}, 
                {data: 'late_fee'}, 
                {data: 'total_amount'}, 
                {data: 'received_by'},
                {data: 'remark'},
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
                         return '\
                            <div class="dropdown">\
                                <a href="javascript:void(0);" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
                                    <i class="flaticon-more-1"></i>\
                                </a>\
                                <div class="dropdown-menu dropdown-menu-right">\
                                    <ul class="kt-nav">\
                                        <li class="kt-nav__item">\
                                            <a href="javascript:void(0);" onclick=print_receipt(event,"'+$('#router_url').val()+'payments/receipt/'+data+'"); class="kt-nav__link printButton">\
                                                <i class="kt-nav__link-icon fa fa-print"></i>\
                                                <span class="kt-nav__link-text">Print Receipt</span>\
                                            </a>\
                                        </li>\
                                    </ul>\
                                </div>\
                            </div>\
                        ';
                    },
                }, 
            ],
        }); 
    } 

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
  
function print_receipt(evt,url){ 
    evt.preventDefault();  
    var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
    loading.show();
    $('body').append('<iframe width="0" height="0"  src="'+url+'" id="printIFrame" name="printIFrame" width="100%"></iframe>');
    $('#printIFrame').bind('load', 
        function() {  
            $('.kt-dialog--shown').remove(); 
        }
    ); 
}