<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Edit Videos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/plugins/fontawesome-free/css/all.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/dist/css/adminlte.min.css');?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/plugins/select2/css/select2.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css');?>">
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
            <h1>Edit Videos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Videos</li>
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
                <h3 class="card-title">Edit Videos</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <?php if(validation_errors() != false){?>
                <div class="alert alert-danger" style="padding: 2px; top: 15px;">
                  <?php echo validation_errors(); ?>
                </div>
              <?php }?>
              
              <form role="form" action="<?php echo base_url('admincontrol/dashboardadmin/updateVideo'); ?>" enctype="multipart/form-data" method="post">
              <?php
                $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
              );
              ?>
              <input id="csrffield" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <div class="card-body">
                  <!-- <div class="form-group">
                    <label for="exampleInputEmail1">Select Multiple Brands</label>
                    <div class="select2-purple">
                      <select name="brand_id[]" class="select2" multiple="multiple" id="exampleInputEmail1" data-placeholder="Select Brands" data-dropdown-css-class="select2-purple" style="width: 100%;">
                        <option value="All">Select Any Brand</option>
                        <?php if(!empty($allbrands)){
                          foreach ($allbrands as $key => $value) {?>
                            <option value="<?php echo $value['id'];?>"><?php echo $value['brand_name'];?></option>
                          <?php }?>
                        <?php }?>
                      </select>
                    </div>
                  </div> -->
                  <input type="hidden" name="videoid" value="<?php echo $videodetail->id; ?>">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Title<label>
                    <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="Enter Title" value="<?php echo $videodetail->title; ?>" >
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Image<label>
                    <input type="file" name="image" class="form-control">
                    <p><?php if($videodetail->image!=''){?>
                      <img src="<?php echo base_url($videodetail->image); ?>" height=100>
                      <?php }?></p>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Link<label>
                    <input type="text" name="video" value="<?php echo $videodetail->video; ?>" class="form-control">
                  </div>
                  
                 <!--  <div class="form-group">
                    <label for="exampleInputEmail1">Upload Image</label>
                    <input type="file" name="category_image" class="form-control" id="exampleInputEmail1">
                  </div> -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
<!-- Select2 -->
<script src="<?php echo base_url('assets/backend/plugins/select2/js/select2.full.min.js');?>"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
  $('.select2').select2()

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })
});
</script>
</body>
</html>
