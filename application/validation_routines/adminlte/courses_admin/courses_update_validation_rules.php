<?php
$this->load->database('read');
$this->load->library('form_validation');
$this->form_validation->set_rules(
    'content',
    'content',
    'trim|required|max_length[16777215]',
    array(
        'required'      => 'The %s is required.',
        'max_length'    => 'The max lenght allowed for the %s is 16777215 characteres.'
    )
);
$this->form_validation->set_rules(
    'title',
    'title',
    'trim|required|max_length[255]|callback_not_repeated_check[title]',
    array(
        'required'      => 'The %s is required.',
        'max_length'    => 'The max lenght allowed for the %s is 255 characteres.'
    )
);
