<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    /*
    * Users controller content:
    *
    * login             REVIEWED 24/05/2022
    * registration      REVIEWED 24/05/2022
    * user_information  REVIEWED 24/05/2022
    * update            REVIEWED 24/05/2022 
    * change_password   REVIEWED 24/05/2022
    * finish_session    REVIEWED 24/05/2022
    * recover_password  REVIEWED 24/05/2022
    * set_new_password
    * 
    * LOAD VIEWS
    * _load_view        REVIEWED 24/05/2022
    *
    * VALIDATIONS
    * username_check    REVIEWED 24/05/2022
    * birthday_check    REVIEWED 24/05/2022
    * 
    */

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Lima');
    }
    public function index()
    {
        redirect(base_url('users/user_information'));
    }
    public function login()
    {
        /*
        * What does it do?
        *
        * If the login method is excecuted through a GET request:
        * ---> It loads the form to enter the username and password
        * If the login method is excecuted through a POST request:
        * ---> It receives an username and a password from the form
        * ---> It sanitizes the data
        * ---> It excecutes validations
        * ---> If the validation process is not successful:
        * -------> It loads the Login Form again
        * ---> If the validation process is successful:
        * -------> It consults the data base
        * -------> If the Login is successfull:
        * ------------> It sets the $_SESSION['user'] variable
        * ------------> It excecutes the default_redirection method
        * -------> If the Login is not successfull:
        * ------------> If the user exists:
        * -----------------> It counts the failed login attemps
        * -----------------> Load the Login Form again
        * If the login method is excecuted through another protocol request:
        * ---> Load the Login Form again
        *
        * The user after deleted their account has a time defined
        * by the field 'users_expiration_time' from the login_parameters table
        * before being totally deleted, if the user log in before that period,
        * the account would be reactivated
        * 
        * How to use it?
        * 
        * The URL must be loaded to access to the form, and the form's 
        * action attribute must point to the method using POST
        *
        * What does it return?
        *
        * The Login method manage the following possibilities:
        * --->$result['access']==TRUE
        * -------> Redirect to the user area
        * ---> $result['access']==FALSE
        * ---> In these cases the form is loaded again
        * -------> The user is not registered
        * -------> The user has been blocked
        * -------> The user has a temporary block
        * -------> Wrong password
        * -------> The username or email is repeated
        *
        */

        $this->load->library('form_validation');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->_load_view('login');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //Rules for evaluating the login form: 
            require_once('application/validation_routines/users/login_form_validation_rules.php');

            if ($this->form_validation->run() === FALSE) {
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_load_view('login');
            } elseif ($this->form_validation->run() === TRUE) {
                //Sanitizing the data and applying the XSS filters
                $user_data = $this->input->post(NULL, TRUE);
                //Consult the data base
                $result = $this->login_model->login($user_data);
                if ($result['access']) { //If the LogIn is successfull
                    $this->generic_model->default_redirection();
                } elseif ($result['access'] === FALSE) { //If the LogIn is not successfull
                    switch ($result['err']) {
                        case 'The user is not registered':
                            $this->session->set_flashdata('Sorry', 'The user is not registered, try again');
                            break;
                        case 'The user has been blocked':
                            $this->session->set_flashdata('result', 'The user was temporarily blocked');
                            break;
                        case 'The user has a temporary block':
                            $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The user has a temporary block', NULL, NULL, '#', 'Send a one-use password to my email');
                            break;
                        case 'Wrong password':
                            $this->generic_model->set_the_flash_variables_for_modal('Ups', 'The username or password is wrong', NULL, 'Ok');
                            break;
                        case 'The username or email is repeated':
                            $this->generic_model->set_the_flash_variables_for_modal('Error', 'There is a problem with your user, we will contact you soon', NULL, 'Ok');
                            break;
                        case 'Login unsuccessful':
                            $this->generic_model->set_the_flash_variables_for_modal('Error', 'Login unsuccessful, Try again', NULL, 'Ok');
                            break;
                    }
                    $this->_load_view('login');
                }
            }
        } else { //If it is used other protocol, loads the Login form again
            $this->_load_view('login');
        }
    }
    public function registration()
    {
        /*
        * What does it do?
        *
        * If the Regisration method is excecuted through a GET request:
        * ---> Registration loads the form where the user introduces the information to sign up
        * If the Regisration method is excecuted through a POST request:
        * ---> Receives the data from the registration form,
        * ---> Excecutes the validations
        * ---> Checks if the username and email are not repeated in the DB
        * ---> If the validation is not successfull:
        * -------> Load the Register Form again
        * ---> If the validation is successfull:
        * -------> Sanitize the data,
        * -------> Build the generic user_data variable
        * -------> Checks if the username and email are not repeated in the DB,
        * -------> If the Username and Email are not repeated: 
        * ------------> Insert in the DB
        * ------------> Redirect to login form
        * -------> If the Username and Email are repeated:
        * ------------> Load the Register Form again
        * 
        * How to use it?
        * 
        * The URL must be loaded to access to the form, and the form's 
        * action attribute must point to the method using POST
        *
        * What does it return?
        *
        * The Login method manage the following possibilities:
        * If the registration was successfull:
        * ---> Redirect to login
        * If the registration was not successfull:
        * ---> Loads the registration form again
        */
        $this->load->library('form_validation');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->_load_view('registration');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //Rules for evaluating the register form: 
            require_once('application/validation_routines/users/register_form_validation_rules.php');

            //If the validation is not successfull, redirect to Register form
            if ($this->form_validation->run() == FALSE) {
                $this->db->close(); //Closing the DB connection because it worked at the validation_form
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_load_view('registration');
            } else {
                $this->db->close(); //Closing the DB connection because it worked at the validation_form
                //If the validation is successfull
                //Sanitizing the data and applying the XSS filters
                $user_data = $this->input->post(NULL, TRUE);
                $user_data['password'] = password_hash($user_data['password'], PASSWORD_DEFAULT);

                if ($this->generic_model->insert_a_new_record('users', $user_data)) {
                    $this->generic_model->set_the_flash_variables_for_modal('Good news!', 'The username was registered', NULL, 'Ok');
                    //User login
                    $user = $this->generic_model->read_records('users', array('username' => $user_data['username']));
                    $settings = $this->login_model->get_login_settings();
                    $this->login_model->set_session_variables_for_users($user[0], $settings);
                    $this->login_model->register_login($user[0]);
                    $this->generic_model->default_redirection();
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Ups!', 'There was a problem, try again', NULL, 'Ok');
                    redirect(base_url('users/registration'));
                }
            }
        } else { //If is used other protocol, loads the Login form again
            $this->_load_view('registration');
        }
    }
    public function user_information()
    {
        /*
        * What does it do?
        *
        * If the User information method is excecuted through a GET request:
        * ---> User information loads the user's data
        * The view of user information has a link to go to Update method
        * 
        * How to use it?
        * 
        * Visiting the URL
        *
        * What does it return?
        *
        * The User information method loads the view with the user's data
        *
        */
        if (!$this->login_model->check_session_validity()) {
            redirect(base_url('users/login'));
        }

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->_load_view('user_information');
        } else {
            redirect(base_url('users/user_information'));
        }
    }
    public function update()
    {
        /*
        * What does it do?
        *
        * If the Update method is excecuted through a GET request:
        * ---> Update loads the form where the user introduces the information
        * If the Update method is excecuted through a POST request:
        * ---> It receives the data from the update form,
        * ---> It excecutes the validations
        * --------> It checks if the username and email are not repeated in the DB
        * ---> If the validation is not successfull:
        * -------> It loads the Update Form again
        * ---> If the validation is successfull:
        * -------> It sanitizes the data,
        *
        *
        * How to use it?
        * 
        * The URL must be loaded to access to the form, and the form's 
        * action attribute must point to the method using POST
        *
        * What does it return?
        *
        * The Login method manage the following possibilities:
        * If the registration was successfull:
        * ---> It saves the user data in the variable user
        * If the registration was not successfull:
        * ---> Loads the registration form again
        */

        $_SESSION['next_page'] = base_url('users/update');

        if (!$this->login_model->check_session_validity()) {
            redirect(base_url('users/login'));
        }

        $this->load->library('form_validation');

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->_load_view('update');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Rules for evaluating the register form: 
            require_once('application/validation_routines/users/update_form_validation_rules.php');
            //If the validation is not successfull, redirect to Register form
            if ($this->form_validation->run() == FALSE) {
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_load_view('update_validation');
            } else {
                //If the validation is successfull
                //Sanitizing the data and applying the XSS filters
                $user = $this->input->post(NULL, TRUE);

                if ($_FILES["photo"]["name"] != "") { //The photo was changed
                    $photo = time();
                    $user['photo'] = 'profile' . $photo;
                }

                //Uploading process
                if ($_FILES["photo"]["name"] != "") {
                    $path = "./assets/parallel_zero/img/users/" . $_SESSION['user']['id'];
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    //Uploading process
                    $config['overwrite']          = TRUE;
                    $config['file_name']          = $user['photo'];
                    $config['upload_path']        = './assets/parallel_zero/img/users/' . $_SESSION['user']['id'] . "/";
                    $config['allowed_types']      = 'gif|jpg|png';
                    $config['max_size']           = 5120;
                    $config['max_filename']       = 100;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('photo')) {
                        $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem uploading the file', NULL, 'Ok');
                        redirect(base_url('users/update'));
                    }
                }

                // If there are not changes in the information
                if (
                    $user['name'] === $_SESSION['user']['name'] &&
                    $user['username'] === $_SESSION['user']['username'] &&
                    $user['phone'] === $_SESSION['user']['phone'] &&
                    $user['birthday'] === $_SESSION['user']['birthday']
                ) {
                    if ($_FILES["photo"]["name"] === "") { //No changes at all
                        redirect(base_url('users/user_information'));
                    }
                }

                $result = $this->generic_model->update_record_by_id('users', $_SESSION['user']['id'], $user);
                if ($result) {
                    $this->generic_model->set_the_flash_variables_for_modal('Good news!', 'The information was updated', NULL, 'Ok');
                    $user = $this->generic_model->read_a_record_by_id('users', $_SESSION['user']['id']);
                    $settings = $this->generic_model->read_a_record_by_id('login_parameters', 1);
                    $this->login_model->set_session_variables_for_users($user, $settings);
                    redirect(base_url("users/user_information"));
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The information could not be updated', NULL, 'Ok');
                    redirect(base_url("users/user_information"));
                }
            }
        }
    }
    public function change_password()
    {
        /*
        * What does it do?
        *
        * If the Change password method is excecuted through a GET request:
        * ---> It changes password loads the form where the user introduces
        * ---> the old password and the new password
        * If the Change password method is excecuted through a POST request:
        * ---> It receives the data from the Change password form,
        * ---> It excecutes the validations
        * ---> If the validation is not successfull:
        * -------> It loads the Change password Form again
        * ---> If the validation is successfull:
        * -------> It sanitizes the data,
        * -------> It updates the password in the DB
        * 
        * How to use it?
        * 
        * The URL must be loaded to access to the form, and the form's 
        * action attribute must point to the method using POST
        *
        * What does it return?
        *
        */

        $_SESSION['next_page'] = base_url('users/update');

        if (!$this->login_model->check_session_validity()) {
            redirect(base_url('users/login'));
        }

        $this->load->library('form_validation');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->_load_view('change_password');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {

            //Rules for evaluating the register form: 
            require_once('application/validation_routines/users/change_password_form_validation_rules.php');

            //If the validation is not successfull, redirect to Register form
            if ($this->form_validation->run() == FALSE) {
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_load_view('change_password_form');
            } else {
                //If the validation is successfull
                //Sanitizing the data and applying the XSS filters
                $data = $this->input->post(NULL, TRUE);
                $user = $this->generic_model->read_a_record_by_id('users', $_SESSION['user']['id']);
                if (password_verify($data['current_password'], $user['password'])) {
                    $update['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    if ($this->generic_model->update_record_by_id('users', $_SESSION['user']['id'], $update)) {
                        $this->generic_model->set_the_flash_variables_for_modal('Good news!', 'Your password was updated', NULL, 'Ok');
                        redirect(base_url('users/user_information'));
                    } else {
                        $this->generic_model->set_the_flash_variables_for_modal(
                            'Sorry',
                            'There was a problem to update the password',
                            NULL,
                            'Ok'
                        );
                        $this->_load_view('change_password_form');
                    }
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal(
                        'Sorry',
                        'The current password is wrong',
                        NULL,
                        'Ok'
                    );
                    $this->_load_view('change_password_form');
                }
            }
        }
    }
    public function finish_session()
    {
        /*
        * What does it do?
        *
        * The finish_session method unset the $_SESSION['user'] variable
        * 
        * How to use it?
        * 
        * The method is used through a GET require
        *
        * What does it return?
        *
        * It finishes the session and redirect to the login method
        */

        unset($_SESSION['user']);
        redirect(base_url('users/login'));
    }
    public function recover_password()
    {
        /*
        * What does it do?
        *
        * If the method is excecuted through a GET request:
        * ---> It loads the form to enter the email for recovering password
        * If the method is excecuted through a POST request:
        * ---> It receives an email from the form,
        * ---> and checks if that email is registered,
        * ---> If the email is registered
        * -------> inserts the link and date in table users,
        * -------> includes the email settings from "application/code_for_loading/emails/template-X/implementations/",
        * -------> includes the email template from "application/code_for_loading/emails/template-X/",
        * -------> excecutes the method $this->generic_model->send_email
        * ---> If the email is not registered
        * -------> It loads the recover password form again
        * 
        * How to use it?
        * 
        * The href attribute of Forgot password's link must be this URL
        * The action attribute in the form must be this URL
        *
        * What does it return?
        *
        * If the email is not registered
        * ---> Excecutes the method $this->generic_model->send_email
        * If the email is not registered
        * ---> Loads the recover password form again
        */

        $_SESSION['next_page'] = base_url('users/recover_password');

        $this->load->library('form_validation');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->_load_view('recover_password');
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Rules for evaluating the register form: 
            require_once('application/validation_routines/users/recover_password_form_validation_rules.php');

            //If the validation is not successfull, redirect to recover_password form
            if ($this->form_validation->run() == FALSE) {
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_load_view('recover_password');
            } else {
                //If the validation is successfull
                //Sanitizing the data and applying the XSS filters
                $email = $this->input->post('email', TRUE);
                $data = array(
                    'email' => $email
                );
                $result = $this->generic_model->read_records('users', $data);
                if (is_array($result) && count($result) == 1) {
                    //The user is registered
                    $link = $this->generic_model->encode_id(array(array('id' => $result[0]['id'])));
                    $data = array(
                        'recover_password_link' => $link[0]['id'],
                        'recover_password_link_date' => date('Y/m/d H:i:s', time())
                    );
                    if ($this->generic_model->update_record_by_id('users', $result[0]['id'], $data)) {
                        $user = $result[0];
                        $link = base_url("users/set_new_password/" . $link[0]['id']); //Parameter used for validating the password update process
                        //Getting settings
                        $parameters = $this->generic_model->read_a_record_by_id('login_parameters', 1);
                        //Including email template
                        require_once('application/code_for_loading/emails/template1/implementations/recover_password.php');
                        require_once('application/code_for_loading/emails/template1/email_template1.php');
                        //Excecuting $this->generic_model->send_email(subject,to,sender,content)
                        $this->generic_model->send_email('Recover your password', $result[0]['email'], $parameters['sender_for_recovery_password_link'], $html);
                        $this->generic_model->set_the_flash_variables_for_modal('Information', 'We have sent an email where you can find a link to recover your password', NULL, 'Ok');
                        redirect(base_url());
                    } else {
                        $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'An error ocurred, try again please', NULL, 'Ok');
                    }
                } else {
                    //The user is not registered
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The email is not registered', NULL, 'Ok', base_url('users/registration'), 'Would you like sign up?');
                    $this->_load_view('recover_password');
                }
            }
        }
    }
    public function set_new_password($code = NULL)
    {
        /*
        * What does it do?
        *
        * The method is excecuted through a GET request
        * from the email to recover the password,
        * it receives a parameter which is a ramdom code
        * that contains the user id, this code is matched with a
        * code saved in the table users.
        * If the code matches and is not expired:
        * ---> Load the form to update the password
        * If the code does not matches or is expired:
        * ---> Show a message that explains the link is not valid
        * ---> Redirect to login
        *
        * How to use it?
        * 
        * The href attribute of recover password's link
        * (sent to the user's email) must point out to this URL
        *
        * What does it return?
        * If the code matches:
        * ---> Load the form to update the password
        * If the code does not matches:
        * ---> Show a message that explains the link is not valid
        * ---> Redirect to login
        */

        $_SESSION['last_page'] = base_url('users/set_new_password');
        $this->load->library('form_validation');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            if ($code != NULL) {
                $id = $this->generic_model->recover_an_id($code);
                $user = $this->generic_model->get_user_by_id($id);
                $parameters = $this->generic_model->read_all_records('control_syslogin');
                $expiration_time = strtotime($user['recover_password_link_date']) + ($parameters[0]['validity_of_recover_password_link'] * 60) - time();
                if ($user['recover_password_link'] === $code) {
                    if ($expiration_time >= 0) {
                        $this->_load_view('set_new_password');
                    } else {
                        $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'The link for recovering the password expired', NULL, 'Ok');
                        redirect(base_url('users/login'));
                    }
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal(
                        'Sorry',
                        'The link for recovering the password is not valid',
                        NULL,
                        'Ok'
                    );
                    redirect(base_url('users/login'));
                }
            }
        } elseif ($this->input->server('REQUEST_METHOD') === 'POST') {
            //Rules for evaluating the register form: 
            require_once('application/validation_routines/users/set_new_password_form_validation_rules.php');

            //If the validation is not successfull, go back to set_new_password_form
            if (
                $this->form_validation->run() == FALSE
            ) {
                $this->generic_model->set_the_flash_variables_for_modal('Sorry', validation_errors(), NULL, 'Ok');
                $this->_load_view('set_new_password');
            } else {
                //If the validation is successfull
                //Sanitizing the data and applying the XSS filters
                $id = $this->input->post('id', TRUE);
                $password = password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT);
                $data = array(
                    'password' => $password
                );
                $result = $this->generic_model->update_record_by_id('users', $id, $data);
                if ($result) {
                    $this->generic_model->set_the_flash_variables_for_modal('Good news!', 'Your password was updated', NULL, 'Ok');
                    redirect(base_url('users/login'));
                } else {
                    $this->generic_model->set_the_flash_variables_for_modal(
                        'Sorry',
                        'The password could not be updated, try again.',
                        NULL,
                        'Ok'
                    );
                    redirect(base_url('users/login'));
                }
            }
        }
    }
    private function _load_view($action = NULL)
    {
        //First group of files
        require_once('application/code_for_loading/canvas/load_first_group_of_files.php');

        //Content

        switch ($action) {
            case 'login':
                $_SESSION['last_page'] = base_url('users/login');
                $this->load->View('canvas/sections/login/login_form');
                break;
            case 'registration':
                $_SESSION['last_page'] = base_url('users/registration');
                $this->load->View('canvas/sections/login/register_form');
                break;
            case 'update':
                $_SESSION['last_page'] = base_url('users/user_information');
                $this->load->View('canvas/users/update_user_form');
                break;
            case 'update_validation':
                $_SESSION['last_page'] = base_url('users/user_information');
                $this->load->View('canvas/users/update_user_form');
                break;
            case 'change_password':
                $_SESSION['last_page'] = base_url('users/user_information');
                $this->load->View('canvas/users/change_password_form');
                break;
            case 'recover_password':
                $_SESSION['last_page'] = base_url('users/user_information');
                $this->load->View('canvas/sections/login/recover_password_form');
                break;
            case 'set_new_password':
                $_SESSION['last_page'] = base_url('users/user_information');
                $this->load->View('canvas/sections/login/set_new_password_form');
                break;
            case 'user_information':
                $_SESSION['last_page'] = base_url('users/user_information');
                $this->load->View('canvas/users/user_information');
                break;
            default:
                $_SESSION['last_page'] = base_url('users/login');
                $this->load->View('canvas/sections/login/login_form');
                break;
        }

        $this->load->View('canvas/sections/footers/01_open_footer');
        $this->load->View('canvas/sections/footers/copyrights');
        $this->load->View('canvas/sections/footers/02_close_footer');

        //End of Content

        //Second group of files
        require_once('application/code_for_loading/canvas/load_second_group_of_files.php');
    }
    public function username_check($username)
    {
        /*
        * This method is part of the validation rules for Update method
        */
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $this->generic_model->default_redirection();
        }
        if ($username == $_SESSION['user']['username']) {
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
