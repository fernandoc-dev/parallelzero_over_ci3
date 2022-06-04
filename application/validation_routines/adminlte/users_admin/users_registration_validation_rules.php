<?php
$this->load->library('form_validation');
$this->load->database('read');
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
    'role',
    'role',
    'trim|required|max_length[50]|in_list[1,2,3,4,5,6]',
);
