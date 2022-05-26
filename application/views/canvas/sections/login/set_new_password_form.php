		<!-- Content
		============================================= -->
		<section id="content">
		    <div class="content-wrap">
		        <div class="container clearfix">

		            <div class="accordion accordion-lg mx-auto mb-0 clearfix" style="max-width: 550px;">

		                <div class="accordion-header">
		                    <div class="accordion-icon">
		                        <i class="accordion-open icon-user4"></i>
		                    </div>
		                    <div class="accordion-title">
		                        Forgot password?
		                    </div>
		                </div>
		                <div class="accordion-content clearfix">
		                    <form id="register-form" name="register-form" class="row mb-0" action="<?php echo (base_url('users/recover_password')) ?>" method="post">
		                        <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />

		                        <input type="hidden" id="id" name="id" value="<?php if (isset($id)) {
                                                                                    echo $id;
                                                                                } else {
                                                                                    echo set_value('id');
                                                                                }; ?>" required>

		                        <div class="col-12 form-group">
		                            <label for="register-form-name">Password:</label>
		                            <input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control" required>
		                        </div>
		                        <div class="col-12 form-group">
		                            <label for="register-form-name">Password confirmation:</label>
		                            <input type="password" id="password_confirmation" name="password_confirmation" value="<?php echo set_value('password_confirmation'); ?>" class="form-control" required>
		                        </div>

		                        <div class="col-12 form-group">
		                            <button class="button button-3d button-black m-0" id="register-form-submit" name="register-form-submit" value="register">Save the new password</button>
		                        </div>
		                    </form>
		                </div>

		            </div>

		        </div>
		    </div>
		</section><!-- #content end -->