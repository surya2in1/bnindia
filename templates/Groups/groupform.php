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
                                    <label class="col-lg-3 col-form-label">Chit Amount:</label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="chit_amount" placeholder="Enter Chit Amount" value="<?= isset($group->chit_amount) ? $group->chit_amount : '';?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Total Number:</label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="total_number" placeholder="Enter Total Number" value="<?= isset($group->total_number) ? $group->total_number : '';?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Premium:</label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="premium" placeholder="Enter Premium" value="<?= isset($group->premium) ? $group->premium : '';?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Goverment Registration Number:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="gov_reg_no" placeholder="Enter Goverment Registration Number" value="<?= isset($group->gov_reg_no) ? $group->gov_reg_no : '';?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Date:</label>
                                    <div class="col-lg-6">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="" value="<?= isset($group->date) && strtotime($group->date) > 0 ? date('m/d/Y',strtotime($group->date)) : '';?>" id="kt_datepicker_3" name="date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="form-text text-muted">Enable clear and today helper buttons</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Number of months:</label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="no_of_months" placeholder="Enter Number of months" value="<?= isset($group->no_of_months) ? $group->no_of_months : '';?>">
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

