<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->database();
		
        
	}

	public function index(){
		// new template 적용 완료
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('new_templates_mk2/top');
		$this->load->view('new_templates_mk2/body');
		
	}
	
	public function Testing_list(){
		// workbench list testing controller
		// used new template
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('new_templates_mk2/top');
		$this->load->view('new_workbenchList_mk2/body');
	}
	
	public function Testing_view(){
		// workbench list testing controller
		// used new template
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('new_templates_mk2/top');
		$this->load->view('new_workbenchView_mk2/body');
	}
	
	public function Friend()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('_templates/top');
		$this->load->view('Friend/index');
		$this->load->view('_templates/body');

	}
	public function Team()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('_templates/top');
		$this->load->view('team/team');
		$this->load->view('_templates/body');

	}
	public function Cover(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('cover');
	}
	
}