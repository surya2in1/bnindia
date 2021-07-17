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
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                             Add members in group
                        </h3>
                        <lable>(Fields marked with * are mandatory.)</lable>
                    </div>
                </div>
                <input type="hidden" name="router_url" id="router_url" value="<?php echo Router::url('/', true); ?>" />
                <input type="hidden" id="config_superadmin_role" value="<?= $config_superadmin_role;?>">
                <input type="hidden" id="user_role" value="<?= $role;?>">
                <!--begin::Form-->
                <?= $this->Form->create(null, array(
                       'class'=>'kt-form',
                       'id'=>'group_form',
                       'method'=> 'Post'
                     )); ?> 
                    <div class="kt-portlet__body pad-bot-0">
                        <div class="kt-section kt-section--first marg-bot-0">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Group:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6"> 
                                        <select id="id" name="group_id" class="form-control" onchange="refresh_member_table()">
                                            <option value="0">Select Group</option>
                                             <?php if($groups){ 
                                                foreach ($groups as $key => $group) {?>
                                                    <option <?php if($key == 1){?> selected='selected' <?php } ?> value="<?= $key; ?>"><?=$group?></option>
                                               <?php } 
                                            } ?> 
                                        </select> 
                                    </div>
                                    <div class="kt-spinner kt-spinner--v2 kt-spinner--md kt-spinner--danger hide bnspinner"></div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Search member by customer id or customer name:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <div class="typeahead">
                                            <input class="form-control" id="customer_id_typeahead" type="text" dir="ltr" placeholder="Enter Customer Id or Customer Name" customer_id = "" cust_id="" name="" address="" autocomplete="chrome-off"/>  
                                        </div> 
                                        <span class="kt-margin-l-10"> <a href="member-form" target="_blank" class="kt-link kt-font-bold">If member not create then create a member using this link</a></span>
                                    </div> 
                                    <div class="col-lg-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6"> 
                                 <button type="button" id="btn_add_members" class="btn btn-success" onclick="add_member_to_existing_group();">
                                    Submit
                                    </button>
                                <a href="groups" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div> 
                <?= $this->Form->end() ?>
                <!--end::Form-->
                <div class="kt-portlet__body">
                     <div class="form-group row">
                        <label class="col-lg-4 col-form-label" id="list_label"><b>List of group members:</b></label>
                        <div class="col-lg-6"> 
                        </div>
                     </div> 

                    <div class="form-group row">
                        <div class="col-lg-12">  
                                <!--begin: Datatable -->
                                <table class="table table-striped- table-bordered table-hover table-checkable" id="group_members_table">
                                    <thead>
                                        <tr> 
                                            <th>Customer Id</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Ticket No</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                                <!--end: Datatable --> 
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end:: Content -->

