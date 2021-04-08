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
                             Add members in group
                        </h3>
                        <lable>(Fields marked with * are mandatory.)</lable>
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

                                 <?php if(($groupid > 0 && $group->status== 1) OR $groupid < 1){ ?>
                                 <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Search member by name:<span class="required" aria-required="true"> * </span></label>
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


                                 <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><b>List of group members:</b></label>
                                    <div class="col-lg-6">
                                    </div>
                                 </div>
                                 
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
                                    <a href="groups" class="btn btn-secondary">Cancel</a>
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

