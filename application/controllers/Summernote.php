<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Summernote extends CI_Controller
{

    public function index()
    {
        $this->load->View('summernote');
    }
    public function get_pictures()
    {
        if (empty($_FILES['file'])) {
            exit();
        }
        $errorImgFile = "./img/img_upload_error.jpg";
        $temp = explode(".", $_FILES["file"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $destinationFilePath = './uploads/' . $newfilename;
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $destinationFilePath)) {
            echo $errorImgFile;
        } else {
            echo $destinationFilePath;
        }
    }
}
