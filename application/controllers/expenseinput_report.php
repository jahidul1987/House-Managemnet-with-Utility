<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expenseinput_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
    }

    public function index() {

        if (in_array($this->session->userdata('role_id'), array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17))):
            $data['base_url'] = $this->config->item('base_url');
            $data['active_menu'] = 'Accounts';
            $data['active_sub_menu'] = 'Reference Report';

            $table_name = 'employee_expense';
            $data['reference_data'] = $this->common_model->getData($table_name);

            $table_name = 'employee_expense';
            $data['reference_name'] = $this->common_model->getData($table_name);

            $this->load->view('common/header', $data);
            $this->load->view('expenseinput_report/expenseinput_report', $data);
            $this->load->view('common/footer', $data);
      
            $this->load->view('expenseinput_report/js_expenseinput_report', $data);
            $this->session->unset_userdata('msg_title');
            $this->session->unset_userdata('msg_body');
        else:
            redirect('home');
        endif;
    }

    public function searchData() {

        if (in_array($this->session->userdata('role_id'), array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17))):
            $data['base_url'] = $this->config->item('base_url');
            $data['active_menu'] = 'Accounts';
            $data['active_sub_menu'] = 'Reference Report';

            $table_name = 'employee_expense';


            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');

            $emp_id = $this->session->userdata('emp_id');
            $role_id = $this->session->userdata('role_id');
            if ($role_id == 1 || $role_id == 2) {
                if ($date_from != "" && $date_to != ""):
                    $result = $this->db->query("select * from employee_expense where (date(`date`) between '$date_from' and '$date_to') ");
                    $data['reference_data'] = $result->result();


                else:
                    $table_name = 'employee_expense';
                    $data['reference_data'] = $this->common_model->getData($table_name);
                endif;
            }
else
{
    
     if ($date_from != "" && $date_to != ""):
                    $result = $this->db->query("select * from employee_expense where (date(`date`) between '$date_from' and '$date_to') and employee_id='$emp_id' ");
                    $data['reference_data'] = $result->result();


                else:
                     $result = $this->db->query("select * from employee_expense where employee_id='$emp_id' ");
                    $data['reference_data'] = $result->result();
                endif;
}
            $this->load->view('common/header', $data);
            $this->load->view('expenseinput_report/expenseinput_report', $data);
            $this->load->view('common/footer', $data);
            $this->load->view('common/js', $data);
            $this->load->view('expenseinput_report/js_expenseinput_report', $data);
            $this->session->unset_userdata('msg_title');
            $this->session->unset_userdata('msg_body');
        else:
            redirect('home');
        endif;
    }

}

?>
