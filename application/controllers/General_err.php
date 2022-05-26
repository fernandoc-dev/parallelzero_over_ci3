<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General_err extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('generic_model');
    }
    public function index()
    {
        $this->generic_model->execution_trace(get_class(), __FUNCTION__);
        $this->generic_model->record_err_event('Unexpected err');
        $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was an unexpected problem', NULL, 'Ok');
        if (isset($_SESSION['last_page'])) {
            redirect(base_url($_SESSION['last_page']));
        } else {
            if (isset($_SESSION['base'])) {
                redirect(base_url($_SESSION['base']));
            }
        }
    }
}
