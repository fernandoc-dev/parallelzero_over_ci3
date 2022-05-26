<?php
$this->load->library('form_validation');
//Check the validation rules
$this->form_validation->set_rules(
    'current_password',
    'current password',
    'trim|required|max_length[25]',
    array(
        'required'      => 'The %s is required.',
        'max_length'     => 'The max lenght allowed for the %s is 25 characteres.'
    )
);
$this->form_validation->set_rules(
    'password',
    'password',
    'trim|required|max_length[25]',
    array(
        'required'      => 'The %s is required.',
        'max_length'    => 'The max lenght allowed for the %s is 25 characteres.'
    )
);
$this->form_validation->set_rules(
    'confirmation',
    'confirmation',
    'trim|required|max_length[25]|matches[password]',
    array(
        'required'      => 'The %s is required.',
        'max_length'    => 'The max lenght allowed for the %s is 25 characteres.',
        'matches'     => 'The password field and the confirmation field must match.'
    )
);
