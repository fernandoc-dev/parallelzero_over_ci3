<?php
$this->load->library('form_validation');
$this->form_validation->set_rules(
    'email',
    'email',
    'trim|required|valid_email',
    array(
        'required' => 'The %s is required.',
        'valid_email' => 'The %s is not valid.'
    )
);
