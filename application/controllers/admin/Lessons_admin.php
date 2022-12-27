<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lessons_admin extends CI_Controller
{

    /*
    * lessons_admin:
    *
    * index
    * create
    * read_all
    * read
    * update
    * delete
    * _load_view
    * load_lesson_data_for_update_process
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
        $this->generic_model->default_redirection('admin/lessons_admin/read_all');
    }
    public function create()
    {
        $_SESSION['next_page'] = base_url('admin/lessons_admin/create');

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

            //Rules for evaluating the lessons form:
            $this->load->database('read');
            require_once('application/validation_routines/adminlte/lessons_admin/lessons_validation_rules.php');

            //If the validation is not successfull, redirect to create lesson form
            if ($this->form_validation->run() == FALSE) {
                $this->db->close();
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_load_view('create');
            } else {
                $this->db->close();
                //Sanitizing the data and applying the XSS filters
                $lesson = $this->input->post(NULL, TRUE);
                $lesson['content'] = $this->input->post('content');
                $lesson = $this->generic_model->cleaning_fake_columns('lessons', $lesson);

                $lesson['position'] = $this->_reorder_positions($lesson['id_course'], $lesson['position']);

                //Insert the lesson in the Data Base
                if ($this->generic_model->insert_a_new_record('lessons', $lesson)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Great!', 'The lesson was registered', NULL, 'Ok');
                    redirect(base_url('admin/lessons_admin/read_all'));
                } else { //If the insertion failed
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The lesson could not be registered', NULL, 'Ok');
                    redirect(base_url('admin/lessons_admin/read_all'));
                }
            }
        }
    }
    public function read_all()
    {
        $_SESSION['next_page'] = base_url('admin/lessons_admin/read_all');

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
            $fields = 'lessons.id,lessons.id_course,lessons.position,lessons.title,lessons.url,courses.course';
            $this->data['lessons'] = $this->generic_model->read_join('lessons', 'courses', 'lessons.id_course=courses.id', NULL, NULL, $fields);
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
        * It updates a lesson
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
        * ---> It updates the selected lesson
        * ---> It redirects to read_all section
        *
        * How to use it?
        *
        * The method is called from read_all method, pushing the update icon
        *
        * What does it return?
        *
        * GET request_method:
        * It builds the admin lesson section where the user
        * can update a lesson
        *
        * POST request_method:
        * It excecutes the procedure to update the selected lesson
        * It redirects to read_all method
        *
        */

        $_SESSION['next_page'] = base_url('admin/lessons_admin/read_all');

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
                redirect(base_url("admin/lessons_admin/read_all"));
            } else {
                $fields = 'lessons.id,lessons.id_course,lessons.position,lessons.title,lessons.url,lessons.content,courses.course';
                $this->data['lesson'] = $this->generic_model->read_join('lessons', 'courses', 'lessons.id_course=courses.id', "lessons.id=$id", NULL, $fields);
                //Load views
                $this->_load_view('update');
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //The $_SESSION['update']['id'] is setted for the validating process (Controller:not_repeated_check()) 
            $_SESSION['update']['id'] = $this->input->post('id', TRUE);

            //Validation rules for lesson's updating: 
            require_once('application/validation_routines/adminlte/lessons_admin/lessons_update_validation_rules.php');

            //If the validation is not successfull
            if ($this->form_validation->run() == FALSE) {
                $this->db->close();

                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');

                $this->data['lesson'] = $this->generic_model->read_a_record_by_id('lessons', $id);
                $this->data['courses'] = $this->generic_model->read_all_records('courses', array('id', 'course'));
                $this->data['lessons'] = $this->generic_model->read_all_records('lessons', array('id', 'id_course', 'title'));
                //Load views
                $this->_load_view('update_validation');
            } else { //If the validation is successfull
                unset($_SESSION['update']['id']);
                $this->db->close();
                //Sanitizing the data and applying the XSS filters
                $lesson = $this->input->post(NULL, TRUE);
                $lesson['content'] = $this->input->post('content');
                $lesson = $this->generic_model->cleaning_fake_columns('lessons', $lesson);

                $record_to_update = $this->generic_model->read_a_record_by_id('lessons', $lesson['id'], 'position,id_course');

                if ($record_to_update['position'] > $lesson['position']) {
                    $update = 'TO-UP';
                } else {
                    $update = 'TO-DOWN';
                }

                if ($this->generic_model->update_record_by_id('lessons', $lesson['id'], $lesson)) {
                    $this->_reorder_positions($record_to_update['id_course'], $lesson['position'], $lesson['id'], 'update', $update);
                    $this->generic_model->set_the_flash_variables_for_modal('Good news!', "The lesson was updated", NULL, 'Ok');
                    redirect(base_url("admin/lessons_admin/read_all"));
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The lesson could not be updated", NULL, 'Ok');
                    redirect(base_url("admin/lessons_admin/read_all"));
                }
            }
        }
    }
    public function delete($id = NULL)
    {
        /*
        * What does it do?
        *
        * It deletes a lesson
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
        * It deletes an lesson
        *
        * POST request_method:
        * It excecutes the method default_admin_redirection
        *
        */

        $_SESSION['next_page'] = base_url('admin/lessons_admin/read_all');

        if ($this->input->server('REQUEST_METHOD') === 'GET') {

            if (
                $id == NULL
            ) {
                //Reload the controller
                redirect(base_url("admin/lessons_admin/read_all"));
            } else {

                $section_parameters = array(
                    'section' => get_class(),
                    'process' => __FUNCTION__
                );

                $this->generic_model->admin_routine($section_parameters);

                $record_to_delete = $this->generic_model->read_a_record_by_id('lessons', $id, 'position,id_course');

                if ($this->generic_model->hard_delete_by_id('lessons', $id)) {
                    $this->_reorder_positions($record_to_delete['id_course'], $record_to_delete['position'], $id, 'delete');
                    $this->generic_model->set_the_flash_variables_for_modal('Information', 'The item was deleted', NULL, 'Ok');
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem and the selected item could not be deleted', NULL, 'Ok');
                }

                //Reload the controller
                unset($_SESSION['next_page']);
                redirect(base_url("admin/lessons_admin/read_all"));
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Load the default admin-section
            $this->generic_model->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->generic_model->default_admin_redirection();
        }
    }
    public function get_positions_according_to_the_selected_course()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $course = $this->input->post('course', TRUE);
        }
        $fields = 'lessons.id,lessons.id_course,lessons.position,lessons.title,lessons.url,courses.course';
        $where = "courses.id = $course";
        $result = $this->generic_model->read_join('lessons', 'courses', 'lessons.id_course=courses.id', $where, NULL, $fields);
        return $result;
    }
    private function _load_view($action)
    {
        unset($_SESSION['next_page']);
        $_SESSION['last_page'] = base_url('admin/lessons_admin/read_all');

        switch ($action) {
            case 'create':
                $this->data['courses'] = $this->generic_model->read_all_records('courses', array('id', 'course'));
                $fields = 'lessons.id,lessons.id_course,lessons.position,lessons.title,courses.course';
                $this->data['lessons'] = $this->generic_model->read_join('lessons', 'courses', 'lessons.id_course=courses.id', NULL, NULL, $fields, array('position', 'ASC'));
                $_SESSION['last_page'] = base_url("admin/lessons_admin/create");
                $default_view = 'generic/create_generic_form';
                break;
            case 'read_all':
                $fields = 'lessons.id,lessons.id_course,lessons.position,lessons.title,lessons.url,courses.course';
                $this->data['lessons'] = $this->generic_model->read_join('lessons', 'courses', 'lessons.id_course=courses.id', NULL, NULL, $fields, array('position', 'ASC'));
                $default_view = 'generic/responsive_hover_table_for_generic_crud';
                break;
            case 'read':
                $this->data['sections_admin']['view'] = 'lessons_admin/read';
                $default_view = 'generic/update_generic_form';
                break;
            case 'update':
                $this->data['lesson'] = $this->data['lesson'][0];
                unset($this->data['lesson'][0]);
                $this->data['courses'] = $this->generic_model->read_all_records('courses', array('id', 'course'));
                $this->data['lessons'] = $this->generic_model->read_all_records('lessons', array('id', 'id_course', 'title', 'position'), array('position', 'ASC'));
                $default_view = 'generic/update_generic_form';
                break;
            case 'update_validation':
                $this->data['sections_admin']['view'] = "lessons_admin/update_validation";
                $default_view = 'generic/update_generic_form';
                break;
        }

        // var_dump($this->data);
        // foreach ($this->data['lessons'] as $each_lesson) {
        //     if ($each_lesson['id'] == $this->data['lesson']['id']) {
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
        $lesson = $this->generic_model->read_a_record_by_id('lessons', $_SESSION['update']['id']);
        if ($value == $lesson[$field]) {
            return TRUE;
        } else {
            $record = array(
                $field => $value
            );
            $result = $this->generic_model->check_if_the_record_exists('lessons', $record);
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
        * It manages the logic for inserting/updating/deleting lessons in different positions
        *
        * How to use it?
        *
        * It is a private method
        * _reorder_positions($position_expected,$action=NULL)
        * For deleting process it downgrades the positions to the lessons 
        *
        * What does it return?
        *
        * It returns the position for the new/updated lesson 
        *
        */
        $lessons = $this->generic_model->read_records('lessons', array('id_course' => $course), array('id', 'position'), array('position', 'ASC'));
        $last_record = end($lessons);
        if ($position_expected == 0 && !$action) { //Create proccess
            return $last_record['position'] + 1;
        } elseif ($position_expected != 0 && !$action) {
            for ($i = $position_expected - 1; TRUE; $i++) {
                $this->generic_model->update_record_by_id('lessons', $lessons[$i]['id'], array('position' => $lessons[$i]['position'] + 1));
                if ($last_record['id'] == $lessons[$i]['id']) {
                    break;
                }
            }
        } elseif ($action == 'delete') {
            $position_deleted = $position_expected;
            if (count($lessons) != 0) {
                if ($last_record['position'] < $position_deleted) {
                    return NULL;
                } else {
                    for ($i = $position_deleted - 1; TRUE; $i++) {
                        $this->generic_model->update_record_by_id('lessons', $lessons[$i]['id'], array('position' => ($lessons[$i]['position'] - 1)));
                        if ($last_record['id'] == $lessons[$i]['id']) {
                            return NULL;
                        }
                    }
                }
            }
        } elseif ($action == 'update' && $update == "TO-DOWN" && $position_expected != 0) {
            $i = 0;
            $afected = FALSE;
            foreach ($lessons as $lesson) {
                if ($lesson['id'] == $id) {
                    $afected = TRUE;
                }
                if ($lesson['id'] != $id && $lesson['position'] == $position_expected) {
                    if ($afected) {
                        $this->generic_model->update_record_by_id('lessons', $lessons[$i]['id'], array('position' => ($i + 1)));
                    } else {
                        $this->generic_model->update_record_by_id('lessons', $lessons[$i]['id'], array('position' => ($i)));
                    }
                } else {
                    $this->generic_model->update_record_by_id('lessons', $lessons[$i]['id'], array('position' => ($i + 1)));
                }
                $i++;
            }
            return NULL;
        } elseif ($action == 'update' && $update == "TO-UP" && $position_expected != 0) {
            $i = 0;
            $afected = FALSE;
            foreach ($lessons as $lesson) {
                if ($lesson['id'] == $id) {
                    $afected = TRUE;
                }
                if ($lesson['id'] != $id && $lesson['position'] == $position_expected) {
                    if ($afected) {
                        $this->generic_model->update_record_by_id('lessons', $lessons[$i]['id'], array('position' => ($i + 1)));
                    } else {
                        $this->generic_model->update_record_by_id('lessons', $lessons[$i]['id'], array('position' => ($i + 2)));
                    }
                } elseif ($lesson['position'] > $position_expected) {
                    $this->generic_model->update_record_by_id('lessons', $lessons[$i]['id'], array('position' => ($i + 1)));
                }
                $i++;
            }
            return NULL;
        } elseif ($action == 'update' && $position_expected == 0) {
            $i = 0;
            foreach ($lessons as $lesson) {
                if ($lesson['position'] == 0) {
                    $this->generic_model->update_record_by_id('lessons', $lessons[$i]['id'], array('position' => (count($lessons))));
                } else {
                    $this->generic_model->update_record_by_id('lessons', $lessons[$i]['id'], array('position' => ($i)));
                }
                $i++;
            }
            return NULL;
        }
    }
}
