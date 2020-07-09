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
					Change Password </a>

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
								<h3 class="kt-portlet__head-title">Change Password <small>change your account password</small></h3>
							</div>
						</div>
						<?= $this->Flash->render() ?>
						
						<?= $this->Form->create(null, array(
											   'url'=>'/change_password',
						                       'class'=>'kt-form kt-form--label-right',
						                       'id'=>'change_password',
						                       'method'=> 'Post'
						                     )); ?>
						<div class="kt-portlet__body">
							<div class="kt-section kt-section--first">
								<div class="kt-section__body">
									
									<div class="row">
										<label class="col-xl-3"></label>
										<div class="col-lg-9 col-xl-6">
											<h3 class="kt-section__title kt-section__title-sm">Change Your Password:</h3>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">Current Password</label>
										<div class="col-lg-9 col-xl-6">
											<input type="password" name="current_password" class="form-control" value="" placeholder="Current password">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
										<div class="col-lg-9 col-xl-6">
											<input type="password" name="password" class="form-control" value="" placeholder="New password">
										</div>
									</div>
									<div class="form-group form-group-last row">
										<label class="col-xl-3 col-lg-3 col-form-label">Verify Password</label>
										<div class="col-lg-9 col-xl-6">
											<input type="password" name="verify_password" class="form-control" value="" placeholder="Verify password">
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
										<button type="reset" class="btn btn-brand btn-bold">Change Password</button>&nbsp;
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
