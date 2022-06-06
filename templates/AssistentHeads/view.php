<?php use Cake\Routing\Router; ?>

<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Assistent Head</h3>
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
<?php $userid = isset($user->id) && ($user->id > 0) ? $user->id : 0;?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            View User
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
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
                                            <label class="col-xl-3 col-lg-3 col-form-label">Profile picture</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="kt-avatar kt-avatar--outline" id="kt_user_avatar">
                                                        <?php 
                                                        $profile_picture = Router::url('/', true).'assets/media/users/default.jpg';
                                                        if($user->profile_picture){
                                                            $profile_picture =  Router::url('/', true).'img/user_imgs/'.$user->profile_picture;
                                                        }
                                                        ?>
                                                        <div class="kt-avatar__holder" style="background-image: url(<?= $profile_picture?>)"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">First Name:</label>
                                    <div class="col-lg-6">
                                        <label class="col-form-label"><?= isset($user->first_name) ? $user->first_name : '';?></label>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Middle name:</label>
                                    <div class="col-lg-6">
                                        <label class="col-form-label"><?= isset($user->middle_name) ? $user->middle_name : '';?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Last Name:</label>
                                    <div class="col-lg-6">
                                        <label class="col-form-label"><?= isset($user->last_name) ? $user->last_name : '';?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Email:</label>
                                    <div class="col-lg-6">
                                        <label class="col-form-label"><?= isset($user->email) ? $user->email : '';?></label>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Gender</label>
                                    <div class="col-6">
                                        <label class="col-form-label"><?= isset($user->gender) ? $user->gender : '';?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Maritial Status</label>
                                    <div class="col-6">
                                        <label class="col-form-label"><?= isset($user->maritial_status) ? $user->maritial_status : '';?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-xl-3">Date of bith</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <label class="col-form-label"><?= isset($user->date_of_birth) ? $user->date_of_birth : '';?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Address</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <label class="col-form-label"><?= isset($user->address) ? $user->address : '';?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">City</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <label class="col-form-label"><?= isset($user->city) ? $user->city : '';?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">State</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <label class="col-form-label"><?= isset($user->state) ? $user->state : '';?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Occupation</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <label class="col-form-label"><?= isset($user->occupation) ? $user->occupation : '';?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Income Amount</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <label class="col-form-label"><?= isset($user->income_amt) ? $user->income_amt : '';?></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-xl-3"></label>
                                    <div class="col-lg-6 col-xl-6">
                                        <h3 class="kt-section__title kt-section__title-sm">Contact Info:</h3>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="input-group">
                                            <label class="col-form-label"><?= isset($user->mobile_number) ? $user->mobile_number : '';?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-xl-3"></label>
                                    <div class="col-lg-6 col-xl-6">
                                        <h3 class="kt-section__title kt-section__title-sm">Nominee Info:</h3>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Nominee name</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <label class="col-form-label"><?= isset($user->nominee_name) ? $user->nominee_name : '';?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Nominee relation</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <label class="col-form-label"><?= isset($user->nominee_relation) ? $user->nominee_relation : '';?></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-xl-3">Nominee date of bith</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="input-group date">
                                            <?php 
                                                $nominee_dob = '';
                                                if(strtotime($user->nominee_dob) > 0){
                                                    $nominee_dob = date('m/d/Y',strtotime($user->nominee_dob));
                                                }
                                            ?>
                                            <label class="col-form-label"><?= $nominee_dob;?></label>
                                        </div>
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
                                            <?php if($user->address_proof){ ?>
                                            <div class="existing-address-doc" >
                                                <div class="kt-widget__media">
                                                    <img src="<?= Router::url('/', true); ?>users_docs/address_proof/<?= $user->address_proof; ?>"width="25%" alt="image">
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
                                            <?php if($user->photo_proof){ ?>
                                            <div class="existing-photo-doc" >
                                                <div class="kt-widget__media">
                                                    <img src="<?= Router::url('/', true); ?>users_docs/photo_proof/<?= $user->photo_proof; ?>"width="25%" alt="image">
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Other Document</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="input-group">   
                                            <?php if($user->other_document){ ?>
                                            <div class="existing-other-doc" >
                                                <div class="kt-widget__media">
                                                    <img src="<?= Router::url('/', true); ?>users_docs/other_document/<?= $user->other_document; ?>"width="25%" alt="image">
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
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
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>
<!-- end:: Content -->

