<?php
$this->load->library('form_validation');
//Receive the data from the Create admin menu item form
//Check the validation rules
$this->form_validation->set_rules(
    'item',
    'item',
    'trim|required|max_length[50]',
    array(
        'required'      => 'The %s is required.',
        'max_length'    => 'Choose a role from the list.'
    )
);
$this->form_validation->set_rules(
    'role',
    'role',
    'trim|required|in_list[1,2,3,4,5,6]',
    array(
        'required'  => 'The %s is required.',
        'in_list'   => 'Choose a role from the list.'
    )
);
$this->form_validation->set_rules(
    'level',
    'level',
    'trim|required|in_list[1,2]',
    array(
        'required'  => 'The %s is required.',
        'in_list'   => 'Choose a level from the list.'
    )
);
