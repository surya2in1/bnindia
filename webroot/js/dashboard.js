"use strict";
var table = $('#group_table');
var KTDatatablesDataSourceAjaxServer = function() {
	//https://preview.keenthemes.com/metronic/demo8/crud/ktdatatable/base/data-ajax.html
	// var datatable = function() { 
	// 	$('.kt-datatableG').KTDatatable({
	// 		data: {
 //                type: 'remote',
 //                source: {
 //                    read: {
 //                        url: 'Dashboard/index',
 //                        beforeSend: function (xhr) { // Add this line
	// 	                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
	// 	                },
 //                        // sample custom headers
 //                        // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
 //                        map: function(raw) {
 //                            // sample data mapping
 //                            var dataSet = raw;
 //                            if (typeof raw.aaData !== 'undefined') {
 //                                dataSet = raw.aaData;
 //                            }
 //                            return dataSet;
 //                        },
 //                    },
 //                }, 
 //                pageSize: 10,
 //                saveState: {
 //                    cookie: false,
 //                    webstorage: true
 //                },
 //                serverPaging: true,
 //                serverFiltering: false,
 //                serverSorting: false
 //            },

	// 		// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
	// 		// responsive: true,
	// 		// searchDelay: 500,
	// 		// processing: true,
	// 		// serverSide: true,
	// 		"order": false,
	// 		/*"ajax": {
	//             "url": "Dashboard/index",
	//             "type": "POST",
	//             beforeSend: function (xhr) { // Add this line
 //                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
 //                },
	//         },*/
	// 		columns: [ 
	// 			{	
	// 				// data: 'chit_amount'
	// 				field: "chit_amount",
	//                 title: "Chit Value(Rs.)",
	//                 sortable: false,
	//                 // width: 40,
	//                 template: function(data) {
	//                     return '<span class="kt-font-bold">' + data.chit_amount + '</span>';
	//                 },
	//                 textAlign: 'center'
	// 			},
	// 			{
	// 				// data: 'no_of_months'
	// 				field: "no_of_months",
	//                 title: "Duration(Months)",
	//                 // width: 100, 
	//                 template: function(data) {
	//                     return '<span class="kt-font-bold">' + data.no_of_months + '</span>';
	//                 }
	// 			},
	// 			{
	// 				// data: 'premium'
	// 				field: "premium",
	//                 title: "Monthly Subscription(Rs.)",
	//                 // width: 100, 
	//                 template: function(data) {
	//                     return '<span class="kt-font-bold">' + data.premium + '</span>';
	//                 }
	// 			},
	// 			{
	// 				// data: 'no_of_installments'
	// 				field: "no_of_installments",
	//                 title: "No. of Inst. Payable",
	//                 // width: 100, 
	//                 template: function(data) {
	//                     return '<span class="kt-font-bold">' + data.no_of_installments + '</span>';
	//                 }
	// 			},
	// 			{
	// 				// data: 'total_amt_payable'
	// 				field: "total_amt_payable",
	//                 title: "Total Amt. Payable(Rs.)",
	//                 // width: 100, 
	//                 template: function(data) {
	//                     return '<span class="kt-font-bold">' + data.total_amt_payable + '</span>';
	//                 }
	// 			},
	// 			{
	// 				//	data: 'total_dividend'
	// 				field: "total_dividend",
	//                 title: "Total Dividend(Rs.)",
	//                 // width: 100, 
	//                 template: function(data) {
	//                     return '<span class="kt-font-bold">' + data.total_dividend + '</span>';
	//                 }
	// 			} 
	// 		],
	// 		layout: {
 //                scroll: true,
 //                height: 500,
 //                footer: false
 //            },

 //            sortable: true,

 //            filterable: false,

 //            pagination: true,
	// 	})};
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
	            "url": "Dashboard/index",
	            "type": "POST",
	            beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
	        },
			columns: [ 
				{data: 'chit_amount'},
				{data: 'no_of_months'},
				{data: 'premium'},
				{data: 'no_of_installments'},
				{data: 'total_amt_payable'},
				{data: 'total_dividend'} 
			],
		});

	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
			// datatable();
		},

	};

}();

// Class definition
var KTDashboard = function() {
	// Activities Charts.
    // Based on Chartjs plugin - http://www.chartjs.org/
    var activitiesChart = function() {
        if ($('#kt_chart_activities').length == 0) {
            return;
        }

        var ctx = document.getElementById("kt_chart_activities").getContext("2d");

        var gradient = ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, Chart.helpers.color('#e14c86').alpha(1).rgbString());
        gradient.addColorStop(1, Chart.helpers.color('#e14c86').alpha(0.3).rgbString());

        var config = {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October"],
                datasets: [{
                    label: "Sales Stats",
                    backgroundColor: Chart.helpers.color('#e14c86').alpha(1).rgbString(),  //gradient
                    borderColor: '#e13a58',

                    pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                    pointHoverBackgroundColor: KTApp.getStateColor('light'),
                    pointHoverBorderColor: Chart.helpers.color('#ffffff').alpha(0.1).rgbString(),

                    //fill: 'start',
                    data: [
                        10, 14, 12, 16, 9, 11, 13, 9, 13, 15
                    ]
                }]
            },
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                    position: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: false,
                        gridLines: false,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.0000001
                    },
                    point: {
                        radius: 4,
                        borderWidth: 12
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 10,
                        bottom: 0
                    }
                }
            }
        };

        var chart = new Chart(ctx, config);
    }

	return {
        // Init demos
        init: function() {
            // init charts 
            activitiesChart(); 
            
            // demo loading
            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
            loading.show();

            setTimeout(function() {
                loading.hide();
            }, 3000);
        }
    };
};

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();
	KTDashboard.init();
});