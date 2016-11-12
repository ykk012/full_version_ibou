<?php

class Workbench extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('workbench_model');
        $this->load->model('Member_model');
        $this->load->helper('form');
		$this->load->library('form_validation');
    }
	public function index()
	{
		// $userData = $this->Member_model->checkLogin('mgshin','1234');
		// $this->session->set_userdata('loginInfo', $userData[0]);
		
	    $this->load->view('new_templates_mk2/top');
		$this->load->view('view');
	}

	public function insertNode()
	{
		$nodeData = $this->input->post();

		$result = $this->workbench_model->insertNewNode($nodeData);

		echo json_encode($result);
	}
	
	public function deleteNode()
	{
		$nodeData = $this->input->post();

		$result = $this->workbench_model->deleteNode($nodeData);
	}

	public function connect($id)
	{
		// $result = $this->workbench_model->getWorkbenchDataAsJSON($id);

		// $this->session->set_flashdata('workbench',$result);

		$this->load->view('new_templates_mk2/top');
		$this->load->view('new_workbenchView_mk2/body');

		// echo json_encode($result);
	}

	public function reflesh($id)
	{
		$result = $this->workbench_model->getWorkbenchDataAsJSON($id);

		// $this->session->set_flashdata('workbench',$result);

		echo json_encode($result);
	}
	
	public function createWB()
	{
		$data = $this->input->post();
		
		
		$this->workbench_model->createNewWorkbench($data);
		
	}
	
	public function getWorkbenchList($id)
	{
		$result['personal'] = $this->workbench_model->getWorkbenchList($id);
		$result['team'] = $this->workbench_model->getTeamWorkbenchList($id);
		
		echo json_encode($result);
	}
	
	public function getAttachList($id)
	{
		$result = $this->workbench_model->getAttachList($id);
		
		echo json_encode($result);
	}
	
	public function createNewVote()
	{
		$data = $this->input->post();
		
		$this->workbench_model->createNewVote($data);
	}
	
	public function getVoteList($id)
	{
		$result = $this->workbench_model->getVoteList($id);
		
		echo json_encode($result);
	}
	
	public function getVoteCandidate($id){
		$result = $this->workbench_model->getVoteCandidate($id);
		
		echo json_encode($result);
	}
	
	public function voteCandidate($id){
		$result = $this->workbench_model->voteCandidate($id);
		
		// print_r($result);
	}
	
	public function closeVote($id){
		$result = $this->workbench_model->closeVote($id);
		
		echo json_encode($result);
	}
	
	public function attachFile(){
		$data = $this->input->post();
		
		$this->workbench_model->attachFile($data);
	}
	
	public function shareWbFriend(){
		$data = $this->input->post();
		
		$this->workbench_model->shareWbFriend($data);
	}
	
	public function shareWbTeam(){
		$data = $this->input->post();
		
		$this->workbench_model->shareWbTeam($data);
	}
	
	public function createPDF($id){
		$data = $this->input->post();
		
		$result = $this->workbench_model->getWorkbenchDataAsJSON($id);
		
		$this->session->set_flashdata('wbData',$result);
		
		$this->load->library('Pdf');
		
		$this->load->view('pdftest');
		
		//실제 PDF제작 구문
		
		// print_r($data);
	}
}