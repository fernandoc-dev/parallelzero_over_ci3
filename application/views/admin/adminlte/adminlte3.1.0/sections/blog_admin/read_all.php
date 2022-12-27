<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="<?php echo base_url('admin/blog_admin/create') ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add an Article</a>
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
                            <th>Title</th>
                            <th>URL</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Sub-categories</th>
                            <th>Tags</th>
                            <th>State</th>
                            <th>Released</th>
                            <th>Expire at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        <?php
                        foreach ($articles as $article) {
                            echo "<tr>\n";
                            echo "<td>" . $article['title'] . "</td>\n";
                            echo "<td>" . $article['url'] . "</td>\n";

                            $filled_author = FALSE;
                            foreach ($authors as $author) {
                                if ($author['id'] == $article['author']) {
                                    $filled_author = TRUE;
                                    echo "<td>" . $author['name'] . "</td>\n";
                                    break;
                                }
                            }
                            if (!$filled_author) {
                                echo "<td>" . "NO INFORMATION" . "</td>\n";
                            }

                            $filled_category = FALSE;
                            foreach ($categories as $category) {
                                if ($category['id'] == $article['category']) {
                                    $filled_category = TRUE;
                                    echo "<td>" . $category['category'] . "</td>\n";
                                    break;
                                }
                            }
                            if (!$filled_category) {
                                echo "<td>" . "NO INFORMATION" . "</td>\n";
                            }

                            $selected_subcategories = array();
                            $subcategories_article = explode(',', $article['subcategories']);
                            foreach ($subcategories_article as $subcategory) {
                                foreach ($subcategories as $subcategory_source) {
                                    if ($subcategory_source['id'] == $subcategory) {
                                        array_push($selected_subcategories, $subcategory_source['subcategory']);
                                    }
                                }
                            }
                            if (count($selected_subcategories) > 0) {
                                echo "<td>" . implode(',', $selected_subcategories) . "</td>\n";
                            } else {
                                echo "<td>" . "NO INFORMATION" . "</td>\n";
                            }

                            $selected_tags = array();
                            $tags_article = explode(',', $article['tags']);
                            foreach ($tags_article as $tag) {
                                foreach ($tags as $tag_source) {
                                    if ($tag_source['id'] == $tag) {
                                        array_push($selected_tags, $tag_source['tag']);
                                    }
                                }
                            }
                            if (count($selected_subcategories) > 0) {
                                echo "<td>" . implode(',', $selected_tags) . "</td>\n";
                            } else {
                                echo "<td>" . "NO INFORMATION" . "</td>\n";
                            }
                            if ($article['current_state'] == 1) {
                                echo "<td>" . "<span style=\"color: green; border: 2px solid green; padding: 2px;\"><b>on-line</b></span>" . "</td>\n";
                            } else {
                                echo "<td>" . "<span style=\"color: red; border: 2px solid red; padding: 2px;\"><b>off-line</b></span>" . "</td>\n";
                            }
                            echo "<td>" . $article['release_at'] . "</td>\n";
                            echo "<td>" . $article['expire_at'] . "</td>\n";
                            echo "<td><a href=\"" . base_url("admin/blog_admin/read/") . $article['id'] . "\" style=\"color: green\">\n";
                            echo "<i class=\"fa-solid fa-eye\"></i> Read\n";
                            echo "</a>\n";
                            echo "<a href=\"" . base_url("admin/blog_admin/update/") . $article['id'] . "\" style=\"margin-left: 20px\">\n";
                            echo "<i class=\"fas fa-user-edit\"></i> Edit\n";
                            echo "</a>\n";
                            echo "<a href=\"" . base_url("admin/blog_admin/delete/") . $article['id'] . "\" style=\"color: red; margin-left: 20px\">\n";
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