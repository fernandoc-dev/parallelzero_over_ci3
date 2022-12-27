<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    Update the lesson
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="<?php echo base_url('admin/lessons_admin/update') ?>" method="post">
                    <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />
                    <input type="hidden" name="id" value="<?php echo $lesson['id'] ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="position">Course:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="id_course" id="id_course" require>
                                        <?php
                                        echo "\n";
                                        $item_selected = FALSE;
                                        foreach ($courses as $course) {
                                            if ($course['id'] == $lesson['id_course']) {
                                                echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $course['id'] . "\" selected>" . $course['course'] . "</option>\n";
                                                $item_selected = TRUE;
                                            } else {
                                                echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $course['id'] . "\">" . $course['course'] . "</option>\n";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="position">Position:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="position" id="position" require>
                                        <?php
                                        echo "\n";
                                        foreach ($lessons as $each_lesson) {
                                            if ($each_lesson['id'] == $lesson['id']) {
                                                echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $each_lesson['position'] . "\" selected>Before Lesson# " . $each_lesson['position'] . " " . $each_lesson['title'] . "</option>\n";
                                            } else {
                                                echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $each_lesson['position'] . "\">Before Lesson# " . $each_lesson['position'] . " " . $each_lesson['title'] . "</option>\n";
                                            }
                                        }
                                        echo "\t\t\t\t\t\t\t\t\t<option value=\"0\">At the end</option>\n";
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter the title" value="<?php echo $lesson['title'] ?>" maxlength=" 255">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="url">URL:</label>
                                    <input type="text" class="form-control" name="url" id="url" placeholder="Enter the url" value="<?php echo $lesson['url'] ?>" maxlength=" 255">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content">Content:</label>
                                    <textarea id="content" name="content">
                                <?php echo $lesson['content'] ?>
                            </textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update lesson</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
<!-- ./row -->