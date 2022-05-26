<?php
$this->load->library('form_validation');
$this->form_validation->set_rules(
    'password',
    'password',
    'trim|required|min_length[5]|max_length[25]',
    array(
        'required'      => 'The password is required.',
        'min_length'      => 'The min lenght allowed for the %s is 5 characteres.',
        'max_length'     => 'The max lenght allowed for the %s is 25 characteres.'
    )
);
$this->form_validation->set_rules(
    'password_confirmation',
    'password confirmation',
    'trim|required|matches[password]',
    array(
        'required'      => 'The %s is required.',
        'matches'     => 'The password field and the confirmation field must match.'
    )
);
