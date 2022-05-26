<div class="row">
    <!-- left column -->
    <div class="col-md-8">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update user information</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo (base_url('admin/users_admin/update_user')) ?>" method="post">
                <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />
                <input type="hidden" name="updating_form_id" id="" value="<?php echo set_value('updating_form_id'); ?>">
                <div class="card-body">
                    <div class="form-group">
                        <label for="updating_form_complete_name">Name:</label>
                        <input type="text" class="form-control" name="updating_form_complete_name" id="updating_form_complete_name" placeholder="Enter name" value="<?php echo set_value('updating_form_complete_name'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="updating_form_email">Email address:</label>
                        <input type="email" class="form-control" name="updating_form_email" id="updating_form_email" placeholder="Enter email" value="<?php echo set_value('updating_form_email'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="updating_form_username">Username:</label>
                        <input type="text" class="form-control" name="updating_form_username" id="updating_form_username" placeholder="Enter username" value="<?php echo set_value('updating_form_username'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="updating_form_role">Role:</label>
                        <select class="form-control" id="updating_form_role" name="updating_form_role">
                            <?php
                            $role_opt = set_value('updating_form_role');
                            foreach ($roles as $role) {
                                if ($role['role'] == $role_opt) {
                                    echo "<option value=\"" . $role['role'] . "\" selected>" . $role['role'] . "</option>";
                                } else {
                                    echo "<option value=\"" . $role['role'] . "\">" . $role['role'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class=" form-group">
                        <label for="exampleInputEmail1">Phone:</label>
                        <input type="text" class="form-control" name="updating_form_phone" id="" placeholder="Enter the phone number" value="<?php echo set_value('updating_form_phone'); ?>">
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