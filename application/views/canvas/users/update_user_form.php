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
		                        User information
		                    </div>
		                </div>
		                <div class="accordion-content clearfix">
		                    <form enctype="multipart/form-data" id="register-form" name="register-form" class="row mb-0" action="<?php echo (base_url('users/update')); ?>" method="post">
		                        <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />

		                        <div class="col-12 form-group">
		                            <label for="name">Name:</label>
		                            <input type="text" id="name" name="name" value="<?php echo $_SESSION['user']['name']; ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <label for="username">Username:</label>
		                            <input type="text" id="username" name="username" value="<?php echo $_SESSION['user']['username']; ?>" class="form-control" />
		                        </div>

		                        <div class="col-12 form-group">
		                            <label for="phone">Phone:</label>
		                            <input type="text" id="phone" name="phone" value="<?php echo $_SESSION['user']['phone']; ?>" class="form-control" />
		                        </div>

		                        <div class="col-md-12 bottommargin-sm">
		                            <label for="">Birthday:</label>
		                            <input type="date" value="<?php echo $_SESSION['user']['birthday']; ?>" id="birthday" name="birthday" class="form-control text-left component-datepicker format" placeholder="DD-MM-YYYY">
		                        </div>

		                        <div class="col-lg-12 form-group">
		                            <label>Profile photo</label><br>
		                            <input type="file" id="input-10" name="photo" class="file-loading" accept="image/*" data-show-preview="false">
		                        </div>

		                        <div class="col-12 form-group">
		                            <button type="submit" class="button button-3d button-black m-0">Save changes</button>
		                        </div>
		                    </form>
		                </div>

		            </div>

		        </div>
		    </div>
		</section><!-- #content end -->