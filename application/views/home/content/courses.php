				        <div id="section-courses" class="page-section">
				        </div>
				        <div class="row justify-content-between align-items-end bottommargin">
				            <div class="col-md-12">
				                <div class="border-bottom-0 mb-3">
				                    <h2>Let's learn together</h2>
				                </div>
				                <p class="text-muted mb-0">I decided to share my notes, if you are interested in them, you can check them out, I hope it helps others to learn a little bit more about these technologies</p>
				            </div>
				        </div>

				        <div class="row clearfix">
				            <!-- Features colomns
							============================================= -->
				            <div class="row clearfix">
				                <?php
                                foreach ($courses as $course) {
                                    echo "<div class=\"col-lg-3 col-md-4 bottommargin-sm\">\n";
                                    echo "\t\t\t\t\t\t\t\t\t<div class=\"feature-box media-box fbox-bg\">\n";
                                    echo "\t\t\t\t\t\t\t\t\t\t<div class=\"fbox-media border\">\n";
                                    echo "\t\t\t\t\t\t\t\t\t\t\t<a href=\"#\"><img src=\"" . base_url('assets/parallel_zero/img/sections/courses/') . $course['image'] . "\" alt=\"" . $course['course'] . "\"></a>\n";
                                    echo "\t\t\t\t\t\t\t\t\t\t</div>\n";
                                    echo "\t\t\t\t\t\t\t\t\t\t<div class=\"fbox-content border\">\n";
                                    echo "\t\t\t\t\t\t\t\t\t\t\t<h3 class=\"nott ls0 font-weight-semibold\">" . $course['course'] . "<span class=\"subtitle font-weight-light ls0\">" . $course['description'] . "</span></h3>\n";
                                    echo "\t\t\t\t\t\t\t\t\t\t\t<div class=\"mt-2 center\">\n";
                                    echo "\t\t\t\t\t\t\t\t\t\t\t\t<a href=\"" . base_url("courses/") . $course['url'] . "\" class=\"button\"><i class=\"icon-circle-arrow-right\"></i>Start</a>\n";
                                    echo "\t\t\t\t\t\t\t\t\t\t\t</div>\n";
                                    echo "\t\t\t\t\t\t\t\t\t\t</div>\n";
                                    echo "\t\t\t\t\t\t\t\t\t</div>\n";
                                    echo "\t\t\t\t\t\t\t\t</div>\n";
                                }
                                ?>
				            </div>
				        </div>