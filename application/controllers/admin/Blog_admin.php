<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog_admin extends CI_Controller
{
    /*
    * Blog_admin:
    *
    * index
    * create
    * read_all
    * read
    * update
    * delete
    * _load_view
    * load_article_data_for_update_process
    * not_repeated_check
    *
    */

    //Class properties
    private $data;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Lima');
    }
    public function index()
    {
        //default method
        $this->generic_model->default_redirection('admin/blog_admin/read_all');
    }
    public function create()
    {
        /*
        * What does it do?
        *
        * It creates a new article
        *
        * It sets the array $section_parameter
        * It excecutes the method admin_routine
        *
        * GET request_method:
        * It loads the form for creating a new article
        *
        * POST request_method:
        * It excecutes the validation form
        * If the validation is not successfull
        * ---> It loads the form again
        * If the validation is successfull
        * ---> It receives the data from the form
        * ---> It inserts a new article
        * ---> It redirects to read_all section
        *
        * How to use it?
        *
        * The method is called from read_all method, pushing the button "Add a new article"
        *
        * What does it return?
        *
        * GET request_method:
        * It builds the admin article section with a form for inserting a new article
        *
        * POST request_method:
        * It redirects to read_all method after inserting the new article
        *
        */

        $_SESSION['next_page'] = base_url('admin/blog_admin/create');

        $section_parameters = array(
            'section' => get_class(),
            'process' => __FUNCTION__
        );
        $this->data = $this->generic_model->admin_routine($section_parameters);

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            //Load views
            $this->load->library('form_validation');
            $this->_load_view('create');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //Rules for evaluating the articles form: 
            require_once('application/validation_routines/adminlte/blog_admin/articles_validation_rules.php');

            //If the validation is not successfull, redirect to create article form
            if ($this->form_validation->run() == FALSE) {
                $this->db->close();
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_load_view('create');
            } else {
                $this->db->close();
                //Sanitizing the data and applying the XSS filters
                $article = $this->input->post(NULL, TRUE);

                $article['subcategories'] = implode(',', $article['subcategories']);
                $article['tags'] = implode(',', $article['tags']);

                if (isset($article['current_state'])) {
                    $article['current_state'] = 1;
                } else {
                    $article['current_state'] = 0;
                }

                unset($article['files']); //Field created automatically by summernote

                //Insert the article in the Data Base
                if ($this->generic_model->insert_a_new_record('articles', $article)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Great!', 'The article was registered', NULL, 'Ok');
                    redirect(base_url('admin/blog_admin/read_all'));
                } else { //If the insertion failed
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The article could not be registered', NULL, 'Ok');
                    redirect(base_url('admin/blog_admin/read_all'));
                }
            }
        }
    }
    public function read_all()
    {
        /*
        * What does it do?
        *
        * It gets all records from articles table
        *
        * It sets the array $section_parameter
        * It excecutes the method admin_routine
        *
        * GET request_method:
        * It loads a table with the all articles
        *
        * POST request_method:
        * It excecutes the method default_admin_redirection
        *
        * How to use it?
        *
        * The method is called through Admin articles item
        *
        * What does it return?
        *
        * GET request_method:
        * It builds the admin articles section
        *
        * POST request_method:
        * It excecutes the method default_admin_redirection
        *
        */

        $_SESSION['next_page'] = base_url('admin/blog_admin/read_all');

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            $section_parameters = array(
                'section' => get_class(),
                'process' => __FUNCTION__
            );
            $this->data = $this->generic_model->admin_routine($section_parameters);

            $this->data['articles'] = $this->generic_model->read_all_records('articles');

            $counter = 0;
            foreach ($this->data['articles'] as $articles) {
                //Formatting the dates
                $this->data['articles'][$counter]['created_at'] = $this->generic_model->formatting_date($this->data['articles'][$counter]['created_at'], 'type-2');
                $this->data['articles'][$counter]['release_at'] = $this->generic_model->formatting_date($this->data['articles'][$counter]['release_at'], 'type-2');
                $this->data['articles'][$counter]['expire_at'] = $this->generic_model->formatting_date($this->data['articles'][$counter]['expire_at'], 'type-2');
                if ($this->data['articles'][$counter]['modified_at']) {
                    $this->data['articles'][$counter]['modified_at'] = $this->generic_model->formatting_date($this->data['articles'][$counter]['modified_at'], 'type-2');
                }
                $counter++;
            }

            //Load views
            $this->_load_view('read_all');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    public function read($id = NULL)
    {
        /*
        * What does it do?
        *
        * It updates an article
        *
        * It sets the array $section_parameter
        * It excecutes the method admin_routine
        *
        * GET request_method:
        * If id==NULL
        * ---> It redirects to read_all method
        * If id!=NULL
        * ---> It brings the complement data
        * ---> It loads the form for updating an admin menu item
        *
        * POST request_method:
        * It receives the data from the form
        * It excecutes the validation form
        * If the validation is not successfull
        * ---> It loads the validation view
        * If the validation is successfull
        * ---> It updates the selected article
        * ---> It redirects to read_all section
        *
        * How to use it?
        *
        * The method is called from read_all method, pushing the update icon
        *
        * What does it return?
        *
        * GET request_method:
        * It builds the admin article section where the user
        * can update a article
        *
        * POST request_method:
        * It excecutes the procedure to update the selected article
        * It redirects to read_all method
        *
        */
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            if ($id) {
                $_SESSION['next_page'] = base_url('admin/blog_admin/read' . $id);

                $section_parameters = array(
                    'section' => get_class(),
                    'process' => __FUNCTION__
                );
                $this->data = $this->generic_model->admin_routine($section_parameters);

                $this->load_article_data_for_update_process($id);

                //Selecting category
                $category = $this->generic_model->read_a_record_by_id('categories', $this->data['article']['category']);
                $this->data['article']['category'] = $category['category'];

                //Selecting tags
                $tags = $this->generic_model->read_all_records('tags');
                // $this->data['article']['tags'] = implode(',', $this->data['article']['tags']);
                // var_dump($this->data['article']['tags']);
                foreach ($this->data['article']['tags'] as $value) {
                    foreach ($tags as $tag) {
                        if ($value == $tag['id']) {
                            $result[] = $tag['tag'];
                        }
                    }
                }
                $this->data['article']['tags'] = $result;

                //Selecting subcategories 
                $subcategories = $this->generic_model->read_all_records('subcategories');
                // $this->data['article']['subcategories'] = implode(',', $this->data['article']['subcategories']);
                foreach ($this->data['article']['subcategories'] as $value) {
                    foreach ($subcategories as $subcategory) {
                        if ($value == $subcategory['id']) {
                            $result[] = $subcategory['subcategory'];
                        }
                    }
                }
                $this->data['article']['subcategories'] = $result;

                $this->data['author'] = $this->generic_model->read_a_record_by_id('users', $this->data['article']['author']);

                // Load views
                $this->_load_view('read');
            } else {
                redirect(base_url('admin/blog_admin/read_all'));
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
        * It updates an article
        *
        * It sets the array $section_parameter
        * It excecutes the method admin_routine
        *
        * GET request_method:
        * If id==NULL
        * ---> It redirects to read_all method
        * If id!=NULL
        * ---> It brings the complement data
        * ---> It loads the form for updating an admin menu item
        *
        * POST request_method:
        * It receives the data from the form
        * It excecutes the validation form
        * If the validation is not successfull
        * ---> It loads the validation view
        * If the validation is successfull
        * ---> It updates the selected article
        * ---> It redirects to read_all section
        *
        * How to use it?
        *
        * The method is called from read_all method, pushing the update icon
        *
        * What does it return?
        *
        * GET request_method:
        * It builds the admin article section where the user
        * can update a article
        *
        * POST request_method:
        * It excecutes the procedure to update the selected article
        * It redirects to read_all method
        *
        */

        $_SESSION['next_page'] = base_url('admin/blog_admin/read_all');

        $section_parameters = array(
            'section' => get_class(),
            'process' => __FUNCTION__
        );
        $this->data = $this->generic_model->admin_routine($section_parameters);

        $this->load->library('form_validation');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            if ($id == NULL) {
                //redirect to section controller
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There is not a selected item', NULL, 'Ok');
                redirect(base_url("admin/blog_admin/read_all"));
            } else {
                $this->load_article_data_for_update_process($id);
                //Load views
                $this->_load_view('update');
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //The $_SESSION['update']['id'] is setted for the validating process (Controller:not_repeated_check()) 
            $_SESSION['update']['id'] = $this->input->post('id', TRUE);

            //Validation rules for article's updating: 
            require_once('application/validation_routines/adminlte/blog_admin/articles_update_validation_rules.php');

            //If the validation is not successfull
            if ($this->form_validation->run() == FALSE) {
                $this->db->close();

                $this->load_article_data_for_update_process($_SESSION['update']['id']);

                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                //Load views
                $this->_load_view('update_validation');
            } else { //If the validation is successfull
                unset($_SESSION['update']['id']);
                $this->db->close();
                //Sanitizing the data and applying the XSS filters
                $article = $this->input->post(NULL, TRUE);
                $article['subcategories'] = implode(',', $article['subcategories']);
                $article['tags'] = implode(',', $article['tags']);
                unset($article['files']); //Field created automatically by summernote

                if ($this->generic_model->update_record_by_id('articles', $article['id'], $article)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Good news!', "The article was updated", NULL, 'Ok');
                    redirect(base_url("admin/blog_admin/read_all"));
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The article could not be updated", NULL, 'Ok');
                    redirect(base_url("admin/blog_admin/read_all"));
                }
            }
        }
    }
    public function delete($id = NULL)
    {
        /*
        * What does it do?
        *
        * It deletes an article
        *
        * It sets the array $section_parameter
        * It excecutes the method admin_routine
        *
        * GET request_method:
        * If $id==NULL:
        * It redirects to read_all method
        * If $id!=NULL:
        * It searches for the record that matches with $id
        * If one record is found:
        * ---> It deletes it
        * If no one record is found:
        * ---> It redirects to read_all method
        *
        * POST request_method:
        * It excecutes the method default_admin_redirection
        *
        * How to use it?
        *
        * The method is called from read_all method, pushing the delete icon
        *
        * What does it return?
        *
        * GET request_method:
        * It deletes an article
        *
        * POST request_method:
        * It excecutes the method default_admin_redirection
        *
        */

        $_SESSION['next_page'] = base_url('admin/blog_admin/read_all');

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            if (
                $id == NULL
            ) {
                //Reload the controller
                redirect(base_url("admin/blog_admin/read_all"));
            } else {

                $section_parameters = array(
                    'section' => get_class(),
                    'process' => __FUNCTION__
                );

                $this->generic_model->admin_routine($section_parameters);

                if ($this->generic_model->hard_delete_by_id('articles', $id)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Information', 'The item was deleted', NULL, 'Ok');
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem and the selected item could not be deleted', NULL, 'Ok');
                }

                //Reload the controller
                unset($_SESSION['next_page']);
                redirect(base_url("admin/blog_admin/read_all"));
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    public function get_pictures()
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
        if (empty($_FILES['file'])) {
            exit();
        }
        $errorImgFile = "./assets/parallel_zero/img/img_upload_error.jpg";
        $temp = explode(".", $_FILES["file"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $destinationFilePath = './assets/parallel_zero/img/blog/' . $newfilename;
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $destinationFilePath)) {
            echo $errorImgFile;
        } else {
            echo base_url('assets/parallel_zero/img/courses/') . $newfilename;
        }
    }
    private function _load_view($action)
    {
        /*
        * What does it do?
        *
        * The _load_view method loads the views
        * according to the controller
        *
        * How to use it?
        *
        * It is a private method, The controller invocates it
        * sending the parameter $action, which determines
        * the specific view to be loaded
        *
        * _load_view($action)
        * $action can be: 'create', 'read_all', 'update' or 'update_validation'
        *
        * What does it return?
        *
        * It loads the views
        *
        */

        unset($_SESSION['next_page']);
        $_SESSION['last_page'] = base_url('admin/blog_admin/read_all');

        if ($action != 'read') {
            //Get_complementary_data (categories, subcategories, tags)
            $this->data['categories'] = $this->generic_model->read_all_records('categories');
            $this->data['subcategories'] = $this->generic_model->read_all_records('subcategories');
            $this->data['tags'] = $this->generic_model->read_all_records('tags', FALSE);
            $values = array(
                'role>=' => 3,
                'deleted' => 0
            );
            $this->data['authors'] = $this->generic_model->read_records('users', $values);
        }

        //Load views
        require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

        switch ($action) {
            case 'create':
                $_SESSION['last_page'] = base_url("admin/blog_admin/create");
                $default_view = 'generic/create_generic_form';
                break;
            case 'read_all':
                $default_view = 'generic/responsive_hover_table_for_generic_crud';
                break;
            case 'read':
                $this->data['sections_admin']['view'] = 'blog_admin/read';
                $default_view = 'generic/update_generic_form';
                break;
            case 'update':
                $default_view = 'generic/update_generic_form';
                break;
            case 'update_validation':
                $this->data['sections_admin']['view'] = "blog_admin/update_validation";
                $default_view = 'generic/update_generic_form';
                break;
        }
        if (
            $this->data['sections_admin']['view'] == "generic" or
            !file_exists('application/views/admin/adminlte/adminlte3.1.0/sections/' . $this->data['sections_admin']['view'] . '.php')
        ) {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/' . $default_view);
        } else {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/' . $this->data['sections_admin']['view']);
        }

        require_once('application/code_for_loading/adminlte/load_second_group_of_files.php');
    }
    private function load_article_data_for_update_process($id)
    {
        $this->data['article'] = $this->generic_model->read_a_record_by_id('articles', $id);
        $this->data['article']['subcategories'] = explode(',', $this->data['article']['subcategories']);
        $this->data['article']['tags'] = explode(',', $this->data['article']['tags']);

        //Formatting the dates
        $this->data['article']['created_at'] = $this->generic_model->formatting_date($this->data['article']['created_at'], 'type-1');
        $this->data['article']['release_at'] = $this->generic_model->formatting_date($this->data['article']['release_at'], 'type-1');
        $this->data['article']['expire_at'] = $this->generic_model->formatting_date($this->data['article']['expire_at'], 'type-1');
        if ($this->data['article']['modified_at']) {
            $this->data['article']['modified_at'] = $this->generic_model->formatting_date($this->data['article']['modified_at'], 'type-1');
        }
    }
    public function not_repeated_check($value, $field)
    {
        /*
        * This method is part of the validation rules for Update method
        */
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->generic_model->default_redirection();
        }
        $article = $this->generic_model->read_a_record_by_id('articles', $_SESSION['update']['id']);
        if ($value == $article[$field]) {
            return TRUE;
        } else {
            $record = array(
                $field => $value
            );
            $result = $this->generic_model->check_if_the_record_exists('articles', $record);
            if (is_array($result)) {
                $this->form_validation->set_message('not_repeated_check', 'Try using other ' . $field);
                return FALSE;
            } elseif ($result === "available") {
                return TRUE;
            } elseif ($result === "error") {
                $this->form_validation->set_message('not_repeated_check', 'Try using other ' . $field);
                return FALSE;
            }
        }
    }
}
