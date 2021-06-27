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
                           Other Payment
                        </h3>
                    </div>
                </div>
                <input type="hidden" name="router_url" id="router_url" value="<?php echo Router::url('/', true); ?>" />
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Payment Head:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->payment_head->payment_head) ? $payment->payment_head->payment_head : '-';?></label> 
                                </div> 
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Date:</label>
                                <div class="col-lg-6">
                                     <?php 
                                        $date = '-';
                                        if(strtotime($payment->date) > 0){
                                            $date = date('m/d/Y',strtotime($payment->date));
                                        }
                                    ?>
                                    <label class="col-form-label"><?= $date;?></label> 
                                </div>
                            </div>  
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Paid to Shri/Smt:</label>
                                <div class="col-lg-6">
                                     <label class="col-form-label"><?= isset($payment->paid_to_name) ? $payment->paid_to_name : '-';?></label> 
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Total Amount:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->total_amount) ? $payment->total_amount : '-';?></label> 
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Less GST:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->gst) ? $payment->gst : '-';?></label>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Less TDS:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->less_tds) ? $payment->less_tds : '-';?></label>
                                </div>
                            </div>
                            
                             <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Total Amount Paid Rs:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->total_amount_paid_rs) ? $payment->total_amount_paid_rs : '-';?></label>
                                </div>
                            </div>
                            
                            <!-- If Cheque select then show below -->
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Cheque No./ Transaction No.:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->cheque_transaction_no) ? $payment->cheque_transaction_no : '-';?></label
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
                                <button  type="button" onclick="history.go(-1);" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<!-- end:: Content -->
