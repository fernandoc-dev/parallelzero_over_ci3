<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Getting_pictures_for_Blog extends CI_Controller
{
    public function index()
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
