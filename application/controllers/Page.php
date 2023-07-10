<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Page extends CI_Controller {

	function __construct(){
        parent::__construct();
		$this->load->library('user_agent');
        $this->load->model('Site_settings_model');
        $this->load->model('Csrf_model');
        $this->load->model('User_model');

        $data = $this->User_model->getCurrency();
        define('CURRENCY', $data['currency']);
    }
    public function login(){
        if(isset($_COOKIE['remember_login'])) {
            $userCookieData = $this->User_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
            $last_url = $this->input->get('return');
            if (isset($userCookieData)) {
                $this->session->set_userdata('user_id', $userCookieData['user_id']);
                $this->session->set_userdata($userCookieData['user_type'], $userCookieData['user_type']);
                $this->session->set_userdata('username', $userCookieData['username']);

                $message = 'Logged in using remember token cookie.';
                $this->User_model->insertActivityLog($message); 


                if ($last_url != '') {
                    header('location:'.base_url( ).$last_url);
                }
                else{
                    header('location:'.base_url('account/dashboard'));
                }

            }
            else{
                unset($_COOKIE['remember_login']); 
                setcookie('remember_login', '', time() - 3600, '/');
                $session = array(
                    'user_id', 
                    'username',
                );
                $this->session->unset_userdata($session);
                header('location:'.base_url('login?return=').uri_string());
            }
        }
        else if (!isset($this->session->user_id)) {
            $data['siteSetting'] = $this->Site_settings_model->siteSettings();
            $data['social_media'] = $this->Site_settings_model->getSocialMedias();
            $data['title'] = 'Login';
            $data['description'] = 'Login your account.';
            $data['canonical_url'] = base_url('login');
            $data['url_param'] = "";
            $data['state'] = "login";
            $data['login_token'] = base64_encode( openssl_random_pseudo_bytes(32)); /* generated token */
            $data['csrf_data'] = $this->Csrf_model->getCsrfData();
            $this->load->view('account/header', $data);
            $this->load->view('account/user/nav');
            $this->load->view('account/login');
            $this->load->view('home/footer');
        }
        else{
           header('location:'.base_url('account/dashboard')); 
        }
    }
    public function dashboard(){
        if (isset($this->session->admin)) {
            $data['siteSetting'] = $this->Site_settings_model->siteSettings();
            $data['social_media'] = $this->Site_settings_model->getSocialMedias();
            $data['title'] = 'Dashboard';
            $data['description'] = 'Login your account.';
            $data['canonical_url'] = base_url('account/dashboard');
            $data['url_param'] = "";
            $data['state'] = "dashboard";
            $data['csrf_data'] = $this->Csrf_model->getCsrfData();
            $data['user_data'] = $this->User_model->getUserData(); 
            $this->load->view('account/header', $data);
            $this->load->view('account/nav');
            $this->load->view('account/dashboard');
            $this->load->view('account/footer');
        }
        else if (isset($this->session->user)) {
            $data['siteSetting'] = $this->Site_settings_model->siteSettings();
            $data['social_media'] = $this->Site_settings_model->getSocialMedias();
            $data['title'] = 'Dashboard';
            $data['description'] = 'Login your account.';
            $data['canonical_url'] = base_url('account/dashboard');
            $data['url_param'] = "";
            $data['state'] = "dashboard";
            $data['csrf_data'] = $this->Csrf_model->getCsrfData();
            $data['user_data'] = $this->User_model->getUserData(); 
            $this->load->view('account/user/header', $data);
            $this->load->view('account/user/nav');
            $this->load->view('account/user/dashboard');
            $this->load->view('account/user/footer');
        }
        else{
            header('location:'.base_url('login?return=').uri_string());
        }
    }
    public function settings(){
        if (isset($this->session->user_id)) {
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['title'] = 'Account Settings';
        $data['description'] = 'Account Settings ';
        $data['canonical_url'] = base_url('account/settings');
        $data['state'] = "settings";
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
        $data['user_data'] = $this->User_model->getUserData(); 
    	$this->load->view('account/user/header', $data);
    	$this->load->view('account/user/nav');
    	$this->load->view('account/settings');
    	$this->load->view('account/user/footer');
        }
        else{
            header('location:'.base_url('login?return=').uri_string());
        }
    }
    public function usersList(){
        if (isset($this->session->admin)) {
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['title'] = 'User Management';
        $data['description'] = 'User Management';
        $data['canonical_url'] = base_url('users-list');
        $data['url_param'] = "";
        $data['state'] = "users_list";
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
        $data['user_data'] = $this->User_model->getUserData(); 
    	$this->load->view('account/header', $data);
    	$this->load->view('account/nav');
    	$this->load->view('account/users_list');
    	$this->load->view('account/footer');
        }
        else{
            header('location:'.base_url('login?return=').uri_string());
        }
    }
    






    public function logout(){
        unset($_COOKIE['remember_login']); 
        setcookie('remember_login', '', time() - 3600, '/');
        $session = array(
            'user_id', 
            'username',
            'admin',
            'sys_admin',
            'staff',
            'super_staff',
            'borrower',
        );
        $this->session->unset_userdata($session);
        $this->session->sess_destroy();
        header('location:'.base_url('login'));
    }
}