<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form extends CI_Controller
{
    public function get_message()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data = $this->input->post(NULL, TRUE);
            $message = "Name: " . $data['name'] . " / Email: " . $data['email'] . " / Message: " . $data['message'];
            $this->load->library('email');
            $this->email->from('fer@fernandoc.dev', 'Fernando');
            $this->email->to('fernandocarrillos86@gmail.com');
            $this->email->subject('Message from the web');
            $this->email->message($message);
            $this->email->send();
            echo 'The message was receipt';
        } else {
            redirect(base_url());
        }
    }
}
