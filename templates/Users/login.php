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
											<?= $this->Flash->render() ?>
											<h3 class="kt-login__title">Sign In</h3>
										</div>
										<div class="kt-login__form">
											<?= $this->Form->create(null, array(
												   'url'=>'/login',
							                       'class'=>'kt-form',
							                       'id'=>'login_form',
							                       'method'=> 'Post'
							                     )); ?>
												<?php 
												// echo "ss <pre>";print_r($_COOKIE);exit;
												    $cookie =  '';
													if(isset($_COOKIE['remember_me_cookie']) && $_COOKIE['remember_me_cookie'] != ''){						
													 $cookie = unserialize($_COOKIE['remember_me_cookie'], ["allowed_classes" => false]);
													}
												?>
												<div class="form-group">
													<input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off" value="<?php if(isset($cookie['remember_me_email'])){ echo $cookie['remember_me_email']; } ?>">
												</div>
												<div class="form-group">
													<input class="form-control form-control-last" type="password" placeholder="Password" name="password" value="<?php if(isset($cookie['remember_me_pwd'])){ echo $cookie['remember_me_pwd']; } ?>" >
												</div>
												<div class="kt-login__extra">
													<!-- <label class="kt-checkbox">
														<input type="checkbox" name="remember_me"> Remember me
														<span></span>
													</label> -->
													<a href="javascript:;" id="kt_login_forgot">Forget Password ?</a>
												</div>
												<div class="kt-login__actions">
													<button id="kt_login_signin_submit" class="btn btn-brand btn-pill btn-elevate">Sign In</button>
												</div>
											<?= $this->Form->end(); ?>
										</div>
									</div>
									<div class="kt-login__signup">
										<div class="kt-login__head">
											<h3 class="kt-login__title">Sign Up</h3>
											<div class="kt-login__desc">Enter your details to create your account:</div>
										</div>
										<div class="kt-login__form">
											<?= $this->Form->create(null, array(
						                       'method'=> 'Post'
						                     )); ?>
												<div class="form-group">
													<input class="form-control" type="text" placeholder="First name" name="first_name">
												</div>
												<div class="form-group">
													<input class="form-control" type="text" placeholder="Middle name" name="middle_name">
												</div>
												<div class="form-group">
													<input class="form-control" type="text" placeholder="Last name" name="last_name">
												</div>
												<div class="form-group">
													<input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
												</div>
												<div class="form-group">
													<input class="form-control" type="password" placeholder="Password" name="password" id="password">
												</div>
												<div class="form-group">
													<input class="form-control form-control-last" type="password" placeholder="Confirm Password" name="rpassword">
												</div>
												<div class="kt-login__extra">
													<label class="kt-checkbox">
														<input type="checkbox" name="agree"> I Agree the <a href="/">terms and conditions</a>.
														<span></span>
													</label>
												</div>
												<div class="kt-login__actions">
													<button id="kt_login_signup_submit" class="btn btn-brand btn-pill btn-elevate">Sign Up</button>
													<button id="kt_login_signup_cancel" class="btn btn-outline-brand btn-pill">Cancel</button>
												</div>
											<?= $this->Form->end(); ?>
										</div>
									</div>
									<div class="kt-login__forgot">
										<div class="kt-login__head">
											<h3 class="kt-login__title">Forgotten Password ?</h3>
											<div class="kt-login__desc">Enter your email to reset your password:</div>
										</div>
										<div class="kt-login__form">
											<?= $this->Form->create(null, array(
												'class'=> 'kt-form',
						                       'method'=> 'Post'
						                     )); ?>
												<div class="form-group">
													<input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
												</div>
												<div class="kt-login__actions">
													<button id="kt_login_forgot_submit" class="btn btn-brand btn-pill btn-elevate">Request</button>
													<button id="kt_login_forgot_cancel" class="btn btn-outline-brand btn-pill">Cancel</button>
												</div>
											<?= $this->Form->end(); ?>
										</div>
									</div>
								</div>
							</div>
							<!-- <div class="kt-login__account">
								<span class="kt-login__account-msg">
									Don't have an account yet ?
								</span>&nbsp;&nbsp;
								<a href="javascript:;" id="kt_login_signup" class="kt-login__account-link">Sign Up!</a>
							</div> -->
						</div>
					</div>
					<div class="kt-grid__item kt-grid__item--fluid kt-grid__item--center kt-grid kt-grid--ver kt-login__content" style="background-image: url(assets/media/bg/bg-4.jpg);">
						<div class="kt-login__section">
							<div class="kt-login__block">
								<h3 class="kt-login__title">Welcome to Shriram Chits</h3>
								<!--<div class="kt-login__desc">
									Lorem ipsum dolor sit amet, coectetuer adipiscing
									<br>elit sed diam nonummy et nibh euismod
								</div>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->