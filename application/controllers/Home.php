<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    //Class properties
    private $data;

    public function __construct() //Método constructor
    {
        parent::__construct();
        $this->load->model('generic_model');
    }
    public function index()
    {
        $this->data['courses'] = $this->generic_model->read_all_records('courses', 'course,description,image,url', array('position', 'ASC'));
        $this->data['projects'] = $this->generic_model->read_all_records('projects', 'title,short_description,image', array('position', 'ASC'));

        //First group of files
        $this->load->View('home/common_files/01_open_html', $this->data);
        $this->load->View('home/common_files/02_head');
        $this->load->View('home/common_files/03_open_body');
        $this->load->View('home/common_files/04_right_images');
        $this->load->View('home/common_files/05_open_wrapper');
        $this->load->View('home/common_files/06_header');
        $this->load->View('home/common_files/07_open_content');
        //End of first group of files

        //Content
        $this->load->View('home/content/introduction');
        $this->load->View('home/content/portfolio');
        $this->load->View('home/content/line_separation');
        $this->load->View('home/content/courses');
        $this->load->View('home/content/line_separation');
        // $this->load->View('home/content/blog');
        // $this->load->View('home/content/line_separation');
        $this->load->View('home/content/contact');

        //End of Content

        //Second group of files
        $this->load->View('home/common_files/08_close_content');
        $this->load->View('home/common_files/09_footer');
        $this->load->View('home/common_files/10_close_wrapper');
        $this->load->View('home/common_files/11_scripts');
        $this->load->View('home/common_files/12_close_body_and_html');
        //End of second group of files
    }
}
