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
                            View Payment Voucher 
                        </h3>
                    </div>
                </div>
                <input type="hidden" name="router_url" id="router_url" value="<?php echo Router::url('/', true); ?>" />
                 
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body">
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
                                <label class="col-lg-3 col-form-label">Chit Series No./Group No.:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->group->group_code) ? $payment->group->group_code : '-';?></label>
                                </div> 
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Group Auction No.:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->auction->auction_no) ? $payment->auction->auction_no : '-';?></label> 
                                </div> 
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Paid to Shri/Smt:</label>
                                <div class="col-lg-6">
                                     <label class="col-form-label"><?= isset($payment->name) ? $payment->name : '-';?></label> 
                                </div>
                            </div>
                        
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Auction Date:</label>
                                <div class="col-lg-6">
                                     <?php 
                                        $auction_date = '-';
                                        if(strtotime($payment->auction_date) > 0){
                                            $auction_date = date('m/d/Y',strtotime($payment->auction_date));
                                        }
                                    ?>
                                    <label class="col-form-label"><?=  $auction_date;?></label>
                                </div>
                            </div>  

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Total Value Of The Chit:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->chit_amount) ? $payment->chit_amount : '-';?></label> 
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Less Forman Commission:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->foreman_commission) ? $payment->foreman_commission : '-';?></label> 
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Less Dividend To Members:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->total_subscriber_dividend) ? $payment->total_subscriber_dividend : '-';?></label> 
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Less GST:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->gst) ? $payment->gst : '-';?></label> 
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Total Amount:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->total) ? $payment->total : '-';?></label> 
                                </div>
                            </div>
                            
                            <!-- If Cheque select then show below -->
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Cheque No./ D.D:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->cheque_dd_no) ? $payment->cheque_dd_no : '-';?></label> 
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Particular Resaon:</label>
                                <div class="col-lg-6">
                                    <label class="col-form-label"><?= isset($payment->resaon) ? $payment->resaon : '-';?></label> 
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

