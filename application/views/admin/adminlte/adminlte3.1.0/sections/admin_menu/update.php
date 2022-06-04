<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <!-- <div class="card card-primary"> -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update a <?php echo $sections_admin['section_singular'] ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo (base_url("admin/menu_admin/update")) ?>" method="post">
                <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />
                <input type="hidden" name="id" id="id" value="<?php echo $item['id'] ?>" require>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item">Item:</label>
                                <input type="text" class="form-control" name="item" id="item" value="<?php echo $item['item'] ?>" placeholder="Enter the item">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="role" id="role" require>
                                    <?php
                                    echo "\n";
                                    foreach ($roles as $role) {
                                        if ($role['id'] == $item['role']) {
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $role['id'] . "\" selected>" . $role['role'] . "</option>\n";
                                        } else {
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $role['id'] . "\">" . $role['role'] . "</option>\n";
                                        }
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
                                        if ($item['level'] == $i) {
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
                                <input type="text" class="form-control" name="icon" id="icon" value="<?php echo $item['icon'] ?>" placeholder="Enter the icon">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link">Link:</label>
                                <input type="text" class="form-control" name="link" id="link" value="<?php echo $item['link'] ?>" placeholder="Enter the link">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position">Position:</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="position" id="position" require>
                                    <?php
                                    $flag = 0;
                                    echo "\n";
                                    if (count($menu_position) == $item['id']) {
                                        $flag = 1;
                                    }
                                    foreach ($menu_position as $menu) {
                                        if ($menu['id'] == ($item['id'] + 1)) {
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $menu['id'] . "\" selected>Before " . $menu['item'] . "</option>\n";
                                        } else {
                                            echo "\t\t\t\t\t\t\t\t\t<option value=\"" . $menu['id'] . "\">Before " . $menu['item'] . "</option>\n";
                                        }
                                    }
                                    if (!$flag) {
                                        echo "\t\t\t\t\t\t\t\t\t<option value=\"0\">At the end</option>\n";
                                    } else {
                                        echo "\t\t\t\t\t\t\t\t\t<option value=\"0\" selected>At the end</option>\n";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update <?php echo $sections_admin['section_singular'] ?></button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
</div>