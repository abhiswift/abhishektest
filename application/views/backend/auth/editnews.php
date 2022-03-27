<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Edit News</title>
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

  <script src="<?php echo base_url('assets/backend/ckeditor/ckeditor.js');?>"></script>
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
            <h1>Edit News</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit News</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <form role="form" action="<?php echo base_url('admincontrol/dashboardadmin/updateNews'); ?>" enctype="multipart/form-data" method="post">
          <?php if(validation_errors() != false){?>
                <div class="alert alert-danger" style="padding: 2px; top: 15px;">
                  <?php echo validation_errors(); ?>
                </div>
              <?php }?>
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Edit News</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              
              
              
              
              <?php
                $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
              );
              ?>
              <input id="csrffield" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <input type="hidden" name="newsid" value="<?php echo $newsdetail->id;?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Select Category</label>
                    <select name="subcat_id" class="form-control">
                      <option value="All">Select any category</option>
                      <?php if(!empty($allcategories)){
                        foreach ($allcategories as $key => $value) {?>
                          <option value="<?php echo $value['id'];?>" <?php echo ($newsdetail->subcat_id==$value['id'])?'selected':''; ?>><?php echo $value['subcat_name'];?></option>
                        <?php }?>
                      <?php }?>
                       
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Title</label>
                    <input type="text" name="title" value="<?php echo $newsdetail->title;?>" class="form-control"></textarea>
                  </div>
                
                  <div class="form-group">
                    <label for="exampleInputPassword1">Description1</label>
                    <textarea name="description1" class="form-control" id="description1"><?php echo $newsdetail->description1 ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Description2</label>
                    <textarea name="description2" class="form-control" id="description2"><?php echo $newsdetail->description2; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Blockqoute</label>
                    <textarea name="blockqoute" class="form-control"><?php echo $newsdetail->blockqoute; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Upload Image 1</label>
                    <input type="file" name="image1" class="form-control"></textarea>
                  </div>
                  <?php if($newsdetail->image1!=''){?>
                    <p><img src="https://www.bulletinstory.com/storage/app/public/images/<?php echo $newsdetail->image1; ?>" height=100></p>
                  <?php }?>
                  

                  <div class="form-group">
                    <label for="exampleInputPassword1">Upload Image 2</label>
                    <input type="file" name="image2" class="form-control"></textarea>
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleInputPassword1">Video Link</label>
                    <textarea name="videolink" class="form-control"><?php echo $newsdetail->videolink; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Meta title</label>
                    <textarea name="meta_title" class="form-control"><?php echo $newsdetail->meta_title; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Meta keywords</label>
                    <textarea name="meta_keywords" class="form-control"><?php echo $newsdetail->meta_keywords; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Meta description</label>
                    <textarea name="meta_description" class="form-control" id="meta_description"><?php echo $newsdetail->meta_description; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">OG URL</label>
                    <textarea name="og_url" class="form-control"><?php echo $newsdetail->og_url; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">OG SITENAME </label>
                    <textarea type="text" name="og_sitename" class="form-control"><?php echo $newsdetail->og_sitename; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">OG Type </label>
                    <input type="text" name="og_type" value="<?php echo $newsdetail->og_type; ?>" class="form-control">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">OG Image </label>
                    <input type="file" name="og_image" class="form-control">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">OG Title </label>
                    <textarea name="og_title" class="form-control"><?php echo $newsdetail->og_title; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">OG description</label>
                    <textarea name="og_description" class="form-control" id="og_description"><?php echo $newsdetail->og_description; ?></textarea>
                  </div>
                </div>
                <!-- /.card-body -->

               
            </div>
            <!-- /.card -->


          </div>
          <div class="col-md-6">

            <div class="card card-info">
              
            
                <div class="card-body">

                  <div class="form-group">
                    <label for="exampleInputPassword1">Canonical Link</label>
                    <input type="text" name="canonical_link" value="<?php echo $newsdetail->canonical_link; ?>" class="form-control"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Twitter Card</label>
                    <input type="text" name="twitter_card" value="<?php echo $newsdetail->twitter_card; ?>" class="form-control"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Twitter Site</label>
                    <input type="text" name="twitter_site" value="<?php echo $newsdetail->twitter_site; ?>" class="form-control"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Twitter Creator</label>
                    <input type="text" name="twitter_creator" value="<?php echo $newsdetail->twitter_creator; ?>" class="form-control"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Twitter Title</label>
                    <input type="text" name="twitter_title" value="<?php echo $newsdetail->twitter_title; ?>" class="form-control"></textarea>
                  </div>
                  

                  <div class="form-group">
                    <label for="exampleInputPassword1">Twitter Description</label>
                    <textarea name="twitter_description" class="form-control" id="twitter_description"><?php echo $newsdetail->twitter_description; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Twitter Image</label>
                    <input type="file" name="twitter_image" class="form-control"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Twitter Url</label>
                    <input type="text" name="twitter_url" value="<?php echo $newsdetail->twitter_url; ?>" class="form-control"></textarea>
                  </div>
                  
                  

                  <button type="submit" class="btn btn-info">Submit</button>

                
                </div>
                <!-- /.card-body -->

               
             
            </div>
            
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          
          <!--/.col (right) -->
        </div>
      </form>
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

  CKEDITOR.replace( 'description1' );
  CKEDITOR.config.allowedContent = true;

  CKEDITOR.replace( 'description2' );
  CKEDITOR.config.allowedContent = true;
});
</script>
</body>
</html>
