<?php
use Cake\Core\Configure;
?>
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Auctions</h3>
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
                    <i class="kt-font-brand  fa fa-gavel" aria-hidden="true"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Auction list
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        
                        <a href="auction_form" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            New Record
                        </a>                       
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <input type="hidden" name="current_role" id="current_role" value="<?= $current_role; ?>">
            <input type="hidden" name="cofig_superadmin" id="cofig_superadmin" value="<?= Configure::read('ROLE_SUPERADMIN'); ?>"> 
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="auctions_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Group No.</th>
                        <th>Auction No</th>
                        <th>Auction Date</th>
                        <th>Highest Percent</th>
                        <th>Winner</th>
                        <th>Chit Amt</th>
                        <th>Priced Amt</th>
                        <th>Foreman Commission</th>
                        <th>Total Subscriber Dividend</th>
                        <th>Subscriber Dividend</th>
                        <th>Net Subscription Amt</th>
                        <?php if($current_role == Configure::read('ROLE_SUPERADMIN')){ ?>
                            <th>Action</th>
                        <?php }?>
                    </tr>
                </thead>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>

<!-- end:: Content -->
