<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent ::__construct();
		$this->load->model('backend/auth/loginModel');
	}
	public function index()
	{
		$this->load->view('backend/auth/login');
	}
	public function logincheck(){
		$username= $this->security->xss_clean($this->input->post('username'));
		$password= $this->security->xss_clean($this->input->post('password'));
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == FALSE){
			$this->load->view('backend/auth/login');
		}else{
			$arraymsg=$this->loginModel->checklogin($username, $password);
			if($arraymsg['status']==2){
				redirect('admincontrol/dashboardadmin');
			}
			$this->session->set_flashdata('credentialchcek',$arraymsg['msg']);
			$this->load->view('backend/auth/login');
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('admincontrol');
	}
	public function forgetpassword(){
		$this->load->view('backend/auth/forget-password');
	}
	public function sendemailforgetpassword(){
		$email= $this->security->xss_clean($this->input->post('email'));
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run() == FALSE){
			$this->load->view('backend/auth/forget-password');
		}else{
			$arraymsg=$this->loginModel->checkEmailexist($email);
			if($arraymsg['status']==2){
				$this->session->set_flashdata('forgetpass_sendmail',$arraymsg['msg']);
				$this->load->view('backend/auth/forget-password');
			}else{
				$this->session->set_flashdata('forgetpass_sendmail',$arraymsg['msg']);
				$this->load->view('backend/auth/forget-password');
			}
			
		}
	}
	public function resetpassword(){
		$token= $this->security->xss_clean($this->input->get('token_key', true));
		$this->db->select('w.id');
		$this->db->from('wami_users w');
		$this->db->join('wami_user_types t', 'w.user_type=t.id');
		$this->db->where('t.id', 1);
		$this->db->where('w.password_token', $token);
		$sql= $this->db->get();
		if($sql->num_rows()>0){
		    $row=$sql->row();
		    /*$data = array(
			    'password_token' => null
			);
			$this->db->where('id', $row->id);
			$this->db->update('wami_users', $data);*/
			$data['passtoken']=$token;
			$this->load->view('backend/auth/recover-password', $data);
		}
	}
	public function resetpassupdate(){
	    $password= $this->security->xss_clean($this->input->post('password'));
	    $usertoken= $this->security->xss_clean($this->input->post('usertoken'));
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');
		if ($this->form_validation->run() == FALSE){
		    $data['passtoken']=$usertoken;
			$this->load->view('backend/auth/recover-password', $data);
		}else{
			$arraymsg=$this->loginModel->updateAdminPassword($password, $usertoken);
			if($arraymsg['status']==2){
				$this->session->set_flashdata('reset_password_msg',$arraymsg['msg']);
				$this->load->view('backend/auth/recover-password');
			}else{
				$this->session->set_flashdata('reset_password_msg',$arraymsg['msg']);
				$this->load->view('backend/auth/recover-password');
			}
			
		}
	}

}