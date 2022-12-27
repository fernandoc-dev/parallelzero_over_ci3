<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <!-- <div class="card card-primary"> -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Register a new <?php echo $sections_admin['section_singular'] ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo (base_url("admin/generic_crud/create/" . $sections_admin['section'] . "/" . $sections_admin['table_section'])) ?>" method="post">
                <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />
                <div class="card-body">
                    <?php
                    $size = count($sections_admin['columns']) - count($sections_admin['dont_show']);
                    $counter = 1;
                    foreach ($sections_admin['columns'] as $key) {
                        if (!in_array($key, $sections_admin['dont_show'])) {
                            if ($counter % 2 !== 0) {
                                echo "\t\t\t\t\t<div class=\"row\">\n";
                            }
                            echo "\t\t\t\t\t\t<div class=\"col-md-6\">\n";
                            echo "\t\t\t\t\t\t\t<div class=\"form-group\">\n";
                            echo "\t\t\t\t\t\t\t\t<label for=\"" . $key . "\">" . ucfirst($key) . ":</label>\n";
                            echo "\t\t\t\t\t\t\t\t<input type=\"text\" class=\"form-control\" name=\"" . $key . "\" id=\"" . $key . "\" placeholder=\"Enter " .  $key . "\" value=\"\">\n";
                            echo "\t\t\t\t\t\t\t</div>\n";
                            echo "\t\t\t\t\t\t</div>\n";
                            if (($counter % 2 == 0) or ($counter == $size)) {
                                echo "\t\t\t\t\t</div>\n";
                            }
                            $counter++;
                        }
                    }
                    ?>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Create <?php echo $sections_admin['section_singular'] ?></button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
</div>