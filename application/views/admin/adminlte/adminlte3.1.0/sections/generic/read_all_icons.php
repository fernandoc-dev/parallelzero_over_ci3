<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="<?php echo base_url("admin/generic_crud/create/" . $sections_admin['section']) ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add <?php echo $sections_admin['section_singular'] ?></a>
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
                            <?php
                            echo "<th>" . "Icon" . "</th>\n";
                            echo "<th>" . "Image" . "</th>\n";
                            echo "<th>" . "Action" . "</th>\n";
                            ?>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        <?php
                        foreach ($sections_admin['content'] as $item) {
                            echo "<tr>\n";
                            foreach ($item as $key => $value) {
                                if (!in_array($key, $sections_admin['dont_show']) && $key != "image") {
                                    echo "<td>" . $value . "</td>\n";
                                    echo "<td><i class=\"" . $value . "\" style=\"font-size:160%;\"></i></td>\n";
                                } elseif (!in_array($key, $sections_admin['dont_show']) && $key === "image") {
                                    echo "<td><i class=\"" . $value . "\" style=\"font-size:160%;\"></i></td>\n";
                                }
                            }
                            echo "<td><a href=\"" . base_url("admin/generic_crud/update/") . $sections_admin['table_section'] . "/" . $item['id'] . "\">\n";
                            echo "<i class=\"fas fa-user-edit\"></i> Edit\n";
                            echo "</a>\n";
                            echo "<a href=\"" . base_url("admin/generic_crud/delete/") . $sections_admin['table_section'] . "/" . $item['id'] . "\" style=\"color: red; margin-left: 20px\">\n";
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