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
                            <?= ($paymentid > 0 ) ? 'Edit Receipt' : 'Add Receipt'; ?> 
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
                                    <label class="col-lg-3 col-form-label">Receipt no:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="receipt_no" placeholder="Enter Receipt No" value="<?= isset($payment->receipt_no) ? $payment->receipt_no : $receipt_no;?>" autofocus="true" readonly title="You can not change this value.">
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Date:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="" value="<?= isset($payment->date) && strtotime($payment->date) > 0 ? date('m/d/Y',strtotime($payment->date)) : date('m/d/Y');?>" name="date"  title="You can not change this value."> 
                                        </div>
                                    </div>
                                </div>  

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Group:<span class="required" aria-required="true"> * </span></label>
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
                                    <div class="kt-spinner kt-spinner--v2 kt-spinner--md kt-spinner--danger hide bnspinner"></div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Member:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <?php $payment_member_id =  isset($payment->user_id) ? $payment->user_id : 0;
                                        ?>
                                        <input type="hidden" name="payment_member_id" id="payment_member_id" value="<?= $payment_member_id ?>">

                                        <!-- Get member list -->
                                        <select id="members" name="user_id" class="form-control border-black" onchange="getInstalmentNo();">
                                             <option value="">Select Member</option>
                                             
                                        </select> 
                                    </div>
                                    <div class="kt-spinner kt-spinner--v2 kt-spinner--md kt-spinner--danger hide bnspinner-member"></div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Subscriber Ticket No:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="subscriber_ticket_no" placeholder="Enter Subscriber Ticket No" value="<?= isset($payment->subscriber_ticket_no) ? $payment->subscriber_ticket_no : '';?>"  id="subscriber_ticket_no" readonly title="You can not change this value.">
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Instalment No:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <?php $payment_instalment_no =  isset($payment->instalment_no) ? $payment->instalment_no : 0;
                                        ?>
                                         <input type="hidden" name="payment_instalment_no" id="payment_instalment_no" value="<?= $payment_instalment_no ?>">

                                        <!-- Get payment_instalment_no list -->
                                        <select id="instalment_no" name="instalment_no" class="form-control border-black" onchange="getRemaingPayments();">
                                             <option value="">Select Instalment No</option>
                                           
                                        </select> 
                                    </div>
                                    <div class="kt-spinner kt-spinner--v2 kt-spinner--md kt-spinner--danger hide bnspinner-instalment"></div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Instalment Month:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="instalment_month" name="instalment_month" placeholder="Enter Instalment Month" value="<?= isset($payment->instalment_month) ? $payment->instalment_month : '';?>"  readonly title="You can not change this value.">
                                        <?php $instalment_month =  isset($payment->instalment_month) ? $payment->instalment_month : 0;?>
                                        <?php 
                                        $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');

                                        ?>
                                            <!--Show months in php list-->
                                        <!-- <select id="instalment_month" name="instalment_month" class="form-control"> 
                                            <?php
                                                // foreach ($months as $num => $name) {
                                                //     $selected = ($num == $instalment_month) ? 'selected' : '';
                                                //     echo '<option value="'.$num.'" '.$selected.'>'.$name.'</option>';
                                                // }
                                            ?>
                                        </select>  --> 
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Due date of payment:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <?php 
                                        $month_dates = array_combine( range(1,31), range(1,31));  
                                        $date =  isset($payment->due_date) ? $payment->due_date : 0;
                                        ?>
                                        <!-- <select id="due_date" name="due_date" class="form-control">
                                            <?php foreach($month_dates  as $key => $month_date){ ?>
                                            <option value="<?= $key; ?>" <?php if($date == $key){ echo "selected";}?>><?= $month_date; ?></option> 
                                            <?php } ?>
                                        </select> -->

                                        <input type="text" class="form-control" readonly  id="due_date" name="due_date"  title="You can not change this value."/>
                                    </div>
                                </div>  

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Subscription Rs:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="subscription_amount" placeholder="Enter Subscription Rs" value="<?= isset($payment->subscription_amount) ? $payment->subscription_amount : '';?>" id="subscription_amount" onchange="calculate_total_amount()" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Late fee:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="late_fee" id="late_fee" placeholder="Enter Late fee" value="<?= isset($payment->late_fee) ? $payment->late_fee : '';?>" readonly title="You can not change this value." onchange="calculate_total_amount()">
                                        <input type="hidden" name="group_late_fee" id="group_late_fee" />
                                        <input type="hidden" name="net_subscription_amount" id="net_subscription_amount" />
                                        <input type="hidden" name="pending_amount" id="pending_amount" />
                                        <input type="hidden" name="auction_id" id="auction_id" />
                                        <input type="hidden" name="group_due_date" id="group_due_date" />
                                        <input type="hidden" name="due_late_fee" id="due_late_fee" />
                                        <input type="hidden" name="remaining_late_fee" id="remaining_late_fee" />
                                        <input type="hidden" name="is_late_fee_clear" id="is_late_fee_clear" />
                                        <input type="hidden" name="total_due_amount" id="total_due_amount"  value= "0.00"/>
                                        <input type="hidden" name="remaining_subscription_amount" id="remaining_subscription_amount" />
                                        <input type="hidden" name="fixed_remaining_subscription_amount" id="fixed_remaining_subscription_amount" />
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Total Amount:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="total_amount" id="total_amount" placeholder="Enter Total Amount" value="<?= isset($payment->total_amount) ? $payment->total_amount : '';?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Received by:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">

                                         <?php $received_by =  isset($payment->received_by) ? $payment->received_by : 'monthly';?>
                                         
                                        <select id="received_by" name="received_by" class="form-control border-black"> 
                                            <option value="">Select</option>
                                            <!--Show months in php list-->
                                            <option value="1" <?php if($received_by == 1){ echo 'selected'; } ?>>Cash</option>
                                            <option value="2" <?php if($received_by == 2){ echo 'selected'; } ?>>Cheque</option>
                                            <option value="3" <?php if($received_by == 3){ echo 'selected'; } ?>>Direct Debit</option>
                                        </select>  
                                    </div>
                                </div>

                                <!-- If Cheque select then show below -->
                                <div class="form-group row hide-div cheque-div rec-by-div">
                                    <label class="col-lg-3 col-form-label">Cheque No:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="number" min="1" class="form-control border-black" name="cheque_no" placeholder="Enter Cheque No" value="<?= isset($payment->cheque_no) ? $payment->cheque_no : '';?>" id="cheque_no">
                                    </div>
                                </div>

                                 <div class="form-group row hide-div cheque-div rec-by-div">
                                    <label class="col-lg-3 col-form-label">Date:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control border-black" readonly="" value="<?= isset($payment->cheque_date) && strtotime($payment->cheque_date) > 0 ? date('m/d/Y',strtotime($payment->cheque_date)) : '';?>" id="cheque_date_datepicker" name="cheque_date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>      

                                <div class="form-group row hide-div cheque-div rec-by-div">
                                    <label class="col-lg-3 col-form-label">Bank details:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control border-black" name="cheque_bank_details" placeholder="Enter Bank details" value="<?= isset($payment->cheque_bank_details) ? $payment->cheque_bank_details : '';?>" id="cheque_bank_details">
                                    </div>
                                </div>

                                <div class="form-group row hide-div cheque-div rec-by-div">
                                    <label class="col-lg-3 col-form-label">Drown on:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control border-black" name="cheque_drown_on" placeholder="Enter Drown on" value="<?= isset($payment->cheque_drown_on) ? $payment->cheque_drown_on : '';?>" id="cheque_drown_on">
                                    </div>
                                </div>

                                <!-- If direct_debit select then show below -->

                                <div class="form-group row hide-div direct-debit-div rec-by-div">
                                    <label class="col-lg-3 col-form-label">Date:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control border-black" readonly="" value="<?= isset($payment->direct_debit_date) && strtotime($payment->direct_debit_date) > 0 ? date('m/d/Y',strtotime($payment->direct_debit_date)) : '';?>" id="direct_debit_datepicker" name="direct_debit_date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>      

                                <div class="form-group row hide-div direct-debit-div rec-by-div">
                                    <label class="col-lg-3 col-form-label">Transaction no:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="number" min="1" class="form-control border-black" name="direct_debit_transaction_no" placeholder="Enter Transaction no" value="<?= isset($payment->direct_debit_transaction_no) ? $payment->direct_debit_transaction_no : '';?>" id="direct_debit_transaction_no">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Received amount:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="received_amount" id="received_amount" placeholder="Enter Received Amount" value="<?= isset($payment->received_amount) ? $payment->received_amount : '0.00';?>" readonly >
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Net Due amount:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="remark" id="remark" placeholder="Enter Net Due amount" value="<?= isset($payment->remark) ? $payment->remark : '';?>" readonly>
                                    </div>
                                </div>
                                
                                <div class="kt-portlet__foot border-bottom-9px  marg-bot-0 hide" id="payment_received_amount_div">
                                    <div class="form-group row">
                                        <div class="col-lg-3"> 
                                            <button type="button" class="btn btn-secondary" id="received_amount_btn">Received Amount</button>
                                        </div>
                                        <label class="col-lg-1 col-form-label txt-center"><b> &nbsp;&nbsp;- </b></label>
                                        <div class="col-lg-6"> 
                                            <input type="number" class="form-control" name="total" id="total" readonly>
                                        </div>
                                    </div>   
                                    
                                    
                                    <div class="form-group row received_amount_div">
                                        <table class="table table-striped- table-bordered table-hover table-checkable" id="money_notes_table">
                                            <thead>
                                                <tr> 
                                                    <th><b>Notes</b></th>
                                                    <th><b>No. Of Notes</b></th>
                                                    <th><b>Amount</b></th>
                                                </tr> 
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2000</td> 
                                                    <td><input type="number" class="form-control border-black group-required" name="money_notes[2000][val]" id="no_of_two_thousands_notes" placeholder="Enter No. Of Two Thousands Notes" value="" lbl-val="2000"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[2000][total]" id="no_of_two_thousands_notes_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td>1000</td> 
                                                    <td><input type="number" class="form-control border-black group-required" name="money_notes[1000][val]" id="no_of_one_thousands_notes" placeholder="Enter No. Of One Thousands Notes" value="" lbl-val="1000"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[1000][total]" id="no_of_one_thousands_notes_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td>500</td> 
                                                    <td><input type="number" class="form-control border-black" name="money_notes[500][val]" id="no_of_five_hundred_notes" placeholder="Enter No. Of Five Hundred Notes" value="" lbl-val="500"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[500][total]" id="no_of_five_hundred_notes_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td>100</td> 
                                                    <td><input type="number" class="form-control border-black" name="money_notes[100][val]" id="no_of_hundred_notes" placeholder="Enter No. Of Hundred Notes" value="" lbl-val="100"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[100][total]" id="no_of_hundred_notes_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td>50</td> 
                                                    <td><input type="number" class="form-control border-black" name="money_notes[50][val]" id="no_of_fifty_notes" placeholder="Enter No. Of Fifty Notes" value="" lbl-val="50"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[50][total]" id="no_of_fifty_notes_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td>20</td> 
                                                    <td><input type="number" class="form-control border-black" name="money_notes[20][val]" id="no_of_twenty_notes" placeholder="Enter No. Of Twenty Notes" value="" lbl-val="20"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[20][total]" id="no_of_twenty_notes_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td>10</td> 
                                                    <td><input type="number" class="form-control border-black" name="money_notes[10][val]" id="no_of_ten_notes" placeholder="Enter No. Of Ten Notes" value="" lbl-val="10"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[10][total]" id="no_of_ten_notes_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td>5</td> 
                                                    <td><input type="number" class="form-control border-black" name="money_notes[5][val]" id="no_of_five_notes" placeholder="Enter No. Of Five Notes" value="" lbl-val="5"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[5][total]" id="no_of_five_notes_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td><b>Coins</b></td> 
                                                    <td><b>No. Of Coins</b></td> 
                                                    <td><b>Amount</b></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td>1rs coins</td> 
                                                    <td><input type="number" class="form-control border-black" name="money_notes[1c][val]" id="no_of_one_rs_coins" placeholder="Enter No. Of One Rs Coins" value="" lbl-val="1"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[1c][total]" id="no_of_one_rs_coins_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td>2rs coins</td> 
                                                    <td><input type="number" class="form-control border-black" name="money_notes[2c][val]" id="no_of_two_rs_coins" placeholder="Enter No. Of Two Rs Coins" value="" lbl-val="2"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[2c][total]" id="no_of_two_rs_coins_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td>5rs coins</td> 
                                                    <td><input type="number" class="form-control border-black" name="money_notes[5c][val]" id="no_of_five_rs_coins" placeholder="Enter No. Of Five Rs Coins" value="" lbl-val="5"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[5c][total]" id="no_of_five_rs_coins_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td>10rs coins</td> 
                                                    <td><input type="number" class="form-control border-black" name="money_notes[10c][val]" id="no_of_ten_rs_coins" placeholder="Enter No. Of Ten Rs Coins" value="" lbl-val="10"></td> 
                                                    <td> <input type="number" class="form-control total" name="money_notes[10c][total]" id="no_of_ten_rs_coins_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td><b>Reverse</b></td> 
                                                    <td><b>No. Of Notes</b></td> 
                                                    <td><b>Amount</b></td> 
                                                </tr>
                                                
                                                <tr>
                                                    <td><input type="number" class="form-control border-black"  id="reverse_notes" placeholder="Enter Reverse Notes" value=""></td> 
                                                    <td><input type="number" class="form-control border-black" name="money_notes[r][val]" id="no_of_reverse_notes" placeholder="Enter No. Of Reverse Notes" value="" lbl-val="0"></td> 
                                                    <td><input type="number" class="form-control total" name="money_notes[r][total]" id="no_of_reverse_notes_total" placeholder="Enter Total" value="" readonly></td> 
                                                </tr>
                                            
                                                <tr>
                                                    <td  colspan="2" class="txt-center"><b>Total</b></td> 
                                                    <td><input type="number" class="form-control" name="money_notes[money_notes_total]" id="money_notes_total" readonly></td> 
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                               <div class="kt-portlet__foot border-bottom-9px  marg-bot-0">
                                <!--<div class="form-group row received_amount_div" style="">-->
                                <!--    <label class="col-lg-1 col-form-label"><b>2000 &nbsp;&nbsp;&nbsp;    X </b></label>-->
                                <!--    <div class="col-lg-4"> -->
                                <!--        <input type="number" class="form-control border-black" name="money_notes[2000][val]" id="no_of_two_thousands_notes" placeholder="Enter No. Of Two Thousands Notes" value="" lbl-val="2000">-->
                                <!--    </div>-->
                                <!--    <label class="col-lg-1 col-form-label txt-center"><b> &nbsp;&nbsp;= </b></label>-->
                                <!--    <div class="col-lg-4"> -->
                                <!--        <input type="number" class="form-control total" name="money_notes[2000][total]" id="no_of_two_thousands_notes_total" placeholder="Enter Total" value="" readonly="">-->
                                <!--    </div>-->
                                <!-- </div>-->
                                <!-- <div class="form-group row received_amount_div">-->
                                <!--    <label class="col-lg-1 col-form-label"><b>Total&nbsp;&nbsp;&nbsp;    </b></label>-->
                                <!--    <label class="col-lg-1 col-form-label txt-center"><b> &nbsp;&nbsp;= </b></label>-->
                                <!--    <div class="col-lg-4"> -->
                                        
                                <!--    </div>-->
                                <!-- </div> -->
                                <!--</div>-->
                                 
                                 
                                <div class="form-group row marg-bot-0">
                                    <label class="col-lg-4 col-form-label" id="list_label"><b>Due Payments:</b></label>
                                    <div class="col-lg-6"> 
                                    </div>
                                 </div>
                                 <div class="form-group row kt-portlet__body">

                                    <!--begin: Datatable -->
                                    <table class="table table-striped- table-bordered table-hover table-checkable" id="due_payment_table">
                                        <thead>
                                            <tr> 
                                                <th>Instalment No.</th>
                                                <th>Instalment Month</th>
                                                <th>Subcription Rs</th>
                                                <th>Due Amount</th>
                                                <th>Due Late Fee</th>
                                                <th>Total Due Amount</th>
                                            </tr>
                                        </thead>
                                        <tfoot align="right" class="due_payment_tfoot hide-div">
                                            <tr><th></th><th></th><th></th><th></th><th></th><th></th></tr>
                                        </tfoot>
                                    </table>

                                    <!--end: Datatable -->
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

