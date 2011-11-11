<?php

class Account extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->auth->is_logged_in();
	}
	
	function index() {
		$data['title'] = 'Account Settings | Envysea Codeigniter Authentication';
		$data['module'] = 'secure';
		$data['template'] = 'account_view';

		$this->load->view('template', $data);	
	}
	
	function update() {
		$this->auth->update_user('secure');	
	}
	
	function delete() {
		$this->auth->delete_user('secure');
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