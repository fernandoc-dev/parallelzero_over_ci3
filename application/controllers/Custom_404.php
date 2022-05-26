<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custom_404 extends CI_Controller
{
    public function __construct() //Método constructor
    {
        parent::__construct();
    }
    public function index()
    {
        echo "ESTE ES MI CONTROLADOR 404";
    }
}
