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
    'trim|required|max_length[50]',
    array(
        'required'      => 'The %s is required.',
        'max_length'    => 'The max lenght allowed for the %s is 50 characteres.'
    )
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
