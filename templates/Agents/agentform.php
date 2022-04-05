a<?php use Cake\Routing\Router; ?>

<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Agent</h3>
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
 <input type="hidden" name="router_url" id="router_url" value="<?php echo Router::url('/', true); ?>" />

<?php $agentid = isset($agent->id) && ($agent->id > 0) ? $agent->id : 0; ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title"> 
                            <?= ($agentid>0) ? 'Edit Member' : 'Add Agent';?>
                        </h3>
                        <lable>(All fields are mandatory.)</lable>
                    </div>
                </div>
                <!--begin::Form-->
                <?= $this->Form->create(null, array(
                       'class'=>'kt-form',
                       'id'=>'agent_form',
                       'enctype' => 'multipart/form-data',
                       'method'=> 'Post'
                     )); ?>
                    <input type="hidden" name="id" id="id" value="<?= $agent; ?>">
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="row">
                                    <label class="col-xl-3"></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <h3 class="kt-section__title kt-section__title-sm">Information:</h3>
                                    </div>
                                </div>     
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Name:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter First Name" value="<?= isset($agent->name) ? $agent->name : '';?>" autofocus="true" onchange="get_agent_code(<?= $agent; ?>)">
                                    </div>
                                </div>
                                 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Address</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <textarea class="form-control"  name="address"><?= isset($agent->address) ? $agent->address : '';?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Mobile No.</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                                            <input type="text" class="form-control" name="mobile_number" value="<?= isset($agent->mobile_number) ? $agent->mobile_number : '';?>" placeholder="Phone" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Email:</label>
                                    <div class="col-lg-6">
                                        <input type="email" class="form-control" <?php if($agentid > 0){ ?>readonly <?php }?> name="email" placeholder="Enter Email" value="<?= isset($agent->email) ? $agent->email : '';?>">
                                    </div>
                                </div>     
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Agent Code</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <input class="form-control" type="text" value="<?= isset($agent->agent_code) ? $agent->agent_code : '';?>" name="agent_code" id="agent_code" readonly>
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
                                                <br/>
                                                <button type="button" class="btn btn-success btn-sm" onClick="(function(){
                                                    $('.existing-address-doc').addClass('hide');
                                                    $('.new-address-doc').removeClass('hide');
                                                    return false;
                                                })();return false;">Change</button>
                                            </div>
                                            <div class="new-address-doc hide">
                                                <input class="file-input" id="address_proof" type="file" name="address_proof"> 
                                                <label for="address_proof" class="file-input-btn">Choose a file</label>
                                                <label class="file-name"></label>
                                            </div>
                                            <?php }else{ ?>
                                             <input class="file-input" type="file" id="address_proof" name="address_proof">
                                             <label for="address_proof" class="file-input-btn">Choose a file</label>
                                            <label class="file-name"></label> 
                                            <?php } ?> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">PAN Card</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="input-group">   
                                            <?php if($agent->pan_card){ ?>
                                            <div class="existing-other-doc" >
                                                <div class="kt-widget__media">
                                                    <img src="<?= Router::url('/', true); ?>agents_docs/pan_card_document/<?= $agent->pan_card; ?>"width="25%" alt="image">
                                                </div>
                                                <br/>
                                                <button type="button" class="btn btn-success btn-sm" onClick="(function(){
                                                    $('.existing-other-doc').addClass('hide');
                                                    $('.new-other-doc').removeClass('hide');
                                                    return false;
                                                })();return false;">Change</button>
                                            </div>
                                            <div class="new-other-doc hide">
                                                <input class="file-input" id="pan_card_document" type="file" name="pan_card_document"> 
                                                <label for="pan_card_document" class="file-input-btn">Choose a file</label>
                                                <label class="file-name"></label>
                                            </div>
                                            <?php }else{ ?>
                                             <input class="file-input" type="file" id="pan_card_document" name="pan_card_document"> 
                                            <label for="pan_card_document" class="file-input-btn">Choose a file</label>
                                                <label class="file-name"></label>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Photo Proof</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="input-group">
                                            <?php if($agent->photo_proof){ ?>
                                            <div class="existing-photo-doc" >
                                                <div class="kt-widget__media">
                                                    <img src="<?= Router::url('/', true); ?>agents_docs/photo_proof/<?= $agent->photo_proof; ?>"width="25%" alt="image">
                                                </div>
                                                <br/>
                                                <button type="button" class="btn btn-success btn-sm" onClick="(function(){
                                                    $('.existing-photo-doc').addClass('hide');
                                                    $('.new-photo-doc').removeClass('hide');
                                                    return false;
                                                })();return false;">Change</button>
                                            </div>
                                            <div class="new-photo-doc hide">
                                                <input class="file-input" id="photo_proof" type="file" name="photo_proof"> 
                                                <label for="photo_proof" class="file-input-btn">Choose a file</label>
                                                <label class="file-name"></label>

                                            </div>
                                            <?php }else{ ?>
                                             <input class="file-input" type="file" id="photo_proof" name="photo_proof"> 
                                             <label for="photo_proof" class="file-input-btn">Choose a file</label>
                                                <label class="file-name"></label>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> 


                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Educational Proof</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="input-group">
                                            <?php if($agent->educational_proof){ ?>
                                            <div class="existing-photo-doc" >
                                                <div class="kt-widget__media">
                                                    <img src="<?= Router::url('/', true); ?>agents_docs/educational_proof/<?= $agent->educational_proof; ?>"width="25%" alt="image">
                                                </div>
                                                <br/>
                                                <button type="button" class="btn btn-success btn-sm" onClick="(function(){
                                                    $('.existing-photo-doc').addClass('hide');
                                                    $('.new-photo-doc').removeClass('hide');
                                                    return false;
                                                })();return false;">Change</button>
                                            </div>
                                            <div class="new-photo-doc hide">
                                                <input class="file-input" id="educational_proof" type="file" name="educational_proof"> 
                                                <label for="educational_proof" class="file-input-btn">Choose a file</label>
                                                <label class="file-name"></label>

                                            </div>
                                            <?php }else{ ?>
                                             <input class="file-input" type="file" id="educational_proof" name="educational_proof"> 
                                             <label for="educational_proof" class="file-input-btn">Choose a file</label>
                                                <label class="file-name"></label>
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
                                        <input class="form-control" type="text" value="<?= isset($agent->bank_name) ? $agent->bank_name : '';?>" name="bank_name">
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Account Number</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <input class="form-control" type="text" value="<?= isset($agent->account_no) ? $agent->account_no : '';?>" name="account_no">
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">IFSC Code</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <input class="form-control" type="text" value="<?= isset($agent->ifsc_code) ? $agent->ifsc_code : '';?>" name="ifsc_code">
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Branch Name</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <input class="form-control" type="text" value="<?= isset($agent->branch_name) ? $agent->branch_name : '';?>" name="branch_name">
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Bank Address</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <textarea class="form-control"  name="bank_address"><?= isset($agent->bank_address) ? $agent->bank_address : '';?></textarea>
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
                                    <a href="members" class="btn btn-secondary">Cancel</a>
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