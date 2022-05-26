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
        $this->benchmark->mark('my_mark_start');

        //test

        $birthday = '1986/11/13';
        if ($this->generic_model->check_date($birthday)) {
            $age = (time() - strtotime($birthday)) / 31536000;
            echo '<br>' . $age . '<br>';
            //$this->form_validation->set_message('birthday_check', 'pepe');
            if (!($age < 120 && $age > 4)) {
                echo "No estoy entre 4 y 120 años";
            } else {
                echo "Si es una edad adecuada";
            }
        } else {
            echo "No es una fecha valida";
        }

        //test


        // var_dump($result);

        $this->benchmark->mark('my_mark_end');
        echo "<br><br>";
        echo 'Tiempo de ejecución: ' . $this->benchmark->elapsed_time('my_mark_start', 'my_mark_end');
    }
}
