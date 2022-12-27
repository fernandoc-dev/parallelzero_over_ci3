<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="<?php echo base_url('admin/lessons_admin/create') ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add an lesson</a>
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
                            <th>Course</th>
                            <th>Position</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        <?php
                        foreach ($lessons as $lesson) {
                            echo "<tr>\n";
                            echo "<td>" . $lesson['course'] . "</td>\n";
                            echo "<td>" . $lesson['position'] . "</td>\n";
                            echo "<td>" . $lesson['title'] . "</td>\n";
                            echo "<td>" . $lesson['url'] . "</td>\n";
                            echo "<td><a href=\"" . base_url("admin/lessons_admin/read/") . $lesson['id'] . "\" style=\"color: green\">\n";
                            echo "<i class=\"fa-solid fa-eye\"></i> Read\n";
                            echo "</a>\n";
                            echo "<a href=\"" . base_url("admin/lessons_admin/update/") . $lesson['id'] . "\" style=\"margin-left: 20px\">\n";
                            echo "<i class=\"fas fa-user-edit\"></i> Edit\n";
                            echo "</a>\n";
                            echo "<a href=\"" . base_url("admin/lessons_admin/delete/") . $lesson['id'] . "\" style=\"color: red; margin-left: 20px\">\n";
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