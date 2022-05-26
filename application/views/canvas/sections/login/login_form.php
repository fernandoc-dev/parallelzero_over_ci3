		<!-- Content
		============================================= -->
		<section id="content">
		    <div class="content-wrap">
		        <div class="container clearfix">

		            <div class="accordion accordion-lg mx-auto mb-0 clearfix" style="max-width: 550px;">

		                <div class="accordion-header">
		                    <div class="accordion-icon">
		                        <i class="accordion-closed icon-lock3"></i>
		                        <i class="accordion-open icon-unlock"></i>
		                    </div>
		                    <div class="accordion-title">
		                        Login to your Account
		                    </div>
		                </div>
		                <div class="accordion-content clearfix">
		                    <form id="login-form" name="login-form" class="row mb-0" action="<?php echo (base_url('users/login')) ?>" method="post" accept-charset="utf-8">

		                        <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />

		                        <div class="col-12 form-group">
		                            <label for="username">Username:</label>
		                            <input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <label for="password">Password:</label>
		                            <input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <button class="button button-3d button-black m-0" id="submit" name="submit" value="login">Login</button>
		                            <a href="<?php echo base_url('users/recorver_password') ?>" class="float-right">Forgot Password?</a>
		                        </div>
		                    </form>
		                </div>

		                <div class="accordion-header">
		                    <div class="accordion-icon">
		                        <i class="accordion-closed icon-user4"></i>
		                        <i class="accordion-open icon-ok-sign"></i>
		                    </div>
		                    <div class="accordion-title">
		                        New Signup? Register for an Account
		                    </div>
		                </div>
		                <div class="accordion-content clearfix">
		                    <form id="register-form" name="register-form" class="row mb-0" action="<?php echo (base_url('users/registration')) ?>" method="post">
		                        <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />

		                        <div class="col-12 form-group">
		                            <label for="name">Name:</label>
		                            <input type="text" id="name" name="name" value="<?php echo set_value('name'); ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <label for="email">Email Address:</label>
		                            <input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <label for="username">Choose a Username:</label>
		                            <input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <label for="phone">Phone:</label>
		                            <input type="text" id="phone" name="phone" value="<?php echo set_value('phone'); ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <label for="password">Choose Password:</label>
		                            <input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <label for="password_confirmation">Re-enter Password:</label>
		                            <input type="password" id="password_confirmation" name="password_confirmation" value="<?php echo set_value('password_confirmation'); ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <button class="button button-3d button-black m-0" id="submit" name="submit" value="register">Register Now</button>
		                        </div>
		                    </form>
		                </div>

		            </div>

		        </div>
		    </div>
		</section><!-- #content end -->