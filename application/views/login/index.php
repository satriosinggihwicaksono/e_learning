<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Litera Mobile School</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/icon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url().'assets2/';?>vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url().'assets2/';?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url().'assets2/';?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url().'assets2/';?>vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=base_url().'assets2/';?>vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url().'assets2/';?>vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url().'assets2/';?>css/util.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url().'assets2/';?>css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('<?=base_url().'assets2/';?>images/buku.jpg');">
			<div class="wrap-login100 p-t-50 p-b-30">
				<form action="<?php echo base_url('auth/aksi_login'); ?>" method="post" class="login100-form validate-form">
					<div class="login100-form-avatar">
						<img src="<?=base_url().'assets2/';?>images/logod.png" alt="AVATAR">
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
						Litera Mobile
					</span>
					  <?php if($this->session->flashdata('message')){?>
						<div class="login100-form-title p-b-20">
							<h5 style="color:#FF4500; font-size:17px;">
								<?php echo $this->session->flashdata('message'); ?>
							</h5>
						</div>
					  <?php } ?>
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="email" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="<?=base_url().'assets2/';?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url().'assets2/';?>vendor/bootstrap/js/popper.js"></script>
	<script src="<?=base_url().'assets2/';?>vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url().'assets2/';?>vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url().'assets2/';?>js/main.js"></script>

</body>
</html>