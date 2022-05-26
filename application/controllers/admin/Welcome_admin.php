<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome_admin extends CI_Controller
{
    /*
    * Generic crud controller content:
    *
    * index
    * _load_generic_view
    *
    */

    //Class properties
    private $data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('generic_model');
    }
    public function index()
    {
        /*
        * What does it do?
        *
        * This method loads the welcome page in the admin panel
        * It checks the basic permission for being in the admin panel
        *
        * How to use it?
        *
        * This is called from the URL
        *
        * What does it return?
        *
        * If the requirement is GET:
        * ---> 
        * If the requirement is POST:
        * --->
        *
        */

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->data = $this->generic_model->admin_routine('welcome_admin', 'role_delete', NULL, FALSE);
            if ($this->data) {
                //Load views
                $this->_load_generic_view();
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    private function _load_generic_view()
    {
        /*
        * What does it do?
        *
        * The _load_generic_view method loads the views
        * according to the controller
        *
        */

        $_SESSION['last_page'] = "welcome_admin";

        //Load views
        //require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

        //$this->load->View('admin/adminlte/adminlte3.1.0/sections/welcome_admin');

        //require_once('application/code_for_loading/adminlte/load_second_group_of_files.php');

        var_dump($this->data);
    }
}
