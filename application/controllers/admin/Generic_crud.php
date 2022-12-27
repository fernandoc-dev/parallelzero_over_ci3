<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Generic_crud extends CI_Controller
{
    /*
    * Generic crud controller content:
    *
    * index
    * create
    * read_all
    * update
    * delete
    *
    * LOADING VIEWS
    * _load_view
    * _set_menu_items
    * _set_singular_and_plural_section
    * load_admin_section
    *
    */

    //Class properties
    private $data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('generic_model');
    }
    public function index()
    {
        //default method
        $this->generic_model->default_admin_redirection();
    }
    public function create($section = NULL, $table = NULL)
    {
        /*
        * What does it do?
        *
        * This method creates a new record in the current table's section
        * If the method is accessed by GET
        * --->Checks if the section is activated in DB
        * --->Loads the generic create form
        * If the method is accessed by POST
        * --->Creates the new record in DB
        *
        * How to use it?
        *
        * The method is called through the URL
        *
        * What does it return?
        *
        *
        */

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            $section_parameters = array(
                'section' => $section,
                'process' => __FUNCTION__
            );
            $this->data = $this->generic_model->admin_routine($section_parameters);

            if ($this->data) {
                //Load views
                $this->_load_view('create', $section);
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Sanitizing the data and applying the XSS filters
            $data = $this->input->post(NULL, TRUE);
            if ($this->generic_model->insert_a_new_record($table, $data)) {
                $this->generic_model->set_the_flash_variables_for_modal('Good news!', "The item was added", NULL, 'Ok');
                redirect(base_url("admin/generic_crud/read_all/$section"));
            } else {
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The item could not been added", NULL, 'Ok');
                redirect(base_url("admin/generic_crud/read_all/$section"));
            }
        }
    }
    public function read_all($section = NULL)
    {
        /*
        * What does it do?
        *
        * This method get all records of a table
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

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $section_parameters = array(
                'section' => $section,
                'process' => __FUNCTION__
            );
            $this->data = $this->generic_model->admin_routine($section_parameters, TRUE);

            if ($this->data) {
                //Load views
                $this->_load_view('read_all', $section);
                // var_dump($this->data);
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    public function update($section = NULL, $id = NULL)
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
            if ($id == NULL) {
                //Redirect to section controller
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There is not a selected item', NULL, 'Ok');
                redirect(base_url("admin/generic_crud/read_all/$section"));
            } else {
                $section_parameters = array(
                    'section' => $section,
                    'process' => __FUNCTION__
                );
                $this->data = $this->generic_model->admin_routine($section_parameters, TRUE, $id);

                if ($this->data) {
                    //Load views
                    $this->_load_view('update', $section);
                }
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data = $this->input->post(NULL, TRUE);
            if ($this->generic_model->update_record_by_id($section, $data['id'], $data)) {
                $this->generic_model->set_the_flash_variables_for_modal('Good news!', 'The item was updated', NULL, 'Ok');
                redirect(base_url("admin/generic_crud/read_all/$section"));
            } else {
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem and the selected item could not be loaded', NULL, 'Ok');
                //Redirect to default controller
                redirect(base_url("admin/generic_crud/read_all/$section"));
            }
        }
    }
    public function delete($section = NULL, $id = NULL)
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
                redirect(base_url("admin/generic_crud/read_all/$section"));
            } else {
                $section_parameters = array(
                    'section' => $section,
                    'process' => __FUNCTION__
                );
                $this->data = $this->generic_model->admin_routine($section_parameters);

                if ($this->data) {
                    if ($this->generic_model->hard_delete_by_id($section, $id)) {
                        $this->generic_model->set_the_flash_variables_for_modal('Information', 'The item was deleted', NULL, 'Ok');
                    } else {
                        $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem and the selected item could not be deleted', NULL, 'Ok');
                    }
                }
                //Reload the controller
                redirect(base_url("admin/generic_crud/read_all/$section"));
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    private function _load_view($action, $section)
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
        * What does it return?
        *
        * It loads the views
        *
        */

        $_SESSION['last_page'] = base_url("admin/generic_crud/$action/$section");

        //Get_complementary_data (categories, subcategories, tags)
        $this->data['categories'] = $this->generic_model->read_all_records('categories', NULL);
        $this->data['subcategories'] = $this->generic_model->read_all_records('subcategories', NULL);
        $this->data['tags'] = $this->generic_model->read_all_records('tags', NULL);

        //Load views
        require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

        switch ($action) {
            case 'create':
                $default_view = 'generic/create_generic_form';
                break;
            case 'read_all':
                $default_view = 'generic/responsive_hover_table_for_generic_crud';
                if ($section == 'icons') {
                    $default_view = 'generic/read_all_icons';
                }
                break;
            case 'update':
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
