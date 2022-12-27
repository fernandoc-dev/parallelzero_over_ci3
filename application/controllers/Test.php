<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->model('generic_model');
    }
    public function index()
    {
        // $this->benchmark->mark('my_mark_start');

        // //test

        // echo date('d/m/Y H:i', strtotime('2022-06-10 09:50:15'));

        // //test


        // // var_dump($result);

        // $this->benchmark->mark('my_mark_end');
        // echo "<br><br>";
        // echo 'Tiempo de ejecución: ' . $this->benchmark->elapsed_time('my_mark_start', 'my_mark_end');
        // $query = $this->db->query("SELECT lessons.id, courses.course FROM lessons JOIN courses ON lessons.course=courses.id WHERE lessons.id=1");
        // $result = $query->result_array();
        $result = $this->generic_model->read_join("lessons", "courses", "lessons.course=courses.id");
        var_dump($result);
    }
}
