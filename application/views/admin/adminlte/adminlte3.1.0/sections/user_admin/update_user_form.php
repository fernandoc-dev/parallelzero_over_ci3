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
            <form action="<?php echo (base_url('admin/users_admin/update_user')) ?>" method="post">
                <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />
                <input type="hidden" name="updating_form_id" id="" value="<?php echo $user['id']; ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updating_form_complete_name">Name:</label>
                                <input type="text" class="form-control" name="updating_form_complete_name" id="updating_form_complete_name" placeholder="Enter name" value="<?php echo $user['complete_name']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updating_form_email">Email address:</label>
                                <input type="email" class="form-control" name="updating_form_email" id="updating_form_email" placeholder="Enter email" value="<?php echo $user['email']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updating_form_username">Username:</label>
                                <input type="text" class="form-control" name="updating_form_username" id="updating_form_username" placeholder="Enter username" value="<?php echo $user['username']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updating_form_role">Role:</label>
                                <select class="form-control" id="updating_form_role" name="updating_form_role">
                                    <?php
                                    foreach ($roles as $role) {
                                        if ($role['id'] == $user['role']) {
                                            echo "<option value=\"" . $role['role'] . "\" selected>" . $role['role'] . "</option>";
                                        } else {
                                            echo "<option value=\"" . $role['role'] . "\">" . $role['role'] . "</option>";
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
                                <label for="updating_form_phone">Phone:</label>
                                <input type="text" class="form-control" name="updating_form_phone" id="updating_form_phone" placeholder="Enter the phone number" value="<?php echo $user['phone']; ?>">
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