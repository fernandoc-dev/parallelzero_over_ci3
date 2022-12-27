<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    Create a new article
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="<?php echo base_url('admin/blog_admin/update') ?>" method="post">
                    <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />
                    <input type="hidden" name="id" id="id" value="<?php echo $article['id'] ?>">
                    <div class="container-fluid">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <span class="btn btn-link" data-toggle="collapse" data-target="#collapseAuthor" aria-expanded="false" aria-controls="collapseAuthor">
                                            Title, Author, URL and description
                                        </span>
                                    </h5>
                                </div>
                                <div id="collapseAuthor" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">Title:</label>
                                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter the title" value="<?php echo $article['title'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="url">URL:</label>
                                                    <input type="text" class="form-control" name="url" id="url" placeholder="Enter the URL for the article" value="<?php echo $article['url'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="author">Author:</label>
                                                    <input type="text" class="form-control" name="url" id="url" placeholder="Enter the URL for the article" value="<?php echo $author['name'] . ' (' . $author['username'] . ')'; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="description">Description:</label>
                                                    <input type="text" class="form-control" name="description" id="description" placeholder="Enter a description" value="<?php echo $article['description'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <span class="btn btn-link" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="false" aria-controls="collapseCategories">
                                            Categories and Tags
                                        </span>
                                    </h5>
                                </div>
                                <div id="collapseCategories" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="category">Category:</label>
                                                    <input type="text" value="<?php echo $article['category'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="subcategories">Sub-categories:</label>
                                                    <select class="select2bs4" multiple="multiple" data-placeholder="Select the sub-categories" style="width: 100%;" name="subcategories[]" id="subcategories">
                                                        <?php
                                                        foreach ($subcategories as $subcategory) {
                                                            if (in_array($subcategory['id'], $article['subcategories'])) {
                                                                echo "<option value=\"" . $subcategory['id'] . "\" selected>" . $subcategory['subcategory'] . "</option>";
                                                            } else {
                                                                echo "<option value=\"" . $subcategory['id'] . "\">" . $subcategory['subcategory'] . "</option>";
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
                                                    <label for="tags">Tags:</label>
                                                    <select class="select2bs4" multiple="multiple" data-placeholder="Select the sub-categories" style="width: 100%;" name="tags[]" id="tags">
                                                        <?php
                                                        foreach ($tags as $tag) {
                                                            if (in_array($tag['id'], $article['tags'])) {
                                                                echo "<option value=\"" . $tag['id'] . "\" selected>" . $tag['tag'] . "</option>";
                                                            } else {
                                                                echo "<option value=\"" . $tag['id'] . "\">" . $tag['tag'] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <span class="btn btn-link" data-toggle="collapse" data-target="#collapseDates" aria-expanded="false" aria-controls="collapseDates">
                                            Dates
                                        </span>
                                    </h5>
                                </div>
                                <div id="collapseDates" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="created_at">Created at:</label>
                                                    <input type="datetime-local" class="form-control" name="created_at" id="created_at" placeholder="Created at..." value="<?php echo $article['created_at']
                                                                                                                                                                            ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="current_state">Released:</label><br>
                                                    <input type="checkbox" id="current_state" name="current_state" <?php if ($article['current_state']) {
                                                                                                                        echo "checked ";
                                                                                                                    }
                                                                                                                    ?> data-bootstrap-switch data-off-color="danger" data-on-color="success" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="release_at">Release at:</label>
                                                    <input type="datetime-local" class="form-control" name="release_at" id="release_at" placeholder="Released at..." value="<?php echo $article['release_at'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="expire_at">Expire at:</label>
                                                    <input type="datetime-local" class="form-control" name="expire_at" id="expire_at" placeholder="Expire at..." value="<?php echo $article['expire_at'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="modified_by">Modified by:</label>
                                                    <input type="text" class="form-control" name="modified_by" id="modified_by" placeholder="Modified by...." value="<?php echo $_SESSION['user']['name'] . ' (' . $_SESSION['user']['username'] . ')'; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="modified_at">Modified at:</label>
                                                    <input type="datetime-local" class="form-control" name="modified_at" id="modified_at" value="<?php echo str_replace(' ', 'T', date('Y-m-d H:i', time())) ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea id="content" name="content">
                                <?php echo $article['content'] ?>
                            </textarea>
                        </div>
                        <div class="form-group">
                            <a href="<?php echo base_url('admin/blog_admin/read_all') ?>" class="btn btn-primary">Go back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
<!-- ./row -->