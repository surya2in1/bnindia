<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Dashboard</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
                <input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
                <span class="kt-input-icon__icon kt-input-icon__icon--right">
                    <span><i class="flaticon2-search-1"></i></span>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <!-- <div class="row">
        <div class="col-xl-12">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Exclusive Datatable Plugin
                        </h3>
                    </div> 
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit"> 
                    <div class="kt-datatableG" id="kt_datatable_latest_orders"></div> 
                </div>
            </div>
        </div> 
    </div> -->
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-users-1"></i>
                </span>
                <h3 class="kt-portlet__head-title"> 
                    Branch: <?= $branch_name;?>
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <?= $this->Form->create(null,[]); ?>
            <?= $this->Form->end(); ?>
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="group_table">
                <thead>
                    <tr>  
                        <th>Chit Value(Rs.)</th>
                        <th>Duration(Months)</th>
                        <th>Monthly Subscription(Rs.)</th>
                        <th>No. of Inst. Payable</th>
                        <th>Total Amt. Payable(Rs.)</th>
                        <th>Total Dividend(Rs.)</th>
                    </tr>
                </thead>
            </table>
            <!--end: Datatable -->
        </div>
    </div>
</div>
<!-- end:: Content -->
                      