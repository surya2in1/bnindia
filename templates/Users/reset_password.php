<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v6 kt-login--signin" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
					<div class="kt-grid__item  kt-grid__item--order-tablet-and-mobile-2  kt-grid kt-grid--hor kt-login__aside">
						<div class="kt-login__wrapper">
							<div class="kt-login__container">
								<div class="kt-login__body">
									<div class="kt-login__logo">
										<a href="#">
											<img src="assets/media/company-logos/logo-2.png">
										</a>
									</div>
									<div class="kt-login__signin">
										<div class="kt-login__head">
											<h3 class="kt-login__title">Reset Password ?</h3>
											<div class="kt-login__desc">Enter new password to replace existing:</div>
										</div>
										<div class="kt-login__form">
											<?= $this->Form->create(null, array(
												'class'=> 'kt-form',
						                       'method'=> 'Post'
						                     )); ?>
												<div class="form-group">
													<input class="form-control" type="password" placeholder="Password" name="password" id="password" autocomplete="off">
													<input type="hidden" id="token" value="<?= $token; ?>" />	
												</div>
												<div class="kt-login__actions">
													<button id="kt_login_reset_submit" class="btn btn-brand btn-pill btn-elevate">Request</button>
													<button id="kt_login_reset_cancel" class="btn btn-outline-brand btn-pill">Cancel</button>
												</div>
											<?= $this->Form->end(); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="kt-login__account">
								<span class="kt-login__account-msg">
									Don't have an account yet ?
								</span>&nbsp;&nbsp;
								<a href="javascript:;" id="kt_login_signup" class="kt-login__account-link">Sign Up!</a>
							</div>
						</div>
					</div>
					<div class="kt-grid__item kt-grid__item--fluid kt-grid__item--center kt-grid kt-grid--ver kt-login__content" style="background-image: url(assets/media/bg/bg-4.jpg);">
						<div class="kt-login__section">
							<div class="kt-login__block">
								<h3 class="kt-login__title">Join Our Community</h3>
								<div class="kt-login__desc">
									Lorem ipsum dolor sit amet, coectetuer adipiscing
									<br>elit sed diam nonummy et nibh euismod
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->