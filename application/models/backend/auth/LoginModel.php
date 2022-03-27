<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class LoginModel extends CI_Model{
	public function checklogin($username, $password){
    	$this->db->select('id, name, username, password');
		$this->db->from('bulletin_admin');
		$this->db->where('username', $username);
		$sql= $this->db->get();
		$arraymsg=$data=null;
		if($sql->num_rows()>0){
			$row=$sql->row();
			if(password_verify($password, $row->password)){
				$arraymsg=array('status'=>2);
				$data=array(
					'id'=>$row->id,
					'name'=>$row->name
				);
				$this->session->set_userdata('AdminloggedIn', $data);
				$arraymsg=array('status'=>2);
			}else{
				$arraymsg=array('status'=>1, 'msg'=>'Username/Password incorrect!!!');
			}
		}else{
			$arraymsg=array('status'=>1, 'msg'=>'Username/Password incorrect!!!');
		}
		return $arraymsg;
	}
	public function checkEmailexist($email){
		$this->db->select('id');
		$this->db->from('wami_users');
		$this->db->where('email', $email);
		$sql= $this->db->get();
		if($sql->num_rows()>0){
			$row=$sql->row();
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success">
          A password reset link has been sent to your email id. Please check your inbox/spam folder.
        </div>');
			
			// send email
			$random_key=time().'-'.$row->id;

			$data = array(
			    'password_token' => $random_key,
			);
			$datatoken['password_token']=$random_key;
			$this->db->where('id', $row->id);
			$this->db->update('wami_users', $data);
	    	$this->load->library('email');
	        $fromemail="info@wami.co.in";
			$subject = "Password reset link from Wami";
			$message= $this->load->view('backend/auth/forget_pass_link_admin',$datatoken,true);
			$config = Array(
			  'protocol' => 'smtp',
			  'smtp_host' => 'ssl://smtp.gmail.com',
			  'smtp_port' => 465,
			  'smtp_user' => 'info@wami.co.in', 
			  'smtp_pass' => 'qAz3qyKzaPX*', 
			  'mailtype' => 'html',
			  'charset' => 'iso-8859-1',
			  'wordwrap' => TRUE
			);
	        $this->email->set_newline("\r\n");
	        $this->email->from($fromemail); 
	        $this->email->to($email);// 
	        $this->email->subject($subject);
	        $this->email->message($message);
	   
         	
         	if($this->email->send()) {
         		$this->session->set_flashdata("email_sent","Email sent successfully.");
         	}else{
         		$this->session->set_flashdata("email_sent","Error in sending Email."); 
         	}
	       
		}else{
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger">
          Sorry!!! this email id does not exist. Please try again.
        </div>');
		}
		return $arraymsg;
	}
	public function updateAdminPassword($password, $usertoken){
	    $this->db->select('id');
		$this->db->from('wami_users');
		$this->db->where('password_token', $usertoken);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
		    $row=$sql->row();
    		    $data = array(
    		        'password'=> password_hash($password, PASSWORD_DEFAULT),
    			    'password_token' => null,
    		);
    		$this->db->where('id', $row->id);
    		$this->db->update('wami_users', $data);
    		$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success">
          Your password has been successfully reset.
        </div>');
		}else{
		    $arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger">
          Sorry!!! Some error occured. Please try again.
        </div>');
		}
	    return $arraymsg;
	}
}