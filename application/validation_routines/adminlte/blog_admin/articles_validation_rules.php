<?php
$this->load->database('read');
$this->load->library('form_validation');
$this->form_validation->set_rules(
    'content',
    'content',
    'trim|required|max_length[16777215]',
    array(
        'required'      => 'The %s is required.',
        'max_length'     => 'The max lenght allowed for the %s is 16777215 characteres.'
    )
);
$this->form_validation->set_rules(
    'title',
    'title',
    'trim|required|max_length[255]|is_unique[articles.title]',
    array(
        'required'      => 'The %s is required.',
        'max_length'     => 'The max lenght allowed for the %s is 255 characteres.',
        'is_unique'     => 'This title is already registered, try using other.'
    )
);
$this->form_validation->set_rules(
    'author',
    'author',
    'trim|required|max_length[50]',
    array(
        'required'      => 'The %s is required.',
        'max_length'     => 'The max lenght allowed for the %s is 50 characteres.'
    )
);
$this->form_validation->set_rules(
    'url',
    'url',
    'trim|required|max_length[255]|is_unique[articles.url]',
    array(
        'required'      => 'The %s is required.',
        'max_length'     =>
        'The max lenght allowed for the %s is 255 characteres.',
        'is_unique'     => 'This url is already registered, try using other.'
    )
);
$this->form_validation->set_rules(
    'category',
    'category',
    'trim|required|max_length[100]',
    array(
        'required'      => 'The %s is required.',
        'max_length'     => 'The max lenght allowed for the %s is 100 characteres.'
    )
);
