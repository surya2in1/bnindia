<?php
use Cake\Routing\Router;
use Cake\Core\Configure;

?>
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Members</h3>
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
 <input type="hidden" name="router_url" id="router_url" value="<?php echo Router::url('/', true); ?>" />
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-user"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                   Vaccant Members list 
                </h3>
            </div> 
        </div>
        <div class="kt-portlet__body">

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                <thead>
                    <tr>
                         <th>Group Code-Ticket No.</th>
                         <th>Chit Value(Rs.)</th>
                         <th>Duration(Months)</th> 
                         <th>Monthly Subcription(Rs.)</th>
                         <th>Ticket No.</th> 
                         <th>Name of Subscriber</th>
                         <th>No. of Installment Payable(Rs.)</th>
                         <th>Total Amount Payable(Rs.)</th>
                         <th>Total Dividend(Rs.)</th>
                         <th>Actions</th>
                    </tr>
                </thead>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>

<!-- end:: Content -->

<!--begin::Modal-->
<div class="modal modal-stick-to-bottom fade" id="tr_user_modal" role="dialog" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Transer User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
             <?= $this->Form->create(null, array(
                   'class'=>'kt-form',
                   'id'=>'transfer_member_form', 
                   'method'=> 'Post'
                 )); ?>
            <div class="modal-body">
                     <input type="hidden" id="group_id" name="group_id">
                     <input type="hidden" id="user_id" name="user_id">
                    <div class="form-group">
                        <label class="form-control-label">New Users:</label>
                        <select class="form-control" id="new_group_users_list" name="new_group_users_list">
                        
                        </select>
                    </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submit" class="btn btn-primary">Save changes</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!--end::Modal-->