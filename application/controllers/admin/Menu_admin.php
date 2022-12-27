<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_admin extends CI_Controller
{
    /*
    * Menu_admin contents:
    *
    * index
    * create
    * read_all
    * update
    * delete
    *
    * LOADING VIEWS
    * _load_view
    *
    */

    //Class properties
    private $data;

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        //default method
        $this->generic_model->default_redirection('admin/menu_admin/read_all');
    }
    public function create()
    {
        /*
        * What does it do?
        *
        * It creates a new item in the Admin menu
        *
        * It sets the array $section_parameter
        * It excecutes the method admin_routine
        *
        * GET request_method:
        * It loads the form for creating a new admin menu item
        *
        * POST request_method:
        * It excecutes the validation form
        * If the validation is not successfull
        * ---> It loads the form again
        * If the validation is successfull
        * ---> It receives the data from the form
        * ---> It excecutes the procedure for adding an admin menu item
        * ---> It redirects to read_all section
        *
        * How to use it?
        *
        * The method is called from read_all method, pushing the button "Add admin-menu item"
        *
        * What does it return?
        *
        * GET request_method:
        * It builds the admin menu section with a form for inserting a new admin menu item
        *
        * POST request_method:
        * It redirects to read_all method after inserting the admin menu item
        *
        */

        $_SESSION['next_page'] = base_url('admin/menu_admin/create');

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

            //Rules for evaluating the create admin menu items form: 
            require_once('application/validation_routines/adminlte/menu_admin/menu_admin_validation_rules.php');

            //If the validation is not successfull, redirect to create article form
            if ($this->form_validation->run() == FALSE) {
                $this->db->close();
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->data['roles'] = $this->generic_model->read_all_records('roles');
                $this->_load_view('create');
            } else {
                $this->db->close();
                //Sanitizing the data and applying the XSS filters
                $data = $this->input->post(NULL, TRUE);
                $items_menu = $this->generic_model->read_all_records('menu_admin');

                //Procedure for building a new menu
                $new_menu = array();
                if ($data['position'] == 0) {
                    //The position is the last one
                    if ($items_menu) {
                        $new_menu = $items_menu;
                    }
                    array_push($new_menu, $data);
                } else {
                    foreach ($items_menu as $item) {
                        if ($data['position'] == $item['id']) {
                            array_push($new_menu, $data);
                        }
                        array_push($new_menu, $item);
                    }
                }
                $this->generic_model->hard_delete_all('menu_admin');
                $this->generic_model->reset_id('menu_admin');
                foreach ($new_menu as $menu) {
                    if (isset($menu['position'])) {
                        unset($menu['position']);
                    }
                    unset($menu['id']);
                    $this->generic_model->insert_a_new_record('menu_admin', $menu);
                }
                //End of procedure for building a new menu

                $new_menu = $this->generic_model->read_all_records('menu_admin');
                if ((count($items_menu) + 1 == count($new_menu)) or
                    ($items_menu == NULL && count($new_menu) == 1) //If there is not menu currently
                ) {
                    $this->generic_model->set_the_flash_variables_for_modal('Good news!', "The menu was updated", NULL, 'Ok');
                    redirect(base_url("admin/menu_admin/read_all"));
                } else {
                    $this->generic_model->hard_delete_all('menu_admin');
                    $this->generic_model->reset_id('menu_admin');
                    foreach ($items_menu as $menu) {
                        unset($menu['id']);
                        $this->generic_model->insert_a_new_record('menu_admin', $menu);
                    }
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The menu could not be updated", NULL, 'Ok');
                    redirect(base_url("admin/menu_admin/read_all"));
                }
            }
        }
    }
    public function read_all()
    {
        /*
        * What does it do?
        *
        * It gets all records from menu_admin table
        *
        * It sets the array $section_parameter
        * It excecutes the method admin_routine
        *
        * GET request_method:
        * It loads a table with the all admin menu items
        *
        * POST request_method:
        * It excecutes the method default_admin_redirection
        *
        * How to use it?
        *
        * The method is called through Admin menu item
        *
        * What does it return?
        *
        * GET request_method:
        * It builds the admin menu section with a table filled
        * by admin menu items 
        *
        * POST request_method:
        * It excecutes the method default_admin_redirection
        *
        */

        $_SESSION['next_page'] = base_url('admin/menu_admin/read_all');

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            $section_parameters = array(
                'section' => get_class(),
                'process' => __FUNCTION__,
            );

            $this->data = $this->generic_model->admin_routine($section_parameters, TRUE);

            $this->data['menu_admin_items'] = $this->generic_model->read_all_records('menu_admin');
            $this->data['roles'] = $this->generic_model->read_all_records('roles');
            //Load views
            $this->_load_view('read_all');
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
        * It updates an admin menu item
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
        * ---> It loads the form again
        * If the validation is successfull
        * ---> It excecutes the procedure for updating an admin menu item
        * ---> It redirects to read_all section
        *
        * How to use it?
        *
        * The method is called from read_all method, pushing the update icon
        *
        * What does it return?
        *
        * GET request_method:
        * It builds the admin menu section where the user
        * can update an admin menu item
        *
        * POST request_method:
        * It excecutes the procedure to update the selected admin menu item
        * It redirects to read_all method
        *
        */

        $_SESSION['next_page'] = base_url('admin/menu_admin/read_all');

        $section_parameters = array(
            'section' => get_class(),
            'process' => __FUNCTION__,
        );
        $this->data = $this->generic_model->admin_routine($section_parameters);

        $this->load->library('form_validation');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            if ($id == NULL) {
                //redirect to section controller
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There is not a selected item', NULL, 'Ok');
                redirect(base_url("admin/menu_admin/read_all"));
            } else {
                $this->data['item'] = $this->generic_model->read_a_record_by_id('menu_admin', $id);
                $this->data['roles'] = $this->generic_model->read_all_records('roles');
                $this->data['menu_position'] = $this->generic_model->read_all_records('menu_admin');
                //Load views
                $this->_load_view('update');
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Sanitizing the data and applying the XSS filters
            $data = $this->input->post(NULL, TRUE);

            $items_menu = $this->generic_model->read_all_records('menu_admin');

            //Rules for evaluating the admin menu items form: 
            foreach ($items_menu as $item) {
                if ($item['id'] == $data['id']) {
                    if ($item['item'] == $data['item']) {
                        require_once('application/validation_routines/adminlte/menu_admin/menu_admin_same_item_validation_rules.php');
                    } else {
                        require_once('application/validation_routines/adminlte/menu_admin/menu_admin_validation_rules.php');
                    }
                }
            }
            //If the validation is not successfull, //redirect to update menu_admin form
            if ($this->form_validation->run() == FALSE) {
                $this->db->close();
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                //Load views
                $this->data['roles'] = $this->generic_model->read_all_records('roles');
                $this->_load_view('update_validation');
            } else { //If the validation is successfull
                $this->db->close();

                //Procedure for updating a new menu
                $new_menu = array();
                $items_menu[$data['id'] - 1]['id'] = 999; //The id's 999 will be filtered
                if ($data['position'] == 0) {
                    //The new position is the last one
                    $new_menu = $items_menu;
                    array_push($new_menu, $data);
                } elseif ($data['position'] != $data['id'] && $data['position'] != 0) {
                    foreach ($items_menu as $item) {
                        if ($data['position'] == $item['id']) {
                            array_push($new_menu, $data);
                        }
                        array_push($new_menu, $item);
                    }
                } elseif ($data['position'] == $data['id']) {
                    foreach ($items_menu as $item) {
                        if ($item['id'] == 999) {
                            array_push($new_menu, $data);
                        } else {
                            array_push($new_menu, $item);
                        }
                    }
                }
                $this->generic_model->hard_delete_all('menu_admin');
                $this->generic_model->reset_id('menu_admin');
                foreach ($new_menu as $menu) {
                    if ($menu['id'] != 999) {
                        if (isset($menu['position'])) {
                            unset($menu['position']);
                        }
                        unset($menu['id']);
                        $this->generic_model->insert_a_new_record('menu_admin', $menu);
                    }
                }
                $this->generic_model->set_the_flash_variables_for_modal('Good news!', "The menu was updated", NULL, 'Ok');
                redirect(base_url("admin/menu_admin/read_all"));
            }
        }
    }
    public function delete($id = NULL)
    {
        /*
        * What does it do?
        *
        * It deletes an admin menu item
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
        * It deletes an admin menu item 
        *
        * POST request_method:
        * It excecutes the method default_admin_redirection
        *
        */

        $_SESSION['next_page'] = base_url('admin/menu_admin/read_all');

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            if ($id == NULL) {
                //Reload the controller
                redirect(base_url("admin/menu_admin/read_all"));
            } else {

                $section_parameters = array(
                    'section' => get_class(),
                    'process' => __FUNCTION__,
                );
                $this->data = $this->generic_model->admin_routine($section_parameters);

                if ($this->generic_model->hard_delete_by_id('menu_admin', $id)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Information', 'The item was deleted', NULL, 'Ok');
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem and the selected item could not be deleted', NULL, 'Ok');
                }

                //Reload the controller
                unset($_SESSION['next_page']);
                redirect(base_url("admin/menu_admin/read_all"));
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
        * It is a private method, the controller invocates it
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
