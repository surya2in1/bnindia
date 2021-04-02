<?php
use Cake\Routing\Router;
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
<?php $auctionid = isset($auction->id) && ($auction->id > 0) ? $auction->id : '0';?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <?= ($auctionid > 0 ) ? 'Edit Auction Winner ' : 'Add Auction Winner '; ?> 
                        </h3>
                        <lable>(Fields marked with * are mandatory.)</lable>
                    </div> 
                </div>
                <input type="hidden" name="router_url" id="router_url" value="<?php echo Router::url('/', true); ?>" />
                <!--begin::Form-->
                <?= $this->Form->create(null, array(
                       'class'=>'kt-form',
                       'id'=>'auction_form',
                       'method'=> 'Post'
                     )); ?>
                      <input type="hidden" name="id" id="id" value="<?= $auctionid; ?>">
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Group Number:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <?php $auction_group_id =  isset($auction->group_id) ? $auction->group_id : 0;?>
                                        <!-- Get groups after select member -->
                                        <select id="groups" name="group_id" class="form-control" autofocus="true">
                                            <option value="">Select Group</option>
                                             <?php if($groups){ 
                                                foreach ($groups as $key => $group_code) {?>
                                                    <option <?php if($key == $auction_group_id){?> selected='selected' <?php } ?> value="<?= $key; ?>"><?=$group_code?></option>
                                               <?php } 
                                            } ?> 
                                        </select> 
                                        <input type="hidden" name="total_members" id="total_members">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Member:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <?php $auction_member_id =  isset($auction->auction_winner_member) ? $auction->auction_winner_member : 0;
                                        ?>
                                        <!-- Get member list -->
                                        <select id="auction_winner_member" name="auction_winner_member" class="form-control">
                                             <option value="">Select Member</option>
                                            <?php if($selected_group_members){ 
                                                foreach ($selected_group_members as $key => $member) {
                                                    ?>
                                                    <option <?php if($key == $auction_member_id){?> selected='selected' <?php } ?> value="<?= $key; ?>"><?=$member?></option>
                                               <?php } 
                                            }  ?> 
                                        </select> 
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Auction no:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" readonly name="auction_no"  id="auction_no" placeholder="Enter Auction No" value="<?= isset($auction->auction_no) ? $auction->auction_no : 0;?>" >
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Auction Date:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="" value="<?= isset($auction->auction_date) && strtotime($auction->auction_date) > 0 ? date('m/d/Y',strtotime($auction->auction_date)) : '';?>" id="auction_date" name="auction_date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Auction Highest Percent:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="auction_highest_percent" placeholder="Enter Auction Highest Percent" value="<?= isset($auction->auction_highest_percent) ? $auction->auction_highest_percent : '';?>" id="auction_highest_percent" onchange="calculate_subscription_amount();">
                                    </div>
                                    <label class="col-lg-3 col-form-label">%</label>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Chit Amount:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="chit_amount" placeholder="Enter Chit Amount" value="<?= isset($auction->chit_amount) ? $auction->chit_amount : '';?>" id="chit_amount" readonly  onchange="calculate_subscription_amount();" title="You can not change this value.">
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Discount Amount:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="discount_amount" placeholder="Enter Discount Amount" value="<?= isset($auction->discount_amount) ? $auction->discount_amount : '';?>" id="discount_amount" readonly  onchange="calculate_subscription_amount();" title="You can not change this value.">
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Priced Amount:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="priced_amount" placeholder="Enter Priced Amount" value="<?= isset($auction->priced_amount) ? $auction->priced_amount : '';?>" id="priced_amount" readonly  onchange="calculate_subscription_amount();" title="You can not change this value.">
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Foreman Commission:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="foreman_commission" placeholder="Enter Foreman Commission" value="<?= isset($auction->foreman_commission) ? $auction->foreman_commission : '5000';?>" id="foreman_commission" id="foreman_commission"  onchange="calculate_subscription_amount();">
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Total Subscriber Dividend:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="total_subscriber_dividend" placeholder="Enter Total Subscriber Dividend" value="<?= isset($auction->total_subscriber_dividend) ? $auction->total_subscriber_dividend : '';?>" id="total_subscriber_dividend"  readonly  onchange="calculate_subscription_amount();" title="You can not change this value.">
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Subscriber Dividend:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="subscriber_dividend" placeholder="Enter Subscriber Dividend" value="<?= isset($auction->subscriber_dividend) ? $auction->subscriber_dividend : '';?>" id="subscriber_dividend"  readonly  onchange="calculate_subscription_amount();" title="You can not change this value.">
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Net Subscription Amount:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="net_subscription_amount" placeholder="Enter Net Subscription Amount" value="<?= isset($auction->net_subscription_amount) ? $auction->net_subscription_amount : '';?>" id="net_subscription_amount" readonly  onchange="calculate_subscription_amount();" title="You can not change this value.">
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

