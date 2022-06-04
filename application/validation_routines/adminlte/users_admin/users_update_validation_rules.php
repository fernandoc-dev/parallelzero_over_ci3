<?php
$this->load->library('form_validation');
$this->load->database('read');
//Check the validation rules
$this->form_validation->set_rules(
    'id',
    'id',
    'trim|required|max_length[999]',
);
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
    'trim|required|max_length[50]',
    array(
        'required'      => 'The %s is required.',
        'max_length'     => 'The max lenght allowed for the %s is 50 characteres.'
    )
);
$this->form_validation->set_rules(
    'email',
    'email',
    'trim|required|valid_email|max_length[50]',
    array(
        'required'      => 'The email is required.',
        'max_length'     => 'The max lenght allowed for the %s is 50 characteres.'
    )
);
$this->form_validation->set_rules(
    'role',
    'role',
    'trim|required|max_length[50]|in_list[1,2,3,4,5,6]',
);
$this->form_validation->set_rules(
    'username',
    'username',
    'callback_username_check',
);
$this->form_validation->set_rules(
    'birthday',
    'birthday',
    'callback_birthday_check',
    array(
        'birthday_check' => 'The given birthday looks wrong.'
    )
);
