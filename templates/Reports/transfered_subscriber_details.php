<?php
use Cake\Routing\Router;
?>
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Reports</h3>
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
                             Transfered Subscriber List
                        </h3>
                        <lable>(Fields marked with * are mandatory.)</lable>
                    </div>
                </div>
                <input type="hidden" name="router_url" id="router_url" value="<?php echo Router::url('/', true); ?>" /> 

                <!--begin::Form-->
                <?= $this->Form->create(null, array(
                       'class'=>'kt-form', 
                       'id'=>'report_form',
                       'url'=>  Router::url('/', true).'reports/transfered_subscriber_details_pdf',
                       'method'=> 'Post'
                     )); ?> 
                    <div class="kt-portlet__body pad-bot-0">
                        <div class="kt-section kt-section--first marg-bot-0">
                            <div class="kt-section__body">

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2 col-sm-12">Group:<span class="required" aria-required="true"> * </span></label>
                                    <div class="col-lg-6">
                                        <select id="group_id" name="group_id" class="form-control">
                                             <option value="">Select Group</option>
                                             <?php if($groups){ 
                                                foreach ($groups as $key => $group) {?>
                                                    <option value="<?= $key; ?>"><?=($group);?></option>
                                               <?php } 
                                            } ?> 
                                        </select> 
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
                                    <button type="submit"  class="btn btn-success">Submit</button>
                                    <button type="reset" id="cancel" class="btn btn-secondary">Cancel</button>
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

