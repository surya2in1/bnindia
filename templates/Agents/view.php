<?php use Cake\Routing\Router; ?>

<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Agents</h3>
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
                            View Agent
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body"> 
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Agent Code:</label>
                                <div class="col-lg-6">
                                    <label class="col-lg-3 col-form-label"><?= isset($agent->agent_code) ? $agent->agent_code : '';?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Name:</label>
                                <div class="col-lg-6">
                                    <label class="col-lg-3 col-form-label"><?= isset($agent->name) ? $agent->name : '';?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Address:</label>
                                <div class="col-lg-6">
                                    <label class="col-lg-3 col-form-label"><?= isset($agent->address) ? $agent->address:'';?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Mobile No.:</label>
                                <div class="col-lg-6">
                                    <label class="col-lg-3 col-form-label"><?= isset($agent->mobile_number) ? $agent->mobile_number : '';?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Email:</label>
                                <div class="col-lg-6">
                                    <label class="col-lg-3 col-form-label"><?= isset($agent->email) ? $agent->email : '';?></label>
                                </div>
                            </div>
                           
                           <div class="row">
                                <label class="col-xl-3"></label>
                                <div class="col-lg-6 col-xl-6">
                                    <h3 class="kt-section__title kt-section__title-sm">Important Documents:</h3>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">Address Proof</label>
                                <div class="col-lg-6 col-xl-6">
                                    <div class="input-group">
                                        <?php if($agent->address_proof){ ?>
                                        <div class="existing-address-doc" >
                                            <div class="kt-widget__media">
                                                <img src="<?= Router::url('/', true); ?>agents_docs/address_proof/<?= $agent->address_proof; ?>"width="25%" alt="image">
                                            </div>
                                        </div>
                                        <?php } ?> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">Photo Proof</label>
                                <div class="col-lg-6 col-xl-6">
                                    <div class="input-group">
                                        <?php if($agent->photo){ ?>
                                        <div class="existing-photo-doc" >
                                            <div class="kt-widget__media">
                                                <img src="<?= Router::url('/', true); ?>agents_docs/photo/<?= $agent->photo; ?>"width="25%" alt="image">
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">PAN Card</label>
                                <div class="col-lg-6 col-xl-6">
                                    <div class="input-group">
                                        <?php if($agent->pan_card){ ?>
                                        <div class="existing-photo-doc" >
                                            <div class="kt-widget__media">
                                                <img src="<?= Router::url('/', true); ?>agents_docs/pan_card/<?= $agent->pan_card; ?>"width="25%" alt="image">
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">Educational Proof</label>
                                <div class="col-lg-6 col-xl-6">
                                    <div class="input-group">   
                                        <?php if($agent->educational_proof){ ?>
                                        <div class="existing-other-doc" >
                                            <div class="kt-widget__media">
                                                <img src="<?= Router::url('/', true); ?>agents_docs/educational_proof/<?= $agent->educational_proof; ?>"width="25%" alt="image">
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> 

                            <div class="row">
                                <label class="col-xl-3"></label>
                                <div class="col-lg-6 col-xl-6">
                                    <h3 class="kt-section__title kt-section__title-sm">Account Details:</h3>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">Bank name</label>
                                <div class="col-lg-6 col-xl-6"> 
                                      <label class="col-lg-3 col-form-label"><?= isset($agent->bank_name) ? $agent->bank_name : '';?></label>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">Account Number</label>
                                <div class="col-lg-6 col-xl-6">
                                     <label class="col-lg-3 col-form-label"><?= isset($agent->account_no) ? $agent->account_no : '';?></label>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">IFSC Code</label>
                                <div class="col-lg-6 col-xl-6">
                                      <label class="col-lg-3 col-form-label"><?= isset($agent->ifsc_code) ? $agent->ifsc_code : '';?></label>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">Branch Name</label>
                                <div class="col-lg-6 col-xl-6">
                                      <label class="col-lg-3 col-form-label"><?= isset($agent->branch_name) ? $agent->branch_name : '';?></label>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">Bank Address</label>
                                <div class="col-lg-6 col-xl-6">
                                      <label class="col-lg-3 col-form-label"><?= isset($agent->bank_address) ? $agent->bank_address : '';?></label>
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

