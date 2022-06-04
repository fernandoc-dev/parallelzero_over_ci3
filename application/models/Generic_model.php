<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Generic_model extends CI_Model
{
    /*
    * Generic model content:
    *
    * CRUD:
    *
    * CREATE:
    * insert_a_new_record                   REVISADO
    *
    * READ:
    * read_all_records                      REVISADO
    * read_a_record_by_id                   REVISADO
    * read_records                          REVISADO
    * read_records_or                       REVISADO
    * check_if_the_record_exists            REVISADO
    * get_columns_of_table                  REVISADO
    *
    * UPDATE:
    * update_record_by_id                   REVISADO
    * update_records                        REVISADO
    * update_records_or                     REVISADO
    *
    * DELETE:
    * hard_delete_by_id                     REVISADO
    * hard_delete                           REVISADO
    * hard_delete_or                        REVISADO
    * hard_delete_all                       REVISADO
    *
    * OTHER FUNCIONALITIES:
    
    * encode_id                             REVISADO
    * decode_id                             REVISADO
    * recover_a_group_of_ids
    * recover_a_single_id
    * get_the_id_of
    *
    * set_the_flash_variables_for_modal     REVISADO
    *
    * load_section_admin
    * admin_routine                         REVISADO
    * default_admin_redirection             REVISADO
    * reset_id                              REVISADO
    *
    */

    //Class properties
    private $data;              //Variable used in _load_admin_section

    public function __construct()
    {
        parent::__construct();
    }
    //CREATE:
    public function insert_a_new_record($table, $data, $check_integrity = TRUE)
    {
        /*
        * What does it do?
        *
        * It inserts a new record with the received data in the received table
        *
        * If $check_integrity == TRUE the items that do not match with the
        * table's fields will be remove before the data insertion,for this
        * is used the method "get_columns_of_table"
        *
        * If $check_integrity == FALSE the items must match with the table's fields
        * or an error will raise
        *
        * It requires a "create" user profile
        *
        * How to use it?
        *
        
        * $table = 'my_table';
        * $data = array(
        *    'name' => 'Roger',
        *    'username' => 'roger',
        *    'email' => 'roger@mail.com'
        * );
        * $this->load->model('generic_model');
        * $result = $this->generic_model->insert_a_new_record($table:STRING, $data:ARRAY, $check_integrity:TRUE/FALSE);
        *
        * What does it return?
        *
        * If the insertion was successful (affected_rows==1): TRUE
        * If the insertion failed (affected_rows!=1): FALSE
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        if ($check_integrity == TRUE) {
            $columns = $this->get_columns_of_table($table);
            foreach ($data as $key => $value) {
                if (!in_array($key, $columns)) {
                    unset($data[$key]);
                }
            }
        }

        $this->load->database('create');

        $sql = "INSERT INTO $table ";
        $keys = "";
        $values = "";
        $records = array();
        foreach ($data as $key => $value) {
            if ($keys == "") {
                $keys .= "($key";
                $values .= " VALUES (?";
            } else {
                $keys .= ", $key";
                $values .= ",?";
            }
            $records[] = $value;
        }
        $keys .= ")";
        $values .= ")";
        $sql .= $keys . $values;
        $this->db->query($sql, $records);
        $insert = $this->db->affected_rows();
        $this->db->close();
        if ($insert === 1) {
            $this->reporting_model->register_event("create", $table, $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    //READ:
    public function read_all_records($table, $encode_id = FALSE)
    {
        /*
        * What does it do?
        *
        * It gets all records from a table
        *
        * I requires the table has a field deleted==0
        *
        * If $encode_id == TRUE is excecuted the method "encode_id"
        * where is applied a mask to ids
        *
        * It requires a "read" user profile
        *
        * How to use it?
        *
        * $table = 'my_table';
        * $this->load->model('generic_model');
        * $result = $this->generic_model->read_all_records($table:STRING, $encode_id:TRUE/FALSE);
        *
        * What does it return?
        *
        * It returns the query's result in array format o NULL if there are not records
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('read');

        $this->db->where('deleted', 0);
        $query = $this->db->get($table);
        $records = $query->result_array();
        $this->db->close();
        if ($encode_id) {
            $records = $this->encode_id($records);
            return $records;
        } else {
            return $records;
        }
    }
    public function read_a_record_by_id($table, $id, $encode_id = FALSE)
    {
        /*
        * What does it do?
        *
        * It gets a record from a table searching by id
        *
        * I requires the table has a field deleted==0
        *
        * If $encode_id == TRUE is excecuted the method "encode_id"
        * where is applied a mask to id
        *
        * It requires a "read" user profile
        *
        * How to use it?
        *
        * $table = 'my_table';
        * $id = 4;
        * $this->load->model('generic_model');
        * $result = $this->generic_model->get_a_record_by_id($table:STRING, $id:INTEGER, $encode_id:TRUE/FALSE);
        *
        * What does it return?
        *
        * It returns the query's result in row format o NULL if there are not records
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('read');

        $this->db->where('id', $id);
        $this->db->where('deleted', 0);
        $query = $this->db->get($table);
        $record = $query->row_array();
        $this->db->close();
        if (is_array($record)) {
            if ($encode_id) {
                $data = array($record);
                $record = $this->encode_id($data);
                return $record[0];
            }
            return $record;
        } else {
            return FALSE;
        }
    }
    public function read_records($table, $values_to_match, $encode_id = FALSE)
    {
        /*
        * What does it do?
        *
        * It gets records which match with the values_to_match (applying AND operators)
        * the array "values_to_match" can work with comparision operators
        *
        * If $encode_id == TRUE is excecuted the method "encode_id"
        * where is applied a mask to id
        *
        * It requires a "read" user profile
        *
        * How to use it?
        *
        * $table = 'my_table';
        * $values_to_match = array(
        *    'username' => 'my_user',
        *    'email' => 'my@mail.com',
        *    'role<=' => 4,
        *    'deleted' => 0
        * );
        * $this->load->model('generic_model');
        * $result = $this->generic_model->read_records($table:STRING, $values_to_match:ARRAY,$encode_id:TRUE/FALSE);
        *
        * What does it return?
        *
        * It returns the query's result in array format o NULL if there are not records
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('read');
        $counter = 1;
        $fields = count($values_to_match);
        $query = $this->db; //Symbolic line to avoid an err message
        foreach ($values_to_match as $key => $value) {
            if ($counter == 1) {
                $this->db->where($key, $value);
            } elseif ($counter <= $fields) {
                $this->db->where($key, $value);
            }
            if ($counter == $fields) {
                $query = $this->db->get($table);
                break;
            }
            $counter++;
        }
        $records = $query->result_array();
        $this->db->close();
        if ($encode_id) {
            $records = $this->encode_id($records);
            return $records;
        } else {
            return $records;
        }
    }
    public function read_records_or($table, $values_to_match, $encode_id = FALSE)
    {
        /*
        * What does it do?
        *
        * It gets records which match with the values_to_match (applying OR operators)
        * the array "values_to_match" can work with comparision operators
        *
        * If $encode_id == TRUE is excecuted the method "encode_id"
        * where is applied a mask to id
        *
        * It requires a "read" user profile
        *
        * How to use it?
        *
        * $table = 'my_table';
        * $values_to_match = array(
        *    'username' => 'my_user',
        *    'email' => 'my@mail.com',
        *    'role<=' => 4,
        *    'deleted' => 0
        * );
        * $this->load->model('generic_model');
        * $result = $this->generic_model->read_records_or($table:STRING, $values_to_match:ARRAY,$encode_id:TRUE/FALSE);
        *
        * What does it return?
        *
        * It returns the query's result in array format o NULL if there are not records
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('read');
        $counter = 1;
        $fields = count($values_to_match);
        $query = $this->db; //Symbolic line to avoid an err message
        foreach ($values_to_match as $key => $value) {
            if ($counter == 1) {
                $this->db->where($key, $value);
            } elseif ($counter <= $fields) {
                $this->db->or_where($key, $value);
            }
            if ($counter == $fields) {
                $query = $this->db->get($table);
                break;
            }
            $counter++;
        }
        $records = $query->result_array();
        $this->db->close();
        if ($encode_id) {
            $records = $this->encode_id($records);
            return $records;
        } else {
            return $records;
        }
    }
    public function check_if_the_record_exists($table, $record)
    {
        /*
        * What does it do?
        *
        * It checks if exists a record with some of the key=>value passed
        * If there are records with those values, it retuns the fields matched 
        *
        *
        * It requires a "read" user profile
        *
        * How to use it?
        *
        
        * $record = array( //Fields that can't be repeated
        *    'username' => 'my_user',
        *    'email' => 'my@mail.com'
        * );
        * $this->load->model('generic_model');
        * $result = $this->generic_model->check_if_the_record_exists($table:STRING, $record:ARRAY);
        *
        * What does it return?
        *
        * If there are not records matched: "available"
        * If there are records matched: An array with the fields repeated
        * If the result was not the expected: "error"
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('read');
        $query = $this->db;
        $counter = 1;
        $values = count($record);
        foreach ($record as $key => $value) {
            if ($counter == 1) {
                $this->db->where($key, $value);
            } elseif ($counter <= $values) {
                $this->db->or_where($key, $value);
            }
            if ($counter == $values) {
                $query = $this->db->get($table);
                break;
            }
            $counter++;
        }
        $result = $query->result_array();
        $this->db->close();
        $repeated_fields = NULL;
        if (count($result) != 0) { //Fields repeated
            foreach ($result as $row) {
                foreach ($record as $key => $value) {
                    if (in_array($value, $row)) {
                        $repeated_fields[] = $key;
                    }
                }
            }
            return $repeated_fields;
        } elseif ($result == NULL) {
            return "availabe";
        } else {
            return "error";
        }
    }
    //UPDATE:
    public function update_record_by_id($table, $id, $data)
    {
        /*
        * What does it do?
        *
        * It updates a record (one and only one) in a table searching by id
        *
        * It requires an "update" user profile
        *
        * How to use it?
        *
        * $table = 'my_table';
        * $data = array(
        *     $key_field => 'record_updated'
        * );
        * $this->load->model('generic_model');
        * $result = $this->generic_model->update_record_by_id($table:STRING, $id:INTEGER, $data:ARRAY);
        *
        * What does it return?
        *
        * If the update process was successfull (affected_rows==1): TRUE
        * If the update process failed (affected_rows!=1): FALSE
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('update');

        $where = "id = $id";
        $this->db->update($table, $data, $where);
        $update = $this->db->affected_rows();
        $this->db->close();
        if ($update === 1) {
            $data = array('id' => $id);
            $this->reporting_model->register_event("update", $table, $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function update_records($table, $values_to_match, $values_to_update)
    {
        /*
        * What does it do?
        *
        * It updates records which match with the values_to_match (applying AND operators)
        * and puts values_to_update
        * the array "values_to_match" can work with comparision operators
        *
        * It requires an "update" user profile
        *
        * How to use it?
        *
        * $table='my_table';
        * $values_to_match = array(
        *     'nationality' => 'venezuelan',
        *     'role' => 'student',
        *     'deleted' => 0
        * );
        * $values_to_update = array(
        *     'scholarship' => 'approved',
        *     'status' => 'solved'
        * );
        * $result = $this->generic_model->update_records($table:STRING, $values_to_match:ARRAY, $values_to_update:ARRAY);
        *
        * What does it return?
        *
        * If the update process was successfull (affected_rows > 0): affected_rows
        * If the update process failed (affected_rows == 0): FALSE
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('update');

        $counter = 1;
        $fields = count($values_to_match);
        foreach ($values_to_match as $key => $value) {
            if ($counter == 1) {
                $this->db->where($key, $value);
            } elseif ($counter <= $fields) {
                $this->db->where($key, $value);
            }
            if ($counter == $fields) {
                $this->db->update($table, $values_to_update);
                break;
            }
            $counter++;
        }
        $update = $this->db->affected_rows();
        $this->db->close();
        if ($update > 0) {
            $this->reporting_model->register_event("update", $table, $values_to_update);
            return $update;
        } else {
            return FALSE;
        }
    }
    public function update_records_or($table, $values_to_match, $values_to_update)
    {
        /*
        * What does it do?
        *
        * It updates records which match with the values_to_match (applying OR operators)
        * and puts values_to_update
        * the array "values_to_match" can work with comparision operators
        *
        * It requires an "update" user profile
        *
        * How to use it?
        *
        * $table='my_table';
        * $values_to_match = array(
        *     'nationality' => 'venezuelan',
        *     'role' => 'student',
        *     'deleted' => 0
        * );
        * $values_to_update = array(
        *     'scholarship' => 'approved',
        *     'status' => 'solved'
        * );
        * $result = $this->generic_model->update_records_or($table:STRING, $values_to_match:ARRAY, $values_to_update:ARRAY);
        *
        * What does it return?
        *
        * If the update process was successfull (affected_rows > 0): affected_rows
        * If the update process failed (affected_rows == 0): FALSE
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('update');

        $counter = 1;
        $fields = count($values_to_match);
        foreach ($values_to_match as $key => $value) {
            if ($counter == 1) {
                $this->db->where($key, $value);
            } elseif ($counter <= $fields) {
                $this->db->or_where($key, $value);
            }
            if ($counter == $fields) {
                $this->db->update($table, $values_to_update);
                break;
            }
            $counter++;
        }
        $update = $this->db->affected_rows();
        $this->db->close();
        if ($update > 0) {
            $this->reporting_model->register_event("update", $table, $values_to_update);
            return $update;
        } else {
            return FALSE;
        }
    }
    //DELETE:
    public function hard_delete_by_id($table, $id)
    {
        /*
        * What does it do?
        *
        * It deletes a specific record selected by id
        *
        * It requires a "delete" user profile
        *
        * How to use it?
        *
        * $result = $this->generic_model->hard_delete_by_id($table:STRING, $id:INTEGER);
        *
        * What does it return?
        *
        * If the update process was successfull (affected_rows == 1): TRUE
        * If the update process failed (affected_rows != 1): FALSE
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('delete');

        $where = "id = $id";
        $this->db->delete($table, $where);
        $delete = $this->db->affected_rows();
        $this->db->close();
        $values = array('id' => $id);
        if ($delete === 1) {
            $this->reporting_model->register_event("delete", $table, $values);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function hard_delete($table, $values_to_match)
    {
        /*
        * What does it do?
        *
        * It deletes records which match with the values_to_match (applying AND operators)
        *
        * It requires a "delete" user profile
        *
        * How to use it?
        *
        * $result = $this->generic_model->hard_delete_by_id($table:STRING, $values_to_match:ARRAY);
        *
        * What does it return?
        *
        * If the update process was successfull (affected_rows == 1): affected_rows
        * If the update process failed (affected_rows != 1): FALSE
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('delete');

        $counter = 1;
        $fields = count($values_to_match);
        foreach ($values_to_match as $key => $value) {
            if ($counter == 1) {
                $this->db->where($key, $value);
            } elseif ($counter <= $fields) {
                $this->db->where($key, $value);
            }
            if ($counter == $fields) {
                $this->db->delete($table);
                break;
            }
            $counter++;
        }
        $delete = $this->db->affected_rows();
        $this->db->close();
        if ($delete > 0) {
            $this->reporting_model->register_event("delete", $table, $values_to_match);
            return $delete;
        } else {
            return FALSE;
        }
    }
    public function hard_delete_or($table, $values_to_match)
    {
        /*
        * What does it do?
        *
        * It deletes records which match with the values_to_match (applying OR operators)
        *
        * It requires a "delete" user profile
        *
        * How to use it?
        *
        * $result = $this->generic_model->hard_delete_or($table:STRING, $values_to_match:ARRAY);
        *
        * What does it return?
        *
        * If the update process was successfull (affected_rows == 1): affected_rows
        * If the update process failed (affected_rows != 1): FALSE
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('delete');

        $counter = 1;
        $fields = count($values_to_match);
        foreach ($values_to_match as $key => $value) {
            if ($counter == 1) {
                $this->db->where($key, $value);
            } elseif ($counter <= $fields) {
                $this->db->or_where($key, $value);
            }
            if ($counter == $fields) {
                $this->db->delete($table);
                break;
            }
            $counter++;
        }
        $delete = $this->db->affected_rows();
        $this->db->close();
        if ($delete > 0) {
            $this->reporting_model->register_event("delete", $table, $values_to_match);
            return $delete;
        } else {
            return FALSE;
        }
    }
    public function hard_delete_all($table)
    {
        /*
        * What does it do?
        *
        * It deletes all records in the table
        *
        * It requires a "delete" user profile
        *
        * How to use it?
        *
        * $result = $this->generic_model->hard_delete_all($table:STRING);
        *
        * What does it return?
        *
        * If the update process was successfull (affected_rows > 0): affected_rows
        * If the update process failed (affected_rows <= 0): FALSE
        *
        */
        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('delete');

        $where = "id >= 1";
        $this->db->delete($table, $where);
        $delete = $this->db->affected_rows();
        $this->db->close();
        if ($delete > 0) {
            $values = array('table' => $table);
            $this->reporting_model->register_event("delete", $table, $values);
            return $delete;
        } else {
            return FALSE;
        }
    }
    //OTHER FUNCTIONALITIES:
    public function encode_id($data)
    {
        /*
        * What does it do?
        *
        * It applies a codification algorithm over the integer received ($id)
        *
        * How to use it?
        *
        * $data = array(
        *    array(
        *        'id'=>4,
        *        'other_fields'=>'values'
        *    ),
        *    array(
        *        'id'=>5,
        *        'other_fields'=>'values'
        *    ),
        * );
        * $this->load->model('generic_model');
        * $result = $this->generic_model->encode_id($data);
        *
        * What does it return?
        *
        * It returns the received array but after encoded the id field
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);
        $factor1 = 2;
        $factor2 = 3;
        $factor3 = 72;
        $counter = 0;
        foreach ($data as $row) {
            $id = $row['id'];
            $initial_segment = strval(random_int(100, 999));
            $factor = $initial_segment[1] + $factor1;
            $central_segment = strval((($id + $factor3) * $factor2) * $factor);
            $ending_segment = strval(random_int(100000, 999999));
            $data[$counter]['id'] = $initial_segment . $central_segment . $ending_segment; //X(Y)X-[((id+72)*3)*(Y+2)]-XXXXXX
            $counter++;
        }
        return $data;
    }
    public function decode_id($data)
    {
        /*
        * What does it do?
        *
        * It applies a codification algorithm over the integer received ($id)
        *
        * How to use it?
        *
        * $data = array(
        *    array(
        *        'id'=>45165434565,
        *        'other_fields'=>'values'
        *    ),
        *    array(
        *        'id'=>16584354965,
        *        'other_fields'=>'values'
        *    ),
        * );
        * $this->load->model('generic_model');
        * $result = $this->generic_model->decode_id($data);
        *
        * What does it return?
        *
        * It returns the received array but after decoded the id field
        * If the id field was altered causing the decoding process can not give
        * the expected result, then the id field will be set like 0
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);
        $factor1 = 2;
        $factor2 = 3;
        $factor3 = 72;
        $counter = 0;
        foreach ($data as $row) {
            $id = $row['id'];
            if (ctype_digit($id)) {
                $factor = intval($id[1]) + $factor1;
                $id = intval($id);
                if (is_numeric($id) & (is_int($id))) {
                    $id = substr($id, 3, -6);
                    $id = intval($id);
                    $id = $id / $factor;
                    $data[$counter]['id'] = ($id / $factor2) - $factor3; //Structure: X(Y)X-[((id+72)*3)*(Y+2)]-XXXXXX
                } else {
                    $data[$counter]['id'] = 0;
                }
            } else {
                $data[$counter]['id'] = 0;
            }
            $counter++;
        }
        return $data;
    }
    public function recover_a_group_of_ids($data)
    {
        /*
        * Instructions:
        
        * $data = array(
        *     'author' => '5301095131906',
        *     'category' => '708438932983',
        *     'subcategories' => array('708438932983', '7301125603196', '6301155119260'),
        *     'tags' => array('708438932983', '7301125603196', '6301155119260'),
        * );
        * $this->load->model('generic_model');
        * $result = $this->generic_model->recover_a_group_of_ids($data);
        */
        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $id = $this->recover_a_single_id($value);
                if ($id != NULL) {
                    $data_result[$key] = $id;
                } else {
                    $data_result[$key] = NULL;
                }
            } else {
                foreach ($value as $sub_value) {
                    $id = $this->recover_a_single_id($sub_value);
                    if ($id != NULL) {
                        $sub_values[] = $id;
                    } else {
                        $sub_values[] = NULL;
                    }
                }
                $data_result[$key] = $sub_values;
                unset($sub_values);
            }
        }
        return $data_result;
    }
    public function recover_a_single_id($id)
    {
        /*
        * Instructions:
        
        * $id = 165432465;
        * $this->load->model('generic_model');
        * $real_id = $this->generic_model->recover_a_group_of_ids($id);
        */
        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $factor = intval($id[1]) + 2;
        $id = intval($id);
        if (is_numeric($id) & (is_int($id))) {
            $id = substr($id, 3, -6);
            $id = intval($id);
            $id = $id / $factor;
            $id = ($id / 3) - 72; //Structure: X(Y)X-[((id+72)*3)*(Y+2)]-XXXXXX
            if (is_int($id)) {
                return $id;
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }
    public function set_the_flash_variables_for_modal($title, $message, $btn1 = NULL, $btn2 = NULL, $link = NULL, $linkm = NULL)
    {
        /*
        * What does it do?
        *
        * It sets the flashdata variables to build the modal message
        * The modal message can contain:
        * title, message, btn1, btn2, link, linkm (link message)
        *
        * How to use it?
        *
        * $this->load->model('generic_model');
        * $this->generic_model->set_the_flash_variables_for_modal($title, $message, $btn1, $btn2, $link, $linkm);
        *
        * What does it return?
        *
        * It does not return any value
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->session->set_flashdata('title', $title);
        $this->session->set_flashdata('message', $message);
        if ($btn1 != NULL) {
            $this->session->set_flashdata('btn1', $btn1);
        }
        if ($btn2 != NULL) {
            $this->session->set_flashdata('btn2', $btn2);
        }
        if ($link != NULL) {
            $this->session->set_flashdata('link', $link);
        }
        if ($linkm != NULL) {
            $this->session->set_flashdata('linkm', $linkm);
        }
    }
    public function get_the_id_of($data, $field)
    {
        /*
        * What does it do?
        *
        * It inserts a new record with the received data in the received table
        *
        * If $check_integrity == TRUE the items that do not match with the
        * table's fields will be remove before the data insertion,for this
        * is used the method "get_columns_of_table"
        *
        * If $check_integrity == FALSE the items must match with the table's fields
        * or an error will raise
        *
        * It requires a "create" user profile
        *
        * How to use it?
        *
        
        * $table = 'my_table';
        * $data = array(
        *    'name' => 'Roger',
        *    'username' => 'roger',
        *    'email' => 'roger@mail.com'
        * );
        * $this->load->model('generic_model');
        * $result = $this->generic_model->insert_a_new_record($table:STRING, $data:ARRAY, $check_integrity:TRUE/FALSE);
        *
        * What does it return?
        *
        * If the insertion was successful (affected_rows==1): TRUE
        * If the insertion failed (affected_rows!=1): FALSE
        *
        */

        /*
        * Instructions:
        
        * $field = array(
        *     'key' => 'category',
        *     'value' => 'Computers'
        * );
        * //$data is the array with the records
        * $this->load->model('generic_model');
        * $this->generic_model->get_the_id_of($data, $field);
        */
        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        foreach ($data as $record) {
            if ($record[$field['field']] == $field['value']) {
                return $record['id'];
            }
        }
    }
    public function get_the_value_of($data, $id, $field)
    {
        /*
        * What does it do?
        *
        * It inserts a new record with the received data in the received table
        *
        * If $check_integrity == TRUE the items that do not match with the
        * table's fields will be remove before the data insertion,for this
        * is used the method "get_columns_of_table"
        *
        * If $check_integrity == FALSE the items must match with the table's fields
        * or an error will raise
        *
        * It requires a "create" user profile
        *
        * How to use it?
        *
        
        * $table = 'my_table';
        * $data = array(
        *    'name' => 'Roger',
        *    'username' => 'roger',
        *    'email' => 'roger@mail.com'
        * );
        * $this->load->model('generic_model');
        * $result = $this->generic_model->insert_a_new_record($table:STRING, $data:ARRAY, $check_integrity:TRUE/FALSE);
        *
        * What does it return?
        *
        * If the insertion was successful (affected_rows==1): TRUE
        * If the insertion failed (affected_rows!=1): FALSE
        *
        */

        /*
        * Instructions:
        
        * //$data is the array with the records
        * $id = 4;
        * $field ='category'; 
        * $this->load->model('generic_model');
        * $this->generic_model->get_the_value_of($data, $id);
        */
        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        foreach ($data as $record) {
            if ($record['id'] == $id) {
                return $record[$field];
            }
        }
    }
    public function get_columns_of_table($table)
    {
        /*
        * What does it do?
        *
        * It reads the table's columns
        *
        * It requires a "read" user profile
        *
        * How to use it?
        *
        * $this->load->model('generic_model');
        * $result = $this->generic_model->get_columns_of_table($table:STRING);
        *
        * What does it return?
        *
        * If the execution is sucessfull: $columns:ARRAY
        * If the execution failed: FALSE
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('read');

        $query = $this->db->query("SHOW COLUMNS FROM $table");
        $result = $query->result_array();

        $this->db->close();

        if ($result) {
            foreach ($result as $items) {
                $columns[] = $items['Field'];
            }
            return $columns;
        } else {
            return FALSE;
        }
    }
    public function default_redirection()
    {
        /*
        * What does it do?
        *
        * It centralizes the redirection process
        *
        * How to use it?
        *
        
        * $result = $this->generic_model->default_redirection();
        *
        * What does it return?
        *
        * It does not return any value
        * It executes the redirection
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);
        if (isset($_SESSION['next_page'])) {
            redirect($_SESSION['next_page']);
            // } elseif (isset($_SESSION['last_page'])) {
            //     redirect($_SESSION['last_page']);
        } else {
            //Redirection by default
            redirect(base_url('users/user_information'));
        }
    }
    public function reset_id($table)
    {
        /*
        * What does it do?
        *
        * It resets the autoincremented field "id" in the received table
        *
        * It requires a "create" user profile
        *
        * How to use it?
        *
        
        * $table = 'my_table';
        * $this->load->model('generic_model');
        * $result = $this->generic_model->reset_id($table:STRING);
        *
        * What does it return?
        *
        * If the statement was executed successfully: TRUE
        * If the execution failed: FALSE
        *
        */
        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $this->load->database('master');

        $sql = "ALTER TABLE `" . $table . "` MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
        $result = $this->db->query($sql);
        $this->db->close();
        if ($result) {
            $this->reporting_model->register_event("reset id", $table);
            return $result;
        } else {
            return FALSE;
        }
    }
    public function admin_routine($section_parameters = FALSE, $content = FALSE, $id = FALSE)
    {
        /*
        * What does it do?
        *
        * 
        * How to use it?
        *
        *
        * What does it return?
        * 
        *
        */

        $this->reporting_model->execution_trace(get_class(), __FUNCTION__);

        $section_parameters['activated'] = 1;
        $section_parameters['role<='] = $_SESSION['user']['role'];
        $section_parameters['deleted'] = 0;

        //Checking if the generic controller is allowed to this section
        if ($section_parameters['section'] == 'Generic_crud') {
            $section_parameters['generic_activated'] = 1;
        }

        //Checking the user session
        $this->login_model->check_session_validity();

        //Checking if the section is activated and if the user is authorized
        if (!$result = $this->generic_model->read_records('sections_admin', $section_parameters)) {
            $this->set_the_flash_variables_for_modal('Sorry', "The intended page is inaccessible", NULL, 'Ok');
            $this->default_redirection();
        }
        $this->data['sections_admin'] = $result[0];

        //Filling the content item
        if ($content) {
            if ($section_parameters['process'] == 'read_all') {
                $this->data['sections_admin']['content'] = $this->read_all_records($this->data['sections_admin']['table_section']);
            } elseif ($section_parameters['process'] == 'update') {
                if (!$this->data['sections_admin']['content'] = $this->read_a_record_by_id($this->data['sections_admin']['table_section'], $id)) {
                    //Reload the controller
                    $this->generic_model->set_the_flash_variables_for_modal('Sorry', 'There was a problem and the selected item could not be loaded', NULL, 'Ok');
                    $this->default_redirection();
                }
            }
        }

        //Filling the company_data item
        $this->data['company_data'] = $this->read_a_record_by_id('company_data', 1);

        //Getting the table's columns
        if (isset($section_parameters['generic_activated'])) {
            if ($section_parameters['generic_activated']) {
                $this->data['sections_admin']['columns'] = $this->get_columns_of_table($this->data['sections_admin']['table_section']);
            }
        }

        //Ordering the dependencies
        if ($this->data['sections_admin']['dependencies']) {
            $this->data['sections_admin']['dependencies'] = explode(',', $this->data['sections_admin']['dependencies']);
            $dependencies = array();
            foreach ($this->data['sections_admin']['dependencies'] as $key => $value) {
                $dependencies[$value] = TRUE;
            }
            unset($this->data['sections_admin']['dependencies']);
            $this->data['sections_admin']['dependencies'] = $dependencies;
        } else {
            $this->data['sections_admin']['dependencies'] = array();
        }

        //Ordering the don't show values
        if ($this->data['sections_admin']['dont_show'] == NULL) {
            $this->data['sections_admin']['dont_show'] = array();
        } else {
            $dont_show = $this->read_records('dont_show', array('identifier' => $this->data['sections_admin']['dont_show']));
            if ($dont_show[0]) {
                $this->data['sections_admin']['dont_show'] = explode(",", $dont_show[0]['dont_show']);
            } else {
                $this->data['sections_admin']['dont_show'] = array();
            }
        }

        //Getting the menu_admin items
        $this->data['items_menu'] = $this->read_records('menu_admin', array('role<=' => $_SESSION['user']['role']));

        //Unsetting data from sections_activated
        $unset = array('id', 'section', 'process', 'activated', 'generic_activated', 'role', 'deleted');
        foreach ($unset as $value) {
            unset($this->data['sections_admin'][$value]);
        }

        //Unsetting data from items_menu
        $unset = array('id', 'role', 'deleted');
        foreach ($unset as $value) {
            unset($this->data['items_menu'][$value]);
        }

        return $this->data;
    }
    public function check_date($date = NULL)
    {
        $date_fields = explode('-', $date);
        if (count($date_fields) == 3 && checkdate($date_fields[1], $date_fields[2], $date_fields[0])) {
            return true;
        }
        return false;
    }
    public function send_email($subject, $to, $sender, $content)
    {
        /*
        * What does it do?
        *
        * The method's function is to send an html email
        * 
        * How to use it?
        * 
        * $this->generic_model->send_email($subject, $to, $sender, $content);
        *
        * What does it return?
        *
        * The method has the single function of mailing
        */

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= "From: " . $sender;

        mail($to, $subject, $content, $headers);
    }
}
