<?php

class envysea extends CI_Controller {

	/***************************************
	* Envysea Authentication for Codeigniter 2.0.3
	* 
	* Version 1.0.8
	* 
	* @author Nicholas Cerminara | envysea.com
	***************************************/
	
	function index() {
		// Parameters "title", "page_description", and "page_keywords" are optional. To maximize SEO, it's best to individually fill each one for every separate function/page when loading a view.
		
		/* Alternate Syntax
		-----------------------------
		$data = array(
				'title' => 'Sample Page | Envysea Codeigniter Authentication',
				'module' => 'envysea',
				'page_keywords' => 'specific page keyword 1, keyword 2, keyword 3',
				'page_description' => 'Envysea authentication for Codeigniter',
				'template' => 'home_view'
				); */
		
		$data['title'] = 'Envysea Codeigniter Authentication';
		$data['page_description'] = 'Envysea authentication offers rapid application development for membership, authentication, and login sites.';
		$data['page_keywords'] = 'Authentication, Membership, Login, Codeigniter 2.0.3';
		$data['module'] = 'envysea';
		$data['template'] = 'home_view';
		
		$this->load->view('template', $data);
	}
	
	function about() {
		$data['title'] = 'About | Envysea Codeigniter Authentication';
		$data['module'] = 'envysea';
		$data['template'] = 'about_view';
		
		$this->load->view('template', $data);
	}
	
	function license() {
		$data['title'] = 'License | Envysea Codeigniter Authentication';
		$data['module'] = 'envysea';
		$data['template'] = 'license_view';
		
		$this->load->view('template', $data);
	}
	
	function contact() {
		redirect('http://envysea.com/contact/', 'location');
	}
}