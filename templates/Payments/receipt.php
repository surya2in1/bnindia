 
<!-- end:: Content Head -->
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid payment-receipt padding-top-50" id="printableArea">
    <div class="row">
        <div class="col-lg-12">
            <div class="kt-portlet p-border">
                 <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body">
                            <!-- First row start -->
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-2 logo1-back max-width-20" > 
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 max-width-60" >
                                    <label class="col-lg-12 col-form-label txt-center">
                                        <h3 class="p-header">BNINDIA KURIES PVT. LTD.</h3>
                                        <h5>(Goverment Registered Chit Fund Company)</h5> 
                                    </label> 
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2" > 
                                </div>
                            </div> 
                            <!-- First row end -->

                            <!-- Second row start -->
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 max-width-25" > 
                                     <div class="row">
                                        <label class="col-lg-2 col-lg-2 col-sm-2 col-form-label max-width-50">No.: </label>
                                        <div class="col-lg-10  col-md-10 col-sm-10 max-width-50">
                                            <label class="col-lg-3 col-md-3 col-sm-3 col-form-label"><?= isset($receipt_data->receipt_no) ? $receipt_data->receipt_no : ''; ?></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg-2 col-lg-2 col-sm-2  col-form-label max-width-50">Date:</label>
                                        <div class="col-lg-10 col-md-10 col-sm-10 max-width-50">
                                            <label class="col-lg-12 col-md-12 col-sm-12 col-form-label"><?=$receipt_date; ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 txt-center max-width-50" >
                                    <label class="col-lg-5 col-md-5 col-sm-5 col-form-label p-rec-lbl">RECEIPT</label>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 max-width-25" >
                                    <label class="col-lg-12 col-form-label border-lbl1">Area Code: <?= isset($memberInfo->agent->agent_code) && ($memberInfo->agent->agent_code!='') ? $memberInfo->agent->agent_code : '----'; ?></label>
                                    <label class="col-lg-12 col-form-label border-lbl2">Cust Code: <?= isset($receipt_data->members_group->temp_customer_id) ? $receipt_data->members_group->temp_customer_id : ''; ?></label>
                                </div>
                            </div> 
                            <!-- Second row end -->

                            <!-- Third row start -->
                            <div class="row">
                                <div class="col-lg-12  ">
                                    <label class="col-form-label">Received with thanks from</label> 
                                </div>
                                <div class="col-lg-12  "> 
                                    <label class="col-form-label">Mr./Ms./M/s <?= isset($memberInfo->name) ? ucwords($memberInfo->name) : '-------'; ?><label>  
                                </div>
                                <div class="col-lg-12  "> 
                                    <label class="col-form-label">the sum of Rs <?= isset($receipt_data->total_amount) ? $receipt_data->total_amount : '-------'; ?></label>  
                                </div>
                                <div class="col-lg-12  "> 
                                    <div class="row">
                                        <label class="col-lg-6 col-form-label max-width-50">by <?= isset($received_by) ? $received_by : '-------'; ?></label>  
                                        <label class="col-lg-3 col-form-label max-width-25">dated- <?= isset($received_by_dt) ? $received_by_dt : '-------'; ?></label> 
                                        <label class="col-lg-3 col-form-label max-width-25">Transaction No. - <?= isset($received_by_tran_no) && !empty($received_by_tran_no) ? $received_by_tran_no : '-------'; ?></label> 
                                    </div>
                                </div>
                                <div class="col-lg-12  "> 
                                    <div class="row">
                                        <label class="col-lg-4 col-form-label max-width-50">Drown on- <?= isset($received_by_drown_on) && !empty($received_by_drown_on) ? $received_by_drown_on : '-------'; ?></label>  
                                        <label class="col-lg-8 col-form-label max-width-50">being subscription due as follows</label>  
                                    </div>
                                </div>
                            </div> 
                            <!-- Third row end -->

                            <!-- Forth row start -->
                            <div class="row">  
                                 <table class="table table-striped- table-bordered table-hover table-checkable ptable-bordered" id="receipt_table">
                                    <caption>
                                        <?= isset($branch_address) ? $branch_address : ''; ?>
                                        <br/>
                                        Reg. No.<?= isset($receipt_data->group->gov_reg_no) ? $receipt_data->group->gov_reg_no : '-'; ?> <br/><br/><br/>
                                     
                                    </caption>
                                   
                                    <thead>
                                        <tr> 
                                            <th rowspan="2">Chit Group</th>
                                            <th rowspan="2">T.No.</th>
                                            <th rowspan="2">Inst No.</th>
                                            <th rowspan="2">Month</th>
                                            <th colspan="2">Received Amount</th> 
                                            <th rowspan="2">Total Outstanding Amount</th>
                                            <th rowspan="2">Total Due Amount</th>
                                        </tr> 
                                        <tr>
                                            <th>Subscription Rs.</th>
                                            <th>Late Fee Rs.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= isset($receipt_data->group->group_code) ? $receipt_data->group->group_code : '-';  ?></td> 
                                            <td><?= isset($receipt_data->members_group->ticket_no) ? $receipt_data->members_group->ticket_no : '-';  ?></td> 
                                            <td><?= isset($receipt_data->instalment_no) ? $receipt_data->instalment_no : '-';  ?></td> 
                                            <td><?= isset($receipt_data->instalment_month) ? $receipt_data->instalment_month : '-';  ?></td>
                                            <td><?= isset($receipt_data->subscription_amount) ? $receipt_data->subscription_amount : '-';  ?></td> 
                                            <td><?= isset($receipt_data->late_fee) ? $receipt_data->late_fee : '-';  ?></td> 
                                            <td><?= isset($receipt_data->remark) ? $receipt_data->remark : '-';  ?></td>
                                            <td><?= isset($all_months_due_amount['total_amount']) ? $all_months_due_amount['total_amount'] : '-';  ?></td>
                                        </tr>
                                         <tr>
                                            <td></td> 
                                            <td></td> 
                                            <td></td> 
                                            <td><b>Total</b></td>
                                            <td colspan="2"><b><?= isset($receipt_data->total_amount) ? $receipt_data->total_amount : '-';  ?></b></td> 
                                            <td></td> 
                                            <td></td> 
                                        </tr>
                                    </tbody>
                                </table> 
                            </div> 
                            <!-- Forth row end -->

                             <div class="col-md-12" style=" text-align: end;">
                                        <lable>Authorised Representative</lable></div>
          
                        </div>
                    </div>
                </div> 
            </div>
            <a href="javascript:void(0);" class="hide-div" onclick="window.print()" id="printbtn">Print Page</a>
        </div>
    </div>
</div>
<!-- end:: Content -->
