<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class DashboardModel extends CI_Model{
	private $userid;
	public function __construct(){
		parent ::__construct();
		$this->load->model('backend/auth/DashboardModel');
		$this->userid=$this->session->userdata('AdminloggedIn')['id'];
	}

	function add_promo_code($data)
    {/*
        echo '<pre>';
        print_r($data);exit;*/
        if($data['discount_type'] == "P")
        {
            $max_limit = $data['max_limit'];
        }
        else
        {
            $max_limit = "0.00";
        }
        $created_date = date("Y-m-d H:i:s");
        $insert_data = array(
            "promo_code" =>  $data['promo_code'],
            "title" =>  $data['title'],
            "max_limit" => $max_limit,
            "description" =>  $data['description'],
            "eligible_order_price" =>  $data['eligible_order_price'],
            "start_date" =>  $data['start_date'],
            "end_date" =>  $data['end_date'],
            "discount_limit" =>  $data['discount_limit'],
            "discount_type" =>  $data['discount_type'],
            /*"user_id" =>  $data['user_id'],*/
            "status" =>  $data['status'],
            "usage_count" =>  $data['usage_count'],
            "created_date" => $created_date
        );
        if($data['start_date'] == '0000-00-00' || empty($data['start_date'])){
            $insert_data['start_date'] = null;
        }
        if($data['end_date'] == '0000-00-00' || empty($data['end_date'])){
            $insert_data['end_date'] = null;
        }
        /*if($data['user_specific'] == 'N'){
            $insert_data['user_id'] = null;
        }*/
        $this->db->insert("wami_promo_code", $insert_data);
        $id =  $this->db->insert_id();
        $response = array("status" => "Y", "message" => "New promo code created", "id" => $id);

        return $response;

    }

    function update_promo_code($data)
    {/*
        echo '<pre>';
        print_r($data);exit;*/
        $id = $data['promo_code_id'];
        // before update banner check promo code ID
        $this->db->select("id");
        $this->db->from("wami_promo_code");
        $this->db->where("id", $id);
        $this->db->where("status !=", "D");
        $emp_check_query = $this->db->get();
        if($emp_check_query->num_rows() == 0)
        {
            $response = array("status" => "N", "message" => "Invalid request. Maybe promo code already deleted.");
        }
        else
        {
            if($data['discount_type'] == "P")
            {
                $max_limit = $data['max_limit'];
            }
            else
            {
                $max_limit = "0.00";
            }
            $update_data = array(
                "promo_code" =>  $data['promo_code'],
                "title" =>  $data['title'],
                "description" =>  $data['description'],
                "eligible_order_price" =>  $data['eligible_order_price'],
                "start_date" =>  $data['start_date'],
                "end_date" =>  $data['end_date'],
                "discount_limit" =>  $data['discount_limit'],
                "discount_type" =>  $data['discount_type'],
                "status" =>  $data['status'],
                /*"user_id" =>  $data['user_id'],
                "user_specific" =>  $data['user_specific'],*/
                "max_limit" => $max_limit,
                "usage_count" =>  $data['usage_count'],
                "updated_date" => date("Y-m-d H:i:s")
            );
            if($data['start_date'] == '0000-00-00' || empty($data['start_date'])){
                $update_data['start_date'] = null;
            }
            if($data['end_date'] == '0000-00-00' || empty($data['end_date'])){
                $update_data['end_date'] = null;
            }
            /*if($data['user_specific'] == 'N'){
                $update_data['user_id'] = null;
            }*/
            $this->db->where("id", $id);
            $this->db->update("wami_promo_code", $update_data);
            $response = array("status" => "Y", "message" => "Promo Code Details updated.");

        }
        return $response;
    }

    // Get single promo code details
    function single_promo_details($id)
    {
        $this->db->select("*");
        $this->db->from("wami_promo_code");
        $this->db->where("status !=", "D");
        $this->db->where("id", $id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $row = $query->row();

            $details = array(
                "id" => $row->id,
                "promo_code" => $row->promo_code,
                "title" => $row->title,
                "description" => $row->description,
                "eligible_order_price" => $row->eligible_order_price,
                "start_date" => ($row->start_date == '0000-00-00')? '' : $row->start_date,
                "end_date" => ($row->end_date == '0000-00-00')? '' : $row->end_date,
                "discount_limit" => $row->discount_limit,
                "discount_type" => $row->discount_type,
                "max_limit" => $row->max_limit,
                "status" => $row->status,
                "user_id" =>  $row->user_id,
                "user_specific" =>  $row->user_specific,
                "mobile_number" =>  null,
                "usage_count" =>  $row->usage_count,
                "created_date" => $row->created_date
            );
            /*if($row->user_specific == 'Y' && !empty($row->user_id)){
                $this->db->select("phone");
                $this->db->from("sb_customer");
                $this->db->where("id",  $row->user_id);
                $query1 = $this->db->get();
               
                if($query1->num_rows() > 0){
                    $row1 = $query1->row();
                    $details['mobile_number'] = $row1->phone;
                }
            }*/

            $response = array("status" => "Y", "message" => "Details found", "details" => $details);
        }
        else
        {
            $response = array("status" => "N", "message" => "No details found. Maybe coupon is already deleted.");
        }
        return $response;

    }

    // Promo code Delete
    function delete_promo_by_id($id)
    {
        $response = array("status" => "N", "message" => "This promo code already deleted or not found.");

        $this->db->where("id", $id);
        $this->db->delete("wami_promo_code");
        if($this->db->affected_rows() > 0)
        {
            $response =  array("status" => "Y", "message" => "Promo code successfully deleted.");
        }

        return $response;

    }

	function promo_code_list($filter_data)
    {
        $list = array();

        $this->db->select("*");
        $this->db->from("wami_promo_code");
        if($filter_data['status'] == 'Y')
        {
            $this->db->where("status", "Y");
        }
        elseif($filter_data['status'] == 'N')
        {
            $this->db->where("status", "N");
        }
        else
        {
            $this->db->where("status !=", "D");
        }
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $list[] = array(
                    "id" => $row->id,
                    "promo_code" => $row->promo_code,
                    "title" => $row->title,
                    "discount_type" => $row->discount_type,
                    "status" => $row->status,
                    "created_date" => $row->created_date
                );
            }
        }
        return $list;
    }

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
    public function saveGeneralInformations($data, $id){
        $this->db->where('id', $id);
        $this->db->update('wami_general_information', $data);
        $arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Information successfuly updated.
        </div>');
        return $arraymsg;
    }

	public function getMastercategories($id=null){
		$this->db->select('*');
		$this->db->from('bulletin_category');
		if($id!=''){
			$this->db->where('id', $id);
		}
		$this->db->order_by('id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
	public function getDeliverycharge(){
		$this->db->select('*');
		$this->db->from('wami_delivery_charge');
		$this->db->where('id', 1);
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->row();
		}
		return $result;
	}
    public function getSecuritycharge(){
        $this->db->select('*');
        $this->db->from('wami_security_deposit');
        $this->db->where('id', 1);
        $sql= $this->db->get();
        $result=array();
        if($sql->num_rows()>0){
            $result=$sql->row();
        }
        return $result;
    }
    
	public function saveDeliverycharge($data){
		$this->db->where('id', 1);
		$this->db->update('wami_delivery_charge', $data);
		$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Delivery Charge successfuly updated.
        </div>');
        return $arraymsg;
	}

    public function saveSecuritycharge($data){
        $this->db->where('id', 1);
        $this->db->update('wami_security_deposit', $data);
        $arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Security Deposit successfuly updated.
        </div>');
        return $arraymsg;
    }
	//Get users list
    function users_list()
    {
        $list = array();

        $this->db->select("
        wami_users.id,wami_users.full_name,wami_users.email,wami_users.phone_no,wami_users.user_active,
        wami_customer_device_details.device_type,wami_customer_device_details.device_token
        ");
        $this->db->from("wami_users");
        $this->db->join('wami_customer_device_details', 'wami_users.id = wami_customer_device_details.customer_id');
     	$this->db->where("user_active", "2");
        $this->db->order_by("wami_users.id", "desc");
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $list[] = array(
                    "id" => $row->id,
                    "full_name" => $row->full_name,
                    "email" => $row->email,
                    "phone_no" => $row->phone_no,
                    "user_active" => $row->user_active,
                    "device_type" => $row->device_type,
                    "device_token" => $row->device_token,
                );
            }
        }
        return $list;
    }
    function find_all_devices(){
        $this->db->select("id");
        $this->db->from("wami_users");
        $this->db->where("user_active", "2");
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            $details = $query->result_array();
            $response = array("status" => "Y", "message" => "Details found", "details" => $details);
        }else{
            $response = array("status" => "N", "message" => "No details found.");
        }
        return $response;
    }
	function send_push_notification($data)
    {
        $customer_id = $data['customer_id'];
        $subject = $data['subject'];
        $message = $data['message'];

        // find device type
        $this->db->select("*");
        $this->db->from("wami_customer_device_details");
        $this->db->where("customer_id", $customer_id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $device_token = $row->device_token;
            if($row->device_type == "A")
            {
                // android
                $push_data = array("device_token" => $device_token, "subject" => $subject, "message" => $message);
                $this->send_push_android($push_data);
                return true;

            }
            else if($row->device_type == "I")
            {
                // ios
                $push_data = array("device_token" => $device_token, "subject" => $subject, "message" => $message);
                $this->send_push_IOS($push_data);
                return true;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }
    function send_push_android($data)
    {
        $device_token = $data['device_token'];
        $subject = $data['subject'];
        $message = $data['message'];

        $type = 0;
        $url = "https://fcm.googleapis.com/fcm/send";
        $title = $subject;
        $body = $message;
        $token = $device_token;
        $serverKey = 'AAAAGg5v4Hg:APA91bEp54xRQWuqUv_WDnlD04w0blWFSSm-2xj2CLxw96Sni9Os8cmI7gsk4DUPqsiQmkWllKXSJm5-vT9232TvDTBPpMEe7oQg_MwKB1bFQZYo8TwvF6EO55ySpY06r8ZDzINZnMHd';
        

        $data_arr = array("title" => $title , "body" => $body, "icon" => base_url("assets/backend/dist/img/app_icon.png"), "type" => $type);
        $notification = array('click_action' => 'Splashactivity', 'title' => $title , 'body' => $body, 'sound' => 'default', 'badge' => '1', 'data' => 'default', 'icon' => base_url('assets/backend/dist/img/app_icon.png'), 'type' => $type);
        $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority'=>'high', 
            'data' => $data_arr, 'content_available' => true);

        $json = json_encode($arrayToSend, true);
        
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //Send the request
        $response = curl_exec($ch);
        /*if ($response === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
        }*/
        curl_close($ch);
        //return json_encode($response);

    }

    function send_push_IOS($data)
    {
        $device_token = $data['device_token'];
        $subject = $data['subject'];
        $message = $data['message'];

        $device_token = $data['device_token'];
        $subject = $data['subject'];
        $message = $data['message'];

        $type = 0;
        $url = "https://fcm.googleapis.com/fcm/send";
        $title = $subject;
        $body = $message;
        $token = $device_token;
        $serverKey = 'AAAAGg5v4Hg:APA91bEp54xRQWuqUv_WDnlD04w0blWFSSm-2xj2CLxw96Sni9Os8cmI7gsk4DUPqsiQmkWllKXSJm5-vT9232TvDTBPpMEe7oQg_MwKB1bFQZYo8TwvF6EO55ySpY06r8ZDzINZnMHd';
        

        $data_arr = array("title" => $title , "body" => $body, "icon" => base_url("assets/backend/dist/img/app_icon.png"), "type" => $type);
        $notification = array('click_action' => '.Splashactivity', 'title' => $title , 'body' => $body, 'sound' => 'default', 'badge' => '1', 'data' => 'default', 'icon' => base_url('assets/backend/dist/img/app_icon.png'), 'type' => $type);
        $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority'=>'high', 
            'data' => $data_arr, 'content_available' => true);

        $json = json_encode($arrayToSend, true);
        
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //Send the request
        $response = curl_exec($ch);
        // if ($response === FALSE) {
        // die('FCM Send Error: ' . curl_error($ch));
        // }
        curl_close($ch);
        return true;

    }
	public function getBrands_related_mastercat($mastercatid){
		$this->db->select('b.`id`, b.`brand_name`');
		$this->db->from('wami_brand b');
		$this->db->join('wami_category c', 'c.id=b.categoryid');
		$this->db->join('wami_category_multiple m', 'c.id=m.catid');
		$this->db->where('m.mastercatid', $mastercatid);
		$this->db->order_by('b.brand_name', 'ASC');
		$sql= $this->db->get();
		$allcats=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
			foreach ($result as $key => $value) {
				$allcats[]=array(
					'id'=>$value['id'],
					'brand_name'=>$value['brand_name']
				);
			}
		}
		return $allcats;
	}
	
	public function addMastercategory($data){
		$this->db->select('id');
		$this->db->from('bulletin_category');
		$this->db->where('cat_name', $data['name']);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Name already exists.
        </div>');
		}else{
			$this->db->insert('bulletin_category', $data);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Category successfuly added.
        </div>');
		}
		return $arraymsg;
	}
	public function saveMastercategory($id, $data){
		$query="id <> $id AND (`cat_name` = '".$data['name']."')";
		$this->db->select('id');
		$this->db->from('bulletin_category');
		$this->db->where($query);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Name already exists.
        </div>');
		}else{
			$this->db->where('id', $id);
			$this->db->update('bulletin_category', $data);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Category successfuly updated.
        </div>');
		}
		return $arraymsg;
	}
	public function getCustomerAddresses($id){
		$this->db->select('id, fullname, address1, address2, pincode, city, state, landmark');
		$this->db->from('wami_user_address');
		$this->db->where('user_id', $id);
		$this->db->order_by('id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
		}
		return $result;
	}

    public function insertVideos($data){
        $this->db->insert('bulletin_video', $data);
    }   

    
    public function getNews($id=""){
        $this->db->select('n.*');
        $this->db->from('bulletin_news n');
        $this->db->join('bulletin_subcategory s', 's.id=n.subcat_id');
        if($id!=''){
            $this->db->where('n.id', $id);
        }
        $this->db->order_by('n.id', 'DESC');
        $sql= $this->db->get();
        $result=array();
        if($sql->num_rows()>0){

            if($id!=''){
                $result=$sql->row();
            }else{
                $result=$sql->result_array();
            }
            
        }
        return $result;
    }
    public function insertNews($data){
        $this->db->insert('bulletin_news', $data);
    }
    public function editNews($data, $id){
        $this->db->where('id', $id);
        $this->db->update('bulletin_news', $data);
    }
    
    public function saveSubscriptionPlan($data, $id){
        $this->db->where('id', $id);
            $this->db->update('wami_subscription_prod', $data);
            $arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Subscription Plan successfuly updated.
        </div>');
            return $arraymsg;
    }
    public function getSubscribeProdDetail($id){
        $this->db->select('*');
        $this->db->from('wami_subscription_prod');
        $this->db->where('id', $id);
        $sql= $this->db->get();
        $result=array();
        if($sql->num_rows()>0){
            $result=$sql->row();
        }
        return $result;
    }
    
	public function getOrderType($orderid=null){
		$this->db->select('order_type');
		$this->db->from('wami_order');
		$this->db->where('id', $orderid);
		$sql_order_type= $this->db->get();
		$row_order_type=$sql_order_type->row();
		return $row_order_type->order_type;
	}

	public function getOrderProducts($orderid, $id=null){

		$this->db->select('order_type');
		$this->db->from('wami_order');
		$this->db->where('id', $orderid);
		$sql_order_type= $this->db->get();
		$row_order_type=$sql_order_type->row();
		$result=array();
		if($row_order_type->order_type==1){
			$this->db->select('d.id, d.total_price, o.order_number, o.payment_mode, p.name, c.category_name, o.created_at, o.updated_at, d.variation_id, d.quantity, d.unit_price, v.unique_id');
			$this->db->from('wami_order_details d');
			$this->db->join('wami_order  o', 'd.order_id=o.id');
			$this->db->join('wami_product p', 'd.product_id=p.id');
			$this->db->join('wami_product_variation v', 'd.variation_id=v.id', 'left');
			$this->db->join('wami_category c', 'p.category_id=c.id');
			$this->db->where('o.id', $orderid);
			if($id!=''){
				$this->db->where('d.id', $id);
			}
			$this->db->order_by('d.id', 'DESC');
			$sql= $this->db->get();
			
			if($sql->num_rows()>0){
				if($id!=''){
					$result=$sql->row();
				}else{
					$result=$sql->result_array();
				}
			}
		}else{
			$this->db->select('o.order_number, o.payment_mode, o.created_at, o.updated_at, o.final_price, o.no_of_jar_ordered, o.no_of_jar_returned');
			$this->db->from('wami_order  o');
			$this->db->join('wami_subscription_prod p', 'o.subscriptionid=p.id', 'left');
			$this->db->where('o.id', $orderid);
			$this->db->order_by('o.id', 'DESC');
			$sql= $this->db->get();
			
			if($sql->num_rows()>0){
				if($id!=''){
					$result=$sql->row();
				}else{
					$result=$sql->result_array();
				}
			}
		}
		return $result;
	}
	public function getOrders($id=null, $limit=null){
		$this->db->select("o.`id`, o.`order_number`, o.`final_price`, o.`order_status`, o.`payment_mode`, o.`created_at`, o.`updated_at`, u.full_name, l.full_name logisticname,o.order_status, o.logistic_id logisticid, o.invoice, o.order_type, CASE o.order_status
	      	WHEN 1 THEN 'Pending'
     	 	WHEN 2 THEN 'Processing'
	      	WHEN 3 THEN 'Completed'
	      	WHEN 4 THEN 'Cancel'
	      	ELSE 'Current'
  			END as orderstatus", FALSE);
		$this->db->from('`wami_order` o');
		$this->db->join('wami_users u', 'o.`user_id`=u.id');
		$this->db->join('wami_logistics l', 'o.logistic_id=l.userid', 'left');
		if($id!=''){
			$this->db->where('o.id', $id);
		}
		$this->db->order_by('o.id', 'DESC');
		if($limit!=''){
			$this->db->limit(5);
		}
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
	public function getSuccessOrders($id=null){
		$this->db->select("o.`id`, o.`order_number`, o.`final_price`, o.`order_status`, o.`payment_mode`, o.`created_at`, o.`updated_at`, u.full_name, o.order_status, l.contact_point, l.alternate_no, l.address, o.invoice, o.order_type");
		$this->db->from('`wami_order` o');
		$this->db->join('wami_users u', 'o.`user_id`=u.id');
		$this->db->join('wami_logistics l', 'o.logistic_id=l.userid', 'left');
		$this->db->where('o.order_status', 3);
		$this->db->where('o.final_price >', '0');
		if($id!=''){
			$this->db->where('o.id', $id);
		}
		$this->db->order_by('o.id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
	
	public function getAdmindata(){
		$this->db->select('w.id, w.full_name, w.username, w.password, w.email, w.phone_no');
		$this->db->from('wami_users w');
		$this->db->join('wami_user_types t', 'w.user_type=t.id');
		$this->db->where('t.id', 1);
		$this->db->where('w.id', $this->userid);
		$sql= $this->db->get();
		$row=$sql->row();
		return $row;
	}
	public function saveAdminData($data){
		$query="id <> $this->userid AND (`phone_no` = '".$data['phone_no']."' OR `email` = '".$data['email']."')";
		$this->db->select('id');
		$this->db->from('wami_users');
		$this->db->where($query);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Phone No/Email Id already exists.
        </div>');
		}else{
			$this->db->where('id', $this->userid);
			$this->db->update('wami_users', $data);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Profile successfuly updated.
        </div>');
		}
		return $arraymsg;
	}
	public function updateadminpassword($data){
		$this->db->where('id', $this->userid);
		$this->db->update('wami_users', $data);
	}
	public function getAllCustomers($userid=null){
		$this->db->select('w.id, w.full_name, w.username, w.password, w.email, w.phone_no, w.user_active, w.updated_at, w.created_at');
		$this->db->from('wami_users w');
		$this->db->join('wami_user_types t', 'w.user_type=t.id');
		$this->db->where('t.id', 4);
		if($userid!=''){
			$this->db->where('w.id', $userid);
		}
		$this->db->order_by('w.id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($userid!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;	
	}
	public function getLogistics($id=null){
		$this->db->select('u.id, u.full_name, u.phone_no, u.email, u.user_active, u.username, u.created_at, u.updated_at, l.contact_point, l.alternate_no, l.address');
		$this->db->from('wami_users u');
		$this->db->join('wami_logistics l', 'l.userid=u.id');
		if($id!=''){
			$this->db->where('u.id', $id);
		}
		$this->db->order_by('u.id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
	public function addLogistic($data){
		$this->db->select('id');
		$this->db->from('wami_users');
		$this->db->where('phone_no', $data['phone_no']);
		$this->db->or_where('email', $data['email_id']);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Phone No/Email Id already exists.
        </div>');
		}else{
			$user_details=array(
				'user_type'=>3,
				'full_name'=>$data['name'],
				'username'=>$data['unique_id'],
				'password'=>$data['password'],
				'email'=>$data['email_id'],
				'phone_no'=>$data['phone_no'],
				'ip_address'=>getIpAddress(),
			);
			$this->db->insert('wami_users', $user_details);
			$lastid=$this->db->insert_id();
			$logistic_detail=array(
				'userid'=>$lastid,
				'full_name'=>$data['name'],
				'contact_point'=>$data['contact_point'],
				'alternate_no'=>$data['alternate_no'],
				'address'=>$data['address'],
			);
			$this->db->insert('wami_logistics', $logistic_detail);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Logistic successfuly added.
        </div>');
		}
		return $arraymsg;
	}
	public function updatelogistic($id, $data){
		$query="id <> $id AND (`phone_no` = '".$data['phone_no']."' OR `email` = '".$data['email_id']."')";
		$this->db->select('id');
		$this->db->from('wami_users');
		$this->db->where($query);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Phone No/Email Id already exists.
        </div>');
		}else{
			$data_user=array(
				'full_name'=>$data['name'],
				'email'=>$data['email_id'],
				'phone_no'=>$data['phone_no']
			);
			$this->db->where('id', $id);
			$this->db->update('wami_users', $data_user);

			$data_logistic=array(
				'contact_point'=>$data['contact_point'],
				'alternate_no'=>$data['alternate_no'],
				'address'=>$data['address']
			);
			$this->db->where('userid', $id);
			$this->db->update('wami_logistics', $data_logistic);

			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Logistic successfuly updated.
        </div>');
		}
		return $arraymsg;
	}
	public function updatelogisticpassword($id, $data){
		$this->db->where('id', $id);
		$this->db->update('wami_users', $data);
	}
	public function getFaqs($id=null){
		$this->db->select('*');
		$this->db->from('wami_faq');
		if($id!=''){
			$this->db->where('id', $id);
		}
		$this->db->order_by('id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
	public function saveFaq($data){
		$this->db->insert('wami_faq', $data);
		$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          FAQ added successfuly.
        </div>');
        return $arraymsg;
	}
	public function uupdatesaveFaq($data, $id){
		
		$this->db->where('id', $id);
		$this->db->update('wami_faq', $data);
		$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          FAQ updated successfuly.
        </div>');
        return $arraymsg;
	}
	
	public function getProductVariationDetail($id=null, $limit=null){
    	$this->db->select('v.id, v.variation_image, v.variation_actual_price, v.unique_id, v.variation_stock, p.name, p.sku, v.created_at, v.updated_at, v.variation_litre, v.variation_discount, v.variation_info, v.variation_key_features, v.stock_active, v.product_type, v.variation_packaging_type, v.variation_disclaimer, v.variation_shelf_life, v.variation_jar_type, v.variation_security_deposit');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_product p', 'v.product_id=p.id');
		$this->db->where('v.product_type', 1);
		if($id!=''){
			$this->db->where('v.id', $id);
		}
		$this->db->order_by('v.id', 'DESC');
		if($limit!=''){
			$this->db->limit(5);
		}
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
	public function editOrderStatus($status, $id, $logistic_id){
		$data=array(
				'order_status'=>$status,
				'logistic_id'=>$logistic_id
			);
		$this->db->where('id', $id);
		$this->db->update('wami_order', $data);
		$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Order Status changed successfuly.
        </div>');
        return $arraymsg;
	}
	public function getBrands($id=null){
    	$this->db->select('b.*, c.category_name');
		$this->db->from('wami_brand b');
		$this->db->join('wami_category c', 'b.categoryid=c.id');
		if($id!=''){
			$this->db->where('b.id', $id);
		}
		$this->db->order_by('b.id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
	public function addBrand($brand, $brand_image, $categoryid){
		$this->db->select('id');
		$this->db->from('wami_brand');
		$this->db->where('brand_name', $brand);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Brand already exist.
        </div>');
		}else{
			$data=array(
				'brand_name'=>$brand,
                'brand_image'=>$brand_image,
				'categoryid'=>$categoryid
			);
			$this->db->insert('wami_brand', $data);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Brand successfuly added.
        </div>');
		}
		return $arraymsg;
	}
	public function editBrand($brandid, $brand_name, $brand_image, $categoryid){
		$this->db->select('id');
		$this->db->from('wami_brand');
		$this->db->where('brand_name', $brand_name);
		$this->db->where('id<>', $brandid);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Brand already exist.
        </div>');
		}else{
			$data=array(
				'brand_name'=>$brand_name,
                'brand_image'=>$brand_image,
				'categoryid'=>$categoryid
			);
			$this->db->where('id', $brandid);
			$this->db->update('wami_brand', $data);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Brand updated successfuly.
        </div>');
		}
		return $arraymsg;
	}
	public function getCategory($id=null){
		$this->db->select('s.*, c.cat_name');
		$this->db->from('bulletin_subcategory s');
		$this->db->join('bulletin_category c', 's.cat_id=c.id');
		if($id!=''){
			$this->db->where('s.id', $id);
		}
		/*$this->db->group_by('c.id');*/
		$this->db->order_by('s.id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
    public function editVideos($data, $id){
        $this->db->where('id', $id);
        $this->db->update('bulletin_video', $data);
    }
    
    public function getVideos($id=null){
        $this->db->select('*');
        $this->db->from('bulletin_video');
        if($id!=''){
            $this->db->where('id', $id);
        }
        /*$this->db->group_by('c.id');*/
        $this->db->order_by('id', 'DESC');
        $sql= $this->db->get();
        $result=array();
        if($sql->num_rows()>0){
            if($id!=''){
                $result=$sql->row();
            }else{
                $result=$sql->result_array();
            }
        }
        return $result;
    }

    public function getAboutUs(){
        $this->db->select('*');
        $this->db->from('bulletin_aboutus');
        $this->db->where('id', 1);
        $sql= $this->db->get();
        $result=array();
        if($sql->num_rows()>0){
            $result=$sql->row();
        }
        return $result;
    }

    public function getPrivacy(){
        $this->db->select('*');
        $this->db->from('bulletin_privacy');
        $this->db->where('id', 1);
        $sql= $this->db->get();
        $result=array();
        if($sql->num_rows()>0){
            $result=$sql->row();
        }
        return $result;
    }
    
    
	public function getProductsDetail($pid){
		$this->db->select('*');
		$this->db->from('wami_product');
		$this->db->where('id', $pid);
		$sql= $this->db->get();
		$row=$sql->row();
		return $row;
	}
	public function getBanners($id=null){
		$this->db->select('*');
		$this->db->from('wami_banner');
		if($id!=''){
			$this->db->where('id', $id);
		}
		$this->db->order_by('id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
	public function getBanners2($id=null){
		$this->db->select('*');
		$this->db->from('wami_banner2');
		if($id!=''){
			$this->db->where('id', $id);
		}
		$this->db->order_by('id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
	public function getBanners3($id=null){
		$this->db->select('*');
		$this->db->from('wami_banner3');
		if($id!=''){
			$this->db->where('id', $id);
		}
		$this->db->order_by('id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}

	
	public function getPincodes($id=null){
		$this->db->select('*');
		$this->db->from('wami_pincodes');
		if($id!=''){
			$this->db->where('id', $id);
		}
		$this->db->order_by('id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
	public function addPincode($pincode){
		$arraymsg=array();
		$this->db->select('*');
		$this->db->from('wami_pincodes');
		$this->db->where('name', $pincode);
		
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Pincode exist.
        </div>');
		}else{
			$data=array(
				'name'=>$pincode
			);
			$this->db->insert('wami_pincodes', $data);
	      	$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Pincode successfuly added.
        </div>');
		}
		return $arraymsg;
	}
	public function updatePincode($pincode, $id){
		$arraymsg=array();
		$this->db->select('*');
		$this->db->from('wami_pincodes');
		$this->db->where('name', $pincode);
		$this->db->where('id<>', $id);
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Pincode exist.
        </div>');
		}else{
			$data=array(
				'name'=>$pincode
			);
			$this->db->where('id', $id);
			$this->db->update('wami_pincodes', $data);
	      	$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Pincode successfuly updated.
        </div>');
		}
		return $arraymsg;
	}

	public function getProductsDetailVariation($pid){
		$this->db->select('*');
		$this->db->from('wami_product_variation');
		$this->db->where('product_id', $pid);
		$sql= $this->db->get();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
		}
		return $result;
	}
	public function getSubscribedVariations($pid){
		$this->db->select('*');
		$this->db->from('wami_subscription_prod');
		$this->db->where('product_variation_id', $pid);
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
		}
		return $result;
	}
	
	public function getBrandsByCategory($id=null){
		$this->db->select('brand_id');
		$this->db->from('wami_category_brands');
		if($id!=''){
			$this->db->where('cat_id', $id);
		}
		$this->db->order_by('id', 'DESC');
		$sql= $this->db->get();
		$allbrands=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->result_array();
				foreach ($result as $key => $value) {
					$allbrands[]=$value['brand_id'];
				}
			}
		}
		return $allbrands;

	}
	public function getCatsByMastercat($id=null){
		$this->db->select('mastercatid');
		$this->db->from('wami_category_multiple');
		if($id!=''){
			$this->db->where('catid', $id);
		}
		$this->db->order_by('id', 'DESC');
		$sql= $this->db->get();
		$allmastercats=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->result_array();
				foreach ($result as $key => $value) {
					$allmastercats[]=$value['mastercatid'];
				}
			}
		}
		return $allmastercats;

	}
	
	public function getCategory_related_mastercat($mastercatid){
		$this->db->select('c.id, c.category_name');
		$this->db->from('wami_category_multiple m');
		$this->db->join('wami_category c', 'm.`catid`=c.id');
		$this->db->where('m.mastercatid', $mastercatid);
		$this->db->order_by('c.category_name', 'ASC');
		$sql= $this->db->get();
		$allcats=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
			foreach ($result as $key => $value) {
				$allcats[]=array(
					'id'=>$value['id'],
					'category_name'=>$value['category_name']
				);
			}
		}
		return $allcats;
	}
	public function addCategory($data){
		$this->db->select('id');
		$this->db->from('bulletin_subcategory');
		$this->db->where('subcat_name ', $data['subcat_name']);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Category already exist.
        </div>');
		}else{
			
			$this->db->insert('bulletin_subcategory', $data);


			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Category successfuly added.
        </div>');
		}
		return $arraymsg;
	}
	public function storeBanner($banner_image){
			$data=array(
				'banner_image'=>$banner_image,
			);
			$this->db->insert('wami_banner', $data);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Banner successfuly added.
        </div>');
	
		return $arraymsg;
	}

	public function storeBanner2($banner_image){
			$data=array(
				'banner_image'=>$banner_image,
			);
			$this->db->insert('wami_banner2', $data);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Banner successfuly added.
        </div>');
	
		return $arraymsg;
	}

	public function storeBanner3($banner_image){
			$data=array(
				'banner_image'=>$banner_image,
			);
			$this->db->insert('wami_banner3', $data);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Banner successfuly added.
        </div>');
	
		return $arraymsg;
	}

	

    public function editAboutUs($data){
       
        $this->db->where('id', 1);
        $this->db->update('bulletin_aboutus', $data);
       
    }

    public function editPrivacy($data){
       
        $this->db->where('id', 1);
        $this->db->update('bulletin_privacy', $data);
       
    }
	
	public function editCategory($data, $categoryid){
		$this->db->select('id');
		$this->db->from('bulletin_subcategory');
		$this->db->where('subcat_name', $data['subcat_name']);
		$this->db->where('id<>', $categoryid);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Category already exist.
        </div>');
		}else{
			
			$this->db->where('id', $categoryid);
			$this->db->update('bulletin_subcategory', $data);



			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Category updated successfuly.
        </div>');
		}
		return $arraymsg;
	}
	public function updateBanner($banner_image, $bannerid){
		$data=array(
			'banner_image'=>$banner_image,
		);
		$this->db->where('id', $bannerid);
		$this->db->update('wami_banner', $data);
			
		$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Banner updated successfuly.
        </div>');
		return $arraymsg;
	}

	public function updateBanner2($banner_image, $bannerid){
		$data=array(
			'banner_image'=>$banner_image,
		);
		$this->db->where('id', $bannerid);
		$this->db->update('wami_banner2', $data);
			
		$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Banner updated successfuly.
        </div>');
		return $arraymsg;
	}

	public function updateBanner3($banner_image, $bannerid){
		$data=array(
			'banner_image'=>$banner_image,
		);
		$this->db->where('id', $bannerid);
		$this->db->update('wami_banner3', $data);
			
		$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Banner updated successfuly.
        </div>');
		return $arraymsg;
	}
	
	public function getBrands_related_cats($catid){
		$this->db->select('id, brand_name');
		$this->db->from('wami_brand');
		$this->db->where('categoryid', $catid);
		$this->db->order_by('brand_name', 'ASC');
		$sql= $this->db->get();
		$allbrands=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
			foreach ($result as $key => $value) {
				$allbrands[]=array(
					'id'=>$value['id'],
					'brand_name'=>$value['brand_name']
				);
			}
		}
		return $allbrands;
	}
	public function getSubcats_related_cats($catid){
		$this->db->select('id, name');
		$this->db->from('wami_sub_category');
		$this->db->where('catid', $catid);
		$this->db->order_by('name', 'ASC');
		$sql= $this->db->get();
		$allsubcats=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
			foreach ($result as $key => $value) {
				$allsubcats[]=array(
					'id'=>$value['id'],
					'name'=>$value['name']
				);
			}
		}
		return $allsubcats;
	}
	
	public function getProducts($id=null){
		$this->db->select('p.`id`, p.product_stock, p.`created_at`, p.`updated_at`, p.name, c.category_name, p.is_active, p.sku');
		$this->db->from('wami_product p');
		$this->db->join('wami_category c', 'p.`category_id`=c.id');
		$this->db->join('wami_product_variation v', 'p.id=v.product_id');
		if($id!=''){
			$this->db->where('p.id', $id);
		}
		$this->db->where('v.product_type', 1);
		$this->db->group_by('p.id');
		$this->db->order_by('p.id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}
	public function getSubscribedProducts($id=null, $limit=null){
    	$this->db->select('v.id, v.variation_image, v.variation_actual_price, v.unique_id, v.variation_stock, v.created_at, v.updated_at, v.variation_litre, v.variation_discount, v.variation_info, v.variation_key_features, v.stock_active, b.brand_name, v.subscribe_per_jar_price, v.offer, v.no_of_jars, v.subscribe_brand_id, v.subscribe_mastercatid');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_brand b', 'v.subscribe_brand_id =b.id', 'left');
		if($id!=''){
			$this->db->where('v.id', $id);
		}
		$this->db->where('v.product_type', 2);
		$this->db->order_by('v.id', 'DESC');
		if($limit!=''){
			$this->db->limit(5);
		}
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			if($id!=''){
				$result=$sql->row();
			}else{
				$result=$sql->result_array();
			}
		}
		return $result;
	}

    public function getSubscribedProductsVariation($id=null){
        $this->db->select('*');
        $this->db->from('wami_subscription_prod');
        $this->db->where('product_variation_id ', $id);
        $this->db->order_by('id', 'DESC');
        $sql= $this->db->get();
        $result=array();
        if($sql->num_rows()>0){
            $result=$sql->result_array();
        }
        return $result;
    }
    public function getSubscribedProductsVariationBrand($id){
        $this->db->select('b.brand_name');
        $this->db->from('wami_product_variation v');
        $this->db->join('wami_brand b', 'v.subscribe_brand_id=b.id', 'left');
        $this->db->where('v.id ', $id);
        $sql= $this->db->get();
        $result=array();
        if($sql->num_rows()>0){
            $result=$sql->row();
        }
        return $result;
    }
    
	public function checkSubscribeProdExist($mastercategoryid, $subscribe_brand_id, $id=null){
		$this->db->select('id');
		$this->db->from('wami_product_variation');
		$this->db->where('subscribe_brand_id', $subscribe_brand_id);
		$this->db->where('subscribe_mastercatid', $mastercategoryid);
		$this->db->where('product_type', 2);
		if($id!=''){
			$this->db->where('id<>', $id);
		}
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
		}
		return $result;
	}
	
	
	
	public function getVariationStocks($id){
		$this->db->select('SUM(`variation_stock`) totalstock');
		$this->db->from('wami_product_variation');
		$this->db->where('product_id', $id);
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->row();
		}
		return $result;
	}
	
}