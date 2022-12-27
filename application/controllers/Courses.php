<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Courses extends CI_Controller
{
    private $data;
    public function __construct() //Método constructor
    {
        parent::__construct();
        $this->load->model('generic_model');
    }
    public function index()
    {
        $this->data['courses'] = $this->generic_model->read_all_records('courses', 'course,description,image,url', array('hidden' => 0), array('position', 'ASC'));
        $this->_load_view('read_all_courses');
    }
    public function load_lesson($tech = null, $lesson = null)
    {
        if ($tech == NULL) { //All courses
            $this->data['courses'] = $this->generic_model->read_all_records('courses', 'course,description,image,url', array('position', 'ASC'));
            $this->_load_view('read_all_courses');
        } else { //An specific course required
            $values_to_match = array(
                'url' => $tech
            );
            if (!$this->data['course'] = $this->generic_model->read_records('courses', $values_to_match)) { //Course not found
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The searched course is not registered', 'Ok');
                redirect(base_url('courses'));
            } else { //An specific course found
                $this->data['course'] = $this->data['course'][0];
                unset($this->data['courses'][0]);
            }
        }
        if ($lesson == NULL) { //All course's lessons
            $values_to_match = array(
                'id_course' => $this->data['course']['id']
            );
            $this->data['lessons'] = $this->generic_model->read_records('lessons', $values_to_match, 'title,content,url', array('position', 'ASC'));
            $this->_load_view('read_all_lessons');
        } elseif ($lesson != NULL) { //An specific course's lesson
            $values_to_match = array(
                'url' => $lesson
            );
            if ($this->data['lesson'] = $this->generic_model->read_records('lessons', $values_to_match)) { //Lesson found
                $this->data['lesson'] = $this->data['lesson'][0];
                unset($this->data['lesson'][0]);
                $this->data['lessons'] = $this->generic_model->read_all_records('lessons', 'title,content,url', array('position', 'ASC'));
                $this->_load_view('read_a_lesson');
            } else { //Lesson not found
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The searched lesson is not registered', 'Ok');
                redirect(base_url("courses/$tech"));
            }
        }
    }
    private function _load_view($action)

    {
        require_once('application/code_for_loading/canvas/courses/load_first_group_of_files.php');

        //Content

        switch ($action) {
            case 'read_all_courses':
                $this->load->View('home/content/courses');
                $this->load->View('home/content/line_separation');
                $this->load->View('home/content/contact');
                break;
            case 'read_all_lessons':
                $this->load->View('courses/list_of_lessons');
                $this->load->View('home/content/line_separation');
                break;
            case 'read_a_lesson':
                $this->load->View('courses/lesson');
                $this->load->View('home/content/line_separation');
                break;
        }

        //End of Content

        require_once('application/code_for_loading/canvas/courses/load_second_group_of_files.php');
    }
}
