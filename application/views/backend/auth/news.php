<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | News</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/plugins/fontawesome-free/css/all.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/dist/css/adminlte.min.css');?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/dist/css/custom.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/dist/css/sweetalert.css');?>">
  <style type="text/css">
    div.dataTables_wrapper {
          width: 100%;
          /*margin: 0 auto;*/
      }
  </style>
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
            <h1>News</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">News</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><a href="<?php echo base_url('admincontrol/dashboardadmin/add-news'); ?>" class="btn btn-sm btn-primary">Add More</a></h3>
              </div>
              <!-- /.card-header -->
              <?php if ($this->session->flashdata('news_add_msg')!= ""){?>
                  <?php echo $this->session->flashdata('news_add_msg'); ?>
              <?php }?>
              
              <div class="card-body">
                <table table id="example1" class="table table-bordered table-striped display nowrap" style="width:100%;">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Status</th>
                    <th>Position 1</th>
                    <th>Position 2</th>
                    <th>Position 3</th>
                    <th>Position 4</th>
                    <th>Latest News</th>
                    <th>Latest Big</th>
                    <th>Entertain Big</th>
                    <th>Travel Big</th>
                    <th>Corona Big</th>
                    <th>Popular News</th>
                    <th>Popular Big</th>
                    <th>Trending News</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  
                  if(!empty($all_news)){
                    $i=0;
                    foreach ($all_news as $key => $value) {
                      $i++;
                    ?>
                      <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $value['title'];?></td>
                        <td><?php echo $value['created_at'];?></td>
                        <td><?php echo $value['updated_at'];?></td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['is_active'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="newslist" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['position1'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="newsposition1" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['position2'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="newsposition2" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['position3'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="newsposition3" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['position4'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="newsposition4" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['is_latest'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="newslatest" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['is_latest_big'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="latest_big" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['entertain_big'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="entertain_big" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['travel_big'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="travel_big" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['food_big'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="food_big" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['is_popular'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="newspopular" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['popular_big'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="newspopularbig" >
                          <span class="slider round"></span></label>

                        </td>
                        <td>
                         <label class="switch">
                          <input type="checkbox" class="switchcheck" <?php if ($value['is_trending'] == 2) { echo 'checked="checked"'; } ?> data-id="<?php echo $value['id'];?>" data-url="<?php echo base_url('admincontrol/dashboardadmin/changestatus');?>" data-name="newstrending" >
                          <span class="slider round"></span></label>

                        </td>
                        <td><a href="<?php echo base_url('admincontrol/dashboardadmin/editNews/'.$value['id']);?>"><i class="fas fa-edit"></i></a></td>
                      </tr>
                    <?php }?>
                  <?php }?>
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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
<!-- DataTables -->
<script src="<?php echo base_url('assets/backend/plugins/datatables/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/backend/dist/js/adminlte.min.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/backend/dist/js/demo.js');?>"></script>
<script src="<?php echo base_url('assets/backend/dist/js/custom.js');?>"></script>
<script src="<?php echo base_url('assets/backend/dist/js/sweetalert.min.js');?>"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      /*"responsive": true,
      "autoWidth": false,*/
      "scrollX": true
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
