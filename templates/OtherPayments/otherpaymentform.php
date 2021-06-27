<?php
use Cake\Routing\Router;
?>
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Other Payments</h3>
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
                            <?= ($paymentid > 0 ) ? 'Edit Payment Voucher' : 'Add  Payment Voucher'; ?> 
                            <lable>(Fields marked with * are mandatory.)</lable>
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
                                    <label class="col-lg-3 col-form-label">Payment Head:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <?php $payment_head_id =  isset($payment->payment_head_id) ? $payment->payment_head_id : 0;?>
                                        <!-- Get groups after select member -->
                                        <select id="payment_head_id" name="payment_head_id" class="form-control  border-black">
                                            <option value="">Select Payment Head</option>
                                             <?php if($payment_heads){ 
                                                foreach ($payment_heads as $key => $val) {?>
                                                    <option <?php if($key == $payment_head_id){?> selected='selected' <?php } ?> value="<?= $key; ?>"><?=$val?></option>
                                               <?php } 
                                            } ?> 
                                        </select> 
                                    </div>
                                    <div class="kt-spinner kt-spinner--v2 kt-spinner--md kt-spinner--danger hide grbnspinner"></div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Date:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control  border-black" readonly="" value="<?= isset($payment->date) && strtotime($payment->date) > 0 ? date('m/d/Y',strtotime($payment->date)) : '';?>" id="date" name="date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Paid to Shri/Smt:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control border-black" name="paid_to_name" id="paid_to_name" placeholder="Enter Paid to Shri/Smt" maxlength="100" value="<?= isset($payment->paid_to_name) ? $payment->paid_to_name : '';?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Total Amount:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control calc txt border-black" name="total_amount" id="total_amount" placeholder="Enter Total Amount" value="<?= isset($payment->total_amount) ? $payment->total_amount : '';?>">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Less GST:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control calc txt  border-black" name="gst" id="gst" placeholder="Enter GST" value="<?= isset($payment->gst) ? $payment->gst : '';?>">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Less TDS:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control  border-black calc" name="less_tds" id="less_tds" placeholder="Enter Less TDS" value="<?= isset($payment->less_tds) ? $payment->less_tds : '0';?>">
                                    </div>
                                </div>
                                
                                 <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Total Amount Paid Rs:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="total_amount_paid_rs" id="total_amount_paid_rs" placeholder="Enter Total Amount Paid Rs" readonly value="<?= isset($payment->total_amount_paid_rs) ? $payment->total_amount_paid_rs : '';?>">
                                    </div>
                                </div>
                                
                                <!-- If Cheque select then show below -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Cheque No./ Transaction No.:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="number" min="1" class="form-control  border-black" name="cheque_transaction_no" id="cheque_transaction_no" maxlength="20" placeholder="Enter Cheque No./ Transaction No." value="<?= isset($payment->cheque_transaction_no) ? $payment->cheque_transaction_no : '';?>">
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
