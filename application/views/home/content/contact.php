					<!-- contact -->
					<div id="section-contact" class="page-section">

					    <h2 class="bottommargin">Contact</h2>

					    <div class="row clearfix">

					        <div class="col-lg-12">

					            <div class="form-widget">

					                <div class="form-result"></div>

					                <form class="row mb-0" action="<?php echo base_url('form/get_message') ?>" id="template-contactform" name="template-contactform" method="post">

					                    <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />

					                    <div class="form-process">
					                        <div class="css3-spinner">
					                            <div class="css3-spinner-scaler"></div>
					                        </div>
					                    </div>

					                    <div class="col-md-6 form-group">
					                        <input type="text" id="name" name="name" value="" class="sm-form-control border-form-control required" placeholder="Name" require />
					                    </div>

					                    <div class="col-md-6 form-group">
					                        <input type="email" id="email" name="email" value="" class="required email sm-form-control border-form-control" placeholder="Email Address" require />
					                    </div>

					                    <div class="clear"></div>

					                    <div class="col-12 form-group">
					                        <input type="text" id="subject" name="subject" value="" class="required sm-form-control border-form-control" placeholder="Subject" require />
					                    </div>

					                    <div class="col-12 form-group">
					                        <textarea class="required sm-form-control border-form-control" id="message" name="message" rows="7" cols="30" placeholder="Your Message" require></textarea>
					                    </div>

					                    <div class="col-12 form-group">
					                        <button class="button button-black ml-0 topmargin-sm" type="submit" id="submit" name="submit" value="submit">Send Message</button>
					                    </div>
					                </form>

					            </div>

					        </div>

					    </div>

					</div>