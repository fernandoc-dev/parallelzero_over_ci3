<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="<?php echo base_url("admin/menu_admin/create") ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add <?php echo $sections_admin['section_singular'] ?></a>
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
                            <th>Item</th>
                            <th>Role</th>
                            <th>Level</th>
                            <th>Icon</th>
                            <th>Link</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        <?php
                        foreach ($menu_admin_items as $item) {
                            echo "<tr>\n";
                            foreach ($item as $key => $value) {
                                if (!in_array($key, $sections_admin['dont_show'])) {
                                    if ($key == "role") {
                                        foreach ($roles as $role) {
                                            if ($role['id'] == $value) {
                                                echo "<td>" . $role['role'] . "</td>\n";
                                            }
                                        }
                                    } else {
                                        echo "<td>" . $value . "</td>\n";
                                    }
                                }
                            }
                            echo "<td><a href=\"" . base_url("admin/menu_admin/update") . "/" . $item['id'] . "\">\n";
                            echo "<i class=\"fas fa-user-edit\"></i> Edit\n";
                            echo "</a>\n";
                            echo "<a href=\"" . base_url("admin/menu_admin/delete") . "/" . $item['id'] . "\" style=\"color: red; margin-left: 20px\">\n";
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