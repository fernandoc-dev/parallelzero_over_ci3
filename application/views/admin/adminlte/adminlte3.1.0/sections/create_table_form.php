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
            <form action="<?php echo (base_url('admin/users_admin/update_user')) ?>" method="post">
                <input type="hidden" name="<?php echo ($this->security->get_csrf_token_name()); ?>" value="<?php echo ($this->security->get_csrf_hash()); ?>" />
                <input type="hidden" name="updating_form_id" id="" value="">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="table">Table name:</label>
                                <input type="text" class="form-control" name="table" id="table" placeholder="Table's name" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_name_1">Field name #1:</label>
                                <input type="field_name_1" class="form-control" name="field_name_1" id="field_name_1" placeholder="Enter the field name" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_type_1">Field type:</label>
                                <select class="form-control" id="field_type_1" name="field_type_1">
                                    <option value="" selected>INT</option>
                                    <option value="">TINYINT</option>
                                    <option value="">VARCHAR</option>
                                    <option value="">TEXT</option>
                                    <option value="">DATE</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_lenght_1">Lenght:</label>
                                <input type="text" class="form-control" name="field_lenght_1" id="field_lenght_1" placeholder="Enter length" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="default_value_1">Default value:</label>
                                <input type="text" class="form-control" name="default_value_1" id="default_value_1" placeholder="Enter default value" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1"><b>NULL</b></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1"><b>AI</b></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary1" checked>
                                    <label for="checkboxPrimary1">NULL</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary1" checked>
                                    <label for="checkboxPrimary1">AI</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_name_1">Field name #1:</label>
                                <input type="field_name_1" class="form-control" name="field_name_1" id="field_name_1" placeholder="Enter the field name" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_type_1">Field type:</label>
                                <select class="form-control" id="field_type_1" name="field_type_1">
                                    <option value="" selected>INT</option>
                                    <option value="">TINYINT</option>
                                    <option value="">VARCHAR</option>
                                    <option value="">TEXT</option>
                                    <option value="">DATE</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_lenght_1">Lenght:</label>
                                <input type="text" class="form-control" name="field_lenght_1" id="field_lenght_1" placeholder="Enter length" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="default_value_1">Default value:</label>
                                <input type="text" class="form-control" name="default_value_1" id="default_value_1" placeholder="Enter default value" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1"><b>NULL</b></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1"><b>AI</b></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary1" checked>
                                    <label for="checkboxPrimary1">NULL</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary1" checked>
                                    <label for="checkboxPrimary1">AI</label>
                                </div>
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