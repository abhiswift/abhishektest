<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class LogisticdashboardModel extends CI_Model{
	private $userid;
	public function __construct(){
		parent ::__construct();
		$this->userid=$this->session->userdata('LogisticloggedIn')['id'];
	}

	public function getMastercategories($id=null){
		$this->db->select('*');
		$this->db->from('wami_master_category');
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
		$this->db->from('wami_master_category');
		$this->db->where('name', $data['name']);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Name already exists.
        </div>');
		}else{
			$this->db->insert('wami_master_category', $data);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Category successfuly added.
        </div>');
		}
		return $arraymsg;
	}
	public function saveMastercategory($id, $data){
		$query="id <> $id AND (`name` = '".$data['name']."')";
		$this->db->select('id');
		$this->db->from('wami_master_category');
		$this->db->where($query);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Name already exists.
        </div>');
		}else{
			$this->db->where('id', $id);
			$this->db->update('wami_master_category', $data);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Category successfuly updated.
        </div>');
		}
		return $arraymsg;
	}
	public function getCustomerAddresses($id){
		$this->db->select('id, fullname, address1, address2, pincode, city, state, landmark');
		$this->db->from('wami_user_address');
		$this->db->order_by('id', 'DESC');
		$sql= $this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
		}
		return $result;
	}

	public function getOrderProducts($orderid, $id=null){
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
	public function getOrders($id=null, $limit=null){
		$this->db->select("o.`id`, o.`order_number`, o.`final_price`, o.`order_status`, o.`payment_mode`, o.`created_at`, o.`updated_at`, u.full_name, o.order_status, CASE o.order_status
	      	WHEN 1 THEN 'Pending'
     	 	WHEN 2 THEN 'Processing'
	      	WHEN 3 THEN 'Completed'
	      	WHEN 4 THEN 'Cancel'
	      	ELSE 'Current'
  			END as orderstatus", FALSE);
		$this->db->from('`wami_order` o');
		$this->db->join('wami_users u', 'o.user_id=u.id');
		$this->db->join('wami_logistics l', 'o.logistic_id=l.userid');
		$this->db->where('l.userid', $this->userid);
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
		$this->db->select("o.`id`, o.`order_number`, o.`final_price`, o.`order_status`, o.`payment_mode`, o.`created_at`, o.`updated_at`, u.full_name, o.order_status, l.name, l.unique_id");
		$this->db->from('`wami_order` o');
		$this->db->join('wami_users u', 'o.`user_id`=u.id');
		$this->db->join('wami_logistics l', 'o.logistic_id=l.id');
		$this->db->where('o.order_status', 3);
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
	
	public function getLogisticdata(){
		$this->db->select('w.id, w.full_name, w.username, w.password, w.email, w.phone_no, l.contact_point, l.alternate_no, l.address');
		$this->db->from('wami_users w');
		$this->db->join('wami_logistics l', 'w.id=l.userid');
		$this->db->join('wami_user_types t', 'w.user_type=t.id');
		$this->db->where('t.id', 3);
		$this->db->where('w.id', $this->userid);
		$sql= $this->db->get();
		$row=$sql->row();
		return $row;
	}
	public function saveLogisticData($data, $data_logistic_others){
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

			$this->db->where('userid', $this->userid);
			$this->db->update('wami_logistics', $data_logistic_others);

			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Profile successfuly updated.
        </div>');
		}
		return $arraymsg;
	}
	public function savelogisticpassword($data){
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
	
	
	public function getProductVariationDetail($id=null, $limit=null){
    	$this->db->select('v.id, v.variation_image, v.variation_actual_price, v.unique_id, v.variation_stock, p.name, p.sku, v.created_at, v.updated_at, v.variation_litre, v.variation_discount, v.variation_info, v.variation_key_features, v.stock_active');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_product p', 'v.product_id=p.id');
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
	public function editOrderStatus($status, $id){
		$data=array(
				'order_status'=>$status
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
	public function addBrand($brand, $categoryid){
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
				'categoryid'=>$categoryid
			);
			$this->db->insert('wami_brand', $data);
			$arraymsg=array('status'=>2, 'msg'=>'<div class="alert alert-success" style="padding: 2px; top: 15px;">
          Brand successfuly added.
        </div>');
		}
		return $arraymsg;
	}
	public function editBrand($brandid, $brand_name, $categoryid){
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
		$this->db->select('c.*, GROUP_CONCAT(mc.name SEPARATOR ", ") name', FALSE);
		$this->db->from('wami_category_multiple m');
		$this->db->join('wami_category c', 'm.catid=c.id');
		$this->db->join('wami_master_category mc', 'm.mastercatid=mc.id');
		if($id!=''){
			$this->db->where('c.id', $id);
		}
		$this->db->group_by('c.id');
		$this->db->order_by('c.id', 'DESC');
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
	public function addCategory($category_name, $category_image, $master_category){
		$this->db->select('id');
		$this->db->from('wami_category');
		$this->db->where('category_name ', $category_name);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Category already exist.
        </div>');
		}else{
			$data=array(
				'category_name'=>$category_name,
				'category_image'=>$category_image
			);
			$this->db->insert('wami_category', $data);
			$last_id=$this->db->insert_id();
			$data_brands_category=array();
			foreach ($master_category as $key => $value) {
				$data_brands_category[]=array(
					'catid'=>$last_id,
					'mastercatid'=>$value
				);
			}
			$this->db->insert_batch('wami_category_multiple', $data_brands_category);

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
	
	public function editCategory($category_name, $category_image, $categoryid, $master_category){
		$this->db->select('id');
		$this->db->from('wami_category');
		$this->db->where('category_name ', $category_name);
		$this->db->where('id<>', $categoryid);
		$sql= $this->db->get();
		$arraymsg=null;
		if($sql->num_rows()>0){
			$arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">
          Category already exist.
        </div>');
		}else{
			$data=array(
				'category_name'=>$category_name,
				'category_image'=>$category_image
			);
			$this->db->where('id', $categoryid);
			$this->db->update('wami_category', $data);

			$this->db->trans_start();

			$this->db->where('catid', $categoryid);
			$this->db->delete('wami_category_multiple');

			$data_category=array();
			foreach ($master_category as $key => $value) {
				$data_category[]=array(
					'catid'=>$categoryid,
					'mastercatid'=>$value
				);
			}
			$this->db->insert_batch('wami_category_multiple', $data_category);
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
		        $arraymsg=array('status'=>1, 'msg'=>'<div class="alert alert-danger" style="padding: 2px; top: 15px;">Some error occured. </div>');
			}

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