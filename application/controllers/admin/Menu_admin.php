<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_admin extends CI_Controller
{
    /*
    * Menu_admin content:
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
        $this->generic_model->default_admin_redirection();
    }
    public function create()
    {
        /*
        * What does it do?
        *
        * This method creates a new record in the current table's section
        * If the method is accessed by GET
        * ---> Checks if the section is activated in DB
        * ---> Loads the generic create form
        * If the method is accessed by POST
        * ---> Creates the new record in DB
        *
        * How to use it?
        *
        * The method is called through the URL
        *
        * What does it return?
        *
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

            //Rules for evaluating the admin menu items form: 
            require_once('application/validation_routines/adminlte/menu_admin/menu_admin_validation_rules.php');

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
                $data = $this->input->post(NULL, TRUE);
                $items_menu = $this->generic_model->read_all_records('menu_admin');
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
                $new_menu = $this->generic_model->read_all_records('menu_admin');
                if ((count($items_menu) + 1 == count($new_menu)) or
                    ($items_menu == NULL && count($new_menu) == 1)
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
        * It gets all records of menu_admin table
        * It checks if the section required has
        * been activated in the DB
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

        $_SESSION['next_page'] = base_url('admin/menu_admin/read_all');

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
        /*
        * What does it do?
        *
        * If the request method is GET:
        * ---> It loads the view for updating the selected item  
        * If the request method is POST:
        * ---> It process the updating
        *
        * How to use it?
        *
        * This is called from the URL
        *
        * What does it return?
        *
        *
        *
        */
        $this->load->library('form_validation');

        $section_parameters = array(
            'section' => get_class(),
            'process' => __FUNCTION__,
        );

        $_SESSION['next_page'] = base_url('admin/menu_admin/read_all');

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            if ($id == NULL) {
                //redirect to section controller
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There is not a selected item', NULL, 'Ok');
                redirect(base_url("admin/menu_admin/read_all"));
            } else {
                $this->data = $this->generic_model->admin_routine($section_parameters, TRUE, $id);
                $this->data['roles'] = $this->generic_model->read_all_records('roles');
                $this->data['menu_position'] = $this->generic_model->read_all_records('menu_admin');

                //Load views
                unset($_SESSION['next_page']);
                $this->_load_view('update');
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Sanitizing the data and applying the XSS filters
            $data = $this->input->post(NULL, TRUE);

            $this->data = $this->generic_model->admin_routine($section_parameters, FALSE, $data['id']);

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
            } else {
                $this->db->close();
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
        * It deletes an specific item
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

                $this->data = $this->generic_model->admin_routine($section_parameters, FALSE);

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
