<?php
function do_upload_normal($img){
  $ci=& get_instance();
  $config['upload_path'] = '../bulletinstory.com/storage/app/public/images/'; //path folder
  $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
  $config['encrypt_name'] = TRUE;
  $ci->load->library('upload');

  $ci->upload->initialize($config);
  if ($ci->upload->do_upload($img)){
      $gbr = $ci->upload->data();
    //Compress Image
          $config = array(
            // Large Image
            array(
                'image_library' => 'GD2',
                'source_image'  => '../bulletinstory.com/storage/app/public/images/'.$gbr['file_name'],
                'maintain_ratio'=> TRUE,
                'width'         => 850,
                'height'        => 565,
                'new_image'     => '../bulletinstory.com/storage/app/public/images/850x565'.$gbr['file_name']
                ),
            // Medium Image
            
          );
          $ci->load->library('image_lib', $config[0]);
          foreach ($config as $item){
              $ci->image_lib->initialize($item);
              if(!$ci->image_lib->resize()){
                  return false;
              }
              $ci->image_lib->clear();
          }
  }else{
    //echo $ci->upload->display_errors();
  }
  return $gbr['file_name'];
}

function do_upload_multiple($img){
  $ci = & get_instance();
  $ci->load->library('image_lib');
  $ci->load->library('upload');

  if(isset($_FILES[$img]) && $_FILES[$img]['size'] > 0) {
    $images = array();
    // Upload
    $files = $_FILES[$img];
    $count=0;
    foreach ($files['name'] as $key => $image) {
      $count ++;
      $_FILES[$img]['name']= $files['name'][$key];
      $_FILES[$img]['type']= $files['type'][$key];
      $_FILES[$img]['tmp_name']= $files['tmp_name'][$key];
      $_FILES[$img]['error']= $files['error'][$key];
      $_FILES[$img]['size']= $files['size'][$key];

      $upload_config = array(
        'allowed_types' => 'jpg|jpeg|gif|png',
        'upload_path' => "uploads/categoryimages/",
        'max_size'    => 5000,
        'remove_spaces' => TRUE,
        'file_name'   => md5(time()).'_'.$count
      );
      $ci->upload->initialize($upload_config);

      if ($ci->upload->do_upload($img)) {
        $image_data = $ci->upload->data();  
        $images[] = $image_data['file_name']; 
      } else {
      }
    }
    // Resize
    // Save to db
  }
  return $images;
}
function imagetypevalidation($img){
  $allowed = array('gif', 'png', 'jpg', 'jpeg');
  $filename = $_FILES[$img]['name'];
  $ext = pathinfo($filename, PATHINFO_EXTENSION);
  if (!in_array($ext, $allowed)) {
    return false;
  }
  return true;
}
function imagetypevalidation_multiple($img){
 $valid_types = array("image/jpg", "image/jpeg", "image/bmp", "image/gif", "image/png");
 $count = count($_FILES[$img]['name']);
 $file_valid_types=array();
  for ($i = 0; $i < ($count); $i++)
  {
    // check the file type is allowed, if so continue
    $file_valid_types =$_FILES[$img]['type'][$i];
  }
  if (in_array($file_valid_types, $valid_types))
    {
      return true;
    }
    else
    { 
      return false;
    }
}
function checkToken($token, $id){
  $ci = & get_instance();
  $ci->db->select('password_token');
  $ci->db->from('wami_users');
  $ci->db->where('id', $id);
  $ci->db->where('password_token', $token);
  $sql=$ci->db->get();
  $query=$ci->db->last_query();
  if($sql->num_rows()>0){
    return true;
  }else{
    return false;
  }
}
function getIpAddress(){
  //whether ip is from the share internet  
  if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
      $ip = $_SERVER['HTTP_CLIENT_IP'];  
  }  
  //whether ip is from the proxy  
  else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
   }  
  //whether ip is from the remote address  
  else{  
    $ip = $_SERVER['REMOTE_ADDR'];  
  }
  return $ip;
}
function create_time_range($start, $end, $interval = '30 mins', $format = '12') {
    $startTime = strtotime($start); 
    $endTime   = strtotime($end);
    $returnTimeFormat = ($format == '12')?'g:i A':'G:i';

    $current   = time(); 
    $addTime   = strtotime('+'.$interval, $current); 
    $diff      = $addTime - $current;

    $times = array(); 
    while ($startTime < $endTime) { 
        $times[] = date($returnTimeFormat, $startTime); 
        $startTime += $diff; 
    } 
    $times[] = date($returnTimeFormat, $startTime); 
    return $times; 
}
function sendSMS($phno, $fourRandomDigit){
   
    $apiKey = urlencode('Pi0Dt98PkGI-dC04KyFwwtVYd6MLePhogjB2RZQOas');
    
    // Message details
    $numbers = array($phno);
    $sender = urlencode('WAMIAP');
    $message = rawurlencode('Hi, your phone verification code is '.$fourRandomDigit.'.

Regards,
-WAMI');
 
    $numbers = implode(',', $numbers);
 
    // Prepare data for POST request
    $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
    // Send the POST request with cURL
    $ch = curl_init('https://api.textlocal.in/send/');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
  
  // Process your response here
  //echo $response;
  return $response;
}
