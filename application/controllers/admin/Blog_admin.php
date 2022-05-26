<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog_admin extends CI_Controller
{
    /*
    * Blog_admin:
    *
    * register
    * articles
    * update_article
    * check_if_the_field_exists
    * categories
    * subcategories
    * generic_crud
    * 
    *
    * _set_menu_items
    * _set_singular_and_plural_item
    * update_generic_crud
    * delete_generic_crud
    * _article_form
    * _load_the_generic_crud_form
    * get_pictures
    *
    */

    //Class properties
    private $data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('generic_model');
        $this->load->model('users_model');
    }
    public function create()
    {
        /*
        * What does it do?
        *
        * If the request is GET
        * ---> It loads the form to create a new article
        * If the request is POST
        * ---> It receives the data from the create form
        * ---> It applies the validation rules
        * ---> If the validation is FALSE
        * --------> It loads again the create form
        * ---> If the validation is TRUE
        * --------> It finds the id of the data from the values
        * --------> It saves the data in the database
        * --------> If the writting in DB is TRUE
        * -------------> It sets a success message for modal
        * -------------> It redirects to blog_admin/read_all
        * --------> If the writting in DB is FALSE
        * -------------> It sets an error message for modal
        * -------------> It redirects to blog_admin/read_all
        *
        */

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->data = $this->generic_model->admin_routine('articles_blog_admin', 'role_create');
            if ($this->data) {
                //Load views
                $this->load->library('form_validation');
                $this->_load_articles_view('create');
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //Rules for evaluating the articles form: 
            require_once('application/validation_routines/adminlte/blog/blog_validation_rules.php');

            //If the validation is not successfull, redirect to create article form
            if ($this->form_validation->run() == FALSE) {
                $this->db->close();
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->data = $this->generic_model->admin_routine('articles_blog_admin', 'role_create');
                if ($this->data) {
                    //Load views
                    $this->load->library('form_validation');
                    $this->_load_articles_view('create');
                }
            } else {
                //Sanitizing the data and applying the XSS filters

                $article_data = $this->input->post(NULL, FALSE);

                $subcategories = implode(',', $article_data['subcategories']);
                unset($article_data['subcategories']);
                $article_data['subcategories'] = $subcategories;

                $tags = implode(',', $article_data['tags']);
                unset($article_data['tags']);
                $article_data['tags'] = $tags;

                if (isset($article_data['current_state'])) {
                    $article_data['current_state'] = 1;
                } else {
                    $article_data['current_state'] = 0;
                }

                unset($article_data['files']); //Field created automatically by summernote

                //Insert the article in the Data Base
                if ($this->generic_model->insert_a_new_record('articles', $article_data)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Great!', 'The article was registered', NULL, 'Ok');
                    redirect(base_url('admin/blog_admin/read_all'));
                } else { //If the insertion failed
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The article could not be registered', NULL, 'Ok');
                    redirect(base_url('admin/blog_admin/read_all'));
                }
            }
        }
    }
    public function read_all($action = NULL)
    {
        /*
        * What does it do?
        *
        *
        *
        * How to use it?
        *
        *
        *
        * What does it return?
        *
        *
        *
        * More details:
        *
        *
        *
        */

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->data = $this->generic_model->admin_routine('articles_blog_admin', 'role_read_all');
            if ($this->data) {
                //Load views
                $this->_load_articles_view('read_all');
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    public function update($id = NULL)
    {
        /*
        * What does it do?
        *
        *
        *
        * How to use it?
        *
        *
        *
        * What does it return?
        *
        *
        *
        * More details:
        *
        *
        *
        */

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->data = $this->generic_model->admin_routine('articles_blog_admin', 'role_update', $id);
            if ($this->data) {
                //Load views
                $this->_load_articles_view('update');
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    public function delete($id = NULL)
    {
        /*
        * What does it do?
        *
        * The delete method deletes an specific item
        *
        * How to use it?
        *
        * The method is accessed by the URL
        *
        * What does it return?
        *
        * The method only delete the item
        *
        */

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            if ($id == NULL) {
                //Reload the controller
                redirect(base_url('admin/blog_admin/articles'));
            } else {
                $this->data = $this->generic_model->admin_routine('articles', 'role_delete');
                if ($this->data) {
                    if ($this->generic_model->hard_delete_by_id('articles', $id)) {
                        $this->generic_model->set_the_flash_variables_for_modal('Information', 'The item was deleted', NULL, 'Ok');
                    } else {
                        $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem and the selected item could not be deleted', NULL, 'Ok');
                    }
                }
                //Reload the controller
                redirect(base_url('admin/blog_admin/read_all'));
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    private function _load_articles_view($action)
    {
        /*
        * What does it do?
        *
        * The _load_generic_view method loads the views
        * according to the controller
        *
        * How to use it?
        *
        * It is a private method, The controller invocates it
        * sending the parameter $action, which determines
        * the specific view to be loaded 
        *
        * What does it return?
        *
        * It loads the views
        *
        */

        $_SESSION['last_page'] = base_url('admin/blog_admin/read_all/');

        //Get_complementary_data (categories, subcategories, tags)
        $this->data['articles'] = $this->generic_model->read_all_records('articles');
        $this->data['categories'] = $this->generic_model->read_all_records('categories', FALSE);
        $this->data['subcategories'] = $this->generic_model->read_all_records('subcategories', FALSE);
        $this->data['tags'] = $this->generic_model->read_all_records('tags', FALSE);
        $values = array(
            'role>=' => 3,
            'deleted' => 0
        );
        $this->data['authors'] = $this->generic_model->get_records_where('users', $values);

        // var_dump($this->data);

        //Load views
        require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

        switch ($action) {
            case 'create':
                $view = 'view_create';
                $default_view = 'generic/create_generic_form';
                break;
            case 'read_all':
                $view = 'view_read_all';
                $default_view = 'generic/responsive_hover_table_for_generic_crud';
                break;
            case 'update':
                $view = 'view_update';
                $default_view = 'generic/update_generic_form';
                break;
        }
        if (
            $this->data['admin_sections'][$view] == "generic" or
            !file_exists('application/views/admin/adminlte/adminlte3.1.0/sections/' . $this->data['admin_sections'][$view] . '.php')
        ) {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/' . $default_view);
        } else {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/' . $this->data['admin_sections'][$view]);
        }

        require_once('application/code_for_loading/adminlte/load_second_group_of_files.php');
    }
}
