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
            <form action="<?php echo (base_url("admin/users_admin/create")) ?>" method="post">
                <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo set_value('name') ?>" placeholder="Enter the name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo set_value('email') ?>" placeholder="Enter the email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username" value="<?php echo set_value('username') ?>" placeholder="Enter the username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo set_value('phone') ?>" placeholder="Enter the phone">
                            </div>
                        </div>
                    </div>
                    <div class="row">
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