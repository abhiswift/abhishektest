<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Commonmodel extends CI_Model{

	public function getGeneralInformations($id){
        $this->db->select('*');
        $this->db->from('wami_general_information');
        $this->db->where('id', $id);
        $sql= $this->db->get();
        $result=array();
        if($sql->num_rows()>0){
            $result=$sql->row();
        }
        return $result;
    }
}