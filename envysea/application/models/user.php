<?php

class User extends CI_Model {

	function verify_and_get_user($username, $password) {
		$this->db->select('user_id, username, first_name, last_name, user_level');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		
		$query = $this->db->get('user');
	
		if ($query->num_rows() == 1) {
			//use reference code and dev message for logging/error handling here if needed
			$data['is_true'] = TRUE;
			$data['message'] = $this->config->item('welcome_message');
			$data['query_result'] = $query->result(); 
			//$data['query_result_array'] = $query->result_array(); 
			//$data['reference_code'] = '001';
			//$data['dev_message'] = 'User has logged in';
			return $data;
		} elseif ($query->num_rows() == 0) {
			$data['is_true'] = FALSE;
			$data['message'] = 'The username and password didn\'t match. If you forgot your password, you can recover it '.anchor('members/forgot/password', 'here').'.';
			return $data;
		} elseif ($query->num_rows() > 1) {
			$data['is_true'] = FALSE;
			$data['message'] = 'Dude, something went wrong! Please try again or contact the site administrator.';
			//$data['reference_code'] = '003';
			//$data['dev_message'] = 'The username and password match more than once in the database.';
			return $data;
		} else {
			$data['is_true'] = FALSE;
			$data['message'] = 'Something went wrong! Please try again, if the problem persists, contact a site administrator.';
			//$data['reference_code'] = '004';
			//$data['dev_message'] = 'Database, script, or site failure.';
			return $data;
		}
	}

	function check_username_exist($username) {
		$this->db->select('username');
		$this->db->where('username', $username);
		
		$query = $this->db->get('user');
		
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function check_email_exist($email) {
		$this->db->select('email');
		$this->db->where('email', $email);
		
		$query = $this->db->get('user');
		
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function create_user($new_user_array) {
		$query = $this->db->insert('user', $new_user_array);

		if ($query == TRUE) {
			$data['is_true'] = TRUE;
			$data['message'] = 'A new user has been successfully created.';
			return $data;
		} else {
			$data['is_true'] = FALSE;
			$data['message'] = 'Failed to create user! Please try again, if the problem persists, contact a site admin.';
			return $data;
		}
	}
	
	//get users
	function get_user() {
		$this->db->select('user_id, username');
		
		$query = $this->db->get('user');
		
		if ($query->num_rows() > 0) {
			$data['is_true'] = TRUE;
			$data['query_result'] = $query->result();
			return $data;
		} else {
			$data['is_true'] = FALSE;
			$data['message'] = 'Failed to get users.';
			return $data;
		}
	}
	
	//get user
	function get_user_by_username($username) {
		$this->db->select('user_id, username, first_name, last_name, user_level');
		$this->db->where('username', $username);
		$this->db->limit(1);
		
		$query = $this->db->get('user');
		
		if ($query == TRUE) {
			$data['is_true'] = TRUE;
			$data['query_result'] = $query->result();
			$data['message'] = 'Successfully retrieved user';
			return $data;
		} else {
			$data['is_true'] = FALSE;
			$data['message'] = 'Failed to retrieved user';
			return $data;
		}
	}
	
	function verify_password($user_id, $password) {
		$this->db->select('user_id', 'password');
		$this->db->where('user_id', $user_id);
		$this->db->where('password', $password);
		
		$query = $this->db->get('user');
		
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	
	function update_user($user_id, $item) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->update('user', $item);
	
		if ($query == TRUE) {
			$data['is_true'] = TRUE;
			$data['message'] = 'Successfully updated user.';
			return $data;
		} else {
			$data['is_true'] = FALSE;
			$data['message'] = 'Failed to update usesr.';
			return $data;
		}
	}	
	
	function delete_user($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->delete('user');
		
		if ($query) {
			$data['is_true'] = TRUE;
			$data['message'] = 'Successfully deleted user!';
			return $data;
		} else {
			$data['is_true'] = FALSE;
			$data['message'] = 'Failed to delete user!';
			return $data;
		}
	}
	
	function get_username($email) {
		$this->db->select('username');
		$this->db->where('email', $email);
		
		$query = $this->db->get('user');
		
		if ($query->num_rows() > 0) {
			$data['message'] = 'Successfully retrieved email!';
			$data['is_true'] = TRUE;
			$data['query_result'] = $query->result();
			return $data;
		} else {
			$data['is_true'] = FALSE;
			$data['message'] = 'Failed to find any matching usernames!';
			return $data;
		}
	}
	
	function verify_recover_password($username, $email) {
		$this->db->select('user_id');
		$this->db->where('username', $username);
		$this->db->where('email', $email);
		
		$query = $this->db->get('user');
		
		if ($query->num_rows() == 1) {
			$data['query_result'] = $query->result();
			$data['message'] = 'The username and email match';
			$data['is_true'] = TRUE;
			return $data;
		} elseif ($query->num_rows() > 1) {
			$data['message'] = 'An error has occurred. Please contact a site admin';
			//$data['reference_code'] = '008';
			//$data['dev_message'] = 'User exists in the database twice (username and email)';
			$data['is_true'] = FALSE;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			$data['message'] = 'Failed to find any matching data!';
			return $data;
		}
	}
	
}