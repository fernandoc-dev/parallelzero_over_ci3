<?php
$this->load->library('form_validation');
//Receive tha data from the LogIn form
$this->form_validation->set_rules(
    'username',
    'username',
    'trim|required',
    array(
        'required' => 'The %s is required.'
    )
);
$this->form_validation->set_rules(
    'password',
    'password',
    'trim|required',
    array(
        'required' => 'The %s is required.'
    )
);
