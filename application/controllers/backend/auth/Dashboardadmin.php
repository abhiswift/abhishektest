<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
class Dashboardadmin extends CI_Controller {

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
		$this->load->model('backend/auth/DashboardModel');
	}
	public function index()
	{
		/*$data['allproducts']=$this->DashboardModel->getProductVariationDetail('', 5);
		$data['alllogistics']=$this->DashboardModel->getLogistics();
		$data['allorders']=$this->DashboardModel->getOrders('', 5);
		$data['all_customers']=$this->DashboardModel->getAllCustomers();*/
		$this->load->view('backend/auth/dashboard');

	}
	public function customFunctions(){
		$urlname= $this->uri->segment(3);
		switch ($urlname) {

			case 'saveNews':
				$subcat_id= $this->security->xss_clean($this->input->post('subcat_id'));
				$title= $this->security->xss_clean($this->input->post('title'));
				$description1= $this->security->xss_clean($this->input->post('description1'));
				$description2= $this->security->xss_clean($this->input->post('description2'));
				$blockqoute= $this->security->xss_clean($this->input->post('blockqoute'));
				$videolink= $this->security->xss_clean($this->input->post('videolink'));


				$meta_title= $this->security->xss_clean($this->input->post('meta_title'));
				$meta_keywords= $this->security->xss_clean($this->input->post('meta_keywords'));
				$meta_description= $this->security->xss_clean($this->input->post('meta_description'));
				$og_url= $this->security->xss_clean($this->input->post('og_url'));
				$og_sitename= $this->security->xss_clean($this->input->post('og_sitename'));


				$og_type= $this->security->xss_clean($this->input->post('og_type'));
				
				$og_title= $this->security->xss_clean($this->input->post('og_title'));
				$og_description= $this->security->xss_clean($this->input->post('og_description'));
				$canonical_link= $this->security->xss_clean($this->input->post('canonical_link'));
				$twitter_card= $this->security->xss_clean($this->input->post('twitter_card'));
				$twitter_site= $this->security->xss_clean($this->input->post('twitter_site'));
				$twitter_creator= $this->security->xss_clean($this->input->post('twitter_creator'));
				$twitter_title	= $this->security->xss_clean($this->input->post('twitter_title'));
				$twitter_description= $this->security->xss_clean($this->input->post('twitter_description'));

				$twitter_url= $this->security->xss_clean($this->input->post('twitter_url'));

				$this->form_validation->set_rules('subcat_id', 'Category', 'callback_selectMastercat');
				$this->form_validation->set_rules('title', 'Title', 'required');
				$this->form_validation->set_rules('description1', 'Description1', 'required');
				$this->form_validation->set_rules('description2', 'Description2', 'required');
				$image1=$image2="";
				$og_image=$twitter_image=null;
				$data['allcategories']=$this->DashboardModel->getCategory();
				if ($this->form_validation->run() == FALSE){
					$this->load->view('backend/auth/addnews', $data);
				}else{
					if(!empty($_FILES['image1']['name'])){
						$image1=do_upload_normal('image1');
					}
					if(!empty($_FILES['image2']['name'])){
						$image2=do_upload_normal('image2');
					}
					if(!empty($_FILES['og_image']['name'])){
						$og_image=do_upload_normal('og_image');
					}
					if(!empty($_FILES['twitter_image']['name'])){
						$twitter_image=do_upload_normal('twitter_image');
					}
					$data_array=array(
						'subcat_id'=>$subcat_id,
						'title'=>$title,
						'description1'=>$description1,
						'description2'=>$description2,
						'blockqoute'=>$blockqoute,
						'image1'=>$image1,
						'image2'=>$image2,
						'meta_title'=>$meta_title,
						'meta_keywords'=>$meta_keywords,
						'meta_description'=>$meta_description,
						'og_url'=>$og_url,
						'og_sitename'=>$og_sitename,
						'og_type'=>$og_type,
						'og_image'=>$og_image,
						'og_title'=>$og_title,
						'og_description'=>$og_description,
						'canonical_link'=>$canonical_link,
						'twitter_card'=>$twitter_card,
						'twitter_site'=>$twitter_site,
						'twitter_creator'=>$twitter_creator,
						'twitter_title'=>$twitter_title,
						'twitter_description'=>$twitter_description,
						'twitter_image'=>$twitter_image,
						'twitter_url'=>$twitter_url,
						'videolink'=>$videolink
					);
					$this->DashboardModel->insertNews($data_array);
					$this->session->set_flashdata('news_add_msg','<div class="alert alert-success">News added successfuly.</div>');

					redirect('admincontrol/dashboardadmin/manage-news');
				}
				break;

			case 'updateNews':
				$subcat_id= $this->security->xss_clean($this->input->post('subcat_id'));
				$title= $this->security->xss_clean($this->input->post('title'));
				$description1= $this->security->xss_clean($this->input->post('description1'));
				$description2= $this->security->xss_clean($this->input->post('description2'));
				$blockqoute= $this->security->xss_clean($this->input->post('blockqoute'));
				$newsid= $this->security->xss_clean($this->input->post('newsid'));
				$videolink= $this->security->xss_clean($this->input->post('videolink'));

				$meta_title= $this->security->xss_clean($this->input->post('meta_title'));
				$meta_keywords= $this->security->xss_clean($this->input->post('meta_keywords'));
				$meta_description= $this->security->xss_clean($this->input->post('meta_description'));
				$og_url= $this->security->xss_clean($this->input->post('og_url'));
				$og_sitename= $this->security->xss_clean($this->input->post('og_sitename'));


				$og_type= $this->security->xss_clean($this->input->post('og_type'));
				
				$og_title= $this->security->xss_clean($this->input->post('og_title'));
				$og_description= $this->security->xss_clean($this->input->post('og_description'));
				$canonical_link= $this->security->xss_clean($this->input->post('canonical_link'));
				$twitter_card= $this->security->xss_clean($this->input->post('twitter_card'));
				$twitter_site= $this->security->xss_clean($this->input->post('twitter_site'));
				$twitter_creator= $this->security->xss_clean($this->input->post('twitter_creator'));
				$twitter_title	= $this->security->xss_clean($this->input->post('twitter_title'));
				$twitter_description= $this->security->xss_clean($this->input->post('twitter_description'));

				$twitter_url= $this->security->xss_clean($this->input->post('twitter_url'));

				$this->form_validation->set_rules('subcat_id', 'Category', 'callback_selectMastercat');
				$this->form_validation->set_rules('title', 'Title', 'required');
				$this->form_validation->set_rules('description1', 'Description1', 'required');
				$this->form_validation->set_rules('description2', 'Description2', 'required');
				$image1=$image2="";
				$data['allcategories']=$this->DashboardModel->getCategory();
				$data['newsdetail']=$this->DashboardModel->getNews($newsid);

				
				if ($this->form_validation->run() == FALSE){
					//$this->load->view('backend/auth/addnews', $data);
					redirect(base_url('admincontrol/dashboardadmin/editNews/'.$newsid));
				}else{
					if(!empty($_FILES['image1']['name'])){
						$image1=do_upload_normal('image1');
					}else{
						$image1=$data['newsdetail']->image1;
					}
					if(!empty($_FILES['image2']['name'])){
						$image2=do_upload_normal('image2');
					}else{
						$image2=$data['newsdetail']->image2;
					}
					if(!empty($_FILES['og_image']['name'])){
						$og_image=do_upload_normal('og_image');
					}else{
						$og_image=$data['newsdetail']->og_image;
					}
					if(!empty($_FILES['twitter_image']['name'])){
						$twitter_image=do_upload_normal('twitter_image');
					}else{
						$twitter_image=	$data['newsdetail']->twitter_image;
					}
					$data_array=array(
						'subcat_id'=>$subcat_id,
						'title'=>$title,
						'description1'=>$description1,
						'description2'=>$description2,
						'blockqoute'=>$blockqoute,
						'image1'=>$image1,
						'image2'=>$image2,
						'meta_title'=>$meta_title,
						'meta_keywords'=>$meta_keywords,
						'meta_description'=>$meta_description,
						'og_url'=>$og_url,
						'og_sitename'=>$og_sitename,
						'og_type'=>$og_type,
						'og_image'=>$og_image,
						'og_title'=>$og_title,
						'og_description'=>$og_description,
						'canonical_link'=>$canonical_link,
						'twitter_card'=>$twitter_card,
						'twitter_site'=>$twitter_site,
						'twitter_creator'=>$twitter_creator,
						'twitter_title'=>$twitter_title,
						'twitter_description'=>$twitter_description,
						'twitter_image'=>$twitter_image,
						'twitter_url'=>$twitter_url,
						'videolink'=>$videolink,
					);
					$this->DashboardModel->editNews($data_array, $newsid);
					$this->session->set_flashdata('news_add_msg','<div class="alert alert-success">News updated successfuly.</div>');

					redirect('admincontrol/dashboardadmin/manage-news');
				}
				break;

			case 'manage-news':
				$data['all_news']=$this->DashboardModel->getNews();
				$this->load->view('backend/auth/news', $data);
				break;

			case 'add-news':
				$data['allcategories']=$this->DashboardModel->getCategory();
				$this->load->view('backend/auth/addnews', $data);
				break;

			case 'manage-videos':
				$data['allvideos']=$this->DashboardModel->getVideos();
				$this->load->view('backend/auth/videos', $data);
				break;

			case 'add-videos':
				$this->load->view('backend/auth/addvideos');
				break;

			case 'submitVideo':
				
				$title= $this->security->xss_clean($this->input->post('title'));
				$image= $this->security->xss_clean($this->input->post('image'));
				$video= $this->security->xss_clean($this->input->post('video'));
				

				
				$this->form_validation->set_rules('title', 'Title', 'required');
				$this->form_validation->set_rules('video', 'Link', 'required');
				
				$image1=$image2="";
				$data['allvideos']=$this->DashboardModel->getVideos();
				if ($this->form_validation->run() == FALSE){
					$this->load->view('backend/auth/addvideos', $data);
				}else{
					if(!empty($_FILES['image']['name'])){
						$image=do_upload_normal('image');
					}
					
					$data_array=array(
						'title'=>$title,
						'video'=>$video,
						'image'=>$image,
					);
					$this->DashboardModel->insertVideos($data_array);
					$this->session->set_flashdata('video_add_msg','<div class="alert alert-success">Video added successfuly.</div>');

					redirect('admincontrol/dashboardadmin/manage-videos');
				}
				break;


			case 'updateVideo':
				$title= $this->security->xss_clean($this->input->post('title'));
				$image= $this->security->xss_clean($this->input->post('image'));
				$video= $this->security->xss_clean($this->input->post('video'));
				$id= $this->security->xss_clean($this->input->post('videoid'));

				
				$this->form_validation->set_rules('title', 'Title', 'required');
				$this->form_validation->set_rules('video', 'Link', 'required');
				
				$image1=$image2="";
				$image_hidden=$this->DashboardModel->getVideos($id);
				if ($this->form_validation->run() == FALSE){
					redirect(base_url('admincontrol/dashboardadmin/editVideo/'.$id));
				}else{
					if(!empty($_FILES['image']['name'])){
						$image=do_upload_normal('image');
						if($image_hidden->image!=''){

							unlink(base_url($image_hidden->image));
						}
						
					}else{
						$image=$image_hidden->image;
					}
					
					$data_array=array(
						'title'=>$title,
						'video'=>$video,
						'image'=>$image,
					);
					$this->DashboardModel->editVideos($data_array, $id);
					$this->session->set_flashdata('video_add_msg','<div class="alert alert-success">Video added successfuly.</div>');

					redirect('admincontrol/dashboardadmin/manage-videos');
				}
				break;

			case 'master-settings':
				$data['delivery_charge']=$this->DashboardModel->getDeliverycharge();
				$data['security_charge']=$this->DashboardModel->getSecuritycharge();
				$this->load->view('backend/auth/mastersettings', $data);
				break;


			case 'about-us':
				$data['content']=$this->DashboardModel->getAboutUs();
				$this->load->view('backend/auth/aboutus', $data);
				break;

			case 'privacy-policy':
				$data['content']=$this->DashboardModel->getPrivacy();
				$this->load->view('backend/auth/privacypolicy', $data);
				break;

			

			case 'saveAboutUs':
				$content= $this->security->xss_clean($this->input->post('content'));
				$meta_title= $this->security->xss_clean($this->input->post('meta_title'));
				$meta_keywords= $this->security->xss_clean($this->input->post('meta_keywords'));
				$meta_description= $this->security->xss_clean($this->input->post('meta_description'));
				$og_url= $this->security->xss_clean($this->input->post('og_url'));
				$og_sitename= $this->security->xss_clean($this->input->post('og_sitename'));


				$og_type= $this->security->xss_clean($this->input->post('og_type'));
				
				$og_title= $this->security->xss_clean($this->input->post('og_title'));
				$og_description= $this->security->xss_clean($this->input->post('og_description'));
				$canonical_link= $this->security->xss_clean($this->input->post('canonical_link'));
				$twitter_card= $this->security->xss_clean($this->input->post('twitter_card'));
				$twitter_site= $this->security->xss_clean($this->input->post('twitter_site'));
				$twitter_creator= $this->security->xss_clean($this->input->post('twitter_creator'));
				$twitter_title	= $this->security->xss_clean($this->input->post('twitter_title'));
				$twitter_description= $this->security->xss_clean($this->input->post('twitter_description'));

				$twitter_url= $this->security->xss_clean($this->input->post('twitter_url'));

				
				$this->form_validation->set_rules('content', 'Description', 'required');
				$image1=$image2="";

				$data['aboutdetail']=$this->DashboardModel->getAboutUs();
				
				if ($this->form_validation->run() == FALSE){
					//$this->load->view('backend/auth/addnews', $data);
					redirect(base_url('admincontrol/dashboardadmin/about-us'));
				}else{
					if(!empty($_FILES['og_image']['name'])){
						$og_image=do_upload_normal('og_image');
					}else{
						$og_image=$data['aboutdetail']->og_image;
					}
					if(!empty($_FILES['twitter_image']['name'])){
						$twitter_image=do_upload_normal('twitter_image');
					}else{
						$twitter_image=$data['aboutdetail']->twitter_image;
					}
					$data_array=array(
						'content'=>$content,
						'meta_title'=>$meta_title,
						'meta_keywords'=>$meta_keywords,
						'meta_description'=>$meta_description,
						'og_url'=>$og_url,
						'og_sitename'=>$og_sitename,
						'og_type'=>$og_type,
						'og_image'=>$og_image,
						'og_title'=>$og_title,
						'og_description'=>$og_description,
						'canonical_link'=>$canonical_link,
						'twitter_card'=>$twitter_card,
						'twitter_site'=>$twitter_site,
						'twitter_creator'=>$twitter_creator,
						'twitter_title'=>$twitter_title,
						'twitter_description'=>$twitter_description,
						'twitter_image'=>$twitter_image,
						'twitter_url'=>$twitter_url,
					);
					$this->DashboardModel->editAboutUs($data_array, $newsid);
					$this->session->set_flashdata('aboutus_add_msg','<div class="alert alert-success">Content updated successfuly.</div>');

					redirect('admincontrol/dashboardadmin/about-us');
				}
				break;

			
			case 'savePrivacy':
				$content= $this->security->xss_clean($this->input->post('content'));
				$meta_title= $this->security->xss_clean($this->input->post('meta_title'));
				$meta_keywords= $this->security->xss_clean($this->input->post('meta_keywords'));
				$meta_description= $this->security->xss_clean($this->input->post('meta_description'));
				$og_url= $this->security->xss_clean($this->input->post('og_url'));
				$og_sitename= $this->security->xss_clean($this->input->post('og_sitename'));


				$og_type= $this->security->xss_clean($this->input->post('og_type'));
				
				$og_title= $this->security->xss_clean($this->input->post('og_title'));
				$og_description= $this->security->xss_clean($this->input->post('og_description'));
				$canonical_link= $this->security->xss_clean($this->input->post('canonical_link'));
				$twitter_card= $this->security->xss_clean($this->input->post('twitter_card'));
				$twitter_site= $this->security->xss_clean($this->input->post('twitter_site'));
				$twitter_creator= $this->security->xss_clean($this->input->post('twitter_creator'));
				$twitter_title	= $this->security->xss_clean($this->input->post('twitter_title'));
				$twitter_description= $this->security->xss_clean($this->input->post('twitter_description'));

				$twitter_url= $this->security->xss_clean($this->input->post('twitter_url'));

				
				$this->form_validation->set_rules('content', 'Description', 'required');
				$image1=$image2="";

				$data['aboutdetail']=$this->DashboardModel->getAboutUs();
				
				if ($this->form_validation->run() == FALSE){
					//$this->load->view('backend/auth/addnews', $data);
					redirect(base_url('admincontrol/dashboardadmin/privacy-policy'));
				}else{
					if(!empty($_FILES['og_image']['name'])){
						$og_image=do_upload_normal('og_image');
					}else{
						$og_image=$data['aboutdetail']->og_image;
					}
					if(!empty($_FILES['twitter_image']['name'])){
						$twitter_image=do_upload_normal('twitter_image');
					}else{
						$twitter_image=$data['aboutdetail']->twitter_image;
					}
					$data_array=array(
						'content'=>$content,
						'meta_title'=>$meta_title,
						'meta_keywords'=>$meta_keywords,
						'meta_description'=>$meta_description,
						'og_url'=>$og_url,
						'og_sitename'=>$og_sitename,
						'og_type'=>$og_type,
						'og_image'=>$og_image,
						'og_title'=>$og_title,
						'og_description'=>$og_description,
						'canonical_link'=>$canonical_link,
						'twitter_card'=>$twitter_card,
						'twitter_site'=>$twitter_site,
						'twitter_creator'=>$twitter_creator,
						'twitter_title'=>$twitter_title,
						'twitter_description'=>$twitter_description,
						'twitter_image'=>$twitter_image,
						'twitter_url'=>$twitter_url,
					);
					$this->DashboardModel->editPrivacy($data_array, $newsid);
					$this->session->set_flashdata('aboutus_add_msg','<div class="alert alert-success">Content updated successfuly.</div>');

					redirect('admincontrol/dashboardadmin/privacy-policy');
				}
				break;

			case 'mastercategory':
				$data['allmastercategory']=$this->DashboardModel->getMastercategories();
				$this->load->view('backend/auth/mastercategory', $data);
				break;

			case 'add-master-category':
				$this->load->view('backend/auth/addmastercategory');
				break;

			case 'submitMasterCategory':
				$name= $this->security->xss_clean($this->input->post('name'));
				$meta_title= $this->security->xss_clean($this->input->post('meta_title'));
				$meta_keywords= $this->security->xss_clean($this->input->post('meta_keywords'));
				$meta_description= $this->security->xss_clean($this->input->post('meta_description'));
				$og_url= $this->security->xss_clean($this->input->post('og_url'));
				$og_sitename= $this->security->xss_clean($this->input->post('og_sitename'));


				$og_type= $this->security->xss_clean($this->input->post('og_type'));
				
				$og_title= $this->security->xss_clean($this->input->post('og_title'));
				$og_description= $this->security->xss_clean($this->input->post('og_description'));
				$canonical_link= $this->security->xss_clean($this->input->post('canonical_link'));
				$twitter_card= $this->security->xss_clean($this->input->post('twitter_card'));
				$twitter_site= $this->security->xss_clean($this->input->post('twitter_site'));
				$twitter_creator= $this->security->xss_clean($this->input->post('twitter_creator'));
				$twitter_title	= $this->security->xss_clean($this->input->post('twitter_title'));
				$twitter_description= $this->security->xss_clean($this->input->post('twitter_description'));

				$twitter_url= $this->security->xss_clean($this->input->post('twitter_url'));

				$this->form_validation->set_rules('name', 'Category Name', 'required');
				$og_image=$twitter_image=null;
				$data['allmastercategory']=$this->DashboardModel->getMastercategories();
				if ($this->form_validation->run() == FALSE){
					$this->load->view('backend/auth/addmastercategory');
				}else{
					if(!empty($_FILES['og_image']['name'])){
						$og_image=do_upload_normal('og_image');
					}
					if(!empty($_FILES['twitter_image']['name'])){
						$twitter_image=do_upload_normal('twitter_image');
					}
					$data_master=array(
						'cat_name'=>$name,
						'meta_title'=>$meta_title,
						'meta_keywords'=>$meta_keywords,
						'meta_description'=>$meta_description,
						'og_url'=>$og_url,
						'og_sitename'=>$og_sitename,
						'og_type'=>$og_type,
						'og_image'=>$og_image,
						'og_title'=>$og_title,
						'og_description'=>$og_description,
						'canonical_link'=>$canonical_link,
						'twitter_card'=>$twitter_card,
						'twitter_site'=>$twitter_site,
						'twitter_creator'=>$twitter_creator,
						'twitter_title'=>$twitter_title,
						'twitter_description'=>$twitter_description,
						'twitter_image'=>$twitter_image,
						'twitter_url'=>$twitter_url,
					);
					$arraymsg=$this->DashboardModel->addMastercategory($data_master);
					if($arraymsg['status']==2){
						$this->session->set_flashdata('update_mastercat_msg',$arraymsg['msg']);
						redirect('admincontrol/dashboardadmin/mastercategory', $data);
					}else{
						$this->session->set_flashdata('update_mastercat_msg',$arraymsg['msg']);
						$this->load->view('backend/auth/addmastercategory');
					}
				}
				break;

			case 'updateMasterCategory':
				$name= $this->security->xss_clean($this->input->post('name'));
				$mastercatid= $this->security->xss_clean($this->input->post('mastercatid'));

				$meta_title= $this->security->xss_clean($this->input->post('meta_title'));
				$meta_keywords= $this->security->xss_clean($this->input->post('meta_keywords'));
				$meta_description= $this->security->xss_clean($this->input->post('meta_description'));
				$og_url= $this->security->xss_clean($this->input->post('og_url'));
				$og_sitename= $this->security->xss_clean($this->input->post('og_sitename'));


				$og_type= $this->security->xss_clean($this->input->post('og_type'));
				
				$og_title= $this->security->xss_clean($this->input->post('og_title'));
				$og_description= $this->security->xss_clean($this->input->post('og_description'));
				$canonical_link= $this->security->xss_clean($this->input->post('canonical_link'));
				$twitter_card= $this->security->xss_clean($this->input->post('twitter_card'));
				$twitter_site= $this->security->xss_clean($this->input->post('twitter_site'));
				$twitter_creator= $this->security->xss_clean($this->input->post('twitter_creator'));
				$twitter_title	= $this->security->xss_clean($this->input->post('twitter_title'));
				$twitter_description= $this->security->xss_clean($this->input->post('twitter_description'));

				$twitter_url= $this->security->xss_clean($this->input->post('twitter_url'));


				$this->form_validation->set_rules('name', 'Category Name', 'required');
				$data['allmastercategory']=$this->DashboardModel->getMastercategories($mastercatid);
				$og_image=$twitter_image=null;
				if ($this->form_validation->run() == FALSE){
					$this->load->view('backend/auth/editMastercategory', $data);
				}else{
					if(!empty($_FILES['og_image']['name'])){
						$og_image=do_upload_normal('og_image');
					}
					if(!empty($_FILES['twitter_image']['name'])){
						$twitter_image=do_upload_normal('twitter_image');
					}
					$data_master=array(
						'cat_name'=>$name,
						'meta_title'=>$meta_title,
						'meta_keywords'=>$meta_keywords,
						'meta_description'=>$meta_description,
						'og_url'=>$og_url,
						'og_sitename'=>$og_sitename,
						'og_type'=>$og_type,
						'og_image'=>$og_image,
						'og_title'=>$og_title,
						'og_description'=>$og_description,
						'canonical_link'=>$canonical_link,
						'twitter_card'=>$twitter_card,
						'twitter_site'=>$twitter_site,
						'twitter_creator'=>$twitter_creator,
						'twitter_title'=>$twitter_title,
						'twitter_description'=>$twitter_description,
						'twitter_image'=>$twitter_image,
						'twitter_url'=>$twitter_url,
					);
					$arraymsg=$this->DashboardModel->saveMastercategory($mastercatid, $data_master);
					if($arraymsg['status']==2){
						$this->session->set_flashdata('update_mastercat_msg',$arraymsg['msg']);
						$data_master_all['allmastercategory']=$this->DashboardModel->getMastercategories();
						redirect('admincontrol/dashboardadmin/mastercategory', $data_master_all);
					}else{
						$this->session->set_flashdata('update_mastercat_msg',$arraymsg['msg']);
						$this->load->view('backend/auth/editMastercategory', $data);
					}
				}
				break;


			case 'adminprofile':
				$data['admindata']=$this->DashboardModel->getAdmindata();
				$this->load->view('backend/auth/adminprofile', $data);
				break;

			case 'updateAdminProfile':
				$full_name= $this->security->xss_clean($this->input->post('full_name'));
				$username= $this->security->xss_clean($this->input->post('username'));
				$email= $this->security->xss_clean($this->input->post('email'));
				$phone_no= $this->security->xss_clean($this->input->post('phone_no'));

				$this->form_validation->set_rules('full_name', 'Name', 'required');

				if(!empty($phone_no)){
					$this->form_validation->set_rules('phone_no', 'Phone Number', 'callback_checkphno');
				}
				
				$this->form_validation->set_rules('email', 'Email Id', 'callback_checkemail');
				
				$data['admindata']=$this->DashboardModel->getAdmindata();
				if ($this->form_validation->run() == FALSE){
					$this->load->view('backend/auth/adminprofile', $data);
				}else{
					$data_user=array(
						'full_name'=>$full_name,
						'username'=>$username,
						'email'=>$email,
						'phone_no'=>$phone_no
					);
					$arraymsg=$this->DashboardModel->saveAdminData($data_user);
					if($arraymsg['status']==2){
						$this->session->set_flashdata('admin_profile_msg',$arraymsg['msg']);
						redirect('admincontrol/dashboardadmin/adminprofile');
					}else{
						$this->session->set_flashdata('admin_profile_msg',$arraymsg['msg']);
						$this->load->view('backend/auth/adminprofile', $data);
					}
				}
				break;

			case 'updateAdminpassword':
				$password= $this->security->xss_clean($this->input->post('password'));
				$cnfpassword= $this->security->xss_clean($this->input->post('cnfpassword'));
				$arraymsg=null;
				if(empty($password)){
					$arraymsg=array('status'=>1, 'msg'=>'Please provide password');
				}else if(empty($cnfpassword)){
					$arraymsg=array('status'=>1, 'msg'=>'Please confirm password');
				}else if($password!==$cnfpassword){
					$arraymsg=array('status'=>1, 'msg'=>'Password and confirmation password do not match.');
				}else{
					$data_admin=array(
						'password'=>password_hash($password, PASSWORD_DEFAULT)
					);
					$this->DashboardModel->updateadminpassword($data_admin);
					$arraymsg=array('status'=>2, 'msg'=>'Password updated successfully.');
				}
				echo json_encode($arraymsg);
				break;

			case 'allcustomers':
				$data['all_customers']=$this->DashboardModel->getAllCustomers();
				$this->load->view('backend/auth/customers', $data);
				break;

			
			

			case 'category':
				$data['allcategories']=$this->DashboardModel->getCategory();
				$this->load->view('backend/auth/categories', $data);
				break;	

			case 'add-category':
				$data['allmastercategory']=$this->DashboardModel->getMastercategories();
				$this->load->view('backend/auth/addcategory', $data);
				break;

			case 'submitCategory':
				$category_name= $this->security->xss_clean($this->input->post('category_name'));
				$master_category= $this->security->xss_clean($this->input->post('master_category'));

				$meta_title= $this->security->xss_clean($this->input->post('meta_title'));
				$meta_keywords= $this->security->xss_clean($this->input->post('meta_keywords'));
				$meta_description= $this->security->xss_clean($this->input->post('meta_description'));
				$og_url= $this->security->xss_clean($this->input->post('og_url'));
				$og_sitename= $this->security->xss_clean($this->input->post('og_sitename'));


				$og_type= $this->security->xss_clean($this->input->post('og_type'));
				
				$og_title= $this->security->xss_clean($this->input->post('og_title'));
				$og_description= $this->security->xss_clean($this->input->post('og_description'));
				$canonical_link= $this->security->xss_clean($this->input->post('canonical_link'));
				$twitter_card= $this->security->xss_clean($this->input->post('twitter_card'));
				$twitter_site= $this->security->xss_clean($this->input->post('twitter_site'));
				$twitter_creator= $this->security->xss_clean($this->input->post('twitter_creator'));
				$twitter_title	= $this->security->xss_clean($this->input->post('twitter_title'));
				$twitter_description= $this->security->xss_clean($this->input->post('twitter_description'));

				$twitter_url= $this->security->xss_clean($this->input->post('twitter_url'));

				$category_image=$og_image=$twitter_image=null;
				$this->form_validation->set_rules('master_category', 'Master Category', 'callback_mastercatfromchildcat');
				$this->form_validation->set_rules('category_name', 'Category Name', 'required');
				
				
				$data['allmastercategory']=$this->DashboardModel->getMastercategories();
				if ($this->form_validation->run() == FALSE){
					$this->load->view('backend/auth/addcategory',$data);
				}else{
					if(!empty($_FILES['og_image']['name'])){
						$og_image=do_upload_normal('og_image');
					}
					if(!empty($_FILES['twitter_image']['name'])){
						$twitter_image=do_upload_normal('twitter_image');
					}

					$data_master=array(
						'cat_id'=>$master_category,
						'subcat_name'=>$category_name,
						'meta_title'=>$meta_title,
						'meta_keywords'=>$meta_keywords,
						'meta_description'=>$meta_description,
						'og_url'=>$og_url,
						'og_sitename'=>$og_sitename,
						'og_type'=>$og_type,
						'og_image'=>$og_image,
						'og_title'=>$og_title,
						'og_description'=>$og_description,
						'canonical_link'=>$canonical_link,
						'twitter_card'=>$twitter_card,
						'twitter_site'=>$twitter_site,
						'twitter_creator'=>$twitter_creator,
						'twitter_title'=>$twitter_title,
						'twitter_description'=>$twitter_description,
						'twitter_image'=>$twitter_image,
						'twitter_url'=>$twitter_url,
					);

					$arraymsg=$this->DashboardModel->addCategory($data_master);
					if($arraymsg['status']==2){
						$this->session->set_flashdata('add_category_msg',$arraymsg['msg']);
						redirect('admincontrol/dashboardadmin/category');
					}else{
						$this->session->set_flashdata('add_category_msg',$arraymsg['msg']);
						$this->load->view('backend/auth/addcategory');
					}
				}
				break;

			case 'updateCategory':
				
				$category_name= $this->security->xss_clean($this->input->post('category_name'));
				$categoryid= $this->security->xss_clean($this->input->post('categoryid'));
				$master_category= $this->security->xss_clean($this->input->post('master_category'));
				$category_detail=$this->DashboardModel->getCategory($categoryid);

				$meta_title= $this->security->xss_clean($this->input->post('meta_title'));
				$meta_keywords= $this->security->xss_clean($this->input->post('meta_keywords'));
				$meta_description= $this->security->xss_clean($this->input->post('meta_description'));
				$og_url= $this->security->xss_clean($this->input->post('og_url'));
				$og_sitename= $this->security->xss_clean($this->input->post('og_sitename'));


				$og_type= $this->security->xss_clean($this->input->post('og_type'));
				
				$og_title= $this->security->xss_clean($this->input->post('og_title'));
				$og_description= $this->security->xss_clean($this->input->post('og_description'));
				$canonical_link= $this->security->xss_clean($this->input->post('canonical_link'));
				$twitter_card= $this->security->xss_clean($this->input->post('twitter_card'));
				$twitter_site= $this->security->xss_clean($this->input->post('twitter_site'));
				$twitter_creator= $this->security->xss_clean($this->input->post('twitter_creator'));
				$twitter_title	= $this->security->xss_clean($this->input->post('twitter_title'));
				$twitter_description= $this->security->xss_clean($this->input->post('twitter_description'));

				$twitter_url= $this->security->xss_clean($this->input->post('twitter_url'));
				

				$this->form_validation->set_rules('master_category', 'Master Category', 'callback_mastercatfromchildcat');
				$this->form_validation->set_rules('category_name', 'Category Name', 'required');

				
				$data['allmastercategory']=$this->DashboardModel->getMastercategories();
				$data['category_detail']=$this->DashboardModel->getCategory($categoryid);
				if ($this->form_validation->run() == FALSE){
					$this->load->view('backend/auth/editcategory', $data);
				}else{
					
					if(!empty($_FILES['og_image']['name'])){
						$og_image=do_upload_normal('og_image');
					}else{
						$og_image=$category_detail->og_image;
					}
					if(!empty($_FILES['twitter_image']['name'])){
						$twitter_image=do_upload_normal('twitter_image');
					}else{
						$twitter_image=$category_detail->twitter_image;
					}

					$data_master=array(
						'cat_id'=>$master_category,
						'subcat_name'=>$category_name,
						'meta_title'=>$meta_title,
						'meta_keywords'=>$meta_keywords,
						'meta_description'=>$meta_description,
						'og_url'=>$og_url,
						'og_sitename'=>$og_sitename,
						'og_type'=>$og_type,
						'og_image'=>$og_image,
						'og_title'=>$og_title,
						'og_description'=>$og_description,
						'canonical_link'=>$canonical_link,
						'twitter_card'=>$twitter_card,
						'twitter_site'=>$twitter_site,
						'twitter_creator'=>$twitter_creator,
						'twitter_title'=>$twitter_title,
						'twitter_description'=>$twitter_description,
						'twitter_image'=>$twitter_image,
						'twitter_url'=>$twitter_url,
					);
					
					$arraymsg=$this->DashboardModel->editCategory($data_master, $categoryid);
					if($arraymsg['status']==2){
						$this->session->set_flashdata('add_category_msg',$arraymsg['msg']);
						redirect('admincontrol/dashboardadmin/category');
					}else{
						$this->session->set_flashdata('add_category_msg',$arraymsg['msg']);
						$this->load->view('backend/auth/editcategory', $data);
					}
				}
				break;

			case 'changestatus':
				$cat= $this->security->xss_clean($this->input->post('cat'));
				$id= $this->security->xss_clean($this->input->post('id'));
				$stat= $this->security->xss_clean($this->input->post('stat'));
				
				$returnmsg= $this->updatestatus($cat, $id, $stat);
				echo json_encode($returnmsg);
				break;

			

			

			
			default:
				# code...
				break;
		}
	}
	public function Fourparamfunctions(){
		$urlname= $this->uri->segment(3);
		$paramid= $this->uri->segment(4);
		switch ($urlname) {

		
			case 'editNews':
				$data['allcategories']=$this->DashboardModel->getCategory();
				$data['newsdetail']=$this->DashboardModel->getNews($paramid);
				$this->load->view('backend/auth/editnews', $data);
				break;

			case 'editMasterCategory':
				$data['allmastercategory']=$this->DashboardModel->getMastercategories($paramid);
				$this->load->view('backend/auth/editMastercategory', $data);
				break;

			case 'customer-details':
				$data['customeraddresses']=$this->DashboardModel->getCustomerAddresses($paramid);
				$this->load->view('backend/auth/viewCustomerAddresses', $data);
				break;

			
			case 'editCategory':
				
				
				$data['category_detail']=$this->DashboardModel->getCategory($paramid);
				$data['allmastercategory']=$this->DashboardModel->getMastercategories();
				$this->load->view('backend/auth/editcategory', $data);
				break;

			case 'editVideo':
				$data['videodetail']=$this->DashboardModel->getVideos($paramid);
				$this->load->view('backend/auth/editvideos', $data);
				break;

				

			

			default:
				# code...
				break;
		}
	}
	
	public function checkbrand($str){
		if($str=='' || empty($str)){
			$this->form_validation->set_message('checkbrand', 'Please select any brand.');
            return FALSE;
		}
        else
        {
            return TRUE;
        }
    }
    public function checkorderstatus($str){
		if($str=='All'){
			$this->form_validation->set_message('checkorderstatus', 'Please select any status.');
            return FALSE;
		}
        else
        {
            return TRUE;
        }
    }
    public function checklogisticselect($str){
		if($str=='All'){
			$this->form_validation->set_message('checklogisticselect', 'Please select any logistic.');
            return FALSE;
		}
        else
        {
            return TRUE;
        }
    }
    public function uploadimage(){
		if (empty($_FILES['category_image']['name'])) {
            $this->form_validation->set_message('uploadimage', 'Please upload any image.');
            return FALSE;
        }else if(imagetypevalidation('category_image')==false){
        	$this->form_validation->set_message('uploadimage', 'Images with .jpg, .png, .jpeg files supported.');
            return FALSE;
        }else{
            return true;
        }
    }
    public function uploadbannerimage(){
		if (empty($_FILES['banner_image']['name'])) {
            $this->form_validation->set_message('uploadbannerimage', 'Please upload any image.');
            return FALSE;
        }else if(imagetypevalidation('banner_image')==false){
        	$this->form_validation->set_message('uploadbannerimage', 'Images with .jpg, .png, .jpeg files supported.');
            return FALSE;
        }else{
            return true;
        }
    }

    public function uploadbrandimage(){
		if (empty($_FILES['brand_image']['name'])) {
            $this->form_validation->set_message('uploadbrandimage', 'Please upload any image.');
            return FALSE;
        }else if(imagetypevalidation('brand_image')==false){
        	$this->form_validation->set_message('uploadbrandimage', 'Images with .jpg, .png, .jpeg files supported.');
            return FALSE;
        }else{
            return true;
        }
    }
    
    public function uploadproductimage(){
		if (empty($_FILES['product_image']['name'])) {
            $this->form_validation->set_message('uploadproductimage', 'Please upload any image.');
            return FALSE;
        }else if(imagetypevalidation('product_image')==false){
        	$this->form_validation->set_message('uploadproductimage', 'Images with .jpg, .png, .jpeg files supported.');
            return FALSE;
        }else{
            return true;
        }
    }
    public function uploadvariationimagesingle(){
		if (empty($_FILES['variation_image']['name'])) {
            $this->form_validation->set_message('uploadvariationimagesingle', 'Please upload any image.');
            return FALSE;
        }else if(imagetypevalidation('variation_image')==false){
        	$this->form_validation->set_message('uploadvariationimagesingle', 'Images with .jpg, .png, .jpeg files supported.');
            return FALSE;
        }else{
            return true;
        }
    }
    
    public function uploadvariationimage(){
		if (empty($_FILES['variation_image']['name'])) {
            $this->form_validation->set_message('uploadvariationimage', 'Please upload any image.');
            return FALSE;
        }else if(imagetypevalidation_multiple('variation_image')==false){
        	$this->form_validation->set_message('uploadvariationimage', 'Images with .jpg, .png, .jpeg files supported.');
            return FALSE;
        }else{
            return true;
        }
    }
    public function checkcategoryinproduct($str){
		if($str=='All'){
			$this->form_validation->set_message('checkcategoryinproduct', 'Please select any category.');
            return FALSE;
		}
        else
        {
            return TRUE;
        }
    }
    public function selectBrandName($brand){
    	if($brand=='All'){
			$this->form_validation->set_message('selectBrandName', 'Please select any brand.');
            return FALSE;
		}
        else
        {
            return TRUE;
        }
    }
    public function mastercatfromchildcat($mastercat){
    	if($mastercat=='All'){
			$this->form_validation->set_message('mastercatfromchildcat', 'Please select any master category.');
            return FALSE;
		}
        else
        {
            return TRUE;
        }
    }

    public function selectMastercat($mastercat){
    	if($mastercat=='All'){
			$this->form_validation->set_message('selectMastercat', 'Please select any category.');
            return FALSE;
		}
        else
        {
            return TRUE;
        }
    }
    public function selectProducttype($prodtype){
    	if($prodtype=='All'){
			$this->form_validation->set_message('selectProducttype', 'Please select any product type.');
            return FALSE;
		}
        else
        {
            return TRUE;
        }
    }
    public function checkphno($str){
		if(!preg_match('/^[0-9]{10}+$/', $str)){
			$this->form_validation->set_message('checkphno', 'Please provide correct phone no.');
            return FALSE;
		}
        else
        {
            return TRUE;
        }
    }
    public function checkemail($str){
		if(!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $str)){
			$this->form_validation->set_message('checkemail', 'Please provide correct email id.');
            return FALSE;
		}
        else
        {
            return TRUE;
        }
    }
    public function updatestatus($cat, $id, $stat){
    	$arraymsg=null;
    	switch ($cat) {
    		case 'newslist':
				$data=array(
					'is_active'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('bulletin_news', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'mastercategorylist':
				$data=array(
					'is_active'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('bulletin_category', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'categorylist':
				$data=array(
					'is_active'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('bulletin_subcategory', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'videolist':
				$data=array(
					'is_active'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('bulletin_video', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    			

    		case 'promostatist':
    			$this->db->select('id');
    			$this->db->from('wami_promo_code');
    			$this->db->where('id<>', $id);
    			$this->db->where('status', 'Y');
    			$sql=$this->db->get();
    			if($sql->num_rows()>0){
    				$arraymsg=array('status'=>1, 'msg'=>'One Promo Code is already activated.');
    			}else{
    				

    				$data=array(
						'status'=>$stat,
					);
					$this->db->where('id', $id);
					$this->db->update('wami_promo_code', $data);
					$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
    			}
    			return $arraymsg;
    			break;

    		case 'newsposition1':
				$data=array(
					'position1'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('bulletin_news', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'newsposition2':
    			$this->db->select('id');
    			$this->db->from('bulletin_news');
    			$this->db->where('id<>', $id);
    			$this->db->where('position2', 2);
    			$sql=$this->db->get();
    			if($sql->num_rows()>0){
    				$arraymsg=array('status'=>1, 'msg'=>'Position 2 is already occupied.');
    			}else{
    				

    				$data=array(
						'position2'=>$stat,
					);
					$this->db->where('id', $id);
					$this->db->update('bulletin_news', $data);
					$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
    			}
    			return $arraymsg;
    			break;

    		case 'newsposition3':
				$this->db->select('id');
    			$this->db->from('bulletin_news');
    			$this->db->where('id<>', $id);
    			$this->db->where('position3', 2);
    			$sql=$this->db->get();
    			if($sql->num_rows()>0){
    				$arraymsg=array('status'=>1, 'msg'=>'Position 3 is already occupied.');
    			}else{
    				

    				$data=array(
						'position3'=>$stat,
					);
					$this->db->where('id', $id);
					$this->db->update('bulletin_news', $data);
					$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
    			}
    			return $arraymsg;
    			break;

    		case 'newsposition4':
				$this->db->select('id');
    			$this->db->from('bulletin_news');
    			$this->db->where('id<>', $id);
    			$this->db->where('position4', 2);
    			$sql=$this->db->get();
    			if($sql->num_rows()>0){
    				$arraymsg=array('status'=>1, 'msg'=>'Position 4 is already occupied.');
    			}else{
    				

    				$data=array(
						'position4'=>$stat,
					);
					$this->db->where('id', $id);
					$this->db->update('bulletin_news', $data);
					$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
    			}
    			return $arraymsg;
    			break;

    		case 'newslatest':
				$data=array(
					'is_latest'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('bulletin_news', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'latest_big':
				$this->db->select('id');
    			$this->db->from('bulletin_news');
    			$this->db->where('id<>', $id);
    			$this->db->where('is_latest_big', 2);
    			$sql=$this->db->get();
    			if($sql->num_rows()>0){
    				$arraymsg=array('status'=>1, 'msg'=>'Position already occupied.');
    			}else{
    				

    				$data=array(
						'is_latest_big'=>$stat,
					);
					$this->db->where('id', $id);
					$this->db->update('bulletin_news', $data);
					$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
    			}
    			return $arraymsg;
    			break;
    			
    		case 'entertain_big':
				$this->db->select('id');
    			$this->db->from('bulletin_news');
    			$this->db->where('id<>', $id);
    			$this->db->where('entertain_big', 2);
    			$sql=$this->db->get();
    			if($sql->num_rows()>0){
    				$arraymsg=array('status'=>1, 'msg'=>'Position already occupied.');
    			}else{
    				

    				$data=array(
						'entertain_big'=>$stat,
					);
					$this->db->where('id', $id);
					$this->db->update('bulletin_news', $data);
					$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
    			}
    			return $arraymsg;
    			break;
    			
    		case 'travel_big':
				$this->db->select('id');
    			$this->db->from('bulletin_news');
    			$this->db->where('id<>', $id);
    			$this->db->where('travel_big', 2);
    			$sql=$this->db->get();
    			if($sql->num_rows()>0){
    				$arraymsg=array('status'=>1, 'msg'=>'Position already occupied.');
    			}else{
    				

    				$data=array(
						'travel_big'=>$stat,
					);
					$this->db->where('id', $id);
					$this->db->update('bulletin_news', $data);
					$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
    			}
    			return $arraymsg;
    			break;
    			
    		case 'food_big':
				$this->db->select('id');
    			$this->db->from('bulletin_news');
    			$this->db->where('id<>', $id);
    			$this->db->where('food_big', 2);
    			$sql=$this->db->get();
    			if($sql->num_rows()>0){
    				$arraymsg=array('status'=>1, 'msg'=>'Position already occupied.');
    			}else{
    				

    				$data=array(
						'food_big'=>$stat,
					);
					$this->db->where('id', $id);
					$this->db->update('bulletin_news', $data);
					$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
    			}
    			return $arraymsg;
    			break;

    		case 'newspopular':
    			$data=array(
					'is_popular'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('bulletin_news', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'newspopularbig':
				$this->db->select('id');
    			$this->db->from('bulletin_news');
    			$this->db->where('id<>', $id);
    			$this->db->where('popular_big', 2);
    			$sql=$this->db->get();
    			if($sql->num_rows()>0){
    				$arraymsg=array('status'=>1, 'msg'=>'Position already occupied.');
    			}else{
    				

    				$data=array(
						'popular_big'=>$stat,
					);
					$this->db->where('id', $id);
					$this->db->update('bulletin_news', $data);
					$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
    			}
    			return $arraymsg;
    			break;

    			

    		case 'newstrending':
				$data=array(
					'is_trending'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('bulletin_news', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'logisticlist':
				$data=array(
					'user_active'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('wami_users', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'productlist':
				$data=array(
					'is_active'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('wami_product', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'bannerlist':
    			$data=array(
					'is_active'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('wami_banner', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'bannerlist2':
    			$data=array(
					'is_active'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('wami_banner2', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'bannerlist3':
    			$data=array(
					'is_active'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('wami_banner3', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		case 'customerlist':
    			$data=array(
					'user_active'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('wami_users', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;
    			
    		case 'variationstocklist':
    			$data=array(
					'stock_active'=>$stat,
				);
				$this->db->where('id', $id);
				$this->db->update('wami_product_variation', $data);
				$arraymsg=array('status'=>2, 'msg'=>'Data successfully updated');
				return $arraymsg;
    			break;

    		default:
    			# code...
    			break;
    	}
    }
}