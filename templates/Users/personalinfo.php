<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-container  kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">
				<button class="kt-subheader__mobile-toggle kt-subheader__mobile-toggle--left" id="kt_subheader_mobile_toggle"><span></span></button>
				My Profile</h3>
			<span class="kt-subheader__separator kt-hidden"></span>
			<div class="kt-subheader__breadcrumbs">
				<span class="kt-subheader__breadcrumbs-separator"></span>
				<a href="" class="kt-subheader__breadcrumbs-link">
					Personal Information </a>

				<!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
			</div>
		</div>
	</div>
</div>
<!-- end:: Subheader -->

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

	<!--Begin::App-->
	<div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

		<?= $this->element('myprofile_aside'); ?>

		<!--Begin:: App Content-->
		<div class="kt-grid__item kt-grid__item--fluid kt-app__content">
			<div class="row">
				<div class="col-xl-12">
					<div class="kt-portlet">
						<div class="kt-portlet__head">
							<div class="kt-portlet__head-label">
								<h3 class="kt-portlet__head-title">Personal Information <small>update your personal informaiton</small></h3>
							</div>
						</div>
						<?= $this->Flash->render() ?>
						
						<?= $this->Form->create(null, array(
											   'url'=>'/personalinfo',
						                       'class'=>'kt-form kt-form--label-right',
						                       'id'=>'user_profile',
						                       'enctype' => 'multipart/form-data',
						                       'method'=> 'Post'
						                     )); ?>
							<div class="kt-portlet__body">
								<div class="kt-section kt-section--first">
									<div class="kt-section__body">
										<div class="row">
											<label class="col-xl-3"></label>
											<div class="col-lg-9 col-xl-6">
												<h3 class="kt-section__title kt-section__title-sm">Customer Info:</h3>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Profile picture</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group">
													<div class="kt-avatar kt-avatar--outline" id="kt_user_avatar">
														<?php 
														$profile_picture = 'assets/media/users/default.jpg';
														if($user->profile_picture){
															$profile_picture = 'img/user_imgs/'.$user->profile_picture;
														}
														?>
														<div class="kt-avatar__holder" style="background-image: url(<?= $profile_picture?>)"></div>
														<label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
															<i class="fa fa-pen"></i>
															<input type="file" name="profile_picture"/>
														</label>
														<span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
															<i class="fa fa-times"></i>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control" name="first_name" type="text" value="<?= $user->first_name; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Middle Name</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control" type="text" name="middle_name" value="<?= $user->middle_name; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control" type="text" name="last_name" value="<?= $user->last_name; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-3 col-form-label">Gender</label>
											<div class="col-9">
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
											<div class="col-9">
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
											<div class="col-lg-9 col-xl-6">
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
											<div class="col-lg-9 col-xl-6">
												<input class="form-control" type="text" value="<?= $user->address; ?>" name="address">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">City</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control" type="text" value="<?= $user->city; ?>" name="city">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">State</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control" name="state" type="text" value="<?= $user->state; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Accupation</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control" name="occupation" type="text" value="<?= $user->occupation; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Income Amount</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control" name="income_amt" type="text" value="<?= $user->income_amt; ?>">
											</div>
										</div>
										<div class="row">
											<label class="col-xl-3"></label>
											<div class="col-lg-9 col-xl-6">
												<h3 class="kt-section__title kt-section__title-sm">Contact Info:</h3>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group">
													<div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
													<input type="text" class="form-control" name="mobile_number" value="<?= $user->mobile_number; ?>" placeholder="Phone" aria-describedby="basic-addon1">
												</div>
												<span class="form-text text-muted">We'll never share your email with anyone else.</span>
											</div>
										</div>
										<div class="row">
											<label class="col-xl-3"></label>
											<div class="col-lg-9 col-xl-6">
												<h3 class="kt-section__title kt-section__title-sm">Nominee Info:</h3>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Nominee name</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control" type="text" value="<?= $user->nominee_name; ?>" name="nominee_name">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Nominee relation</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control" name="nominee_relation" type="text" value="<?= $user->nominee_relation; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-form-label col-lg-3 col-xl-3">Nominee date of bith</label>
											<div class="col-lg-9 col-xl-6">
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
											<div class="col-lg-9 col-xl-6">
												<h3 class="kt-section__title kt-section__title-sm">Important Documents:</h3>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">Address Proof</label>
											<div class="col-lg-9 col-xl-6">
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
											<div class="col-lg-9 col-xl-6">
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
											<div class="col-lg-9 col-xl-6">
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
										<div class="col-lg-3 col-xl-3">
										</div>
										<div class="col-lg-9 col-xl-9">
											<button type="submit" class="btn btn-success">Submit</button>&nbsp;
											<button type="reset" class="btn btn-secondary">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						<?= $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>

		<!--End:: App Content-->
	</div>

	<!--End::App-->
</div>

<!-- end:: Content -->
