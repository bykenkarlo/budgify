<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class User extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Site_settings_model');
        $this->load->model('User_model');
        $this->load->model('Csrf_model');
        $this->load->library('user_agent');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $data = $this->User_model->getCurrency();
        define('CURRENCY', $data['currency']);
       
    }
    public function getCashflow() 
    {
		$row_no = $this->input->get('page_no');
        // Row per page
        $row_per_page = 10;
        // Row position
        if($row_no != 0){
            $row_no = ($row_no-1) * $row_per_page;
        }
        // All records count
        $all_count = $this->User_model->getCashflowCount();
        // Get records
        $result = $this->User_model->getCashflow($row_per_page, $row_no);
        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/user/_get_cashflow');
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $all_count;
        $config['per_page'] = $row_per_page;
        // Pagination with bootstrap
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page_no';
        $config['full_tag_open'] = '<ul class="pagination pagination-rounded mb-0">';
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
        $config['next_link'] = '<span class="next" aria-hidden="true">»</span>'; // change > to 'Next' link
        $config['prev_link'] = '<span class="prev" aria-hidden="true">«</span>'; // change < to 'Previous' link
        // Initialize
        $this->pagination->initialize($config);
        // Initialize $data Array
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $this->security->xss_clean($result); 
        $data['row'] = $row_no;
        $data['count'] = $all_count;
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getCategory() 
    {
        $data = $this->User_model->getCategory();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function addNewCashflowRecord() 
    {
        $amount = $this->input->post('amount');
        $type = $this->input->post('type');
        $account_id = $this->input->post('account_id');
        $date = date('Y-m-d  H:i:s', strtotime($this->input->post('date')));
        if(is_int($amount) || is_float($amount)){
            $response['status'] = 'error';
            $response['message'] = 'Please enter a valid amount!';
        }
        else{
            $data_arr = array(
                'account_id'=>$account_id,
                'user_id'=>$this->session->user_id,
                'category_id'=>$this->input->post('category'),
                'date'=>$date,
                'description'=>$this->input->post('description'),
                'amount'=>$amount,
                'type'=>$type,
                'status'=>'active',
            );

            // $account_balance = $this->User_model->getAccountBalance($account_id);
            // if ($type == 'income')
            // {
            //     $total_balance = $account_balance + $amount;
            // }
            // else if($type == 'expense'){
            //     $total_balance = $account_balance - $amount;
            // }
            // $this->User_model->updateAccountBalanceSheet($total_balance, $account_id);
            $response = $this->User_model->addNewCashflowRecord($data_arr);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function updateNewCashflowRecord() 
    {
        $new_amount = $this->input->post('amount2');
        $prev_amount = $this->input->post('amount');
        $date = date('Y-m-d  H:i:s', strtotime($this->input->post('date')));
        $account_id = $this->input->post('account_id');
        $type = $this->input->post('type');
        if(is_int($new_amount) || is_float($new_amount)){
            $response['status'] = 'error';
            $response['message'] = 'Please enter a valid amount!';
        }
        else{
            $data_arr = array(
                'category_id'=>$this->input->post('category'),
                'date'=>$date,
                'description'=>$this->input->post('description'),
                'amount'=>$new_amount,
                'type'=>$type,
                'status'=>'active',
            );
            $response = $this->User_model->updateNewCashflowRecord($data_arr);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function getCashflowStat() 
    {
        $response = $this->User_model->getCashflowStat();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function getCashflowDetails() 
    {
        $response = $this->User_model->getCashflowDetails();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    
    public function getAccountType() 
    {
        $data = $this->User_model->getAccountType();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function addNewAccount() 
    {
        $amount = $this->input->post('amount');
        $date = date('Y-m-d  H:i:s', strtotime($this->input->post('date')));
        if(is_int($amount) || is_float($amount)){
            $response['status'] = 'error';
            $response['message'] = 'Please enter a valid amount!';
        }
        else{
            $data_arr = array(
                'user_id'=>$this->session->user_id,
                'type_id'=>$this->input->post('type'),
                'name'=>$this->input->post('account_name'),
                'initial_amount'=>$amount,
                'currency'=>$this->input->post('currency'),
                'status'=>'active',
    
            );
            $response = $this->User_model->addNewAccount($data_arr);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function getAccounts() 
    {
        $data = $this->User_model->getAccounts();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getAccountsList() 
    {
        $data = $this->User_model->getAccountsList();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }


    
    

    public function newUser() 
    {
        $email_address = $this->input->post('email_address');
        $mobile_number = $this->input->post('mobile_number');
        $username = $this->input->post('username');

        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users_tbl.username]|min_length[5]|trim|alpha_numeric',
            array(
                'required' => '%s is required!',
                'is_unique'     => 'This %s already exists.'
            )
        );
        if(isset($email_address)){
            $this->form_validation->set_rules('email_address', 'Email Address', 'is_unique[users_tbl.email_address]',
                array(
                    'is_unique'     => 'This %s already exists.'
                )
            );
        }
        if(isset($mobile_number)){
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'is_unique[users_tbl.mobile_number]|min_length[11]|max_length[11]',
                array(
                    'is_unique'     => 'This %s already exists.'
                )
            );
        }
        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'error';
            $response['message'] = $this->form_validation->error_array();
        }
        else{
            $response['status'] = 'success';
            $response['message'] = 'User successfully added!';
            $data = $this->User_model->addUser();
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function getUserList(){
        $row_no = $this->input->get('page_no');
        // Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
            $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->User_model->getUsersCount();

        // Get records
        $result = $this->User_model->getUsers($row_per_page, $row_no);

        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/user/_get_list');
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
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
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
    public function updateUserStatus(){
        $data = $this->User_model->updateUserStatus();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));

        $message = 'Updated User Active Status. User ID#'.$this->input->post('id').'.';
        $this->User_model->insertActivityLog($message); 
    }
    public function deleteUser(){
        $data = $this->User_model->deleteUser();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getData(){
        $data = $this->User_model->getData();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function editUser(){
        $user_id = $this->input->post('user_id');
        $email_address = $this->input->post('email_address');
        $mobile_number = $this->input->post('mobile_number');
        $username = $this->input->post('username');
        $user_type = $this->input->post('user_type');
        $checkEmail = $this->User_model->checkEmail($email_address, $user_id);
        $checkUsername = $this->User_model->checkUsername($username, $user_id);
        $checkMobileNumber = $this->User_model->checkMobileNUmber($mobile_number, $user_id);
        $user_data = $this->User_model->getUserDataByUserID($user_id);

        
        if(!empty($username)){
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|trim|alpha_numeric',
                array(
                    'required' => '%s is required!',
                    'is_unique'     => 'This %s already exists.'
                )
            );
        }
        else if(!empty($email_address)){
            $this->form_validation->set_rules('email_address', 'Email Address','is_unique[users_tbl.email_address]',
                array(
                    'is_unique'     => 'This %s already exists.'

                )
            );
        }
        else if(!empty($mobile_number)){
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'min_length[11]|max_length[11]',
                array(
                    'required' => '%s is required!',
                )
            );
        }

        if (!empty($email_address) && $checkEmail > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Email address already exists!';
        }
        else if ($checkUsername > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Username already exists!';
        }
        else if ($checkMobileNumber > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Mobile number already exists!';
        }
        else if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'error';
            $response['message'] = $this->form_validation->error_array();
        }
        else{
            $response['status'] = 'success';
            $response['message'] = 'User successfully Updated!';
            $data = $this->User_model->editUser();
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function checkUsernameRecovery() {
        $data = $this->User_model->checkUsernameRecovery();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getClientPets() {
        $data = $this->User_model->getClientPets();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function changePasword() {
        $pass = $this->input->post('password');
        $conf_pass = $this->input->post('confirm_password');
        if($pass !== $conf_pass){
            $response['status'] = 'error';
            $response['message'] = 'Password does not match! Try again!';
        }
        else if(strlen($pass) <= 4){
            $response['status'] = 'error';
            $response['message'] = 'Password must be more than 4 characters!';
        }
        else{
            $this->User_model->changePasword();
            $response['status'] = 'success';
            $response['message'] = 'Password successfully updated!';

            $message = 'User updated password.';
            $this->User_model->insertActivityLog($message); 
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
}