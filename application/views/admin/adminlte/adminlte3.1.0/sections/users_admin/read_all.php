<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="<?php echo base_url('admin/users_admin/create') ?>" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add a New User</a>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" id="table_search" class="mt-2 form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default mt-2">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        <?php
                        foreach ($users as $user) {
                            echo "<tr>\n";
                            echo "<td>" . $user['name'] . "</td>\n";
                            echo "<td>" . $user['username'] . "</td>\n";
                            echo "<td>" . $user['email'] . "</td>\n";
                            foreach ($roles as $role) {
                                if ($role['id'] == $user['role']) {
                                    echo "<td>" . $role['role'] . "</td>\n";
                                }
                            }
                            echo "<td><a href=\"" . base_url("admin/users_admin/update") . "/" . $user['id'] . "\">\n";
                            echo "<i class=\"fas fa-user-edit\"></i> Edit\n";
                            echo "</a>\n";
                            echo "<a href=\"" . base_url("admin/users_admin/delete") . "/" . $user['id'] . "\" style=\"color: red; margin-left: 20px\">\n";
                            echo "<i class=\"fas fa-trash-alt\"></i> Delete\n";
                            echo "</a></td>\n";
                            echo "</tr>\n";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.row -->