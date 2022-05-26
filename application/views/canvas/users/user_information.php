		<!-- Content
		============================================= -->
		<section id="content">
		    <div class="content-wrap">
		        <div class="container clearfix">
		            <div class="row">
		                <div class="col-12 center">
		                    <h1>User information</h1>
		                </div>
		            </div>
		            <div class="row justify-content-center">
		                <div class="col-md-3">
		                    <div>
		                        <img src="<?php echo base_url('assets/parallel_zero/img/users/' . $_SESSION['user']['id'] . '/' . $_SESSION['user']['photo'] . '.jpg'); ?>" alt="">
		                    </div>
		                </div>

		                <div class="col-md-6 col-lg-3">
		                    <div class="col-12 form-group">
		                        <label for="name">Name:</label><span><?php echo $_SESSION['user']['name']; ?></span>
		                    </div>

		                    <div class="col-12 form-group">
		                        <label for="username">Username:</label><span><?php echo $_SESSION['user']['username']; ?></span>
		                    </div>

		                    <div class="col-12 form-group">
		                        <label for="phone">Phone:</label><span><?php echo $_SESSION['user']['phone']; ?></span>
		                    </div>

		                    <div class="col-12 form-group">
		                        <label for="phone">Birthday:</label>
		                        <span>
		                            <?php
                                    if ($_SESSION['user']['birthday']) {
                                        $DateTime = DateTime::createFromFormat('Y-m-d', $_SESSION['user']['birthday']);
                                        $birthday = $DateTime->format('d/m/Y');
                                    } else {
                                        $birthday = "";
                                    }
                                    echo $birthday;
                                    ?>
		                    </div>
		                    <div class="col-12 form-group">
		                        <a href="<?php echo base_url('users/update') ?>" class="button button-3d button-black m-0">Update information</a>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</section><!-- #content end -->