<?php
use Cake\Routing\Router;
?>
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Payments</h3>
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
<?= $this->Form->create(null,[]); ?>
<?= $this->Form->end(); ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-users-1"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Payment list
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <input type="hidden" name="router_url" id="router_url" value="<?php echo Router::url('/', true); ?>" />
                        <a href="payment_form" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            New Record
                        </a>         
                        <input type="button" value="Print this page" onClick="print('http://localhost/bnindia/payments/receipt')">
                        <button type="button" class="kt-nav__link printButton" ref_url="http://localhost/bnindia/payments/receipt"> <i class="kt-nav__link-icon fa fa-print"></i>
                            <span class="kt-nav__link-text">Print Receipt</span></button>  

                        <!-- <a href="javascript:void(0);" class="kt-nav__link printButton" ref_url="http://localhost/bnindia/payments/receipt">
                            <i class="kt-nav__link-icon flaticon2-expand"></i>
                            <span class="kt-nav__link-text">Print Receipt</span>
                        </a> -->
                          <p><span onclick="loadOtherPage('http://localhost/bnindia/payments/receipt');" >Print external page!</span></p>

                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="payment_table">
                <thead>
                    <tr>
                        <th>Receipt No.</th>
                        <th>Date</th>
                        <th>Group Code</th>
                        <th>Member</th>
                        <th>Subscriber Ticket No.</th>
                        <th>Instalment No.</th>
                        <th>Instalment Month</th>
                        <th>Due date of payment</th>
                        <th>Subscription Rs.</th>
                        <th>Late Fee</th>
                        <th>Total Amount</th>
                        <th>Received By</th> 
                        <th>Remark</th> 
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>

<!-- end:: Content -->
