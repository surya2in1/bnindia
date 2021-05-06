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
                            View Group
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Chit Amount:</label>
                                <div class="col-lg-6">
                                    <label class="col-lg-3 col-form-label"><?= isset($group->chit_amount) ? $group->chit_amount : '';?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Total Number:</label>
                                <div class="col-lg-6">
                                    <label class="col-lg-3 col-form-label"><?= isset($group->total_number) ? $group->total_number : '';?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Premium:</label>
                                <div class="col-lg-6">
                                    <label class="col-lg-3 col-form-label"><?= isset($group->premium) ? $group->premium : '';?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Goverment Registration Number:</label>
                                <div class="col-lg-6">
                                    <label class="col-lg-3 col-form-label"><?= isset($group->gov_reg_no) ? $group->gov_reg_no : '';?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Date:</label>
                                <div class="col-lg-6">
                                    <label class="col-lg-3 col-form-label"><?= isset($group->date) ? $group->date : '';?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Number of months:</label>
                                <div class="col-lg-6">
                                    <label class="col-lg-3 col-form-label"><?= isset($group->no_of_months) ? $group->no_of_months : '';?></label>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label  class="col-xl-3 col-lg-3 col-form-label" for="group_ids">Group Members:</label>
                                <div class="col-lg-6 col-xl-6">
                                    <?php if($membergroup){ 
                                        foreach ($membergroup as $key => $value) {
                                                echo ($key+1).'. '.$value->name."<br/> <br/>";
                                            }    
                                    }else{
                                        echo 'No members available';
                                    } ?>
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
                                <button type="button" onclick="history.go(-1);" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end:: Content -->

