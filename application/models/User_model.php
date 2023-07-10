<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private function hash_password($password)
    {
       return password_hash($password, PASSWORD_BCRYPT);
    }
    public function getCsrfData() 
    {
        $data = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        return $data;
    }
    public function getUserData () 
    {
        if (isset($this->session->user_id)) {
            $query = $this->db->WHERE('user_id', $this->session->user_id)->GET('users_tbl')->row_array();
            if(empty($query['profile_image'])){
                $query['profile_image'] = 'assets/images/default-profile.webp';
            }
            $query['accounts'] = $this->getInitialAccount();
            return $query;
        }
    }
    public function getInitialAccount () 
    {
        return $this->db->WHERE('user_id', $this->session->user_id)->GET('accounts_tbl')->row_array(0);
    }
    public function checkCookie($cookie)
    {
        if ($this->agent->is_mobile()) {
            return $this->db->WHERE('mobile_rem_token', $cookie)
            ->GET('users_tbl')->row_array();
        }
        else{
            return $this->db->WHERE('web_rem_token', $cookie)
            ->GET('users_tbl')->row_array();
        }
    }
    public function insertActivityLog ($message) 
    {
        if (isset($this->session->user_id)) {
            $activity_log = array(
                'user_id'=>$this->session->user_id, 
                'message_log'=>$message, 
                'ip_address'=>$this->input->ip_address(), 
                'platform'=>$this->agent->platform(), 
                'browser'=>$this->agent->browser(), 
                'created_at'=>date('Y-m-d H:i:s')
            ); 
            $this->db->INSERT('activity_logs_tbl', $activity_log);
        }
    }

    public function getCashflow($row_per_page, $row_no)
    {
        if (isset($this->session->user)) {
            $search = $this->input->get('search');
            $query = $this->db->SELECT('cft.*, ct.category_name')
                ->FROM('cash_flow_tbl as cft')
                ->JOIN('category_tbl as ct', 'ct.category_id = cft.category_id','left')
                ->WHERE("(cft.description LIKE '%".$search."%' OR cft.amount LIKE '%".$search."%' OR ct.category_name LIKE '%".$search."%' )", NULL, FALSE)
                ->WHERE('cft.status', 'active')
                ->WHERE('cft.user_id', $this->session->user_id)
                ->WHERE('account_id',$this->input->get('account_id'))
                ->LIMIT($row_per_page, $row_no)
                ->ORDER_BY('cft.created_at','desc')
                ->GET()->result_array();
            $result = array();

            foreach($query as $q){
                $array = array(
                    'id'=>$q['id'],
                    'type'=>$q['type'],
                    'date'=>$this->getTimeAgo(strtotime($q['date'])),
                    'category'=>$q['category_name'],
                    'description'=>$q['description'],
                    'amount'=>number_format($q['amount'],2),
                    'currency'=>$this->getCurrencySymbol(CURRENCY),
                );
                array_push($result, $array);
            }
            return $result;
        }
    }
    public function getCurrencySymbol($currency)
    {
        if($currency == 'PHP')
        {
            $symbol = '₱';
        }
        return $symbol;
    }
    public function getCashflowCount()
    {
        if (isset($this->session->user)) {
            $search = $this->input->get('search');
            return $this->db
                ->FROM('cash_flow_tbl as cft')
                ->JOIN('category_tbl as ct', 'ct.category_id = cft.category_id','left')
                ->WHERE("(cft.description LIKE '%".$search."%' OR cft.amount LIKE '%".$search."%' OR ct.category_name LIKE '%".$search."%' )", NULL, FALSE)
                ->WHERE('cft.status', 'active')
                ->WHERE('account_id',$this->input->get('account_id'))
                ->ORDER_BY('cft.created_at','desc')
                ->GET()->num_rows();
        }
    }
    public function getCategory()
    {
        if (isset($this->session->user)) {
            $query = $this->db->SELECT('category_id, category_name')
                 ->FROM('category_tbl')
                 ->WHERE('status','active')
                 ->ORDER_BY('category_name','asc')
                 ->GET()->result_array();
            $result = array();
    
            return $query;
        }
    }
    public function addNewCashflowRecord($data_arr)
    {
        if (isset($this->session->user)) {
            $this->db->INSERT('cash_flow_tbl', $data_arr);

            if($this->db->insert_id() > 0)
            {
                $response['status'] = 'success';
                $response['message'] = 'New record added!';
            }
            return $response;
        }

    }
    public function getCurrency()
    {
        return $this->db->SELECT('currency')->WHERE('user_id',$this->session->user_id)->GET('users_tbl')->row_array();
    }
    public function getTimeAgo( $timestamp ) 
    {
        $date = date('Y-m-d', $timestamp);
        if($date == date('Y-m-d')) {
            $date = 'Today';
        } 
        else if($date == date('Y-m-d', strtotime('-1 day'))) {
            $date = 'Yesterday';
        }
        else{
            $date = date('M d', $timestamp);
        }
        return $date;
    }
    public function getCashflowStat() 
    {
        if (isset($this->session->user_id)) {

            $range = $this->input->get('range');
            
            if($range == '7_days') {
                $start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
                $end_date = date('Y-m-d 23:59:59');
                $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
            }

            else if($range == '30_days') {
                $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
                $end_date = date('Y-m-d 23:59:59');
                $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
            }
            else if($range == '1_year') {
                $start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
                $end_date = date('Y-m-d 23:59:59');
                $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
            }
            $expense_stat = $this->getExpenseStatChart();
            $balance_amount = $this->getBalanceStat($date_range);
            $expense = $this->getExpenseStat($date_range);
            $balance = (float)$balance_amount - (float)$expense;
            $savings = (float)$balance - (float)$expense;

            $data['balance'] = number_format($balance, 2);
            $data['expense'] = number_format($expense, 2);
            // $data['savings'] = number_format($savings, 2);
            $data['expense_stat'] = $expense_stat;
            $data['currency'] = $this->getCurrencySymbol(CURRENCY);

            return $data;
        }
    }
    public function getBalanceStat($date_range)
    {   
        $income = $this->db->SELECT('SUM(amount) as amount')
            ->WHERE($date_range)
            ->WHERE('status','active')
            ->WHERE('type','income')
            ->WHERE('user_id',$this->session->user_id)
            ->WHERE('account_id',$this->input->get('account_id'))
            ->GET('cash_flow_tbl')->row_array();

        $initial_balance = $this->db->SELECT('initial_amount')
            ->WHERE($date_range)
            ->WHERE('status','active')
            ->WHERE('user_id',$this->session->user_id)
            ->WHERE('account_id',$this->input->get('account_id'))
            ->GET('accounts_tbl')->row_array();

        $amount = $initial_balance['initial_amount'] + $income['amount'];
        return $amount;
    }
    public function getExpenseStat($date_range)
    {
        $query = $this->db->SELECT('SUM(amount) as amount')
            ->WHERE($date_range)
            ->WHERE('status','active')
            ->WHERE('type','expense')
            ->WHERE('user_id',$this->session->user_id)
            ->WHERE('account_id',$this->input->get('account_id'))
            ->GET('cash_flow_tbl')->row_array();
        $amount = $query['amount'];
        return $amount;
    }
    public function getExpenseStatChart()
    {
        $range = $this->input->get('range');
            
        if($range == '7_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('cft.created_at >'=>$start_date, 'cft.created_at <'=> $end_date);
        }

        else if($range == '30_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('cft.created_at >'=>$start_date, 'cft.created_at <'=> $end_date);
        }
        else if($range == '1_year') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('cft.created_at >'=>$start_date, 'cft.created_at <'=> $end_date);
        }   
		$groupBy = 'category_name';
        $stat_data = $this->db->SELECT('SUM(cft.amount) as amount, ct.category_name')
                ->FROM('cash_flow_tbl as cft')
                ->JOIN('category_tbl as ct', 'ct.category_id = cft.category_id','left')
                ->WHERE('cft.status', 'active')
                ->WHERE('cft.type', 'expense')
                ->GROUP_BY($groupBy)
                ->WHERE($date_range)
                ->WHERE('account_id',$this->input->get('account_id'))
                ->WHERE('user_id',$this->session->user_id)
                ->ORDER_BY('cft.created_at','desc')
                ->GET()->result_array();
		$result = array();
		foreach($stat_data as $q){
			$array = array(
				'amount'=>$q['amount'],
				'category_name'=>$q['category_name']
			);
			array_push($result, $array);
		}
		return $result;
    }
    public function getCashflowDetails()
    {
        $query = $this->db->SELECT('cft.id, cft.account_id, at.name as account_name, type, cft.amount, date, cft.category_id, category_name, description')
        ->FROM('cash_flow_tbl as cft')
        ->JOIN('category_tbl as ct', 'ct.category_id = cft.category_id','left')
        ->JOIN('accounts_tbl as at', 'at.account_id = cft.account_id','left')
        ->WHERE('cft.status', 'active')
        ->WHERE('cft.user_id',$this->session->user_id)
        ->WHERE('cft.id', $this->input->get('id'))
        ->GET()->row_array();

        $query['date'] = date('m/d/Y', strtotime($query['date']));
        return $query;
    }
    public function updateNewCashflowRecord($data_arr)
    {
        $this->db->WHERE('id', $this->input->post('id'))
            ->WHERE('user_id', $this->session->user_id)
            ->UPDATE('cash_flow_tbl', $data_arr);
        
        $response['status'] = 'success';
        $response['message'] = 'Record succesfully updated!';
        return $response;
    }
    public function getAccountType()
    {
        if (isset($this->session->user)) {
            $query = $this->db->SELECT('id, type')
                 ->FROM('account_type_tbl')
                 ->WHERE('status','active')
                 ->ORDER_BY('type','asc')
                 ->GET()->result_array();
            $result = array();
    
            return $query;
        }
    }
    public function addNewAccount($data_arr)
    {
        if (isset($this->session->user)) {
            $query = $this->db->INSERT('accounts_tbl', $data_arr);
            if($this->db->insert_id() > 0)
            {
                $response['status'] = 'success';
                $response['message'] = 'Account added!';
            }
            return $response;
        }
    }
    public function getAccounts()
    {
        $query = $this->db->WHERE('user_id', $this->session->user_id)
            ->FROM('accounts_tbl')
            ->GET()->result_array();
        return $query;
    }
    public function getAccountsList()
    {
        $query = $this->db->SELECT('account_id, name')->WHERE('user_id', $this->session->user_id)
            ->FROM('accounts_tbl')
            ->GET()->result_array();
        return $query;
    }
    public function getAccountBalance($account_id)
    {
         $query = $this->db->SELECT('amount')
            ->WHERE('account_id',$account_id)
            ->GET('accounts_tbl')->row_array();
        $amount = $query['amount'];
        return $amount;
    }
    public function updateAccountBalanceSheet($total_balance, $account_id){
        $data_arr = array(
            'amount'=>$total_balance,
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $this->db->WHERE('account_id',$account_id)->WHERE('user_id',$this->session->user_id)
            ->UPDATE('accounts_tbl', $data_arr);
    }








    public function addUser(){
        if (isset($this->session->user_id)) {
            $password = '123456';
            $dataArr = array(
                'name'=>$this->input->post('name'),
                'password'=>$this->hash_password($password),
                'username'=>$this->input->post('username'),
                'user_type'=>$this->input->post('user_type'),
                'email_address'=>$this->input->post('email_address'),
                'mobile_number'=>$this->input->post('mobile_number'),
                'created_at'=>date('Y-m-d H:i:s'),
            );
    
            $this->db->INSERT('users_tbl', $dataArr);
            $id = $this->db->insert_id();
            $this->generateUserID($id);
            $message = 'Added User ID#'.$id.' name: '.$this->input->post('fname').' '.$this->input->post('lname') ;
            $this->insertActivityLog($message); 
        }
    }
    public function generateUserID ($id, $length = 9) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $temp_id = '';
        for ($i = 0; $i < $length; $i++) {
            $temp_id .= $characters[rand(0, $charactersLength - 1)];
        }
        $rand = rand(1, 100);
        $user_id = '100'.$rand.$id.$temp_id;
        $dataArr = array('user_id'=>$user_id);
        $this->db->WHERE('id',$id)->UPDATE('users_tbl',$dataArr);
    }
    public function getUsers($row_per_page, $row_no){
        if (isset($this->session->user_id)) {
            $search = $this->input->get('search');
            $query = $this->db->SELECT('user_id, user_type, name, username, email_address, mobile_number, status, created_at')
                ->WHERE("(username LIKE '%".$search."%' OR name LIKE '%".$search."%' OR email_address LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
                // ->WHERE_NOT_IN('user_type','admin')
                ->LIMIT($row_per_page, $row_no)
                ->ORDER_BY('created_at','desc')
                ->GET('users_tbl')->result_array();
            $result = array();

            foreach($query as $q){
                $array = array(
                    'user_id'=>$q['user_id'],
                    'user_type'=>$q['user_type'],
                    'username'=>$q['username'],
                    'name'=>ucwords($q['name']),
                    'email_address'=>$q['email_address'],
                    'mobile_number'=>$q['mobile_number'],
                    'status'=>$q['status'],
                    'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
            return $result;
        }
    }
    public function getUsersCount(){
        if (isset($this->session->user_id)) {
            $search = $this->input->get('search');
            return $this->db->WHERE("(username LIKE '%".$search."%' OR name LIKE '%".$search."%' OR email_address LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
                // ->WHERE_NOT_IN($admins)
                ->ORDER_BY('created_at','desc')
                ->GET('users_tbl')->num_rows();
        }
    }
    public function updateUserStatus() {
        if (isset($this->session->user_id)) {
            $user_data = $this->db->SELECT('user_id')->WHERE('user_id', $this->input->post('id'))->GET('users_tbl')->row_array();
            $status = $this->input->post('status');
            $dataArr = array('status'=>$status,'updated_at'=>date('Y-m-d H:i:s'));
            if ($status == 'disabled' && $this->session->user_id == $user_data['user_id'] && $user_data['user_type'] == 'admin') {
                $response['status'] = 'error';
                $response['message'] = 'Action not allowed!';
            }
            else{
                $this->db->WHERE('user_id', $this->input->post('id'))->UPDATE('users_tbl', $dataArr);
                $response['status'] = 'success';
                $response['message'] = 'User status change to '.$status.'.';
            }
            return $response;
        }
    }
    public function deleteUser() {
        if (isset($this->session->user_id)) {
            $user_data = $this->db->SELECT('user_id, username, user_type')->WHERE('user_id', $this->input->post('id'))->GET('users_tbl')->row_array();

            if ($this->session->user_id == $user_data['user_id'] && $user_data['user_type'] == 'admin') {
                $response['status'] = 'error';
                $response['message'] = 'Action not allowed!';

                // activity logs
                $message = 'Deleting User Attempt. User ID#'.$user_data['user_id'].' Username: '.$user_data['username'].' User Type: '.$user_data['user_type'] ;
                $this->insertActivityLog($message);
            }
            
            else{
                $this->db->WHERE('user_id', $this->input->post('id'))->DELETE('users_tbl');
                $response['status'] = 'success';
                $response['message'] = 'User '.$user_data['username'].' was successfully deleted!';
                
                // activity logs
                $message = 'Deleted User ID#'.$user_data['user_id'].' Username: '.$user_data['username'].' User Type: '.$user_data['user_type'] ;
                $this->insertActivityLog($message);
            }
            return $response;
        }
    }
    public function getData() {
        if (isset($this->session->user_id)) {
            $user_data = $this->db->SELECT('user_id, name, email_address, user_type, mobile_number, username')->WHERE('user_id', $this->input->get('id'))->GET('users_tbl')->row_array();
            return $user_data;
        }
    }
    public function checkEmail($email_address, $user_id){
        if (isset($this->session->admin)) {
            $data = array($user_id);
            return $this->db
            ->WHERE('user_id !=', $user_id)
            ->WHERE('email_address', $email_address)
            ->GET('users_tbl')->num_rows();
        }
    }
    public function checkUsername($username, $user_id){
        if (isset($this->session->user_id)) {
            return $this->db->WHERE('username', $username)
            ->WHERE('user_id !=', $user_id)
            ->GET('users_tbl')->num_rows();
        }
    }
    public function checkMobileNUmber($mobile_number, $user_id){
        if (isset($this->session->user_id) && $mobile_number !== '') {
            return $this->db->WHERE('mobile_number', $mobile_number)
            ->WHERE('user_id !=', $user_id)
            ->GET('users_tbl')->num_rows();
        }
    }
    public function getUserDataByUserID($user_id){
        if (isset($this->session->admin) || isset($this->session->staff) || isset($this->session->sys_admin)) {
            return $this->db->WHERE('user_id', $user_id)->GET('users_tbl')->row_array();
        }
    }
    public function editUser(){
        if (isset($this->session->admin)) {
            $id = $this->input->post('user_id');
            $dataArr = array(
                'name'=>$this->input->post('name'),
                'username'=>$this->input->post('username'),
                'email_address'=>$this->input->post('email_address'),
                'mobile_number'=>$this->input->post('mobile_number'),
                'updated_at'=>date('Y-m-d H:i:s'),
            );
            $this->db->WHERE('user_id', $id)->UPDATE('users_tbl', $dataArr);

            $message = 'Updated User @'.$this->input->post('username').'. User ID '.$id;
            $this->insertActivityLog($message); 
        }
    }
    public function checkUsernameRecovery(){
        $username = $this->input->post('user_email');
        $query = $this->db->WHERE('username', $username)
            ->OR_WHERE('mobile_number',$username)
            ->OR_WHERE('email_address',$username)
            ->GET('users_tbl')->row_array();
        if(!empty($query)){
            $response['status'] = 'success';
            $response['message'] = 'User Found!';
        }
        else{
            $response['status'] = 'error';
            $response['message'] = 'User does not exist!';
        }
        return $response;
    }
    public function changePasword(){
        $data_arr = array(
            'password'=>$this->hash_password($this->input->post('password')),
            'updated_at'=>date('Y-m-d H:i:s')
        );
        
        $query = $this->db->WHERE('username', $this->session->username)
            ->UPDATE('users_tbl', $data_arr);
    }







}

