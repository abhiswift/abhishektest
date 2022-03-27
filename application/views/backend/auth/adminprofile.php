<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Edit Admin Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/plugins/fontawesome-free/css/all.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/dist/css/adminlte.min.css');?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="<?php echo base_url('assets/backend/dist/css/sweetalert.css');?>" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php $this->load->view('backend/auth/includes/navigation') ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php $this->load->view('backend/auth/includes/sidebar') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Admin Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Admin Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Edit Admin Profile</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <?php if(validation_errors() != false){?>
                <div class="alert alert-danger" style="padding: 2px; top: 15px;">
                  <?php echo validation_errors(); ?>
                </div>
              <?php }?>
              <?php if ($this->session->flashdata('admin_profile_msg')!= ""){?>
                  <?php echo $this->session->flashdata('admin_profile_msg'); ?>
              <?php }?>
              
              <form role="form" action="<?php echo base_url('admincontrol/dashboardadmin/updateAdminProfile'); ?>" method="post">
              <?php
                $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
              );
              ?>
              <input id="csrffield" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
             
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="full_name" value="<?php echo set_value('full_name') == false ? $admindata->full_name : set_value('full_name'); ?>" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" name="username" value="<?php echo set_value('username') == false ? $admindata->username : set_value('username'); ?>" class="form-control" id="exampleInputEmail1" placeholder="Enter Username">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" name="email" value="<?php echo set_value('email') == false ? $admindata->email : set_value('email'); ?>" class="form-control" id="exampleInputEmail1" placeholder="Enter Phone No">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone No</label>
                    <input type="text" name="phone_no" value="<?php echo set_value('phone_no') == false ? $admindata->phone_no : set_value('phone_no'); ?>" class="form-control" id="exampleInputEmail1" placeholder="Enter Phone No">
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
            <!-- /.card -->


          </div>
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="error" style="color: red;"></div>
              <form method="post" id="changepassfrm">
              <?php
                $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
              );
              ?>
              <input id="csrffield" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
             
                <div class="card-body">
                  
                  <div class="form-group">
                    <label for="exampleInputEmail1">New Password</label>
                    <input type="password" name="password" value="<?php echo set_value('cnfpassword') == false ? '' : set_value('password'); ?>" class="form-control" id="newpassword" placeholder="Enter Confirm Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Confirm Password</label>
                    <input type="password" name="cnfpassword" value="<?php echo set_value('cnfpassword') == false ? '': set_value('cnfpassword'); ?>" class="form-control" id="confrmpass" placeholder="Enter Confirm Password">
                  </div>
                 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  
                  <button type="button" id="profilebtn" class="btn btn-warning">Update</button>
                </div>
              </form>
            </div>
            <!-- /.card -->


          </div>
          <!--/.col (left) -->
          <!-- right column -->
          
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('backend/auth/includes/footer') ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url('assets/backend/plugins/jquery/jquery.min.js');?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo base_url('assets/backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/backend/dist/js/adminlte.min.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/backend/dist/js/demo.js');?>"></script>
<script src="<?php echo base_url('assets/backend/dist/js/sweetalert.min.js');?>"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
  $('#profilebtn').prop('disabled', true);
      //on keypress 
  $('#confrmpass').keyup(function(e){
      //get values 
      var pass = $('#newpassword').val();
      var confpass = $(this).val();
      
      //check the strings
      if(pass == confpass){
        //if both are same remove the error and allow to submit
        $('.error').text('');
        $('#profilebtn').prop('disabled', false);
      }else{
        //if not matching show error and not allow to submit
        $('.error').text('Password and confirmation password do not match.');
        $('#profilebtn').prop('disabled', true);
      }
  });
  $('#newpassword').keyup(function(e){
      //get values 
      var pass = $('#confrmpass').val();
      var confpass = $(this).val();
      
      //check the strings
      if(pass == confpass){
        //if both are same remove the error and allow to submit
        $('.error').text('');
        $('#profilebtn').prop('disabled', false);
      }else{
        //if not matching show error and not allow to submit
        $('.error').text('Password and confirmation password do not match.');
        $('#profilebtn').prop('disabled', true);
      }
  });
  $('#profilebtn').on('click', function(){
        $(this).prop('disabled', true);
        var formdata= $('#changepassfrm').serialize();
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url('admincontrol/dashboardadmin/updateAdminpassword');?>',
          data: formdata,
          dataType: 'json',
          success: function(res){
            console.log(res);
            $('#profilebtn').prop('disabled', false);
            if(res.status==1){
              swal("Oops!", res.msg, "error");
            }else{
              swal({title: 'Success', text: res.msg, type: "success"},
                  function(){ 
                    location.reload();
                  }
              );
            }
          }, erroor: function(jqXHR){
          }
        })
      })
});
</script>
</body>
</html>
