<?php

class Members extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		/* Check session to see if an admin or user is already logged in
		----------------------------------------------------------------*/
		if ($this->session->userdata('is_logged_in') == TRUE && $this->config->item('admin_level') == $this->session->userdata('user_level')) :
			redirect('admin', 'location');
		endif;
		if ($this->session->userdata('is_logged_in') == TRUE && $this->config->item('admin_level') != $this->session->userdata('user_level')) :
			redirect('secure', 'location');
		endif;
	}
	
	function index() {
		$data['title'] = 'Members Description | Envysea Codeigniter Authentication';
		$data['module'] = 'envysea';
		$data['template'] = 'members_view';
	
		$this->load->view('template', $data);
	}
	
	function login() {
		$this->form_validation->set_rules('username', 'Username', 'required|trim|max_length[25]|xss_clean|callback__check_username_exist_login');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|max_length[25]|xss_clean');
	
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Login | Envysea Codeigniter Authentication';
			$data['module'] = 'envysea';
			$data['template'] = 'login_view';
			
			$this->load->view('template', $data);	
		} else {
			$result = $this->auth->login($this->input->post('username'), sha1($this->config->item('salty_salt').$this->input->post('password')));
			
			if ($result['is_true'] == TRUE &&  $result['is_admin'] == TRUE) {
				$this->session->set_flashdata('message', '<div class="success_message">'.$result['message'].'</div>');
				redirect('admin', 'location');
			} elseif ($result['is_true'] == TRUE && $result['is_admin'] == FALSE) {
				$this->session->set_flashdata('message', '<div class="success_message">'.$result['message'].'</div>');
				redirect('secure', 'location');
			} else {
				$data['message'] = '<div class="error_message">'.$result['message'].'</div>';
				$data['title'] = 'Login | Envysea Codeigniter Authentication';
				$data['module'] = 'envysea';
				$data['template'] = 'login_view';
			
				$this->load->view('template', $data);
			}
		}
	}
	
	function create() {
		$this->auth->create_user('join');	
	}
	
	//It is normal behavior for this function to display errors
	//To turn the errors off, go into the main index.php and switch the environment from 'production' to 'development'
	function forgot($page) {
		if ($page == 'username') {
			$this->auth->recover_username();
		} elseif ($page == 'password') {
			$this->auth->recover_password();
		} else {
			$data['title'] = 'Recovery Page | Envysea Codeigniter Authentication';
			$data['module'] = 'envysea';
			$data['template'] = 'forgot_view';

			$this->load->view('template', $data);
		}
	}
	
	//required callback -- codeigniter forces these to be in the controller -- this function is private
	function _check_username_exist_login($username) {
		$this->load->model('user');
		$result = $this->user->check_username_exist($username);
		
		if ($result == FALSE) {
			$this->form_validation->set_message('_check_username_exist_login', 'The username "'.$username .'" doesn\'t even exist! If you forgot your username, you can recover it '.anchor('members/forgot/username', 'here').'.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	//required callback -- codeigniter forces these to be in the controller -- this function is private
	function _check_username_exist_create($username) {
		$this->load->model('user');
		$result = $this->user->check_username_exist($username);
		
		if ($result == TRUE) {
			$this->form_validation->set_message('_check_username_exist_create', 'The username "'.$username.'" already exists! Please pick a different username.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	//required callback -- codeigniter forces these to be in the controller -- this function is private
	function _check_email_exist_create($email) {
		$this->load->model('user');
		$result = $this->user->check_email_exist($email);
		
		if ($result == TRUE) {
			$this->form_validation->set_message('_check_email_exist_create', 'The email "'.$email.'" already exists! If you forgot you login credentials, click '.anchor('members/forgot/password', 'password'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	//required callback -- codeigniter forces these to be in the controller -- this function is private
	function _check_email_exist_forgot($email) {
		$this->load->model('user');
		$result = $this->user->check_email_exist($email);
		
		if ($result == FALSE) {
			$this->form_validation->set_message('_check_email_exist_forgot', 'The email "'.$email.'" doesn\'t even exist! Click '.anchor('members/create', 'here').' to sign up for an account.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}