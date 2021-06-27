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
                                    <label class="col-lg-3 col-form-label">Date:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="" value="<?= isset($payment->date) && strtotime($payment->date) > 0 ? date('m/d/Y',strtotime($payment->date)) : date('m/d/Y');?>" name="date"  title="You can not change this value."> 
                                        </div>
                                    </div>
                                </div>  

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Chit Series No./Group No.:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <?php $payment_group_id =  isset($payment->group_id) ? $payment->group_id : 0;?>
                                        <!-- Get groups after select member -->
                                        <select id="groups" name="group_id" class="form-control  border-black">
                                            <option value="">Select Group</option>
                                             <?php if($groups){ 
                                                foreach ($groups as $key => $group) {?>
                                                    <option <?php if($key == $payment_group_id){?> selected='selected' <?php } ?> value="<?= $key; ?>"><?=$group?></option>
                                               <?php } 
                                            } ?> 
                                        </select> 
                                    </div>
                                    <div class="kt-spinner kt-spinner--v2 kt-spinner--md kt-spinner--danger hide grbnspinner"></div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Group Auction No.:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <?php $payment_auction_id =  isset($payment->auction_id) ? $payment->auction_id : 0;?>
                                        <input type="hidden" id="payment_auction_id" value="<?= $payment_auction_id;?>" />
                                        <!-- Get groups after select member -->
                                        <select id="group_auction_id" name="group_auction_id" class="form-control  border-black">
                                            <option value="">Select Auction No</option>
                                        </select> 
                                    </div>
                                    <div class="kt-spinner kt-spinner--v2 kt-spinner--md kt-spinner--danger hide bnspinner"></div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Paid to Shri/Smt:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="hidden" name="user_id" id="user_id" > 
                                        <input type="text" class="form-control" name="auction_winner" id="auction_winner" placeholder="Enter User" value="" readonly> 
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Auction Date:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="" value="<?= isset($payment->auction_date) && strtotime($payment->auction_date) > 0 ? date('m/d/Y',strtotime($payment->auction_date)) : '';?>" id="auction_date" name="auction_date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Total Value Of The Chit:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="chit_amount" id="chit_amount" placeholder="Enter Chit Amount" value="<?= isset($payment->chit_amount) ? $payment->chit_amount : '';?>" readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Less Forman Commission:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control txt" name="foreman_commission" id="foreman_commission" placeholder="Enter Less Forman Commission" value="<?= isset($payment->foreman_commission) ? $payment->foreman_commission : '';?>" >
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Less Dividend To Members:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control txt" name="total_subscriber_dividend" id="total_subscriber_dividend" placeholder="Enter Less Dividend To Members" value="<?= isset($payment->total_subscriber_dividend) ? $payment->total_subscriber_dividend : '';?>">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Less GST:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control txt" name="gst" id="gst" placeholder="Enter GST" value="<?= isset($payment->gst) ? $payment->gst : '';?>">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Total Amount:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="total" id="total" placeholder="Enter Total Amount" value="<?= isset($payment->total) ? $payment->total : '';?>" readonly>
                                    </div>
                                </div>
                                
                                <!-- If Cheque select then show below -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Cheque No./ D.D:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="number" min="1" class="form-control border-black" name="cheque_dd_no" id="cheque_dd_no" placeholder="Enter Cheque No./ D.D" value="<?= isset($payment->cheque_dd_no) ? $payment->cheque_dd_no : '';?>" id="cheque_dd_no">
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

