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
            <form action="<?php echo (base_url("admin/menu_admin/create")) ?>" method="post">
                <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item">Item:</label>
                                <input type="text" class="form-control" name="item" id="item" value="<?php echo set_value('item') ?>" placeholder="Enter the item">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="role" id="role" require>
                                    <?php
                                    echo "\n";
                                    $role_selected = FALSE;
                                    foreach ($roles as $role) {
                                        if ($role['id'] == set_value('role')) {
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $role['id'] . "\" selected>" . $role['role'] . "</option>\n";
                                            $role_selected = TRUE;
                                        } else {
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $role['id'] . "\">" . $role['role'] . "</option>\n";
                                        }
                                    }
                                    if ($role_selected == FALSE) {
                                        echo "\t\t\t\t\t\t\t\t\t<option value=\"\" disabled selected>Select the role</option>\n";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="level">Level:</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="level" id="level" require>
                                    <option value="" selected disabled>Select the level</option>
                                    <?php
                                    echo "\n";
                                    for ($i = 1; $i < 3; $i++) {
                                        if (set_value('level') == $i) {
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $i . "\" selected>" . $i . "</option>\n";
                                        } else {
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $i . "\">" . $i . "</option>\n";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="icon">Icon:</label>
                                <input type="text" class="form-control" name="icon" id="icon" value="<?php echo set_value('icon') ?>" placeholder="Enter the icon">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link">Link:</label>
                                <input type="text" class="form-control" name="link" id="link" value="<?php echo set_value('link') ?>" placeholder="Enter the link">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position">Position:</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="position" id="position" require>
                                    <?php
                                    echo "\n";
                                    $item_selected = FALSE;
                                    foreach ($items_menu as $menu) {
                                        if ($menu['id'] == set_value('position')) {
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $menu['id'] . "\" selected>Before " . $menu['item'] . "</option>\n";
                                            $item_selected = TRUE;
                                        } else {
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $menu['id'] . "\">Before " . $menu['item'] . "</option>\n";
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