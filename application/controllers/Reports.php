<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Reports extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Site_settings_model');
        $this->load->model('User_model');
        $this->load->model('Reports_model');
        $this->load->model('Csrf_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function getMonthlySalesReports(){
        $row_no = $this->input->get('page_no');
        // Row per page
        $row_per_page = 10;
        // Row position
        if($row_no != 0){
            $row_no = ($row_no-1) * $row_per_page;
        }
        // All records count
        $all_count = $this->Reports_model->getMonthlySalesReportsCount();
        // Get records
        $result = $this->Reports_model->getMonthlySalesReports($row_per_page, $row_no);
        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/reports/_monthly_sales_reports');
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $all_count;
        $config['per_page'] = $row_per_page;
        // Pagination with bootstrap
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page_no';
        $config['full_tag_open'] = '<ul class="pagination btn-xs">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item ">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#curr">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item disabled">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $config['next_link'] = 'Next'; // change > to 'Next' link
        $config['prev_link'] = 'Previous'; // change < to 'Previous' link
        // Initialize
        $this->pagination->initialize($config);
        // Initialize $data Array
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $this->security->xss_clean($result); 
        $data['row'] = $row_no;
        $data['count'] = $all_count;
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getClientSalesReports(){
        $row_no = $this->input->get('page_no');
        // Row per page
        $row_per_page = 10;
        // Row position
        if($row_no != 0){
            $row_no = ($row_no-1) * $row_per_page;
        }
        // All records count
        $all_count = $this->Reports_model->getClientSalesReportsCount();
        // Get records
        $result = $this->Reports_model->getClientSalesReports($row_per_page, $row_no);
        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/reports/_per_client_monthly_sales_reports');
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $all_count;
        $config['per_page'] = $row_per_page;
        // Pagination with bootstrap
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page_no';
        $config['full_tag_open'] = '<ul class="pagination btn-xs">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item ">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#curr">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item disabled">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $config['next_link'] = 'Next'; // change > to 'Next' link
        $config['prev_link'] = 'Previous'; // change < to 'Previous' link
        // Initialize
        $this->pagination->initialize($config);
        // Initialize $data Array
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $this->security->xss_clean($result); 
        $data['row'] = $row_no;
        $data['count'] = $all_count;
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function addSalesPerClientRemark() {
        $data = $this->Reports_model->addSalesPerClientRemark();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function addDailyReports() {
        $data = $this->Reports_model->addDailyReports();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getActivityLogs(){
        $row_no = $this->input->get('page_no');
        // Row per page
        $row_per_page = 20;
        // Row position
        if($row_no != 0){
            $row_no = ($row_no-1) * $row_per_page;
        }
        // All records count
        $all_count = $this->Reports_model->getActivityLogsCount();
        // Get records
        $result = $this->Reports_model->getActivityLogs($row_per_page, $row_no);
        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/reports/_per_client_monthly_sales_reports');
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $all_count;
        $config['per_page'] = $row_per_page;
        // Pagination with bootstrap
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page_no';
        $config['full_tag_open'] = '<ul class="pagination btn-xs">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item ">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#curr">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item disabled">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $config['next_link'] = 'Next'; // change > to 'Next' link
        $config['prev_link'] = 'Previous'; // change < to 'Previous' link
        // Initialize
        $this->pagination->initialize($config);
        // Initialize $data Array
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $this->security->xss_clean($result); 
        $data['row'] = $row_no;
        $data['count'] = $all_count;
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getDailyReportDataByDate() {
        $data = $this->Reports_model->getDailyReportDataByDate();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
}