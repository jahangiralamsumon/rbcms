<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Not Found (#404)</title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php echo $setting['meta_tag'];?>
<?php
    if(!empty($setting['favicon_path'])){
    	$favicon_path = $setting['favicon_path'];
    } else{
    $favicon_path = 'images/favicon/favicon.ico';
	}
?>
  <link rel="icon" href="<?php echo $this->request->webroot.'webroot/'.$favicon_path;?>" type="image/icon">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!--  cms_style.css   custom style -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>css/cms_style.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/js/html5shiv.min.js"></script>
  <script src="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/js/respond.min.js"></script>
  <![endif]-->
  
</head>
<body class="skin-blue layout-top-nav">

<div class="wrapper">
<header class="main-header">               
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand name"><b><?php echo $this->Html->image('../images/zeerow_logo.png', array('alt' => 'logo')); ?></b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        
      </div><!-- /.container-fluid -->
    </nav>
  </header>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Main content -->
<section class="content">
   <?= $this->Flash->render() ?>
	<?= $this->fetch('content') ?>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
<strong>Copyright &copy; 2016 <a href="#">CHTL</a>.</strong> All rights
reserved.
</footer>
</div>
<!-- ./wrapper -->
<script src="<?php echo $this->request->webroot; ?>js/jquery-1.11.2.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

</body>
</html>