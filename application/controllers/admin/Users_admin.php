<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_admin extends CI_Controller
{
    /*
    * create_an_user
    * users
    * update_user
    * delete
    *
    * _load_update_user_form
    *
    */

    //Class properties
    private $data;

    public function __construct() //Método constructor
    {
        parent::__construct();
        $this->load->model('generic_model');
    }
    public function registration()
    {
        /*
        * What does it do?
        *
        * If the Regisration method is excecuted through a GET request:
        * --->Registration loads the form where the user can be registered
        * If the Regisration method is excecuted through a POST request:
        * --->Receives the data from the registration form,
        * --->Excecutes the validations
        * --->Checks if the username and email are not repeated in the DB
        * --->If the validation is not successfull:
        * ------->Load the Register Form again
        * --->If the validation is successfull:
        * ------->Sanitize the data,
        * ------->Build the generic user_data variable
        * ------->Checks if the username and email are not repeated in the DB,
        * ------->If the Username and Email are not repeated: 
        * ------------>Insert in the DB
        * ------------>Redirect to login form
        * ------->If the Username and Email are repeated:
        * ------------>Load the Register Form again
        * 
        * How to use it?
        * 
        * The URL must be loaded to access to the form, and the form's 
        * action attribute must point to the method using POST
        *
        * What does it return?
        *
        * The Login method manage the following possibilities:
        * If the registration was successfull:
        * --->Redirect to login
        * If the registration was not successfull:
        * --->Loads the registration form again
        */
        $this->load->library('form_validation');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->_registration_form();
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //Rules for evaluating the register form: 
            require_once('application/validation_routines/users/register_form_validation_rules.php');

            //If the validation is not successfull, redirect to Register form
            if ($this->form_validation->run() == FALSE) {
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_registration_form();
            } else {
                //If the validation is successfull
                //Sanitizing the data and applying the XSS filters
                //Build the generic user_data variable
                $user_data['complete_name'] = $this->input->post('register_form_complete_name', TRUE);
                $user_data['email'] = $this->input->post('register_form_email', TRUE);
                $user_data['username'] = $this->input->post('register_form_username', TRUE);
                $user_data['phone'] = $this->input->post('register_form_phone', TRUE);
                $user_data['password'] = $this->input->post('register_form_password', TRUE);
                $user_data['password_confirmation'] = $this->input->post('register_form_password_confirmation', TRUE);
                //Consult the data base for repeated records
                $this->load->model('users_model');
                $result = $this->users_model->check_if_the_user_exists($user_data);
                switch ($result) {
                    case 'The username and email are available':
                        //Insert in the DB
                        $result = $this->users_model->create_an_user($user_data);
                        if ($result) {
                            $this->generic_model->set_the_flash_variables_for_modal('Good news!', 'The username was registered', NULL, 'Ok');
                            redirect(base_url('users/users/login'));
                        } else {
                            $this->generic_model->set_the_flash_variables_for_modal('Ups!', 'There was a problem, try again later', NULL, 'Ok');
                            redirect(base_url('users/users/registration'));
                        }
                        break;
                    case 'The username is already registered':
                        //If the Username is repeated:
                        //Reload the Register Form
                        $this->generic_model->set_the_flash_variables_for_modal('Ups!', 'The username is not available', NULL, 'Try other username');
                        $this->_registration_form();
                        break;
                    case 'The email is already registered':
                        //If the Email is repeated:
                        //Offer to redirect to the Login Form
                        $this->generic_model->set_the_flash_variables_for_modal('Ups!', 'The email is already registered. You can Log in directly', NULL, NULL, base_url('users/users/login'), 'Go to log in form');
                        $this->_registration_form();
                        break;
                }
            }
        }
    }
    public function create_an_user()
    {
        /*
        * What does it do?
        *
        * Loads the form to create the user
        * Applies the validations
        * If the validation es successful:
        * --->Insert the user
        * Reads the parameters from the table "admin_sections"
        * If the section is not registered in "admin_sections"
        * --->It redirects to a default page
        * Gets the content (users table)
        * Gets the menu items
        * Gets the roles
        * Loads the views
        *
        * How to use it?
        *
        * This is called from the URL
        *
        * What does it return?
        *
        * It loads the views
        *
        */

        $this->data['admin_sections'] = $this->generic_model->get_a_record_by_record('admin_sections', 'section', 'users');
        if (!$this->data['admin_sections']) {
            redirect(base_url());
        }
        $this->data['admin_sections']['content'] = $this->generic_model->get_all_records($this->data['admin_sections']['table_section']);
        $this->data['admin_sections']['columns'] = $this->generic_model->get_columns_of_table($this->data['admin_sections']['table_section']);
        //Menu items
        $this->data['items_menu'] = $this->generic_model->get_all_records('admin_menu');

        $this->data['roles'] = $this->generic_model->get_all_records('roles');

        //Load views
        require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

        $this->load->view('admin/adminlte/adminlte3.1.0/sections/tables/responsive_hover_table_for_users');

        require_once('application/code_for_loading/adminlte/load_second_group_of_files.php');
    }
    public function update_user($id = NULL)
    {
        /*
        * What does it do?
        *
        * This method get all records of a table
        *
        * How to use it?
        *
        * This is called from the URL
        *
        * What does it return?
        *
        * This gets the data and loads the views
        *
        */

        $this->load->model('users_model');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->_load_update_user_form($id);
        }
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            //Rules for evaluating the login form: 
            require_once('application/validation_routines/adminlte/users/users_validation_rules.php');

            //If the validation is not successfull, redirect to Register form
            if ($this->form_validation->run() == FALSE) {
                //echo 'Falló la validacion';
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_load_update_user_form($id, TRUE);
                //echo "NO PASÓ LA VALIDACION<br>";
            } else {
                //If the validation is successfull
                //Sanitizing the data and applying the XSS filters
                //Build the generic user_data variable
                $user_data['id'] = $this->input->post('updating_form_id', TRUE);
                $user_data['complete_name'] = $this->input->post('updating_form_complete_name', TRUE);
                $user_data['email'] = $this->input->post('updating_form_email', TRUE);
                $user_data['username'] = $this->input->post('updating_form_username', TRUE);
                $user_data['phone'] = $this->input->post('updating_form_phone', TRUE);
                $user_data['password'] = $this->input->post('updating_form_password', TRUE);
                $user_data['password_confirmation'] = $this->input->post('updating_form_password_confirmation', TRUE);
                //echo "LA VALIDACION FUE EXITOSA<br>";
                $result = $this->users_model->update_a_user($user_data);
                if ($result) {
                    redirect(base_url("admin/users_admin/users"));
                } else {
                    //echo "EL USUARIO FINALMENTE NO FUE ACTUALIZADO<br>";
                }
            }
        }
    }
    public function users()
    {
        /*
        * What does it do?
        *
        * Loads all users on the table
        * Reads the parameters from the table "admin_sections"
        * If the section is not registered in "admin_sections"
        * --->It redirects to a default page
        * Gets the content (users table)
        * Gets the menu items
        * Gets the roles
        * Loads the views
        *
        * How to use it?
        *
        * This is called from the URL
        *
        * What does it return?
        *
        * It loads the views
        *
        */

        $this->data['admin_sections'] = $this->generic_model->get_a_record_by_record('admin_sections', 'section', 'users');
        if (!$this->data['admin_sections']) {
            redirect(base_url());
        }
        $this->data['admin_sections']['content'] = $this->generic_model->get_all_records($this->data['admin_sections']['table_section']);
        $this->data['admin_sections']['columns'] = $this->generic_model->get_columns_of_table($this->data['admin_sections']['table_section']);
        //Menu items
        $this->data['items_menu'] = $this->generic_model->get_all_records('admin_menu');

        $this->data['roles'] = $this->generic_model->get_all_records('roles');

        //Load views
        require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

        $this->load->view('admin/adminlte/adminlte3.1.0/sections/tables/responsive_hover_table_for_users');

        require_once('application/code_for_loading/adminlte/load_second_group_of_files.php');
    }
    private function _load_update_user_form($id, $validation = NULL)
    {
        /*
        * What does it do?
        *
        * This method get all records of a table
        *
        * How to use it?
        *
        * This is called from the URL
        *
        * What does it return?
        *
        * This gets the data and loads the views
        *
        */
        //Menu settings
        $this->load->model('menu_admin_model');
        $data['items_menu'] = $this->menu_admin_model->get_items_admin_menu();
        $identifier_1 = "Users";
        $identifier_2 = "Update";
        $identifier_3 = "";
        $data['menu_open'] = $identifier_1; //Open menu with children
        $data['menu_active'] = $identifier_1;    //Active item
        $data['menu_active_2'] = $identifier_2;  //Active item for submenu
        //Menu settings

        //Load dependencies
        $data['dependencies'] = array(
            'editors' => array(
                'summernote' => TRUE
            )
        );
        //Load dependencies

        $this->load->model('users_model');
        $data['user'] = $this->users_model->get_user_by_id($id);

        $this->load->model('users_model');
        $data['roles'] = $this->users_model->get_roles();

        //Load views
        require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

        if ($validation == TRUE) {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/forms/update_user_form_validation');
        } elseif ($validation == NULL) {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/forms/update_user_form');
        }

        require_once('application/code_for_loading/adminlte/load_second_group_of_files.php');
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

        //Load views
        require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

        switch ($action) {
            case 'create':
                $_SESSION['last_page'] = base_url("admin/users/create");
                $default_view = 'generic/create_generic_form';
                break;
            case 'read_all':
                $_SESSION['last_page'] = base_url("admin/users/read_all");
                $default_view = 'generic/responsive_hover_table_for_generic_crud';
                break;
            case 'update':
                $_SESSION['last_page'] = base_url("admin/users/read_all");
                $default_view = 'generic/update_generic_form';
                break;
            case 'update_validation':
                $_SESSION['last_page'] = base_url("admin/users/read_all");
                $this->data['admin_sections']['view'] = "admin_menu/update_validation";
                $default_view = 'generic/update_generic_form';
                break;
        }
        if (
            $this->data['admin_sections']['view'] == "generic" or
            !file_exists('application/views/admin/adminlte/adminlte3.1.0/sections/' . $this->data['admin_sections']['view'] . '.php')
        ) {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/' . $default_view);
        } else {
            $this->load->View('admin/adminlte/adminlte3.1.0/sections/' . $this->data['admin_sections']['view']);
        }

        require_once('application/code_for_loading/adminlte/load_second_group_of_files.php');
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
        $_SESSION['last_page'] = base_url("admin/menu_admin/read_all");

        //Load views
        require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

        switch ($action) {
            case 'create':
                $_SESSION['last_page'] = base_url("admin/menu_admin/create");
                $default_view = 'generic/create_generic_form';
                break;
            case 'read_all':
                $default_view = 'generic/responsive_hover_table_for_generic_crud';
                break;
            case 'update':
                $default_view = 'generic/update_generic_form';
                break;
            case 'update_validation':
                $this->data['sections_admin']['view'] = "menu_admin/update_validation";
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
}
