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
    public function create()
    {

        $_SESSION['next_page'] = base_url('admin/users_admin/create');

        $section_parameters = array(
            'section' => get_class(),
            'process' => __FUNCTION__,
        );

        $this->data = $this->generic_model->admin_routine($section_parameters);

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            //Load views
            $this->load->library('form_validation');
            $this->data['roles'] = $this->generic_model->read_all_records('roles');
            $this->_load_view('create');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //Rules for evaluating the new user's registration: 
            require_once('application/validation_routines/adminlte/users_admin/users_registration_validation_rules.php');

            //If the validation is not successfull, redirect to create article form
            if ($this->form_validation->run() == FALSE) {
                $this->db->close();
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');

                $this->load->library('form_validation');
                $this->data['roles'] = $this->generic_model->read_all_records('roles');
                $this->_load_view('create');
            } else {
                $this->db->close();
                //Sanitizing the data and applying the XSS filters
                $this->db->close(); //Closing the DB connection because it worked at the validation_form
                //If the validation is successfull
                //Sanitizing the data and applying the XSS filters
                $user_data = $this->input->post(NULL, TRUE);

                if ($this->generic_model->insert_a_new_record('users', $user_data)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Good news!', 'The username was registered', NULL, 'Ok');
                    redirect(base_url('admin/users_admin/read_all'));
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Ups!', 'There was a problem, try again', NULL, 'Ok');
                    redirect(base_url('admin/users_admin/create'));
                }
            }
        }
    }
    public function read_all()
    {

        $_SESSION['next_page'] = base_url('admin/users_admin/read_all');

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            $section_parameters = array(
                'section' => get_class(),
                'process' => __FUNCTION__,
            );

            $this->data = $this->generic_model->admin_routine($section_parameters, TRUE);

            $this->data['roles'] = $this->generic_model->read_all_records('roles');

            //Load views
            unset($_SESSION['next_page']);
            $this->_load_view('read_all');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    public function update($id = NULL)
    {
        $_SESSION['next_page'] = base_url('admin/users_admin/read_all');

        $section_parameters = array(
            'section' => get_class(),
            'process' => __FUNCTION__,
        );
        $this->data = $this->generic_model->admin_routine($section_parameters, FALSE, $id);

        $this->load->library('form_validation');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            if ($id == NULL) {
                //redirect to section controller
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There is not a selected item', NULL, 'Ok');
                redirect(base_url("admin/users_admin/read_all"));
            } else {
                $this->data = $this->generic_model->admin_routine($section_parameters, FALSE, $id);
                $this->data['user'] = $this->generic_model->read_a_record_by_id('users', $id);
                $this->data['roles'] = $this->generic_model->read_all_records('roles');

                //Load views
                unset($_SESSION['next_page']);
                $this->_load_view('update');
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //The $_SESSION['update']['id'] is setted for the validating process (Controller:username_check()) 
            $_SESSION['update']['id'] = $this->input->post('id', TRUE);

            //Validation rules for user's updating: 
            require_once('application/validation_routines/adminlte/users_admin/users_update_validation_rules.php');

            //If the validation is not successfull
            if ($this->form_validation->run() == FALSE) {
                $this->db->close();

                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                //Load views
                $this->data['roles'] = $this->generic_model->read_all_records('roles');
                $this->_load_view('update_validation');
            } else { //If the validation is successfull
                $this->db->close();

                //Sanitizing the data and applying the XSS filters
                $user = $this->input->post(NULL, TRUE);

                if ($user['birthday'] == "") {
                    $user['birthday'] = NULL;
                }

                if ($this->generic_model->update_record_by_id('users', $user['id'], $user)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Good news!', "The user was updated", NULL, 'Ok');
                    redirect(base_url("admin/users_admin/read_all"));
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Good news!', "The user was updated", NULL, 'Ok');
                    redirect(base_url("admin/users_admin/read_all"));
                }
            }
        }
    }
    public function delete($id = NULL)
    {

        $_SESSION['next_page'] = base_url('admin/users_admin/read_all');

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            if ($id == NULL) {
                //Reload the controller
                redirect(base_url("admin/users_admin/read_all"));
            } else {

                $section_parameters = array(
                    'section' => get_class(),
                    'process' => __FUNCTION__,
                );

                $this->generic_model->admin_routine($section_parameters, FALSE);

                if ($this->generic_model->hard_delete_by_id('users', $id)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Information', 'The item was deleted', NULL, 'Ok');
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem and the selected item could not be deleted', NULL, 'Ok');
                }

                //Reload the controller
                unset($_SESSION['next_page']);
                redirect(base_url("admin/users_admin/read_all"));
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
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
        $_SESSION['last_page'] = base_url("admin/users_admin/read_all");

        //Load views
        require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

        switch ($action) {
            case 'create':
                $_SESSION['last_page'] = base_url("admin/users_admin/create");
                $default_view = 'generic/create_generic_form';
                break;
            case 'read_all':
                $default_view = 'generic/responsive_hover_table_for_generic_crud';
                break;
            case 'update':
                $default_view = 'generic/update_generic_form';
                break;
            case 'update_validation':
                $this->data['sections_admin']['view'] = "users_admin/update_validation";
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
    public function username_check($username)
    {
        /*
        * This method is part of the validation rules for Update method
        */
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->generic_model->default_redirection();
        }
        $user = $this->generic_model->read_a_record_by_id('users', $_SESSION['update']['id']);
        unset($_SESSION['update']['id']);
        if ($username == $user['username']) {
            return TRUE;
        } else {
            $record = array(
                'username' => $username
            );
            $result = $this->generic_model->check_if_the_record_exists('users', $record);
            if (is_array($result)) {
                $this->form_validation->set_message('username_check', 'Try using other username');
                return FALSE;
            } elseif ($result === "available") {
                return TRUE;
            } elseif ($result === "error") {
                $this->form_validation->set_message('username_check', 'Try using other username');
                return FALSE;
            }
        }
    }
    public function birthday_check($birthday)
    {
        /*
        * This method is part of the validation rules for Update method
        */
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->generic_model->default_redirection();
        }
        if ($birthday == $_SESSION['user']['birthday']) {
            return TRUE;
        } elseif ($birthday == "") {
            return TRUE;
        } else {
            if ($this->generic_model->check_date($birthday)) {
                $age = (time() - strtotime($birthday)) / 31536000;
                $this->form_validation->set_message('birthday_check', 'The date looks wrong');
                if (!($age > 4 && $age < 120)) {
                    return FALSE;
                } else {
                    return TRUE;
                }
            } else {
                return FALSE;
            }
        }
    }
}
