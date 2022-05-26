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

    public function register() //CREATE
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
            $this->_article_form('register');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //Rules for evaluating the articles form: 
            require_once('application/validation_routines/adminlte/blog/blog_validation_rules.php');

            //If the validation is not successfull, redirect to Register form
            if ($this->form_validation->run() == FALSE) {
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_article_form('validation');
            } else {
                //Getting article data: 
                require_once('application/helpers/adminlte/blog/getting_article_data.php');

                //Rules for evaluating the articles form: 
                require_once('application/helpers/adminlte/blog/converting_from_values_to_id.php');

                //Insert the article in the Data Base
                if ($this->generic_model->insert_a_new_record('articles', $article_data)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Great!', 'The article was registered', NULL, 'Ok');
                    $this->_article_form(NULL);
                } else { //If the insertion failed
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The article could not be registered', NULL, 'Ok');
                    $this->_article_form(NULL);
                }
            }
        }
    }
    public function articles($action = NULL) //READ
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
            $this->data = $this->generic_model->admin_routine('articles', 'role_get_all');
            if ($this->data) {
                //Load views
                $this->_load_articles_view('get_all', 'articles');
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            redirect(base_url('admin/generic_crud/get_all/dont_show'));
        }
        //Load views
        require_once('application/helpers/adminlte/load_first_group_of_files.php');

        if ($action == TRUE) {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/tables/responsive_hover_table_for_articles');
        } elseif ($action == NULL) {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/tables/responsive_hover_table_for_articles');
        }

        require_once('application/helpers/adminlte/load_second_group_of_files.php');
    }
    public function update_article(int $id) //UPDATE
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
            $this->_article_form('update', $id);
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Rules for evaluating the articles form: 
            require_once('application/helpers/adminlte/blog/blog_validation_rules.php');

            //If the validation is not successfull, redirect to Register form
            if ($this->form_validation->run() == FALSE) {
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_article_form('validation');
            } else {
                //Getting article data: 
                require_once('application/helpers/adminlte/blog/getting_article_data.php');

                //Rules for evaluating the articles form: 
                require_once('application/helpers/adminlte/blog/converting_from_values_to_id.php');

                //Update the article in the Data Base
                if ($this->generic_model->insert_a_new_record('articles', $article_data)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Great!', 'The article was registered', NULL, 'Ok');
                    $this->_article_form(NULL);
                } else { //If the insertion failed
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The article could not be registered', NULL, 'Ok');
                    $this->_article_form(NULL);
                }
            }
        }
    }
    public function check_if_the_field_exists($item = NULL, $field = NULL)
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
        //This method is the validation for url not repeated
        //The equivalent to "is_unique" CI validation, but I keep this is here to know other way of doing that validation.
        //This is an example of a "call back" function for validating
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            redirect(base_url('admin/blog_admin/new_article'));
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $record = array( //Fields that can't be repeated
                $field => $item
            );
            $result = $this->generic_model->check_if_the_record_exists('articles', $record);
            if ($result === "available") {
                return TRUE;
            } else {
                $this->load->helper('helpers_for_modal');
                $message = build_message_about_repeated_records_for_modal(array($field));
                $this->form_validation->set_message('check_if_the_field_exists', $message);
                return FALSE;
            }
        }
    }
    private function _set_menu_items($menu_open, $active, $active_2)
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
        $this->load->model('menu_admin_model');
        $this->data['items_menu'] = $this->menu_admin_model->get_items_admin_menu();
        $this->data['menu_open'] = $menu_open; //Open menu with children
        $this->data['menu_active'] = $active;    //Active item
        $this->data['menu_active_2'] = $active_2;  //Active item for submenu
    }
    private function _set_singular_and_plural_item($original, $singular, $plural)
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
        $this->data['item_original'] = $original;
        $this->data['item_plural'] = $plural;
        $this->data['item_singular'] = $singular;
    }
    public function update_generic_crud($subsection = NULL, $id = NULL)
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
            if ($subsection == NULL or $id == NULL) {
                redirect(base_url('admin/blog_admin/articles'));
            } else {
                if ($result = $this->generic_model->get_a_record_by_id($subsection, $id, FALSE)) {
                    $this->data['item'] = $result[0];
                    $this->data['original'] = $subsection;
                    $this->_set_singular_and_plural_item($subsection, "", "");
                    switch ($subsection) {
                        case "Users":
                            $this->data['items'] = $this->generic_model->get_all_records('users', NULL);
                            $dont_show = 'users-admin';
                            $this->_set_singular_and_plural_item($subsection, 'a User', 'Users');
                            $this->_set_menu_items('Users', 'Users', '');
                            break;
                        case "Categories":
                            $this->data['items'] = $this->generic_model->get_all_records('categories', NULL);
                            $dont_show = 'categories';
                            $this->_set_singular_and_plural_item($subsection, 'a Category', 'Categories');
                            $this->_set_menu_items('Articles', 'Articles', 'Categories');
                            break;
                        case "Subcategories":
                            $this->data['items'] = $this->generic_model->get_all_records('subcategories', NULL);
                            $this->_set_singular_and_plural_item($subsection, 'a Sub-category', 'Sub-categories');
                            $this->_set_menu_items('Articles', 'Articles', 'Sub-categories');
                            break;
                    }
                    if (isset($dont_show)) {
                        $result = $this->generic_model->get_a_record_by_record('dont_show', 'identifier', $dont_show);
                        $this->data['dont_show'] = explode(",", $result['dont_show']);
                    } else {
                        $this->data['dont_show'] = array();
                    }
                    $this->_load_the_generic_crud_form('update');
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem and the selected item could not be loaded', NULL, 'Ok');
                    redirect(base_url('admin/blog_admin/articles'));
                }
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            if (strtolower($subsection) == 'categories') {
                echo "AQUI VAN LAS REGLAS DE VALIDACION";
            }
        }
    }
    public function delete_generic_crud($subsection = NULL, $id = NULL)
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
        if ($subsection == NULL or $id == NULL) {
            redirect(base_url('admin/blog_admin/articles'));
        } else {
            if ($this->generic_model->deactivate_by_id($subsection, $id)) {
                $this->generic_model->set_the_flash_variables_for_modal('Information', 'The item was deleted', NULL, 'Ok');
                redirect(base_url("admin/blog_admin/generic_crud/$subsection"));
            } else {
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem and the selected item could not be deleted', NULL, 'Ok');
                redirect(base_url("admin/blog_admin/generic_crud/$subsection"));
            }
        }
    }
    private function _article_form($action = 'register', $id = NULL)
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

        //Menu settings
        $this->load->model('menu_admin_model');
        $this->data['items_menu'] = $this->menu_admin_model->get_items_admin_menu();
        $this->_set_menu_items('Articles', 'New article', '');
        //Menu settings

        //Load dependencies
        $this->data['dependencies'] = array(
            'editors' => array(
                'summernote' => TRUE
            ),
            'select2' => TRUE,
            'switch' => TRUE
        );
        //Load dependencies

        //Action
        $this->data['action'] = $action;

        //Get_complementary_data (categories, subcategories, tags)
        $this->data['categories'] = $this->generic_model->get_all_records('categories', NULL);
        $this->data['subcategories'] = $this->generic_model->get_all_records('subcategories', NULL);
        $this->data['tags'] = $this->generic_model->get_all_records('tags', NULL);

        //Get Authors
        $this->load->model('users_model');
        $this->data['authors'] = $this->users_model->get_authors(NULL);

        //Update case
        if ($action == 'update') {
            require_once('application/helpers/adminlte/blog/update/preparing_data_article_for_update_form.php');
        }

        //Load views
        require_once('application/helpers/adminlte/load_first_group_of_files.php');

        if ($action === 'register') {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/editors/summernote');
        } elseif ($action === 'validation') {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/editors/summernote_validation');
        } elseif ($action === 'update') {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/editors/summernote_update');
        }

        require_once('application/helpers/adminlte/load_second_group_of_files.php');
    }
    private function _load_the_generic_crud_form($action)
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
        //Menu settings
        $this->load->model('menu_admin_model');
        $this->data['items_menu'] = $this->menu_admin_model->get_items_admin_menu();
        $this->_set_menu_items('', '', '');
        //Menu settings

        //Load dependencies
        $this->data['dependencies'] = array(
            'editors' => array(
                'summernote' => TRUE
            ),
            'select2' => TRUE,
            'switch' => TRUE
        );
        //Load dependencies

        //Action
        $this->data['action'] = $action;

        //Get_complementary_data (categories, subcategories, tags)
        $this->data['categories'] = $this->generic_model->get_all_records('categories', NULL);
        $this->data['subcategories'] = $this->generic_model->get_all_records('subcategories', NULL);
        $this->data['tags'] = $this->generic_model->get_all_records('tags', NULL);

        //Get Authors
        $this->load->model('users_model');
        $this->data['authors'] = $this->users_model->get_authors(NULL);

        //Update case
        if ($action == 'update') {
            //require_once('application/helpers/adminlte/blog/update/preparing_data_article_for_update_form.php');
        }

        //Load views
        require_once('application/helpers/adminlte/load_first_group_of_files.php');

        if ($action === 'register') {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/editors/summernote');
        } elseif ($action === 'validation') {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/editors/summernote_validation');
        } elseif ($action === 'update') {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/forms/update_generic_crud_form');
        } elseif ('categories') {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/editors/categories');
        }

        require_once('application/helpers/adminlte/load_second_group_of_files.php');
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
        $errorImgFile = "./img/img_upload_error.jpg";
        $temp = explode(".", $_FILES["file"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        //$destinationFilePath = './img-uploads/'.$newfilename ;
        //$destinationFilePath = '../mp/ci/assets/parallel_zero/img/' . $newfilename;
        $destinationFilePath = './assets/parallel_zero/img/' . $newfilename;
        //$destinationFilePath = '../mp/ci/assets/img/' . $newfilename;
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $destinationFilePath)) {
            echo $errorImgFile;
        } else {
            echo $destinationFilePath;
        }
    }
    private function _load_articles_view($action, $section)
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

        $_SESSION['last_page'] = "$action/$section";

        //Load dependencies
        $this->data['dependencies'] = array(
            'editors' => array(
                'summernote' => TRUE
            ),
            'select2' => TRUE,
            'switch' => TRUE
        );
        //Load dependencies

        //Get_complementary_data (categories, subcategories, tags)
        $this->data['articles'] = $this->generic_model->get_all_records('articles');
        $this->data['categories'] = $this->generic_model->get_all_records('categories', FALSE);
        $this->data['subcategories'] = $this->generic_model->get_all_records('subcategories', FALSE);
        $this->data['tags'] = $this->generic_model->get_all_records('tags', FALSE);
        $values = array(
            'role>=' => 3,
            'deleted' => 0
        );
        $this->data['authors'] = $this->generic_model->get_records_where('users', $values);

        //Load views
        require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

        switch ($action) {
            case 'create':
                $this->load->View('admin/adminlte/adminlte3.1.0/sections/forms/generic/create_generic_form');
                break;
            case 'get_all':
                //Specific cases which need specific views
                if (
                    $this->data['admin_sections']['view_get'] == "generic"
                ) {
                    //General cases which work with the general view
                    $this->load->View('admin/adminlte/adminlte3.1.0/sections/tables/responsive_hover_table_for_generic_crud');
                } else {
                    $view = 'application/views/admin/adminlte/adminlte3.1.0/sections/' . $this->data['admin_sections']['view_get'] . '.php';
                    if (file_exists($view)) {
                        $this->load->View('admin/adminlte/adminlte3.1.0/sections/' . $this->data['admin_sections']['view_get']);
                    } else {
                        $this->load->View('admin/adminlte/adminlte3.1.0/sections/tables/responsive_hover_table_for_generic_crud');
                    }
                }
                break;
            case 'update':
                $this->load->View('admin/adminlte/adminlte3.1.0/sections/forms/generic/update_generic_form');
                break;
            case 'create_table':
                $this->load->View('admin/adminlte/adminlte3.1.0/sections/forms/create_table_form');
                break;
            case 'validation':
                $this->load->View('admin/adminlte/adminlte3.1.0/sections/editors/summernote_validation');
                break;
        }

        require_once('application/code_for_loading/adminlte/load_second_group_of_files.php');
    }
}
