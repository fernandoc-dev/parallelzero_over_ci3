<?php
$this->load->library('form_validation');
//Receive the data from the Updating form
//Check the validation rules
$this->form_validation->set_rules(
    'updating_form_id',
    'id',
    'trim|required|max_length[100]',
);
$this->form_validation->set_rules(
    'updating_form_complete_name',
    'name',
    'trim|required|max_length[50]',
    array(
        'required'      => 'The %s is required.',
        'max_length'     => 'The max lenght allowed for the %s is 50 characteres.'
    )
);
$this->form_validation->set_rules(
    'updating_form_username',
    'username',
    'trim|required|max_length[50]',
    array(
        'required'      => 'The %s is required.',
        'max_length'     => 'The max lenght allowed for the %s is 50 characteres.'
    )
);
$this->form_validation->set_rules(
    'updating_form_email',
    'email',
    'trim|required|valid_email|max_length[50]',
    array(
        'required'      => 'The email is required.',
        'max_length'     => 'The max lenght allowed for the %s is 50 characteres.'
    )
);
$this->form_validation->set_rules(
    'updating_form_role',
    'role',
    'trim|required|max_length[50]',
);
