<?php
class Load_views extends CI_Controller
{

    function test()
    {
        return $this->load->View('admin/adminlte/adminlte3.1.0/common_files/openning/01_open_html');
    }
    // function load_first_group_of_views($data)
    // {
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/openning/01_open_html', $data);
    //     //load_header_dependencies($data);
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/openning/02_head');
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/openning/03_open_body_and_wrapper');
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/openning/04_messages_notification_list');
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/openning/05_sidebar_menu');
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/openning/06_open_content_wrapper');
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/openning/07_content_header');
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/openning/08_open_content_container_fluid');
    // }
    // function load_second_group_of_views($data)
    // {
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/closing/01_close_content_container_fluid');
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/closing/02_close_content_wrapper');
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/closing/03_close_wrapper');
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/closing/04_footer');
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/closing/05_sidebar');
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/closing/06_scripts');
    //     //load_closing_dependencies($data);
    //     $this->load->View('admin/adminlte/adminlte3.1.0/common_files/closing/07_close_body_and_html');
    // }
}
