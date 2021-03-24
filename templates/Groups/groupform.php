<?php
use Cake\Routing\Router;
?>
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Groups</h3>
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
<?php $groupid = isset($group->id) && ($group->id > 0) ? $group->id : '0';?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <?= ($groupid > 0 ) ? 'Edit Group' : 'Add Group'; ?> 
                        </h3>
                    </div>
                </div>
                <input type="hidden" name="router_url" id="router_url" value="<?php echo Router::url('/', true); ?>" />
                <!--begin::Form-->
                <?= $this->Form->create(null, array(
                       'class'=>'kt-form',
                       'id'=>'group_form',
                       'method'=> 'Post'
                     )); ?>
                      <input type="hidden" name="id" id="id" value="<?= $groupid; ?>">
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Group Number:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="group_number" placeholder="Enter Group Number" value="<?= isset($group->group_number) ? $group->group_number : '';?>" autofocus="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Group Type:</label>
                                    <div class="col-lg-6">
                                        <?php $group_type =  isset($group->group_type) ? $group->group_type : 'monthly';?>
                                        <select id="group_type" name="group_type" class="form-control" onchange="calculate_no_of_months();">
                                            <option value="monthly" <?php if($group_type == 'monthly'){ echo 'selected'; } ?>>Monthly</option>
                                            <option value="forthnight" <?php if($group_type == 'forthnight'){ echo 'selected'; } ?> >Forthnight</option>
                                            <option value="weekly" <?php if($group_type == 'weekly'){ echo 'selected'; } ?> >Weekly</option>
                                            <option value="daily" <?php if($group_type == 'daily'){ echo 'selected'; } ?> >Daily</option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Chit Amount:</label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="chit_amount" id="chit_amount" placeholder="Enter Chit Amount" value="<?= isset($group->chit_amount) ? $group->chit_amount : '';?>" onchange="calculate_premium(),calculate_no_of_months();">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Total Member:</label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="total_number" placeholder="Enter Total Member" value="<?= isset($group->total_number) ? $group->total_number : '';?>" id="total_number"  onchange="calculate_premium(),calculate_no_of_months();">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Number of months:</label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="no_of_months" placeholder="Enter Number of months" value="<?= isset($group->no_of_months) ? $group->no_of_months : '';?>" id="no_of_months" onchange="calculate_no_of_months();">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Premium:</label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="premium" placeholder="Enter Premium" value="<?= isset($group->premium) ? $group->premium : '';?>" id="premium" readonly onchange="calculate_no_of_months();">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Goverment Registration Number:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="gov_reg_no" placeholder="Enter Goverment Registration Number" value="<?= isset($group->gov_reg_no) ? $group->gov_reg_no : '';?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Auction Day:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="auction_day" placeholder="Enter Auction Day" value="<?= isset($group->auction_day) ? $group->auction_day : '';?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Late fee(in percent):</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="late_fee" placeholder="Enter Late Fee" value="<?= isset($group->late_fee) ? $group->late_fee : '';?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Collection Date:</label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="" value="<?= isset($group->date) && strtotime($group->date) > 0 ? date('m/d/Y',strtotime($group->date)) : '';?>" id="kt_datepicker_3" name="date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                 <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><b>List of group members:</b></label>
                                    <div class="col-lg-6">
                                    </div>
                                 </div>

                                 <?php if(($groupid > 0 && $group->status== 1) OR $groupid < 1){ ?>
                                 <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Search member by name:</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="typeahead">
                                            <input class="form-control" id="customer_id_typeahead" type="text" dir="ltr" placeholder="Enter Name" customer_id = "" cust_id="" name="" address="" autocomplete="chrome-off"/>  
                                        </div> 
                                    </div>
                                    <div class="col-lg-5">
                                        <button type="button" id="btn_add_members" class="btn btn-success"   <?php if($groupid > 0){ ?> onclick="add_member_to_existing_group();"<?php }else{?>  onclick="add_member_to_new_group();" <?php }?>
                                            >
                                        Add Member
                                        </button>
                                    </div>
                                </div>
                                <?php } ?>

                                <?php if($groupid > 0){ ?> 
                                <div class="form-group row">
                                    <div class="col-lg-12">  
                                            <!--begin: Datatable -->
                                            <table class="table table-striped- table-bordered table-hover table-checkable" id="group_members_table">
                                                <thead>
                                                    <tr> 
                                                        <th>Customer Id</th>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <!--end: Datatable --> 
                                    </div>
                                </div>
                                <?php }else{?>
                                    <div class="form-group row">                                    
                                        <div class="col-lg-12">  
                                                <!--begin: Datatable -->
                                                <table class="table table-striped- table-bordered table-hover table-checkable" id="new_group_members_table">
                                                    <thead>
                                                        <tr> 
                                                            <th>Customer Id</th>
                                                            <th>Name</th>
                                                            <th>Address</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <!--end: Datatable --> 
                                        </div>
                                    </div>
                                <?php } ?>

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

