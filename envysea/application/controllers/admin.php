<?php

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->auth->is_logged_in();
		$this->auth->is_admin();
	}
	
	function index() {
		$data['title'] = 'Admin | Envysea Codeigniter Authentication';
		$data['module'] = 'admin';
		$data['template'] = 'home_view';

		$this->load->view('template', $data);	
	}
	
	//It is normal behavior for this function to display errors
	//To turn the errors off, go into the main index.php and switch the environment from 'production' to 'development'
	function panel($page) {
		if ($page == 'create') {
			$this->auth->create_user('admin');	
		} elseif ($page == 'update') {
			$this->auth->update_user('admin');	
		} elseif ($page == 'delete') {
			$this->auth->delete_user('admin');
		} elseif ($page == 'roles') {
			$this->auth->change_roles();
		} else {
			$data['title'] = 'Admin Panel | Envysea Codeigniter Authentication';
			$data['module'] = 'admin';
			$data['template'] = 'panel_view';

			$this->load->view('template', $data);
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
			$this->form_validation->set_message('_check_email_exist_create', 'The email "'.$email.'" already exists!');
			return FALSE;
		} else {
			return TRUE;
		}
	}	
	
	//required callback -- codeigniter forces these to be in the controller -- this function is private
	function _verify_password($password) {
		$this->load->model('user');
		
		$user_id = $this->session->userdata('user_id');
		
		$result = $this->user->verify_password($user_id, sha1($this->config->item('salty_salt').$password));
		
		if ($result == FALSE) {
			$this->form_validation->set_message('_verify_password', 'Incorrect password submitted.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	
}