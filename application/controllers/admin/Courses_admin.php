<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Courses_admin extends CI_Controller
{
    /*
    * courses_admin:
    *
    * index
    * create
    * read_all
    * read
    * update
    * delete
    * _load_view
    * load_course_data_for_update_process
    * not_repeated_check
    *
    */

    //Class properties
    private $data;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Lima');
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
        $errorImgFile = "./assets/parallel_zero/img/img_upload_error.jpg";
        $temp = explode(".", $_FILES["file"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $destinationFilePath = './assets/parallel_zero/img/courses/' . $newfilename;
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $destinationFilePath)) {
            echo $errorImgFile;
        } else {
            echo base_url('assets/parallel_zero/img/courses/') . $newfilename;
        }
    }
    public function index()
    {
        //default method
        $this->generic_model->default_redirection('admin/courses_admin/read_all');
    }
    public function create()
    {
        $_SESSION['next_page'] = base_url('admin/courses_admin/create');

        $section_parameters = array(
            'section' => get_class(),
            'process' => __FUNCTION__
        );
        $this->data = $this->generic_model->admin_routine($section_parameters);

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            //Load views
            $this->load->library('form_validation');

            $this->_load_view('create');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //Rules for evaluating the courses form: 
            require_once('application/validation_routines/adminlte/courses_admin/courses_validation_rules.php');

            //If the validation is not successfull, redirect to create course form
            if ($this->form_validation->run() == FALSE) {
                $this->db->close();

                $this->_load_view('create');
            } else {
                $this->db->close();
                //Sanitizing the data and applying the XSS filters
                $course = $this->input->post(NULL, TRUE);
                $course['content'] = $this->input->post('content');
                $course = $this->generic_model->cleaning_fake_columns('courses', $course);

                $course['position'] = $this->_reorder_positions($course['id_course'], $course['position']);

                //Insert the course in the Data Base
                if ($this->generic_model->insert_a_new_record('courses', $course)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Great!', 'The course was registered', NULL, 'Ok');
                    redirect(base_url('admin/courses_admin/read_all'));
                } else { //If the insertion failed
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The course could not be registered', NULL, 'Ok');
                    redirect(base_url('admin/courses_admin/read_all'));
                }
            }
        }
    }
    public function read_all()
    {
        $_SESSION['next_page'] = base_url('admin/courses_admin/read_all');

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            $section_parameters = array(
                'section' => get_class(),
                'process' => __FUNCTION__
            );
            $this->data = $this->generic_model->admin_routine($section_parameters, TRUE);
            //Get_complementary_data (courses)
            $param = array(
                'id',
                'course'
            );
            $this->data['courses'] = $this->generic_model->read_all_records('courses', $param);
            $fields = 'courses.id,courses.id_course,courses.position,courses.title,courses.url,courses.course';
            $this->data['courses'] = $this->generic_model->read_join('courses', 'courses', 'courses.id_course=courses.id', NULL, NULL, $fields);
            //Load views
            $this->_load_view('read_all');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    public function read($id = NULL)
    {
    }
    public function update($id = NULL)
    {
        /*
        * What does it do?
        *
        * It updates a course
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
        * ---> It loads the validation view
        * If the validation is successfull
        * ---> It updates the selected course
        * ---> It redirects to read_all section
        *
        * How to use it?
        *
        * The method is called from read_all method, pushing the update icon
        *
        * What does it return?
        *
        * GET request_method:
        * It builds the admin course section where the user
        * can update a course
        *
        * POST request_method:
        * It excecutes the procedure to update the selected course
        * It redirects to read_all method
        *
        */

        $_SESSION['next_page'] = base_url('admin/courses_admin/read_all');

        $section_parameters = array(
            'section' => get_class(),
            'process' => __FUNCTION__
        );
        $this->data = $this->generic_model->admin_routine($section_parameters);

        $this->load->library('form_validation');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            if ($id == NULL) {
                //redirect to section controller
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There is not a selected item', NULL, 'Ok');
                redirect(base_url("admin/courses_admin/read_all"));
            } else {
                $fields = 'courses.id,courses.id_course,courses.position,courses.title,courses.url,courses.content,courses.course';
                $this->data['course'] = $this->generic_model->read_join('courses', 'courses', 'courses.id_course=courses.id', "courses.id=$id", NULL, $fields);
                //Load views
                $this->_load_view('update');
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //The $_SESSION['update']['id'] is setted for the validating process (Controller:not_repeated_check()) 
            $_SESSION['update']['id'] = $this->input->post('id', TRUE);

            //Validation rules for course's updating: 
            require_once('application/validation_routines/adminlte/courses_admin/courses_update_validation_rules.php');

            //If the validation is not successfull
            if ($this->form_validation->run() == FALSE) {
                $this->db->close();

                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');

                $this->data['course'] = $this->generic_model->read_a_record_by_id('courses', $id);
                $this->data['courses'] = $this->generic_model->read_all_records('courses', array('id', 'course'));
                $this->data['courses'] = $this->generic_model->read_all_records('courses', array('id', 'id_course', 'title'));
                //Load views
                $this->_load_view('update_validation');
            } else { //If the validation is successfull
                unset($_SESSION['update']['id']);
                $this->db->close();
                //Sanitizing the data and applying the XSS filters
                $course = $this->input->post(NULL, TRUE);
                $course['content'] = $this->input->post('content');
                $course = $this->generic_model->cleaning_fake_columns('courses', $course);

                $record_to_update = $this->generic_model->read_a_record_by_id('courses', $course['id'], 'position,id_course');

                if ($record_to_update['position'] > $course['position']) {
                    $update = 'TO-UP';
                } else {
                    $update = 'TO-DOWN';
                }

                if ($this->generic_model->update_record_by_id('courses', $course['id'], $course)) {
                    $this->_reorder_positions($record_to_update['id_course'], $course['position'], $course['id'], 'update', $update);
                    $this->generic_model->set_the_flash_variables_for_modal('Good news!', "The course was updated", NULL, 'Ok');
                    redirect(base_url("admin/courses_admin/read_all"));
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The course could not be updated", NULL, 'Ok');
                    redirect(base_url("admin/courses_admin/read_all"));
                }
            }
        }
    }
    public function delete($id = NULL)
    {
        /*
        * What does it do?
        *
        * It deletes a course
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
        * It deletes an course
        *
        * POST request_method:
        * It excecutes the method default_admin_redirection
        *
        */

        $_SESSION['next_page'] = base_url('admin/courses_admin/read_all');

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            if (
                $id == NULL
            ) {
                //Reload the controller
                redirect(base_url("admin/courses_admin/read_all"));
            } else {

                $section_parameters = array(
                    'section' => get_class(),
                    'process' => __FUNCTION__
                );

                $this->generic_model->admin_routine($section_parameters);

                $record_to_delete = $this->generic_model->read_a_record_by_id('courses', $id, 'position,id_course');

                if ($this->generic_model->hard_delete_by_id('courses', $id)) {
                    $this->_reorder_positions($record_to_delete['id_course'], $record_to_delete['position'], $id, 'delete');
                    $this->generic_model->set_the_flash_variables_for_modal('Information', 'The item was deleted', NULL, 'Ok');
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem and the selected item could not be deleted', NULL, 'Ok');
                }

                //Reload the controller
                unset($_SESSION['next_page']);
                redirect(base_url("admin/courses_admin/read_all"));
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    private function _load_view($action)
    {
        unset($_SESSION['next_page']);
        $_SESSION['last_page'] = base_url('admin/courses_admin/read_all');

        switch ($action) {
            case 'create':
                $this->data['courses'] = $this->generic_model->read_all_records('courses', array('id', 'course'));
                $fields = 'courses.id,courses.id_course,courses.position,courses.title,courses.course';
                $this->data['courses'] = $this->generic_model->read_join('courses', 'courses', 'courses.id_course=courses.id', NULL, NULL, $fields, array('position', 'ASC'));
                $_SESSION['last_page'] = base_url("admin/courses_admin/create");
                $default_view = 'generic/create_generic_form';
                break;
            case 'read_all':
                $fields = 'courses.id,courses.id_course,courses.position,courses.title,courses.url,courses.course';
                $this->data['courses'] = $this->generic_model->read_join('courses', 'courses', 'courses.id_course=courses.id', NULL, NULL, $fields, array('position', 'ASC'));
                $default_view = 'generic/responsive_hover_table_for_generic_crud';
                break;
            case 'read':
                $this->data['sections_admin']['view'] = 'courses_admin/read';
                $default_view = 'generic/update_generic_form';
                break;
            case 'update':
                $this->data['course'] = $this->data['course'][0];
                unset($this->data['course'][0]);
                $this->data['courses'] = $this->generic_model->read_all_records('courses', array('id', 'course'));
                $this->data['courses'] = $this->generic_model->read_all_records('courses', array('id', 'id_course', 'title', 'position'), array('position', 'ASC'));
                $default_view = 'generic/update_generic_form';
                break;
            case 'update_validation':
                $this->data['sections_admin']['view'] = "courses_admin/update_validation";
                $default_view = 'generic/update_generic_form';
                break;
        }

        // var_dump($this->data);
        // foreach ($this->data['courses'] as $each_course) {
        //     if ($each_course['id'] == $this->data['course']['id']) {
        //         echo "Encontre al culpable<br>";
        //     } else {
        //         echo "Todos estan limpios<br>";
        //     }
        // }

        // Load views
        require_once('application/code_for_loading/adminlte/load_first_group_of_files.php');

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
    public function not_repeated_check($value, $field)
    {
        /*
        * This method is part of the validation rules for Update method
        */
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->generic_model->default_redirection();
        }
        $course = $this->generic_model->read_a_record_by_id('courses', $_SESSION['update']['id']);
        if ($value == $course[$field]) {
            return TRUE;
        } else {
            $record = array(
                $field => $value
            );
            $result = $this->generic_model->check_if_the_record_exists('courses', $record);
            if (is_array($result)) {
                $this->form_validation->set_message('not_repeated_check', 'Try using other ' . $field);
                return FALSE;
            } elseif ($result === "available") {
                return TRUE;
            } elseif ($result === "error") {
                $this->form_validation->set_message('not_repeated_check', 'Try using other ' . $field);
                return FALSE;
            }
        }
    }
    private function _reorder_positions($course, $position_expected, $id = NULL, $action = NULL, $update = NULL)
    {
        /*
        * What does it do?
        *
        * It manages the logic for inserting/updating/deleting courses in different positions
        *
        * How to use it?
        *
        * It is a private method
        * _reorder_positions($position_expected,$action=NULL)
        * For deleting process it downgrades the positions to the courses 
        *
        * What does it return?
        *
        * It returns the position for the new/updated course 
        *
        */
        $courses = $this->generic_model->read_records('courses', array('id_course' => $course), array('id', 'position'), array('position', 'ASC'));
        $last_record = end($courses);
        if ($position_expected == 0 && !$action) { //Create proccess
            return $last_record['position'] + 1;
        } elseif ($position_expected != 0 && !$action) {
            for ($i = $position_expected - 1; TRUE; $i++) {
                $this->generic_model->update_record_by_id('courses', $courses[$i]['id'], array('position' => $courses[$i]['position'] + 1));
                if ($last_record['id'] == $courses[$i]['id']) {
                    break;
                }
            }
        } elseif ($action == 'delete') {
            $position_deleted = $position_expected;
            if (count($courses) != 0) {
                if ($last_record['position'] < $position_deleted) {
                    return NULL;
                } else {
                    for ($i = $position_deleted - 1; TRUE; $i++) {
                        $this->generic_model->update_record_by_id('courses', $courses[$i]['id'], array('position' => ($courses[$i]['position'] - 1)));
                        if ($last_record['id'] == $courses[$i]['id']) {
                            return NULL;
                        }
                    }
                }
            }
        } elseif ($action == 'update' && $update == "TO-DOWN" && $position_expected != 0) {
            $i = 0;
            $afected = FALSE;
            foreach ($courses as $course) {
                if ($course['id'] == $id) {
                    $afected = TRUE;
                }
                if ($course['id'] != $id && $course['position'] == $position_expected) {
                    if ($afected) {
                        $this->generic_model->update_record_by_id('courses', $courses[$i]['id'], array('position' => ($i + 1)));
                    } else {
                        $this->generic_model->update_record_by_id('courses', $courses[$i]['id'], array('position' => ($i)));
                    }
                } else {
                    $this->generic_model->update_record_by_id('courses', $courses[$i]['id'], array('position' => ($i + 1)));
                }
                $i++;
            }
            return NULL;
        } elseif ($action == 'update' && $update == "TO-UP" && $position_expected != 0) {
            $i = 0;
            $afected = FALSE;
            foreach ($courses as $course) {
                if ($course['id'] == $id) {
                    $afected = TRUE;
                }
                if ($course['id'] != $id && $course['position'] == $position_expected) {
                    if ($afected) {
                        $this->generic_model->update_record_by_id('courses', $courses[$i]['id'], array('position' => ($i + 1)));
                    } else {
                        $this->generic_model->update_record_by_id('courses', $courses[$i]['id'], array('position' => ($i + 2)));
                    }
                } elseif ($course['position'] > $position_expected) {
                    $this->generic_model->update_record_by_id('courses', $courses[$i]['id'], array('position' => ($i + 1)));
                }
                $i++;
            }
            return NULL;
        } elseif ($action == 'update' && $position_expected == 0) {
            $i = 0;
            foreach ($courses as $course) {
                if ($course['position'] == 0) {
                    $this->generic_model->update_record_by_id('courses', $courses[$i]['id'], array('position' => (count($courses))));
                } else {
                    $this->generic_model->update_record_by_id('courses', $courses[$i]['id'], array('position' => ($i)));
                }
                $i++;
            }
            return NULL;
        }
    }
}
