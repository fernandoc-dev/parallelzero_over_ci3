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
		                        Update password
		                    </div>
		                </div>
		                <div class="accordion-content clearfix">
		                    <form enctype="multipart/form-data" id="register-form" name="register-form" class="row mb-0" action="<?php echo (base_url('users/change_password')); ?>" method="post">
		                        <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />

		                        <div class="col-12 form-group">
		                            <label for="name">Current password:</label>
		                            <input type="password" id="current_password" name="current_password" value="<?php echo set_value('current_password'); ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <label for="username">New password:</label>
		                            <input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <label for="phone">Confirmation:</label>
		                            <input type="password" id="confirmation" name="confirmation" value="<?php echo set_value('confirmation'); ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <button type="submit" class="button button-3d button-black m-0">Update password</button>
		                        </div>
		                    </form>
		                </div>

		            </div>

		        </div>
		    </div>
		</section><!-- #content end -->