<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Apimodel extends CI_Model{

	public function checkphnoexist($phno){
		$this->db->select('id, full_name, email, created_at');
		$this->db->from('wami_users');
		$this->db->where('user_type', 3);
		$this->db->where('user_active', '2');
		$this->db->where('phone_no', $phno);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->row();
		}
		return $row;
	}
	public function checkuserotp($phno, $otp){
		$this->db->select('id, full_name, email');
		$this->db->from('wami_users');
		$this->db->where('user_type', 3);
		$this->db->where('user_active', 2);
		$this->db->where('phone_no', $phno);
		$this->db->where('otp', $otp);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->row();
		}
		return $row;
	}
	public function fetchBrands(){
		$this->db->select('id, brand_name');
		$this->db->from('wami_brand');
		$this->db->where('is_active', 2);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchCategories(){
		$this->db->select('id, category_name, category_image');
		$this->db->from('wami_category');
		$this->db->where('is_active', 2);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchBrandsByCategories($catid){
		$this->db->select('id, brand_name');
		$this->db->from('wami_brand');
		$this->db->where('categoryid', $catid);
		$this->db->where('is_active', 2);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchProducts(){
		$this->db->select('v.id, v.unique_id, v.variation_stock, v.variation_litre, v.variation_image, v.variation_info, v.variation_key_features, v.variation_discount, v.variation_discount_price, v.variation_actual_price, p.name, p.product_stock, c.category_name, b.brand_name, p.id productid');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_product p', 'v.product_id=p.id');
		$this->db->join('wami_category  c', 'p.`category_id`=c.id');
		$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
		$this->db->where('p.is_active', 2);
		$this->db->order_by('v.id', 'DESC');
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchProductsByname($pname=null){
		$this->db->select('v.id, v.unique_id, v.variation_stock, v.variation_litre, v.variation_image, v.variation_info, v.variation_key_features, v.variation_discount, v.variation_discount_price, v.variation_actual_price, p.name, p.product_stock, c.category_name, b.brand_name, p.id productid, v.variation_jar_type');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_product p', 'v.product_id=p.id');
		$this->db->join('wami_category  c', 'p.`category_id`=c.id');
		$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
		$this->db->where('p.is_active', 2);
		if($pname!=''){
			$this->db->like('p.name', $pname, 'both'); 
		}
		$this->db->order_by('v.id', 'DESC');
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	
	public function fetchDetailProduct($pid){
		$this->db->select('v.*, p.name, b.brand_name, p.category_id');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_product p', 'v.product_id=p.id');
		$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
		$this->db->where('p.is_active', 2);
		$this->db->where('v.id', $pid);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->row();
		}
		return $row;
	}
	public function fetchDetailProductFromsearch($pid){
		$this->db->select('v.*, p.name, b.brand_name, p.category_id');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_product p', 'v.product_id=p.id');
		$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
		$this->db->where('p.is_active', 2);
		$this->db->where('p.id', $pid);
		$this->db->order_by('v.variation_litre', 'DESC');
		$this->db->limit(1);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->row();
		}
		return $row;
	}
	
	public function fetchAllBrandsByCategories($mastercatid){
		$this->db->select('b.`id`, b.`brand_name`');
		$this->db->from('wami_brand b');
		$this->db->join('wami_category c', 'c.id=b.`categoryid`');
		$this->db->join('wami_category_multiple m', 'c.id=m.catid');
		$this->db->where('m.mastercatid', $mastercatid);
		$this->db->where('b.`is_active`', 2);
		$sql=$this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
		}
		return $result;
	}
	public function fetchOtherVariationProducts($product_id){
		$this->db->select('v.id, v.unique_id, v.variation_stock, v.variation_litre, v.variation_image, v.variation_info, v.variation_key_features, v.variation_discount, v.variation_discount_price, v.variation_actual_price, v.variation_packaging_type, v.variation_disclaimer, v.variation_shelf_life, p.name, p.product_stock, c.category_name, b.brand_name, p.id productid');
			$this->db->from('wami_product_variation v');
			$this->db->join('wami_product p', 'v.product_id=p.id');
			$this->db->join('wami_category  c', 'p.`category_id`=c.id');
			$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
			$this->db->where('v.product_id', $product_id);
			$this->db->order_by('v.variation_litre', 'ASC');
			$sql=$this->db->get();
			$result=array();
			if($sql->num_rows()>0){
				$result=$sql->result_array();
			}
			return $result;
	}
	public function fetchVariationDetailMilk($pid){
		$this->db->select('v.*, p.name, b.brand_name, p.category_id');
			$this->db->from('wami_product_variation v');
			$this->db->join('wami_product p', 'v.product_id=p.id');
			$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
			$this->db->where('p.is_active', 2);
			$this->db->where('v.id', $pid);
			$sql=$this->db->get();
			$result=array();
			if($sql->num_rows()>0){
				$result=$sql->row();
			}
			return $result;
	}
	public function fetchProductDetailsMilk($product_id){
		$this->db->select('v.id, v.unique_id, v.variation_stock, v.variation_litre, v.variation_image, v.variation_info, v.variation_key_features, v.variation_discount, v.variation_discount_price, v.variation_actual_price, v.variation_packaging_type, v.variation_disclaimer, v.variation_shelf_life, p.name, p.product_stock, c.category_name, b.brand_name, p.id productid');
			$this->db->from('wami_product_variation v');
			$this->db->join('wami_product p', 'v.product_id=p.id');
			$this->db->join('wami_category  c', 'p.`category_id`=c.id');
			$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
			$this->db->where('v.product_id', $product_id);
			$this->db->order_by('v.variation_litre', 'ASC');
			$sql_variation_others=$this->db->get();
			$result=array();
			if($sql_variation_others->num_rows()>0){
				$result=$sql_variation_others->result_array();
			}
			return $result;
	}
	public function fetchProdsByCat($catid){
		$this->db->select('v.id, v.unique_id, v.variation_stock, v.variation_litre, v.variation_image, v.variation_info, v.variation_key_features, v.variation_discount, v.variation_discount_price, v.variation_actual_price, p.name, p.product_stock, c.category_name, b.brand_name, p.id productid');
			$this->db->from('wami_product_variation v');
			$this->db->join('wami_product p', 'v.product_id=p.id');
			$this->db->join('wami_category  c', 'p.`category_id`=c.id');
			$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
			$this->db->where('p.is_active', 2);
			$this->db->where('c.id', $catid);
			$this->db->order_by('v.id', 'DESC');
			$sql=$this->db->get();
			$result=array();
			if($sql->num_rows()>0){
				$result=$sql->result_array();
			}
			return $result;
	}
	public function checkstock($product_variation_id){
		$this->db->select('variation_stock, stock_active');
		$this->db->from('wami_product_variation');
		$this->db->where('id', $product_variation_id);
		$sql=$this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->row();
		}
		return $result;
	}
	public function fetchCartItems($cart_user_id){
		$this->db->select('c.`id`, c.`product_variation_id`, c.`quantity`, p.name, p.id product_id, v.variation_image, v.variation_actual_price, v.variation_discount_price, v.variation_security_deposit, v.variation_jar_type, c.return_quanity, v.variation_stock, p.expected_delivery');
			$this->db->from('wami_cart c');
			$this->db->join('wami_product_variation v', 'c.`product_variation_id`=v.id');
			$this->db->join('wami_product p', 'v.`product_id`=p.id');
			$this->db->where('c.cart_user_id', $cart_user_id);
			$this->db->order_by('c.id', 'DESC');
			$sql=$this->db->get();
			$result=array();
			if($sql->num_rows()>0){
				$result=$sql->result_array();
			}
			return $result;
	}
	public function fetchCartItemsByUser($cart_user_id){
		$this->db->select('c.`id`, c.`product_variation_id`, c.`quantity`, p.name, p.id product_id, v.variation_image, v.variation_actual_price, v.variation_discount_price, v.variation_security_deposit, v.variation_jar_type, c.return_quanity, v.variation_stock, p.expected_delivery');
		$this->db->from('wami_cart c');
		$this->db->join('wami_product_variation v', 'c.`product_variation_id`=v.id');
		$this->db->join('wami_product p', 'v.`product_id`=p.id');
		$this->db->where('c.cart_user_id', $cart_user_id);
		$this->db->order_by('c.id', 'DESC');
		$sql=$this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
		}
		return $result;
	}
	public function fetchOrdersByUser($user_id, $orderid=null){
		$this->db->select("o.`id`, o.`order_number`, o.delivery_charge, o.total_price, o.order_type, o.user_address_id, o.`final_price`, o.`order_status`, o.`payment_mode`, o.`created_at`, o.`updated_at`, u.full_name, a.address1, a.address2, a.pincode, a.city, a.state, a.landmark, o.order_status, o.delivery_date, o.no_of_jar_returned, o.no_of_jar_ordered, s.no_of_jars, s.per_jar_price, CASE o.order_status
		      	WHEN 1 THEN 'Pending'
	     	 	WHEN 2 THEN 'Processing'
		      	WHEN 3 THEN 'Completed'
		      	ELSE 'Cancel'
	  			END as orderstatus", FALSE);
			$this->db->from('`wami_order` o');
			$this->db->join('wami_users u', 'o.`user_id`=u.id');
			$this->db->join('wami_user_address a', 'o.`user_address_id`=a.id', 'LEFT');
			$this->db->join('wami_logistics l', 'o.logistic_id=l.userid', 'LEFT');
			$this->db->join('wami_subscription_prod s', 'o.subscriptionid=s.id', 'LEFT');
			$this->db->where('o.logistic_id', $user_id);
			if($orderid!=''){
				$this->db->where('o.id', $orderid);
			}
			$this->db->order_by('o.id', 'DESC');
			$sql= $this->db->get();
			$result=array();
			if($sql->num_rows()>0){
				if($orderid!=''){
					$result=$sql->row();
				}else{
					$result=$sql->result_array();
				}
			}
			return $result;
	}
	public function fetchOrdersById($id){
		$this->db->select('d.id, d.total_price, o.order_number, o.payment_mode, p.name, c.category_name, o.created_at, o.updated_at, d.variation_id, d.quantity, d.unit_price, v.unique_id, v.variation_image, v.variation_litre');
		$this->db->from('wami_order_details d');
		$this->db->join('wami_order  o', 'd.order_id=o.id');
		$this->db->join('wami_product p', 'd.product_id=p.id');
		$this->db->join('wami_product_variation v', 'd.variation_id=v.id', 'left');
		$this->db->join('wami_category c', 'p.category_id=c.id');
		$this->db->where('o.id', $id);
		$this->db->order_by('d.id', 'DESC');
		$sql_prods= $this->db->get();
		$result=array();
		if($sql_prods->num_rows()>0){
			$result=$sql_prods->result_array();
		}
		return $result;
	}
	public function fetchUserAddresses($userid){
		$this->db->select('*');
		$this->db->from('wami_user_address');
		$this->db->where('user_id', $userid);
		$sql=$this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
		}
		return $result;
	}
	public function fetchMasterCategories(){
		$this->db->select('id, name, slug');
		$this->db->from('wami_master_category');
		$this->db->where('is_active', 2);
		$sql=$this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
		}
		return $result;
	}
	public function fetchAllProdsByMasterCategories($mastercatid){
		$this->db->select('v.*, p.name, c.category_name, b.brand_name');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_product p', 'v.product_id=p.id');
		$this->db->join('wami_category c', 'p.category_id=c.id');
		$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
		$this->db->where('p.is_active', 2);
		$this->db->where('p.mastercategoryid', $mastercatid);
		$sql=$this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
		}
		return $result;
	}
	public function fetchMasterCategoryProducts($id){
		$this->db->select('v.id, v.unique_id, v.variation_stock, v.variation_litre, v.variation_image, v.variation_info, v.variation_key_features, v.variation_discount, v.variation_discount_price, v.variation_actual_price, p.name, p.product_stock, c.category_name, b.brand_name, v.variation_jar_type');
			$this->db->from('wami_product_variation v');
			$this->db->join('wami_product p', 'v.product_id=p.id');
			$this->db->join('wami_category  c', 'p.`category_id`=c.id');
			$this->db->join('wami_category_multiple  m', 'c.id=m.catid');
			$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
			$this->db->where('p.is_active', 2);
			$this->db->where('p.mastercategoryid', $id);
			$this->db->group_by('v.id');
			$this->db->order_by('v.id', 'DESC');
			$sql=$this->db->get();
			$result=array();
			if($sql->num_rows()>0){
				$result=$sql->result_array();
			}
			return $result;
	}
	public function fetchAddressById($address_id, $user_id){
		$this->db->select('*');
		$this->db->from('wami_user_address');
		$this->db->where('id', $address_id);
		$this->db->where('user_id ', $user_id);
		$sql=$this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->row();
		}
		return $result;
	}
	public function fetchBanners(){
		$this->db->select('id, banner_image');
		$this->db->from('wami_banner');
		$this->db->where('is_active', 2);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchSubcategories($categoryid, $mastercategoryid){
		$this->db->select('s.id, s.name, s.catid, m.mastercatid');
		$this->db->from('wami_sub_category s');
		$this->db->join('wami_category c', 's.catid=c.id');
		$this->db->join('wami_category_multiple m', 'c.id=m.catid');
		$this->db->where('s.is_active', 2);
		$this->db->where('c.id', $categoryid);
		$this->db->where('m.mastercatid', $mastercategoryid);
		$this->db->group_by('s.id');
		$this->db->order_by('s.id', 'DESC');
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchSubscriptionbrands($mastercatid){
		$this->db->select('v.id productid, b.id, b.brand_name, v.subscribe_per_jar_price');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_brand b', 'v.subscribe_brand_id=b.id');
		$this->db->where('v.product_type', 2);
		$this->db->where('v.subscribe_mastercatid', $mastercatid);
		$this->db->order_by('b.id', 'DESC');
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchSubscriptionBybrands($prodid){
		$this->db->select('id, no_of_jars, per_jar_price, offer');
		$this->db->from('wami_subscription_prod');
		$this->db->where('product_variation_id', $prodid);
		$this->db->order_by('id', 'DESC');
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchProdsByPriceRange($mastercatid, $priceid){
		$clause=null;
		switch ($priceid) {
			case '1':
				$clause="v.variation_actual_price BETWEEN 10 AND 100";
				break;

			case '2':
				$clause="v.variation_actual_price BETWEEN 100 AND 250";
				break;

			case '3':
				$clause="v.variation_actual_price BETWEEN 500 AND 750";
				break;

			case '4':
				$clause="v.variation_actual_price BETWEEN 750 AND 1000";
				break;

			case '5':
				$clause="v.variation_actual_price>1000";
				break;
			
			default:
				# code...
				break;
		}
		$this->db->select('v.id, v.unique_id, v.variation_stock, v.variation_litre, v.variation_image, v.variation_info, v.variation_key_features, v.variation_discount, v.variation_discount_price, v.variation_actual_price, p.name, p.product_stock, c.category_name, b.brand_name, v.variation_jar_type');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_product p', 'v.product_id=p.id');
		$this->db->join('wami_category  c', 'p.`category_id`=c.id');
		$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
		$this->db->where('p.mastercategoryid', $mastercatid);
		if($priceid!=='All'){
			$this->db->where("$clause");
		}
		$this->db->where('p.is_active', 2);
		$this->db->order_by('v.id', 'DESC');
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchProdsByBrandsandcat($mastercat, $brand){

		$this->db->select('v.id, v.unique_id, v.variation_stock, v.variation_litre, v.variation_image, v.variation_info, v.variation_key_features, v.variation_discount, v.variation_discount_price, v.variation_actual_price, p.name, p.product_stock, c.category_name, b.brand_name, v.variation_jar_type');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_product p', 'v.product_id=p.id');
		$this->db->join('wami_category  c', 'p.`category_id`=c.id');
		$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
		$this->db->where('p.mastercategoryid', $mastercat);
		if($brand!=='All'){
			$this->db->where('p.brand_id', $brand);
		}
		$this->db->where('p.is_active', 2);
		$this->db->order_by('v.id', 'DESC');
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchProdsByOnetimeorder($mastercat, $filterid, $filtertype){
		switch ($filtertype) {
			case 'search_by_price':
				$sql=$this->fetchProdsByPriceRange($mastercat, $filterid);
				break;

			case 'search_by_brand':
				$sql=$this->fetchProdsByBrandsandcat($mastercat, $filterid);
				break;
			
			default:
				# code...
				break;
		}
		return $sql;
	}
	
	public function fetchProdsBysubcat($subcat){
		$this->db->select('v.id, v.unique_id, v.variation_stock, v.variation_litre, v.variation_image, v.variation_info, v.variation_key_features, v.variation_discount, v.variation_discount_price, v.variation_actual_price, p.name, p.product_stock, c.category_name, b.brand_name');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_product p', 'v.product_id=p.id');
		$this->db->join('wami_category  c', 'p.`category_id`=c.id');
		$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
		$this->db->where('p.subcatid', $subcat);
		$this->db->where('p.is_active', 2);
		$this->db->order_by('v.id', 'DESC');
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchSchecdulers($date, $userid){
		$this->db->select('*');
		$this->db->from('wami_order');
		$this->db->where('date(schedule_date)', $date);
		$this->db->where('user_id', $userid);
		$this->db->order_by('id', 'DESC');
		$sql=$this->db->get();
		/*$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}*/
		return $sql->num_rows();
	}
	public function fetchPopularProducts($mastercatid){
		$this->db->select('DISTINCT(v.id), v.unique_id, v.variation_stock, v.variation_litre, v.variation_image, v.variation_info, v.variation_key_features, v.variation_discount, v.variation_discount_price, v.variation_actual_price, p.name, p.product_stock, c.category_name, b.brand_name, r.star_rating, v.variation_jar_type');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_rating r', 'r.productid=v.id');
		$this->db->join('wami_product p', 'v.product_id=p.id');
		$this->db->join('wami_category  c', 'p.`category_id`=c.id');
		$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
		$this->db->where('p.mastercategoryid', $mastercatid);
		$this->db->order_by('r.star_rating', 'DESC');
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function fetchSubscritionTotalAmount($subscriptionid){
		$this->db->select('(no_of_jars*per_jar_price) totalamount, no_of_jars, per_jar_price, id');
		$this->db->from('wami_subscription_prod');
		$this->db->where('id', $subscriptionid);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->row();
		}
		return $row;
	}
	public function fetchProdsPriceDifference($mastercatid, $pricerange){
		$this->db->select('v.id, v.unique_id, v.variation_stock, v.variation_litre, v.variation_image, v.variation_info, v.variation_key_features, v.variation_discount, v.variation_discount_price, v.variation_actual_price, p.name, p.product_stock, c.category_name, b.brand_name, v.variation_jar_type');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_product p', 'v.product_id=p.id');
		$this->db->join('wami_category  c', 'p.`category_id`=c.id');
		$this->db->join('wami_brand  b', 'p.`brand_id`=b.id');
		$this->db->where('p.mastercategoryid', $mastercatid);
		$this->db->where('p.is_active', 2);
		if($pricerange=='4'){
			$this->db->order_by('v.variation_actual_price', 'ASC');
		}else{
			$this->db->order_by('v.variation_actual_price', 'DESC');
		}
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function getSecuritydepositamnt($prodtype, $subscribeid){
		$this->db->select('v.variation_security_deposit');
		$this->db->from('wami_product_variation v');
		$this->db->join('wami_subscription_prod s', 'v.id=s.product_variation_id');
		$this->db->where('s.id', $subscribeid);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->row();
		}
		return $row;
	}
	public function fetchSubscriptionStock($subscribeid){
		$this->db->select('id, no_of_jars, per_jar_price, offer');
		$this->db->from('wami_subscription_prod');
		$this->db->where('id', $subscribeid);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->row();
		}
		return $row;
	}
	public function saveUserSubscriptionstock($userid, $subscribeid, $stock_left){
		/*$this->db->select('id');
		$this->db->from('wami_user_subscriptions');
		$this->db->where('user_id', $userid);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()<=0){
			$data=array(
				'user_id'=>$userid,
				'subscriptionid'=>$subscribeid,
				'subscribe_stock'=>$stock_left
			);
			$this->db->insert('wami_user_subscriptions', $data);
		}else{
			$data=array(
				'subscribe_stock'=>$stock_left
			);
			$this->db->where('user_id', $userid);
			$this->db->update('wami_user_subscriptions', $data);
		}*/

		$data=array(
				'user_id'=>$userid,
				'subscriptionid'=>$subscribeid,
				'subscribe_stock'=>$stock_left
			);
		$this->db->insert('wami_user_subscriptions', $data);
	}
	public function getSupportstaff($id){
		$this->db->select('id, phones');
		$this->db->from('wami_support_phone');
		$this->db->where('id', $id);
		$this->db->where('is_active', 2);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->row();
		}
		return $row;
	}
	public function getFAQ(){
		$this->db->select('id, question, answer');
		$this->db->from('wami_faq');
		$this->db->where('is_active', 2);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function generalInformations(){
		$this->db->select('id, title, description');
		$this->db->from('wami_general_information');
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
		}
		return $row;
	}
	public function storeUsersubsinstockOrder($data_order, $jars){
		$this->db->insert('wami_order', $data_order);
		
		$this->db->select('id, subscribe_stock');
		$this->db->from('wami_user_subscriptions');
		$this->db->where('id', $data_order['subscriptionid']);
		$this->db->where('user_id', $data_order['user_id']);
		$sql=$this->db->get();
		$result=$finalstock=0;
		if($sql->num_rows()>0){
			$row=$sql->row();
			$result_stock=$row->subscribe_stock;
			$finalstock=$result_stock+$jars;

			$data_update_stock=array(
				'subscribe_stock'=>$finalstock
			);
			$this->db->where('id', $data_order['subscriptionid']);
			$this->db->where('user_id', $data_order['user_id']);
			$this->db->update('wami_user_subscriptions', $data_update_stock);
		}else{
			$user_subscribe=array(
				'user_id'=>$data_order['user_id'],
				
				'subscriptionid'=>$data_order['subscriptionid'],
				'subscribe_stock'=>$jars,
			);
			$this->db->insert('wami_user_subscriptions', $user_subscribe);
		}
		$this->db->select('subscribe_stock as totalsum');
		$this->db->from('wami_user_subscriptions');
		$this->db->where('user_id', $data_order['user_id']);
		$sql_total_stock=$this->db->get();
		$result_total_stock=0;
		if($sql_total_stock->num_rows()>0){
			$row_total_stock=$sql_total_stock->row();
			$result_total_stock=$row_total_stock->totalsum;
		}
		return $result_total_stock;
	}
	public function fetchUserTotalSubscriptionstock($userid){
		
		$this->db->select('SUM(subscribe_stock) totalstock');
		$this->db->from('wami_user_subscriptions');
		$this->db->where('user_id', $userid);
		$sql=$this->db->get();
		$result=0;
		if($sql->num_rows()>0){
			$row=$sql->row();
			$result=$row->totalstock;
			
		}
		return $result;
	}
	public function updateUserSubscriptionstock($userid){
		$this->db->select('SUM(subscribe_stock) totalstock');
		$this->db->from('wami_user_subscriptions');
		$this->db->where('user_id', $userid);
		$sql=$this->db->get();
		$leftstock=0;
		if($sql->num_rows()>0){
			$row=$sql->row();
			$result=$row->totalstock;
			
			$this->db->select('SUM(no_of_jar_ordered) totaljarsordered');
			$this->db->from('wami_order');
			$this->db->where('user_id', $userid);
			$this->db->where('order_type', 2);
			$sql_orders=$this->db->get();
			$row_orders=$sql_orders->row();
			$jarsordered=$row_orders->totaljarsordered;

			$leftstock=$result-$jarsordered;

			$data=array(
				'subscription_stock'=>$leftstock
			);
			$this->db->where('id', $userid);
			$this->db->update('wami_users', $data);
		}
		return $leftstock;
	}
	/*public function checkUsersubscrstock($userid, $subscribeid){
		$this->db->select('id, subscribe_stock');
		$this->db->from('wami_user_subscriptions');
		$this->db->where('user_id', $userid);
		$this->db->where('subscriptionid', $subscribeid);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()<=0){
			$result=$sql->row();
			if($result->subscribe_stock==0){

			}
			$data=array(
				'user_id'=>$userid,
				'subscriptionid'=>$subscribeid,
				'subscribe_stock'=>$stock_left
			);
			$this->db->insert('wami_user_subscriptions', $data);
		}
	}*/
	public function fetchOnetimeOrders($userid){
		$this->db->select("id, order_number, order_type, user_address_id, final_price, created_at, delivery_date, CASE order_status
	      	WHEN 1 THEN 'Pending'
     	 	WHEN 2 THEN 'Processing'
	      	WHEN 3 THEN 'Completed'
	      	ELSE 'Cancel'
  			END as orderstatus", FALSE);
		$this->db->from('wami_order');
		/*$this->db->where('order_type', 1);*/
		$this->db->where('user_id', $userid);
		$sql=$this->db->get();
		$result=array();
		if($sql->num_rows()>0){
			$result=$sql->result_array();
			foreach ($result as $key => $value) {
				$result[$key]['created_at']=date("jS F, Y", strtotime($value['created_at']));
				if($value['delivery_date']==''){
					$result[$key]['delivery_date']='Yet to be delivered';
				}else{
					$result[$key]['delivery_date']=date("jS F, Y", strtotime($value['delivery_date']));
				}
				if($value['order_type']==2){
					if($value['user_address_id']==''){
						$result[$key]['order_type']='instock';
					}else{
						$result[$key]['order_type']='subscribe';
					}
				}else{
					$result[$key]['order_type']='one-time';
				}
				if($value['user_address_id']==''){
					$result[$key]['user_address_id']='na';
				}
			}
		}
		return $result;
	}
	public function checkUsercredenexist($userid, $name, $nameval){
		$this->db->select('id');
		$this->db->from('wami_users');
		$this->db->where('id<>', $userid);
		$this->db->where($name, $nameval);
		$sql=$this->db->get();
		if($sql->num_rows()>0){
			return false;
		}
		return true;
	}
	public function saveUserCredentials($userid, $data){
		$this->db->where('id', $userid);
		$this->db->update('wami_users', $data);
		return $this->fetchUsercreds($userid);
	}

	public function fetchUsercreds($userid){
		$this->db->select('id, full_name, email, photo, phone_no');
		$this->db->from('wami_users');
		$this->db->where('id', $userid);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->row();
		}
		return $row;
	}
	public function fetchDeliveryOrders($userid, $cat, $stat){
		$clause='';
		switch ($cat) {
			case 'todays':
				$clause="DATE(o.delivery_date)='$stat' AND (o.payment_status in (2) OR o.order_status<3)";
				break;

			case 'current':
				$clause="order_status=5 AND (o.payment_status in (2) OR o.order_status<3)";
				break;

			case 'upcoming':
				$clause="DATE(o.delivery_date)>'$stat' AND (o.payment_status in (2) OR o.order_status<3)";
				break;

			case 'completed':
				$clause="o.order_status=3";
				break;

			case 'cancelled':
				$clause="o.order_status=4";
				break;
			
			default:
				# code...
				break;
		}
		$paymentstatus=array('2');
		$this->db->select('o.`id`, o.`final_price`, o.`payment_mode`, o.order_status, o.`payment_status`, o.delivery_date, a.fullname, a.address1, a.address2, a.pincode, a.city, a.state, a.landmark, a.latitude, a.longitude, u.phone_no');
		$this->db->from('wami_order o');
		$this->db->join('wami_user_address a', 'o.`user_address_id`=a.id', 'LEFT');
		$this->db->join('wami_users u', 'o.`user_id`=u.id');
		$this->db->where('o.logistic_id', $userid);
		$this->db->where('o.delivery_date is not null');
		$this->db->where("$clause");
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
			foreach ($row as $key => $value) {
				if($value['payment_mode']=='COD'){
					$row[$key]['payment_mode']='Payment COD';
				}
				if($value['payment_status']=='1'){
					$row[$key]['payment_status']='Payment Pending';
				}
				if($value['payment_status']=='2'){
					$row[$key]['payment_status']='Payment Paid';
				}
				if($value['payment_status']=='3'){
					$row[$key]['payment_status']='Payment Failed';
				}
				if($value['payment_status']=='4'){
					$row[$key]['payment_status']='Payment Cancelled';
				}
				if($value['latitude']==''){
					$row[$key]['latitude']='na';
				}else{
					$row[$key]['latitude']=$value['latitude'];
				}
				if($value['longitude']==''){
					$row[$key]['longitude']='na';
				}else{
					$row[$key]['longitude']=$value['longitude'];
				}
			}
		}
		return $row;
	}
	public function fetchDeliveryOrdersCompleteandCancel($userid, $cat, $stat, $curdate, $day){
		$clause='';
		if($cat=='completed'){
			switch ($day) {
				case 'today':
					$clause="o.order_status=3 AND DATE(o.delivery_date)='$curdate'";
					break;

				case 'yesterday':
					$clause="o.order_status=3 AND DATE(o.delivery_date)<'$curdate'";
					break;
				
				default:
					# code...
					break;
			}
		}else if($cat=='cancelled'){
			switch ($day) {
				case 'today':
					$clause="o.order_status=4 AND DATE(o.cancel_date)='$curdate'";
					break;

				case 'yesterday':
					$clause="o.order_status=4 AND DATE(o.cancel_date)<'$curdate'";
					break;
				
				default:
					# code...
					break;
			}
		}
		$this->db->select('o.`id`, o.`final_price`, o.`payment_mode`, o.order_status, o.`payment_status`, o.delivery_date, a.fullname, a.address1, a.address2, a.pincode, a.city, a.state, a.landmark, a.latitude, a.longitude, u.phone_no');
		$this->db->from('wami_order o');
		$this->db->join('wami_user_address a', 'o.`user_address_id`=a.id', 'LEFT');
		$this->db->join('wami_users u', 'o.`user_id`=u.id');
		$this->db->where('o.logistic_id', $userid);
		$this->db->where('o.delivery_date is not null');
		$this->db->where("$clause");
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->result_array();
			foreach ($row as $key => $value) {
				if($value['payment_mode']=='COD'){
					$row[$key]['payment_mode']='Payment COD';
				}
				if($value['payment_status']=='1'){
					$row[$key]['payment_status']='Payment Pending';
				}
				if($value['payment_status']=='2'){
					$row[$key]['payment_status']='Payment Paid';
				}
				if($value['payment_status']=='3'){
					$row[$key]['payment_status']='Payment Failed';
				}
				if($value['payment_status']=='4'){
					$row[$key]['payment_status']='Payment Cancelled';
				}
				if($value['latitude']==''){
					$row[$key]['latitude']='na';
				}else{
					$row[$key]['latitude']=$value['latitude'];
				}
				if($value['longitude']==''){
					$row[$key]['longitude']='na';
				}else{
					$row[$key]['longitude']=$value['longitude'];
				}
			}
		}
		return $row;
	}
	
	public function checkUserConfirmation($phno, $orderid){
		$this->db->select('u.id');
		$this->db->from('wami_order o');
		$this->db->join('wami_users u', 'o.`user_id`=u.id');
		$this->db->where('u.phone_no', $phno);
		$this->db->where('o.id', $orderid);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->row();
		}
		return $row;
	}
	public function CheckUserconfirmdeliverybyotp($phno, $otp, $orderid){
		$this->db->select('u.*');
		$this->db->from('wami_order o');
		$this->db->join('wami_users u', 'o.`user_id`=u.id');
		$this->db->where('u.phone_no', $phno);
		$this->db->where('u.otp', $otp);
		$sql=$this->db->get();
		$row=array();
		if($sql->num_rows()>0){
			$row=$sql->row();
		}
		return $row;
	}
	
}