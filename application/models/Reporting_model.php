<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reporting_model extends CI_Model
{
    /*
    *
    * execution_trace 
    * record_err_event
    * _array_to_string
    * _register_event 
    *
    */

    //Class properties
    private $array_to_string;   //Variable used in _$array_to_string method

    public function execution_trace($controller = NULL, $method = NULL, $reset = FALSE)
    {
        /*
        * What does it do?
        *
        * It sets a route in the session variable "route"
        * to later register it in a err_event table to track
        * the errs occurred.
        *
        * How to use it?
        *
        * $this->load->model('generic_model');
        * $this->generic_model->execution_trace(get_class(),__FUNCTION__,TRUE/FALSE);
        *
        * If $reset == TRUE then the route is reset
        *
        * What does it return?
        *
        * It sets the "route" session variable but does not return any value
        *
        */
        if ($reset == TRUE) {
            unset($_SESSION['route']);
        }
        if (isset($_SESSION['route'])) {
            if ($method == "record_err_event") {
                $_SESSION['route'] .= "Class:$controller/Method:$method";
            } else {
                $_SESSION['route'] .= "Class:$controller/Method:$method-> ";
            }
        } else {
            $_SESSION['route'] = "Class:$controller/Method:$method-> ";
        }
    }
    public function record_err_event($err = NULL, $var = NULL)
    {
        /*
        * What does it do?
        *
        * It registers the err message, a variable that can help
        * as reference of the err's scene, and the
        * route where the err appeared 
        *
        * How to use it?
        *
        * $this->generic_model->record_err_event($err,$var);
        *
        * What does it return?
        *
        * If the registration failed: FALSE
        * If the registration was done effectively: TRUE 
        *
        */
        $this->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('create');

        $err .= " -> ";
        if (is_array($var)) {
            $err .= $this->array_to_string($var);
        } else {
            $err .= " var : $var ";
        }

        $data = array(
            'err' => $err,
            'route' => $_SESSION['route']
        );

        $this->db->insert('err_event', $data);
        $insert = $this->db->affected_rows();
        $this->db->close();

        if (
            $insert == 1
        ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function array_to_string($var)
    {
        /*
        * What does it do?
        *
        * This method is a resource to work for the method "record_err_event"
        * It participates in the building process for the variable that is
        * registered in the method "record_err_event"
        *
        * How to use it?
        *
        * $this->_array_to_string($var);
        *
        * What does it return?
        *
        * It concatenates "$this->_array_to_string" property according to de values of var
        *
        */
        foreach ($var as $key => $value) {
            if (!is_array($value)) {
                $this->array_to_string .= " $key : $value / ";
            } else {
                $this->array_to_string .= " $key : { ";
                $this->array_to_string($value);
                $this->array_to_string .= " } ";
            }
        }
        return $this->array_to_string;
    }
    public function register_event($action = NULL, $table = NULL, $values = NULL)
    {

        $this->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('create');

        if (is_array($values)) {
            $this->_array_to_string = "";
            $values = $this->array_to_string($values);
        }

        if ($_SESSION['user']) {
            $data['user_id'] = $_SESSION['user']['id'];
        }
        $data = array(
            'action' => $action,
            'table_used' => $table,
            'values_used' => $values
        );
        $this->db->insert(
            'events',
            $data
        );

        $this->db->close();
    }
}
