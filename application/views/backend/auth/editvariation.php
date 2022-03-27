<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Edit Product Variation</title>
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
            <h1>Edit Product Variation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Product Variation</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <form role="form" action="<?php echo base_url('admincontrol/dashboardadmin/updateProductVariation'); ?>" enctype="multipart/form-data" method="post">
        <div class="row">
          <!-- left column -->
          <?php if(validation_errors() != false){?>
            <div class="alert alert-danger" style="padding: 2px; top: 15px;">
              <?php echo validation_errors(); ?>
            </div>
          <?php }?>
          
          
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Edit Product Variation</h3>
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
              <input type="hidden" name="variationid" value="<?php echo ($product_detail->id!='')?$product_detail->id:set_value('variationid') ;?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Variation Litre (<span style="color: red;">*</span>)</label>
                     <input type="text" name="variation_litre" class="form-control" value="<?php echo ($product_detail->variation_litre!='')?$product_detail->variation_litre:set_value('variation_litre') ;?>" id="exampleInputEmail1" placeholder="Enter Product Litre">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Variation Stock (<span style="color: red;">*</span>)</label>
                     <input type="text" name="variation_stock" class="form-control numbers" value="<?php echo ($product_detail->variation_stock!='')?$product_detail->variation_stock:set_value('variation_stock') ;?>" id="exampleInputEmail1" placeholder="Enter Variation Stock">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Upload Image (<span style="color: red;">*</span>)</label>
                     <input type="file" name="variation_image" class="form-control" id="exampleInputEmail1">
                     <input type="hidden" name="variation_image_hidden" value="<?php echo $product_detail->variation_image; ?>">
                     <p><img src="<?php echo base_url('uploads/categoryimages/'.$product_detail->variation_image);?>" height=100></p>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Variation Actual Price (<span style="color: red;">*</span>)</label>
                     <input type="text" name="variation_actual_price" class="form-control numbers" value="<?php echo ($product_detail->variation_actual_price!='')?$product_detail->variation_actual_price:set_value('variation_actual_price') ;?>" id="exampleInputEmail1" placeholder="Enter Variation Actual Price">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Variation Discount (%)</label>
                     <input type="text" name="variation_discount" class="form-control numbers" value="<?php echo ($product_detail->variation_discount!='')?$product_detail->variation_discount:set_value('variation_discount') ;?>" id="exampleInputEmail1" placeholder="Enter Variation Discount">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Variation Information (<span style="color: red;">*</span>)</label>
                     <textarea name="variation_info" class="form-control" id="exampleInputEmail1" placeholder="Enter Variation Information"><?php echo ($product_detail->variation_info!='')?$product_detail->variation_info:set_value('variation_info') ;?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Variation Key Features</label>
                     <textarea name="variation_key_features" class="form-control" id="exampleInputEmail1" placeholder="Enter Variation Key Features"><?php echo ($product_detail->variation_key_features!='')?$product_detail->variation_key_features:set_value('variation_key_features') ;?></textarea>
                  </div>
                  
                </div>
                
                <!-- /.card-body -->
            </div>
            <!-- /.card -->


          </div>
          <!--/.col (left) -->
          <!-- right column -->
         
          <!--/.col (right) -->
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
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
<script type="text/javascript">
$(document).ready(function () {
  acceptonlynumerics();
  bsCustomFileInput.init();
  
  {
    let max_fields      = 10; //maximum input boxes allowed
    let wrapper         = $(".input_fields_wrap"); //Fields wrapper
    let add_button      = $(".add_field_button"); //Add button ID

    let x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        x++; //text box increment
        $(wrapper).append('<div style="outline-style: dotted; padding:5px;"><div class="form-group"><label for="exampleInputEmail1">Variation Litre (<span style="color: red;">*</span>)</label><input type="text" name="variation_litre[]" class="form-control" id="exampleInputEmail1" placeholder="Enter Variation Litre"></div><div class="form-group"><label for="exampleInputEmail1">Product Stock (<span style="color: red;">*</span>)</label><input type="text" name="variation_stock[]" class="form-control numbers" id="exampleInputEmail1" placeholder="Enter Variation Stock"></div><div class="form-group"><label for="exampleInputEmail1">Upload Image (<span style="color: red;">*</span>)</label><input type="file" name="variation_image[]" class="form-control" id="exampleInputEmail1"></div><div class="form-group"><label for="exampleInputEmail1">Variation Actual Price (<span style="color: red;">*</span>)</label><input type="text" name="variation_actual_price[]" class="form-control numbers" id="exampleInputEmail1" placeholder="Enter Variation Actual Price"></div><div class="form-group"><label for="exampleInputEmail1">Variation Discount (%)</label><input type="text" name="variation_discount[]" class="form-control numbers" id="exampleInputEmail1" placeholder="Enter Variation Discount"></div><div class="form-group"><label for="exampleInputEmail1">Variation Information (<span style="color: red;">*</span>)</label><textarea name="variation_info[]" class="form-control" id="exampleInputEmail1" placeholder="Enter Variation Information"></textarea></div><div class="form-group"><label for="exampleInputEmail1">Variation Key Features</label><textarea name="variation_key_features[]" class="form-control" id="exampleInputEmail1" placeholder="Enter Variation Key Features"></textarea></div><a href="#" class="remove_field">Remove</a></div><br>'); //add input box
          acceptonlynumerics();
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })

  }
  function acceptonlynumerics(){
    $('.numbers').keyup(function () { 
      this.value = this.value.replace(/[^0-9\.]/g,'');
    });
  }
  {
    $('select[name="brand_id"]').on('change', function(){
      let brandid=$(this).val();
      $.ajax({
        type:'POST',
        url: '<?php echo base_url('admincontrol/dashboardadmin/getCategoriesByBrand'); ?>',
        data: {
          brandid:brandid
        },
        dataType: 'json',
        success: function(res){
          var html ='';
          for (var i =0; i<res.length; i++) {
            html += '<option value="'+res[i].id+'">'+res[i].category_name+'</option>'; 
          }
          $('#category_id').html(html);
        }, error: function(jqXHR){
        }
      })
    })
  }
  
});
</script>
</body>
</html>
