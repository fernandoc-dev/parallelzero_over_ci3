<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    /*
    * Login model content:
    *
    * login
    * check_if_the_user_exists
    * check_if_the_deleted_user_is_expired
    * get_login_settings
    * register_login
    * set_session_variables_for_users
    * register_new_block
    * add_failed_attempt
    * erase_failed_attempts
    * check_session_validity
    * check_permission
    * register_new_login
    * register_failed_attempt
    * block_user
    * reactivate_user
    *
    */

    public function login($user_data)
    {
        /*
        * What does it do?
        *
        * It authenticates users according to the credentials (username and password)
        * If there is a unique user then:
        * ---> It gets the login settings
        * ---> It checks if the user is blocked for exceeding the failed attempts
        * ---> It checks the password
        * ---> If the login attempt is successfull:
        * --------> It clears the failed attempts and sets the $_SESSION['user] variable
        * ---> If the login attempt failed, then add the failed attempt
        * ---> and return a specific message according to the fail
        *
        * How to use it?
        *
        * $this->load->model('generic_model');
        * $result = $this->generic_model->login($user_data);
        *
        * What does it return?
        *
        * This method returns the array $result
        *
        * If the loggin is not successful:
        * ---> $result['access'] = FALSE:
        * ---------> $result['err'] = 'The user is not registered'
        * ---------> $result['err'] = 'The username or email is repeated'
        * ---------> $result['err'] = 'The user has been blocked'
        * ---------> $result['err'] = 'The user has a temporary block'
        * ---------> $result['err'] = 'Wrong password'
        * ---------> $result['err'] = 'Login unsuccessful'
        *
        * If the loggin is successful:
        * ---> $result['access'] = TRUE
        *
        */

        //Initial condition->Login failed
        $result['access'] = FALSE;
        $user = $this->generic_model->read_records_or('users', array('username' => $user_data['username'], 'email' => $user_data['username']));
        if (count($user) === 0) {
            $result['err'] = 'The user is not registered';
            return $result;
        } elseif (count($user) > 1) {
            $result['err'] = 'The username or email is repeated';
            return $result;
        } elseif ((count($user) === 1) && ($user[0]['deleted'] == 0)) { //There is only one user matched
            $user = $user[0];
            unset($user[0]);
            $settings = $this->get_login_settings();
            //The system is checking the failed attempts
            if ($settings['check_failed_attempts']) {
                //The user is not blocked
                if ($user['last_block'] == NULL) {
                    //Checking the password
                    if (password_verify($user_data['password'], $user['password'])) {
                        $this->register_login($user);
                        $this->set_session_variables_for_users($user, $settings);
                        $result['access'] = TRUE;
                        return $result;
                    } else { //If the password does not matched
                        if ($settings['failed_attempts_allowed'] <= ($user['failed_attempts_made'] + 1)) {
                            $this->register_new_block($user);
                            $result['err'] = 'The user has been blocked';
                            return $result;
                        } else {
                            $this->add_failed_attempt($user);
                            $result['err'] = 'Wrong password';
                            return $result;
                        }
                    }
                } elseif ($user['last_block'] != NULL) {
                    if ($settings['unblock_method'] === 'time') {
                        //Check if the time penalty was released
                        $penalty_expiration_time = strtotime(date('Y/m/d H:i:s', time())) -
                            strtotime($user['last_block']) -
                            ($settings['time_after_failed_attempts']);
                        if ($penalty_expiration_time >= 0) {
                            $this->erase_failed_attempts($user); //Erase the penalty
                            $user['failed_attempts_made'] = 0;
                            if (password_verify($user_data['password'], $user['password'])) {
                                $this->register_login($user);
                                $this->set_session_variables_for_users($user, $settings);
                                $result['access'] = TRUE;
                                return $result;
                            } else {
                                $this->add_failed_attempt($user);
                                $result['err'] = 'Wrong password';
                                return $result;
                            }
                        } elseif ($penalty_expiration_time < 0) {
                            $result['err'] = 'The user has a temporary block';
                            return $result;
                        }
                    } elseif ($settings['unblock_method'] === 'email') {
                        $this->add_failed_attempt($user);
                        $result['err'] = 'The user has been blocked';
                        return $result;
                    }
                }
            } elseif ($settings['check_failed_attempts'] == FALSE) { //If the system is not checking the failed attempts
                if (password_verify($user_data['password'], $user['password'])) {
                    $this->register_login($user);
                    $this->set_session_variables_for_users($user, $settings);
                    $result['access'] = TRUE;
                    return $result;
                } else {
                    $this->add_failed_attempt($user);
                    $result['err'] = 'Wrong password';
                    return $result;
                }
            }
        } elseif ((count($user) === 1) && ($user[0]['deleted'] == 1)) { //There is only one user matched
            $expiration = $this->check_if_the_deleted_user_is_expired($user[0]);
            if ($expiration) {
                $this->generic_model->hard_delete('users', $user[0]['id']);
                $result['err'] = 'The user is not registered';
                return $result;
            } else {
                if (password_verify($user_data['password'], $user['password'])) {
                    $this->reactivate_user($user[0]);
                    $settings = $this->get_login_settings();
                    $this->register_login($user);
                    $this->set_session_variables_for_users($user, $settings);
                    $result['access'] = TRUE;
                    return $result;
                } else {
                    $this->register_failed_attempt($user);
                    $result['err'] = 'Wrong password';
                    return $result;
                }
            }
        }
    }
    public function check_if_the_user_exists($user_data)
    {
        /*
        * What does it do?
        *
        * Checks if the username and email are available
        * The "deleted" records are considered and the "deleted_at"
        * is considered to check if the user expired
        *
        * How to use it?
        *
        * At the Controller you must set:
        * $data = array(
        *    'username' => 'roger',
        *    'email' => 'roger@mail.com'
        * );
        * $this->load->model('users_model');
        * $result = $this->users_model->check_if_the_user_exists($data);
        *
        * What does it return?
        *
        * If the username and email are available:
        * --->'The username and email are available'
        * If the username is registered:
        * --->'The username is already registered'
        * If the email is registered:
        * --->'The email is already registered'
        *
        */

        $sql = "SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1";

        //Connection to READ in the DB
        $this->load->database('read');

        $query = $this->db->query($sql, array(
            $user_data['username'],
            $user_data['email']
        ));
        $this->db->close();
        $users = $query->result_array();
        if (count($users) === 0) {
            return 'The username and email are available';
        } else {
            if (
                count($users) === 1 && $users[0]['deleted'] == 1
            ) {
                $expiration = $this->check_if_the_deleted_user_is_expired($users[0]);
                if ($expiration) {
                    $this->generic_model->hard_delete('users', $users[0]['id']);
                    return 'The username and email are available';
                }
            }
            if ($users[0]['username'] === $user_data['username']) {
                return 'The username is already registered';
            } elseif ($users[0]['email'] === $user_data['email']) {
                return 'The email is already registered';
            }
        }
    }
    public function check_if_the_deleted_user_is_expired($user)
    {
        /*
        * What does it do?
        *
        * Compares the soft delete date + the interval set in
        * login_parameters with time()
        *
        * How to use it?
        *
        * Receives the user data, important: $user['deleted_at']
        * $this->load->model('users_model');
        * $result = $this->users_model->check_if_the_deleted_user_is_expired($user);
        *
        * What does it return?
        *
        * If the user expired:
        * --->TRUE
        * If the user did not expired:
        * --->FALSE
        *
        */

        $settings = $this->get_login_settings();
        if (
            $settings['users_expiration_time'] * 86400 + strtotime($user['deleted_at']) <= time()
        ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function get_login_settings()
    {
        /*
        * What does it do?
        *
        * Gets the settings from login_parameters
        *
        * How to use it?
        *
        * Receives the user data, important: $user['deleted_at']
        * $this->load->model('users_model');
        * $result = $this->users_model->get_login_settings();
        *
        * What does it return?
        *
        * An array with the settings
        *
        */

        //Connection to READ in the DB
        $this->load->database('read');

        $query = $this->db->get('login_parameters');
        $this->db->close();
        $settings = $query->row_array();
        return $settings;
    }
    public function register_login($user)
    {
        /*
        * What does it do?
        *
        * Updates the user with:
        * --->last_login : time()
        * --->failed_attempts_made: 0
        * --->last_block: NULL
        *
        * How to use it?
        *
        * This method is used from login
        *
        * What does it return?
        *
        * The method only updates the user, it does not return any value
        *
        */

        $id = $user['id'];
        $data = array(
            'last_login' => date(
                'Y/m/d H:i:s',
                time()
            ),
            'failed_attempts_made' => 0,
            'last_block' => NULL
        );
        $where = "id = $id";

        //Connection to UPDATE in the DB
        $this->load->database('update');

        $this->db->update('users', $data, $where);
        $this->db->close();
    }
    public function set_session_variables_for_users($user, $settings)
    {
        /*
        * What does it do?
        *
        * Sets Session variables
        *
        * How to use it?
        *
        * This method is used from login when the login is successful
        *
        * What does it return?
        *
        * The method only sets the session variables
        *
        */
        $_SESSION['user'] = $user;
        $_SESSION['user']['session_time'] = $settings['session_time'];
        $_SESSION['user']['time'] = time();
    }
    public function register_new_block($user)
    {
        /*
        * What does it do?
        *
        * Receives the selected user
        * Sets the "failed_attempts_made" field
        * Sets the current datetime in "last_block" field
        *
        * How to use it?
        *
        * This method is used from login when the user results blocked
        *
        * What does it return?
        *
        * The method only updates the user, it does not return any value
        *
        */

        $id = $user['id'];
        $data = array(
            'failed_attempts_made' => $user['failed_attempts_made'] + 1,
            'last_block' => date('Y/m/d H:i:s', time())
        );
        $where = "id = $id";

        //Connection to UPDATE in the DB
        $this->load->database('update');

        $this->db->update(
            'users',
            $data,
            $where
        );
        $this->db->close();
    }
    public function add_failed_attempt($user)
    {
        /*
        * What does it do?
        *
        * Receives the selected user
        * Sets the "failed_attempts_made" field
        * Sets the current datetime in "last_failed_attempt" field
        *
        * How to use it?
        *
        * This method is used from login when the user fail the log in process
        *
        * What does it return?
        *
        * The method only updates the user, it does not return any value
        *
        */

        $id = $user['id'];
        $failed_attempts_made = $user['failed_attempts_made'] + 1;
        $data = array(
            'failed_attempts_made' => $failed_attempts_made,
            'last_failed_attempt' => date('Y/m/d H:i:s', time()),
        );
        $where = "id = $id";

        //Connection to UPDATE in the DB
        $this->load->database('update');

        $this->db->update('users', $data, $where);
        $this->db->close();
    }
    public function erase_failed_attempts($user)
    {
        /*
        * What does it do?
        *
        * Receives the selected user
        * Clears the failed attempts
        * Clears the "last_block" field
        *
        * How to use it?
        *
        * This method is used from login when the user fail the log in process
        *
        * What does it return?
        *
        * The method only updates the user, it does not return any value
        *
        */

        $id = $user['id'];
        $data = array(
            'failed_attempts_made' => 0,
            'last_block' => NULL
        );
        $where = "id = $id";

        //Connection to UPDATE in the DB
        $this->load->database('update');

        $this->db->update('users', $data, $where);
        $this->db->close();
    }
    public function check_session_validity()
    {
        /*
        * What does it do?
        *
        * This method determines if the session expired according to the
        * settings of the table login_parameters
        * If the session is active then reset $_SESSION['user']['time']
        * If the session expired then destroy the session
        *
        * It receives the parameter $redirection which is the URL where
        * the user is redirected after login
        *
        * How to use it?
        *
        * $this->load->model('generic_model');
        * $this->generic_model->check_session_validity($redirection:STRING);
        *
        * What does it return?
        *
        * If the session expired:
        * ---> Set the session variable "last_page" using the parameter $redirection
        * ---> Redirect to login form
        * If the session did not expire: TRUE
        * 
        */

        $session_time = $this->generic_model->read_all_records('login_parameters');

        if (isset($_SESSION['user']['time'])) {
            $session_expiration = $_SESSION['user']['time'] + $session_time[0]['session_time'] - time();
            if ($session_expiration > 0) {
                $_SESSION['user']['time'] = time();
                return TRUE;
            } elseif ($session_expiration <= 0) {
                unset($_SESSION['user']);
                $result = FALSE;
            }
        } else {
            $result = FALSE;
        }
        if (!$result) {
            redirect('users/login');
        }
    }
    public function check_permission($role)
    {
        /*
        * What does it do?
        *
        * This method determines if the
        * user has the permission to acceed a resource, the criteria is the role
        *
        * How to use it?
        *
        * This method is invocated at the begining of every method with restrictions
        *
        * What does it return?
        *
        * If the user has the permission: TRUE
        * If the user does not have the permission: FALSE
        * 
        */
        if (intval($_SESSION['user']['role']) < $role) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function register_new_login($user)
    {
        $data = array(
            'last_login' => date('Y/m/d H:i:s', time()),
            'failed_attempts_made' => 0,
            'last_block' => NULL
        );
        $this->generic_model->update_record_by_id('users', $user['id'], $data);
    }
    public function register_failed_attempt($user)
    {
        $data = array(
            'failed_attempts_made' => $user['failed_attempts_made'] + 1,
            'last_failed_attempt' => date('Y/m/d H:i:s', time()),
        );
        $this->generic_crud->update_record_by_id('users', $user['id'], $data);
    }
    public function block_user($user)
    {
        $data = array(
            'failed_attempts_made' => $user['failed_attempts_made'] + 1,
            'last_block' => date('Y/m/d H:i:s', time())
        );
        $this->generic_model->update_record_by_id('users', $user['id'], $data);
    }
    public function reactivate_user($user)
    {
        $data = array(
            'deleted' => 0
        );
        $this->generic_model->update_record_by_id('users', $user['id'], $data);
    }
}
