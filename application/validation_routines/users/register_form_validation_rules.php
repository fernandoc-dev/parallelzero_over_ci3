<?php
$this->load->library('form_validation');
//Check the validation rules
$this->form_validation->set_rules(
    'name',
    'name',
    'trim|required|max_length[50]',
    array(
        'required'      => 'The %s is required.',
        'max_length'     => 'The max lenght allowed for the %s is 50 characteres.'
    )
);
$this->form_validation->set_rules(
    'username',
    'username',
    'trim|required|max_length[50]|is_unique[users.username]',
    array(
        'required'      => 'The %s is required.',
        'max_length'     => 'The max lenght allowed for the %s is 50 characteres.',
        'is_unique'     => 'The %s is already registered, try using other.',
    )
);
$this->form_validation->set_rules(
    'email',
    'email',
    'trim|required|valid_email|max_length[50]|is_unique[users.email]',
    array(
        'required'      => 'The email is required.',
        'max_length'     => 'The max lenght allowed for the %s is 50 characteres.',
        'is_unique'     => 'The %s is already registered, try using other.',
    )
);
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
