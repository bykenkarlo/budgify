<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class App extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Site_settings_model');
        $this->load->model('User_model');
        $this->load->model('Csrf_model');
        $this->load->library('user_agent');
    }
    public function login(){
        if(isset($this->session->user_id)){
            header('location:'.base_url('account/dashboard')); 
         }
        if (!isset($this->session->user_id)) {
            $data['siteSetting'] = $this->Site_settings_model->siteSettings();
            $data['social_media'] = $this->Site_settings_model->getSocialMedias();
            $data['title'] = 'Login';
            $data['description'] = 'Login your account.';
            $data['canonical_url'] = base_url('');
            $data['url_param'] = "";
            $data['state'] = "login";
            $data['login_token'] = base64_encode( openssl_random_pseudo_bytes(32)); /* generated token */
            $data['csrf_data'] = $this->Csrf_model->getCsrfData();
            $this->load->view('account/header', $data);
            $this->load->view('home/nav');
            $this->load->view('account/login');
            $this->load->view('home/footer');
        }
        else if(isset($_COOKIE['remember_login'])) {
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
        
        
    }
    public function getCsrfData() { 
        $data = $this->Csrf_model->getCsrfData();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
   
}
