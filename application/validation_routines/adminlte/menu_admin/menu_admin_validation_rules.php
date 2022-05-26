<?php
$this->load->database('read');
$this->load->library('form_validation');
//Receive the data from the Create admin menu item form
//Check the validation rules
$this->form_validation->set_rules(
    'item',
    'item',
    'trim|required|max_length[50]|is_unique[menu_admin.item]',
    array(
        'required'      => 'The %s is required.',
        'is_unique'     => 'The %s is repeated, try using other word.',
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
