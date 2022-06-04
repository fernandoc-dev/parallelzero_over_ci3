<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <!-- <div class="card card-primary"> -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update user information</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo (base_url('admin/users_admin/update')) ?>" method="post">
                <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />
                <input type="hidden" name="id" id="id" value="<?php echo set_value('id'); ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="<?php echo set_value('name'); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?php echo set_value('email'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" value="<?php echo set_value('username'); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select class="form-control" id="role" name="role">
                                    <?php
                                    $role_opt = set_value('updating_form_role');
                                    foreach ($roles as $role) {
                                        if ($role['role'] == $role_opt) {
                                            echo "<option value=\"" . $role['id'] . "\" selected>" . $role['role'] . "</option>";
                                        } else {
                                            echo "<option value=\"" . $role['id'] . "\">" . $role['role'] . "</option>";
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
                                <label for="phone">Phone:</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter the phone number" value="<?php echo set_value('phone'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Birthday:</label>
                                <input type="date" class="form-control" name="birthday" id="birthday" placeholder="Enter the birthday" value="<?php echo set_value('birthday'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update user information</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
</div>