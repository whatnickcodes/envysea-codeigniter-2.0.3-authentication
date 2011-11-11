<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Auth {

	protected $CI;
	
	function __construct () {
		$this->CI =& get_instance();
	}
	
	function login($username, $password) {
		$this->CI->load->model('user');
		$result = $this->CI->user->verify_and_get_user($username, $password);
		
		if ($result['is_true'] == TRUE) {
			foreach ($result['query_result'] as $qr);
			
			$session_data =	array(
							'user_id' => $qr->user_id,
							'username' => $qr->username,
							'first_name' => $qr->first_name,
							'last_name' => $qr->last_name,
							'user_level' => $qr->user_level,
							'is_logged_in' => TRUE
							);
			$this->CI->session->set_userdata($session_data);
			
			$data['message'] = $result['message'];
			$data['is_true'] = $result['is_true'];
			$data['is_admin'] = ($qr->user_level == $this->CI->config->item('admin_level') ? TRUE : FALSE);
			return $data;
		} else {
			$data['message'] = $result['message'];
			$data['is_true'] = $result['is_true'];
			return $data;
		}
	}
	
	function create_user($page) {
		$this->CI->form_validation->set_rules('username', 'Username', 'required|trim|min_length[4]|max_length[25]|xss_clean|alpha_numeric|callback__check_username_exist_create');
		$this->CI->form_validation->set_rules('email', 'Email', 'required|trim|max_length[200]|xss_clean|valid_email|callback__check_email_exist_create');
		$this->CI->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|max_length[25]|xss_clean|matches[confirm_password]');
		$this->CI->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|min_length[6]|max_length[25]|xss_clean');
		$this->CI->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[25]|xss_clean|alpha');
		$this->CI->form_validation->set_rules('last_name', 'Last Name', 'required|trim|max_length[25]|xss_clean|alpha');
		
		if ($this->CI->form_validation->run() == FALSE) {
			$data['title'] = 'Create User | Envysea Codeigniter Authentication';
			$data['template'] = 'create_view';
			
			if ($page == 'admin') {
				$data['module'] = 'admin';
			} else {
				$data['module'] = 'envysea';
			}
			
			$this->CI->load->view('template', $data);	
		} else {
			$new_user_array = array(
								'username' => $this->CI->input->post('username'),
								'email' => $this->CI->input->post('email'),
								'password' => sha1($this->CI->config->item('salty_salt').$this->CI->input->post('password')),
								'first_name' => $this->CI->input->post('first_name'),
								'last_name' => $this->CI->input->post('last_name')
								);
		
			$this->CI->load->model('user');
			$result = $this->CI->user->create_user($new_user_array);
			
			if ($result['is_true'] == TRUE) {
				$this->CI->session->set_flashdata('message', '<div class="success_message">'.$result['message'].'</div>');
				
				if ($page == 'admin') {
					redirect('admin/panel/create', 'location');
				} else {
					redirect('members/create', 'location');				}
			
			} else {
				$data['message'] = '<div class="error_message">'.$result['message'].'</div>';
				$data['title'] = 'Create User | Envysea Codeigniter Authentication';
				$data['template'] = 'create_view';
				
				if ($page == 'admin') {
					$data['module'] = 'admin';
				} else {
					$data['module'] = 'envysea';
				}
				
				$this->CI->load->view('template', $data);	
			}
		}
	}
	
	function update_user($page) {
		$this->CI->load->model('user');
		$result_get_users = $this->CI->user->get_user();
	
		if ($page == 'admin') :
			$this->CI->form_validation->set_rules('user_id', 'User', 'required|xss_clean');
		endif;
	
		$this->CI->form_validation->set_rules('username', 'Username', 'trim|min_length[4]|max_length[25]|xss_clean|alpha_numeric|callback__check_username_exist');
		$this->CI->form_validation->set_rules('email', 'Email', 'trim|max_length[200]|xss_clean|valid_email|callback__check_email_exist');
		$this->CI->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|max_length[15]|xss_clean|matches[confirm_password]');
		$this->CI->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|min_length[6]|max_length[15]|xss_clean');
		$this->CI->form_validation->set_rules('first_name', 'First Name', 'trim|max_length[25]|xss_clean|alpha');
		$this->CI->form_validation->set_rules('last_name', 'Last Name', 'trim|max_length[25]|xss_clean|alpha');
		
		if ($this->CI->form_validation->run() == FALSE) {
			if ($page == 'secure') {
				$data['title'] = 'Update Account | Envysea Codeigniter Authentication';
				$data['module'] = 'secure';
				$data['template'] = 'update_view';

				$this->CI->load->view('template', $data);
			} elseif ($result_get_users['is_true'] == TRUE) {
				$data['users'] = $result_get_users['query_result']; 
				$data['title'] = 'Update Account | Envysea Codeigniter Authentication';
				$data['module'] = 'admin';
				$data['template'] = 'update_view';

				$this->CI->load->view('template', $data);
			} else {
				$data['message'] = '<div class="error_message">'.$result_get_users['message'].'</div>';
				$data['title'] = 'Delete User | Envysea Codeigniter Authentication';
				$data['module'] = 'admin';
				$data['template'] = 'delete_view';
				
				$this->CI->load->view('template', $data);
			}
		} else {
			$user_id = $page == 'admin' ? $this->CI->input->post('user_id') : $this->CI->session->userdata('user_id');
			$email = $this->CI->input->post('email');
			$username = $this->CI->input->post('username');
			$password_post = $this->CI->input->post('password');
			$first_name = $this->CI->input->post('first_name');
			$last_name = $this->CI->input->post('last_name');
			
			$result_update = NULL;
			
			if ($username != NULL || FALSE) :
				$updated_user = array('username' => $username);
				$result_update = $this->CI->user->update_user($user_id, $updated_user);
				if ($page == 'secure') :
					$this->CI->session->unset_userdata('username');
					$session_data['username'] = $username;
					$this->CI->session->set_userdata($session_data);
				endif;
			endif;
			
			if ($email != NULL || FALSE) :
				$updated_user = array('email' => $email);
				$result_update = $this->CI->user->update_user($user_id, $updated_user);
			endif;
			
			if ($password_post != NULL || FALSE) :
				$password = sha1($this->CI->config->item('salty_salt').$password_post);
				$updated_user = array('password' => $password);
				$result_update = $this->CI->user->update_user($user_id, $updated_user);
			endif;
			
			if ($first_name != NULL || FALSE) :
				$updated_user = array('first_name' => $first_name);
				$result_update = $this->CI->user->update_user($user_id, $updated_user);
				if ($page == 'secure') :
					$this->CI->session->unset_userdata('first_name');
					$session_data['first_name'] = $first_name;
					$this->CI->session->set_userdata($session_data);
				endif;
			endif;
			
			if ($last_name != NULL || FALSE) :
				$updated_user = array('last_name' => $last_name);
				$result_update = $this->CI->user->update_user($user_id, $updated_user);
				if ($page == 'secure') :
					$this->CI->session->unset_userdata('last_name');
					$session_data['last_name'] = $last_name;
					$this->CI->session->set_userdata($session_data);
				endif;
			endif;
			
			if ($result_update['is_true'] == TRUE) {
				$this->CI->session->set_flashdata('message', '<div class="success_message">'.$result_update['message'].'</div>');
				
				$header = $page == 'admin' ? 'admin/panel/update' : 'account/update';
				redirect($header, 'location');
			} elseif ($result_update == NULL) {
				$data['message'] = '<div class="error_message">No changes were made. Fill out at least one field to make an update.</div>';
				$data['title'] = 'Update User | Envysea Codeigniter Authentication';
				$data['template'] = 'update_view';
				
				if ($page == 'secure') {
					$data['module'] = 'secure';
					$data['template'] = 'update_view';
				
					$this->CI->load->view('template', $data);
				} else {
					$data['users'] = $result_get_users['query_result']; 
					$data['module'] = 'admin';
					
					$this->CI->load->view('template', $data);
				}
			} else {
				$data['message'] = '<div class="error_message">'.$result_update['message'].'</div>';
				$data['title'] = 'Update User | Envysea Codeigniter Authentication';
				$data['template'] = 'update_view';
				
				if ($page == 'secure') {
					$data['module'] = 'secure';
					$data['template'] = 'account_view';
				
					$this->CI->load->view('template', $data);
				} else {
					$data['users'] = $result_get_users['query_result']; 
					$data['module'] = 'admin';
					$data['template'] = 'panel_view';
					
					$this->CI->load->view('template', $data);
				}	
			}
		}
	}

	function change_roles() {
		$this->CI->load->model('user');
		$result_get_users = $this->CI->user->get_user();
	
		$this->CI->form_validation->set_rules('is_admin', 'Make Admin', 'required|trim|xss_clean');
		
		if ($this->CI->form_validation->run() == FALSE) {
			if ($result_get_users['is_true'] == TRUE) {
				$data['users'] = $result_get_users['query_result']; 
				$data['title'] = 'Change Roles | Envysea Codeigniter Authentication';
				$data['module'] = 'admin';
				$data['template'] = 'roles_view';

				$this->CI->load->view('template', $data);
			} else {
				$data['message'] = '<div class="error_message">'.$result_get_users['message'].'</div>';
				$data['title'] = 'Change Roles | Envysea Codeigniter Authentication';
				$data['module'] = 'admin';
				$data['template'] = 'roles_view';
				
				$this->CI->load->view('template', $data);	
			}
		} else {
			$user_level = $this->CI->input->post('is_admin') == 'yes' ? $this->CI->config->item('admin_level') : 0;
			$updated_user = array('user_level' => $user_level);
			$result_update = $this->CI->user->update_user($this->CI->input->post('user_id'), $updated_user);
			
			if ($result_update['is_true'] == TRUE) {
				$this->CI->session->set_flashdata('message', '<div class="success_message">'.$result_update['message'].'</div>');
				redirect('admin/panel/roles', 'location');
			} else {
				$data['message'] = '<div class="error_message">'.$result_update['message'].'</div>';
				$data['users'] = $result_get_users['query_result']; 
				$data['title'] = 'Change Roles | Envysea Codeigniter Authentication';
				$data['module'] = 'admin';
				$data['template'] = 'roles_view';
				
				$this->CI->load->view('template', $data);
			}
		}
	}
	
	function delete_user($page) {
		if ($page == 'admin') :
			$this->CI->load->model('user');
			$result_get_users = $this->CI->user->get_user();
			$this->CI->form_validation->set_rules('user_id', 'User', 'required|xss_clean');
		endif;
	
		$this->CI->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|max_length[25]|xss_clean|callback__verify_password');
		
		if ($this->CI->form_validation->run() == FALSE) {
			if ($page == 'secure') {
				$data['title'] = 'Delete User | Envysea Codeigniter Authentication';
				$data['module'] = 'secure';
				$data['template'] = 'delete_view';

				$this->CI->load->view('template', $data);
			} elseif ($result_get_users['is_true'] == TRUE) {
				$data['users'] = $result_get_users['query_result']; 
				$data['title'] = 'Delete User | Envysea Codeigniter Authentication';
				$data['module'] = 'admin';
				$data['template'] = 'delete_view';

				$this->CI->load->view('template', $data);
			} else {
				$data['message'] = '<div class="error_message">'.$result_get_users['message'].'</div>';
				$data['title'] = 'Delete User | Envysea Codeigniter Authentication';
				$data['module'] = 'admin';
				$data['template'] = 'delete_view';
				
				$this->CI->load->view('template', $data);
			}
		} else {
		
			$user_id = $page == 'admin' ? $this->CI->input->post('user_id') : $this->CI->session->userdata('user_id');
		
			$result_delete = $this->CI->user->delete_user($user_id);

			if ($result_delete['is_true'] == TRUE) {
				$this->CI->session->set_flashdata('message', '<div class="success_message">'.$result_delete['message'].'</div>');
				
				if ($page == 'secure') :
					
					$this->CI->session->unset_userdata('user_id');
					$this->CI->session->unset_userdata('username');
					$this->CI->session->unset_userdata('first_name');
					$this->CI->session->unset_userdata('last_name');
					$this->CI->session->unset_userdata('is_logged_in');
					
					
					redirect(base_url(), 'location');
				endif;
				redirect('admin/panel/delete', 'location');
			} else {
				$data['users'] = $result_get_users['query_result']; 
				$data['message'] = '<div class="error_message">'.$result_delete['message'].'</div>';
				$data['title'] = 'Delete User | Envysea Codeigniter Authentication';
				$data['module'] = 'admin';
				$data['template'] = 'delete_view';

				$this->CI->load->view('template', $data);
			}
		}
	}
	
	function recover_username() {
		$this->CI->form_validation->set_rules('email', 'Email', 'required|trim|max_length[200]|xss_clean|valid_email|callback__check_email_exist_forgot');
	
		if ($this->CI->form_validation->run() == FALSE) {
			$data['title'] = 'Recover Username | Envysea Codeigniter Authentication';
			$data['module'] = 'envysea';
			$data['template'] = 'forgot_username_view';

			$this->CI->load->view('template', $data);
		} else {
			$this->CI->load->model('user');
			$result = $this->CI->user->get_username($this->CI->input->post('email'));
			
			if ($result['is_true'] == TRUE) {
				foreach ($result['query_result'] as $qr);
				$username = $qr->username;
				
				$from = $this->CI->config->item('from_email');
				$to = $this->CI->input->post('email');
				$subject = $this->CI->config->item('forgot_username_subject');
				$message = 	'Hello! This is an an automatically generated message! You\'re username is '.$qr->username .'.';
				
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/plain; charset=iso-8859-2\r\nContent-Transfer-Encoding: 8bit\r\nX-Priority: 1\r\nX-MSMail-Priority: High\r\n";
				$headers .= "From: $from\r\n" . "Reply-To: $from\r\n" . "X-Mailer: PHP/" . phpversion() . "\r\nX-originating-IP: " . $this->CI->input->ip_address() . "\r\n";			
			
				mail($to, $subject, $message, $headers);
			
				$this->CI->session->set_flashdata('message', '<div class="success_message">Thank you! You should be receiving an email shortly containing your username.</div>');
				redirect('members/forgot/username', 'location');
			} else {
				$data['message'] = '<div class="error_message">'.$result['message'].'</div>';
				$data['title'] = 'Recover Username | Envysea Codeigniter Authentication';
				$data['module'] = 'envysea';
				$data['template'] = 'forgot_username_view';

				$this->CI->load->view('template', $data);
			}
		}
	}
	
	function recover_password() {
		$this->CI->form_validation->set_rules('username', 'Username', 'required|trim|max_length[25]|xss_clean|callback__check_username_exist_login');
		$this->CI->form_validation->set_rules('email', 'Email', 'required|trim|max_length[200]|xss_clean|valid_email|callback__check_email_exist_forgot');
		
		if ($this->CI->form_validation->run() == FALSE) {
			$data['title'] = 'Recover Password | Envysea Codeigniter Authentication';
			$data['module'] = 'envysea';
			$data['template'] = 'forgot_password_view';

			$this->CI->load->view('template', $data);
		} else {
			$username = $this->CI->input->post('username');
			$email = $this->CI->input->post('email');
			
			$this->CI->load->model('user');
			$result_verify = $this->CI->user->verify_recover_password($username, $email);
			
			if ($result_verify['is_true'] == TRUE) {
				foreach ($result_verify['query_result'] as $qr);
				
				$this->CI->load->helper('string');
				$new_password = random_string('alnum', 12);
				
				$updated_user = array('password' => sha1($this->CI->config->item('salty_salt').$new_password));
			
				$result_update = $this->CI->user->update_user($qr->user_id, $updated_user);
				if ($result_update['is_true'] == TRUE) {
					$from = $this->CI->config->item('from_email');
					$to = $email;
					$subject = $this->CI->config->item('forgot_password_subject');
					$message = 	'Hello '.$username.'! This is an automatically generated message. Your new password is '.$new_password.'.';
					
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/plain; charset=iso-8859-2\r\nContent-Transfer-Encoding: 8bit\r\nX-Priority: 1\r\nX-MSMail-Priority: High\r\n";
					$headers .= "From: $from\r\n" . "Reply-To: $from\r\n" . "X-Mailer: PHP/" . phpversion() . "\r\nX-originating-IP: " . $this->CI->input->ip_address() . "\r\n";			
				
					mail($to, $subject, $message, $headers);
					
					$this->CI->session->set_flashdata('message', '<div class="success_message">Thank you! You should be receiving an email shortly containing your new password.</div>');
					redirect('members/forgot/password', 'location');
				} else {
					$data['message'] = '<div class="error_message">Failed to create a new password. Please try again or alert a site Admin.</div>';
					$data['title'] = 'Recover Password | Envysea Codeigniter Authentication';
					$data['module'] = 'envysea';
					$data['template'] = 'forgot_password_view';

					$this->CI->load->view('template', $data);
				} 
			} else {
				$data['message'] = '<div class="error_message">'.$result_verify['message'].'</div>';
				$data['title'] = 'Recover Password | Envysea Codeigniter Authentication';
				$data['module'] = 'envysea';
				$data['template'] = 'forgot_password_view';

				$this->CI->load->view('template', $data);
			}
		}
	}
	
	function is_logged_in() {
		$is_logged_in = $this->CI->session->userdata('is_logged_in');
		if (!isset($is_logged_in) || $is_logged_in != TRUE ) {
			$this->CI->session->set_flashdata('message', '<div class="error_message">Try logging in first.</div>');
			redirect('members/login', 'location');
		}
	}
	
	function is_admin() {
		$admin_level = $this->CI->config->item('admin_level');
		$user_level = $this->CI->session->userdata('user_level');
	
		if (!isset($user_level) || $user_level != $admin_level) {
			$this->CI->session->set_flashdata('message', '<div class="error_message">You are most definitely not an admin.</div>');
			redirect('secure', 'location');
		}
	}
	
	function logout() {
		$this->CI->session->sess_destroy();
	}

}

/* End of custom library, Auth.php */