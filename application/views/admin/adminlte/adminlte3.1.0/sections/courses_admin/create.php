<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    Create a new lesson
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="<?php echo base_url('admin/lessons_admin/create') ?>" method="post">
                    <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="position">Course:</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="id_course" id="id_course" require">
                                        <?php
                                        echo "\n";
                                        $item_selected = FALSE;
                                        foreach ($courses as $course) {
                                            if ($course['id'] == set_value('course')) {
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
                                        $item_selected = FALSE;
                                        foreach ($lessons as $lesson) {
                                            if ($lesson['id'] == set_value('lesson')) {
                                                echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $lesson['position'] . "\" selected>Before " . $lesson['title'] . "</option>\n";
                                                $item_selected = TRUE;
                                            } else {
                                                echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $lesson['position'] . "\">Before Lesson# " . $lesson['position'] . " " . $lesson['title'] . "</option>\n";
                                            }
                                        }
                                        if ($item_selected == FALSE) {
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"0\">At the end</option>\n";
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"\" disabled selected>Select the position</option>\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter the title" value="<?php echo set_value('title'); ?>" maxlength=" 255">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="url">URL:</label>
                                    <input type="text" class="form-control" name="url" id="url" placeholder="Enter the url" value="<?php echo set_value('url'); ?>" maxlength=" 255">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content">Content:</label>
                                    <textarea id="content" name="content">
                                <?php echo set_value('content'); ?>
                            </textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save lesson</button>
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