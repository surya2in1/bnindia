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
<?php $paymentid = isset($payment->id) && ($payment->id > 0) ? $payment->id : '0';?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <?= ($paymentid > 0 ) ? 'Edit Payment' : 'Add Payment'; ?> 
                        </h3>
                    </div>
                </div>
                <input type="hidden" name="router_url" id="router_url" value="<?php echo Router::url('/', true); ?>" />
                <!--begin::Form-->
                <?= $this->Form->create(null, array(
                       'class'=>'kt-form',
                       'id'=>'payment_form',
                       'method'=> 'Post'
                     )); ?>
                      <input type="hidden" name="id" id="id" value="<?= $paymentid; ?>">
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Receipt no:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="receipt_no" placeholder="Enter Receipt No" value="<?= isset($payment->receipt_no) ? $payment->receipt_no : '';?>" autofocus="true">
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Due date of payment:</label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="" value="<?= isset($payment->due_date) && strtotime($payment->due_date) > 0 ? date('m/d/Y',strtotime($payment->due_date)) : '';?>" id="kt_datepicker_3" name="date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Date:</label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="" value="<?= isset($payment->date) && strtotime($payment->date) > 0 ? date('m/d/Y',strtotime($payment->date)) : '';?>" id="kt_datepicker_3" name="date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Member:</label>
                                    <div class="col-lg-6">
                                        <?php $payment_member_id =  isset($payment->member_id) ? $payment->member_id : 0;?>
                                        <!-- Get member list -->
                                        <select id="member_id" name="member_id" class="form-control"> 
                                        </select> 
                                    </div>
                                </div>

                                <!-- Show hear member details after select member -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Group:</label>
                                    <div class="col-lg-6">
                                        <?php $payment_group_id =  isset($payment->group_id) ? $group->group_id : 0;?>
                                        <!-- Get groups after select member -->
                                        <select id="group_id" name="group_id" class="form-control"> 
                                        </select> 
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Subscriber Ticket No:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="subscriber_ticket_no" placeholder="Enter Subscriber Ticket No" value="<?= isset($payment->subscriber_ticket_no) ? $payment->subscriber_ticket_no : '';?>" autofocus="true">
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Instalment No:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="instalment_no" placeholder="Enter Instalment No" value="<?= isset($payment->instalment_no) ? $payment->instalment_no : '';?>" autofocus="true">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Instalment Month:</label>
                                    <div class="col-lg-6">
                                        <select id="instalment_month" name="instalment_month" class="form-control"> 
                                            <!--Show months in php list-->
                                            <option></option>
                                        </select>  
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Subscription Rs:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="subscription_amount" placeholder="Enter Subscription Rs" value="<?= isset($payment->subscription_amount) ? $payment->subscription_amount : '';?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Late fee:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="late_fee" placeholder="Enter Late fee" value="<?= isset($payment->late_fee) ? $payment->late_fee : '';?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Received by:</label>
                                    <div class="col-lg-6">
                                         <?php $received_by =  isset($payment->received_by) ? $payment->received_by : 'monthly';?>
                                        <select id="received_by" name="received_by" class="form-control"> 
                                            <!--Show months in php list-->
                                            <option value="1" <?php if($received_by == 1){ echo 'selected'; } ?>>Cash</option>
                                            <option value="2" <?php if($received_by == 2){ echo 'selected'; } ?>>Cheque</option>
                                            <option value="3" <?php if($received_by == 3){ echo 'selected'; } ?>>Direct Debit</option>
                                        </select>  
                                    </div>
                                </div>

                                <!-- If Cash select then show below -->
                                <div class="form-group row hide" id="cash_received_date_div">
                                    <label class="col-lg-3 col-form-label">Received  Date:</label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="" value="<?= isset($payment->cash_received_date) && strtotime($payment->cash_received_date) > 0 ? date('m/d/Y',strtotime($payment->date)) : '';?>" id="kt_datepicker_3" name="cash_received_date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                <!-- If Cheque select then show below -->
                                <div class="form-group row cash_div">
                                    <label class="col-lg-3 col-form-label">Cheque No:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="cheque_no" placeholder="Enter Cheque No" value="<?= isset($payment->cheque_no) ? $payment->cheque_no : '';?>">
                                    </div>
                                </div>

                                 <div class="form-group row hide cash_received_date_div">
                                    <label class="col-lg-3 col-form-label">Date:</label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="" value="<?= isset($payment->cheque_date) && strtotime($payment->cheque_date) > 0 ? date('m/d/Y',strtotime($payment->cheque_date)) : '';?>" id="kt_datepicker_3" name="cheque_date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>      

                                <div class="form-group row cash_received_date_div">
                                    <label class="col-lg-3 col-form-label">Bank details:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="cheque_bank_details" placeholder="Enter Bank details" value="<?= isset($payment->cheque_bank_details) ? $payment->cheque_bank_details : '';?>">
                                    </div>
                                </div>

                                <div class="form-group row cash_received_date_div">
                                    <label class="col-lg-3 col-form-label">Drown on:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="cheque_drown_on" placeholder="Enter Drown on" value="<?= isset($payment->cheque_drown_on) ? $payment->cheque_drown_on : '';?>">
                                    </div>
                                </div>

                                <!-- If direct_debit select then show below -->

                                <div class="form-group row hide direct_debit_date_div">
                                    <label class="col-lg-3 col-form-label">Date:</label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="" value="<?= isset($payment->direct_debit_date) && strtotime($payment->direct_debit_date) > 0 ? date('m/d/Y',strtotime($payment->direct_debit_date)) : '';?>" id="kt_datepicker_3" name="direct_debit_date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>      

                                <div class="form-group row direct_debit_date_div">
                                    <label class="col-lg-3 col-form-label">Transaction no:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="direct_debit_transaction_no" placeholder="Enter Transaction no" value="<?= isset($payment->direct_debit_transaction_no) ? $payment->direct_debit_transaction_no : '';?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Remark:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="remark" placeholder="Enter Remark" value="<?= isset($payment->remark) ? $payment->remark : '';?>">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <button type="button" id="submit" class="btn btn-success">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>
<!-- end:: Content -->

