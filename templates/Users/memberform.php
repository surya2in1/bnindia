<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">Add Member</h3>
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
                            Add Member
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <?= $this->Form->create(null, array(
                       'class'=>'kt-form',
                       'id'=>'member_form',
                       'method'=> 'Post'
                     )); ?>
                      <input type="hidden" name="id" id="id" value="<?= isset($member->id) && ($member->id > 0) ? $member->id : '0';?>">
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">First Name:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="first_name" placeholder="Enter First Name" value="<?= isset($user->first_name) ? $user->first_name : '';?>" autofocus="true">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Middle name:</label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="middle_name" placeholder="Enter Middle Name" value="<?= isset($user->middle_name) ? $user->middle_name : '';?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Last Name:</label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="last_name" placeholder="Enter Last Name" value="<?= isset($user->last_name) ? $user->last_name : '';?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Email:</label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" name="email" placeholder="Enter Email" value="<?= isset($user->email) ? $user->email : '';?>">
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Gender</label>
                                    <div class="col-6">
                                        <div class="kt-radio-inline">
                                            <label class="kt-radio">
                                                <input type="radio" name="gender" value="male" 
                                                <?php if($user->gender ==  'male'){?>
                                                    checked="checked"
                                                <?php }
                                                ?>> Male
                                                <span></span>
                                            </label>
                                            <label class="kt-radio">
                                                <input type="radio" name="gender" value="female" 
                                                <?php if($user->gender ==  'female' || $user->gender == ''){?>
                                                    checked="checked"
                                                <?php }
                                                ?>
                                                > Female
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Maritial Status</label>
                                    <div class="col-6">
                                        <div class="kt-radio-inline">
                                            <label class="kt-radio">
                                                <input type="radio" name="maritial_status" value="married"
                                                <?php if($user->maritial_status ==  'married' || $user->maritial_status == ''){?>
                                                    checked="checked"
                                                <?php }
                                                ?>> Married
                                                <span></span>
                                            </label>
                                            <label class="kt-radio">
                                                <input type="radio" name="maritial_status" value="unmarried"
                                                <?php if($user->maritial_status ==  'unmarried'){?>
                                                    checked="checked"
                                                <?php }
                                                ?>> Unmarried
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-xl-3">Date of bith</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="input-group date">
                                            <?php 
                                                $dob = '';
                                                if(strtotime($user->date_of_birth) > 0){
                                                    $dob = date('m/d/Y',strtotime($user->date_of_birth));
                                                }
                                            ?>
                                            <input type="text" class="form-control" readonly="" value="<?= $dob; ?>" id="date_of_birth" name="date_of_birth">
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
                                    <label class="col-xl-3 col-lg-3 col-form-label">Address</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <input class="form-control" type="text" value="<?= $user->address; ?>" name="address">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">City</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <input class="form-control" type="text" value="<?= $user->city; ?>" name="city">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">State</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <input class="form-control" name="state" type="text" value="<?= $user->state; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Accupation</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <input class="form-control" name="occupation" type="text" value="<?= $user->occupation; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Income Amount</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <input class="form-control" name="income_amt" type="text" value="<?= $user->income_amt; ?>">
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
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                                            <input type="text" class="form-control" name="mobile_number" value="<?= $user->mobile_number; ?>" placeholder="Phone" aria-describedby="basic-addon1">
                                        </div>
                                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
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
                                        <input class="form-control" type="text" value="<?= $user->nominee_name; ?>" name="nominee_name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Nominee relation</label>
                                    <div class="col-lg-6 col-xl-6">
                                        <input class="form-control" name="nominee_relation" type="text" value="<?= $user->nominee_relation; ?>">
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
                                            <input type="text" class="form-control" readonly="" value="<?= $nominee_dob; ?>" id="nominee_dob" name="nominee_dob">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="form-text text-muted">Enable clear and today helper buttons</span>
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
                                                    <img src="users_docs/address_proof/<?= $user->address_proof; ?>"width="25%" alt="image">
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
                                             <input class="file-input" type="file" id="address_proof" value="<?= $user->address_proof; ?>" name="address_proof">
                                             <label for="address_proof" class="file-input-btn">Choose a file</label>
                                            <label class="file-name"></label> 
                                            <?php } ?>
                                            <!-- <div class="dropzone dropzone-default" id="kt_dropzone_1">
                                                <div class="dropzone-msg dz-message needsclick">
                                                    <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
                                                </div>
                                            </div> -->
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
                                                    <img src="users_docs/photo_proof/<?= $user->photo_proof; ?>"width="25%" alt="image">
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
                                             <input class="file-input" type="file" id="photo_proof" value="<?= $user->photo_proof; ?>" name="photo_proof"> 
                                             <label for="photo_proof" class="file-input-btn">Choose a file</label>
                                                <label class="file-name"></label>
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
                                                    <img src="users_docs/other_document/<?= $user->other_document; ?>"width="25%" alt="image">
                                                </div>
                                                <br/>
                                                <button type="button" class="btn btn-success btn-sm" onClick="(function(){
                                                    $('.existing-other-doc').addClass('hide');
                                                    $('.new-other-doc').removeClass('hide');
                                                    return false;
                                                })();return false;">Change</button>
                                            </div>
                                            <div class="new-other-doc hide">
                                                <input class="file-input" id="other_document" type="file" name="other_document"> 
                                                <label for="other_document" class="file-input-btn">Choose a file</label>
                                                <label class="file-name"></label>
                                            </div>
                                            <?php }else{ ?>
                                             <input class="file-input" type="file" id="other_document" value="<?= $user->other_document; ?>" name="other_document"> 
                                            <label for="other_document" class="file-input-btn">Choose a file</label>
                                                <label class="file-name"></label>
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

