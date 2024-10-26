<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Truelysell | Template</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="../uploads/logo/favicon.png"> 
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Fearther CSS -->
	<link rel="stylesheet" href="assets/css/feather.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	
</head>
<style>
         .error {
            color: red;
            font-size: 11px;
            font-weight: 500;
        }
         .error-msg {
            color: red !important;
            font-size: 11px;
            font-weight: 500;
        }
         .error-icon {
            color: red !important;
        }
    </style>
<body>
<?php 

$step=isset($step)?$step:1;
// $step=4;
// print_r($_POST);
?>
	
	<div class="main-wrapper">

		<div class="installation-header">
        <img src="./assets/img/header-installation.png" alt="Logo" class="img-fluid">
       </div>

	   <div class="project-installation">
		<div class="content">
			<div class="container">
			<div class="row">
			<div class="col-lg-10 mx-auto">
				<div class="wizard">
					<ul class="form-wizard-steps" id="progressbar2">
						<li class="<?php if($step==1){ echo 'progress-active';}else if($step>1){ echo 'progress-activated';} ?>">
							<div class="profile-step">
								<span class="profile-box"><img src="assets/img/icons/install-icon-01.svg" alt="image"></span>
								<div class="step-section">
									<h5>Licence</h5>
									
								</div>
								<span class="dot-active"></span>
							</div>
						</li>
						<li class="<?php if($step==2){ echo 'progress-active';}else if($step>2){ echo 'progress-activated';} ?>">
							<div class="profile-step">
								<span class="profile-box"><img src="assets/img/icons/install-icon-02.svg" alt="image"></span>
								<div class="step-section">
									<h5>System Requirements</h5>
								</div>
								<span class="dot-active"></span>
							</div>
						</li>
						<li class="<?php if($step==3){ echo 'progress-active';}else if($step>3){ echo 'progress-activated';} ?>">
							<div class="profile-step">
								<span class="profile-box"><img src="assets/img/icons/install-icon-03.svg" alt="image"></span>
								<div class="step-section">
									<h5>File & Folder Permission</h5>
								</div>
								<span class="dot-active"></span>
							</div>
						</li>
						<li class="<?php if($step==4){ echo 'progress-active';}else if($step>4){ echo 'progress-activated';} ?>">
							<div class="profile-step">
								<span class="profile-box"><img src="assets/img/icons/install-icon-04.svg" alt="image"></span>
								<div class="step-section">
									<h5>Database</h5>
								</div>
								<span class="dot-active"></span>
							</div>
						</li>
						<li class="<?php if($step==5){ echo 'progress-active';}else if($step>5){ echo 'progress-activated';} ?>">
							<div class="profile-step">
								<span class="profile-box"><img src="assets/img/icons/install-icon-05.svg" alt="image"></span>
								<div class="step-section">
									<h5>Admin</h5>
								</div>
								<span class="dot-active"></span>
							</div>
						</li>
					</ul>
				</div>
				<div class="initialization-form-set">
					<fieldset class="form-inner card wizard-form-card" id="first" style="<?php if($step==1){ echo 'display:block';}else{ echo 'display:none';} ?>">
						<form action="" id="verify" method="post" accept-charset="utf-8" autocomplete="off">
							<div class="licence-verifi">
								<div class="card-title">
									<h4>Purchase Verification</h4>
								</div>
									<div class="install-step">
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group mb-0">
													<label>Purchase Code &nbsp;</label>
													<input type="text" class="form-control" name="purchase_code" id="purchase_code" value="nullcave">
													<input type="hidden" name="step" value="2">
													<input type="hidden" name="code_status" id="code_status" value="false">
												</div>
												<?php 
													if($step==1 && isset($bug_error)){
												?>
													<span class="error-msg"><?=$bug_error?></span>										
												<?php 
													} 
												?>
											</div>
										</div>
									</div>
							</div>
							<div class="add-form-btn widget-next-btn submit-btn">
								<div class="btn-left">
									<a href="javascript:void(0);" class="btn btn-primary btn-icon main-btn pre-btn disabled"><i class="feather-arrow-left"></i>Prev</a>
								</div>
								<div class="btn-left">
									<input type="hidden" name="permissions_success" value="true">
									<!-- <button type="submit" class="btn btn-primary">Setup Database</button> -->
									<button type="button" class="btn btn-primary btn-icon main-btn " id="btn_verify_code">Next <i class="feather-arrow-right"></i></button>
								</div>
							</div>
						</form>
					</fieldset>
					<fieldset class="form-inner card wizard-form-card" style="<?php if($step==2){ echo 'display:block';}else{ echo 'display:none';} ?>">
						<div class="system-verifi">
							<div class="card-title">
								<h4>System Requirement</h4>
								<p>Required Elements to installl tuelysell into your System</p>
							</div>
							<div class="install-step">
								<?php 
								$error = FALSE;
								$movetofile=true;
                                if (phpversion() < "8.0") {
                                    $error = false;
									$movetofile=false;
                                } else {
                                    $error = true;
                                }
								?>
								<div class="requirment-field">
									<div class="elements-name"><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i>Php Version</div>
									<?php 
									if($error==false){
										echo "<span class='error-icon'>Your PHP version is " . phpversion() . "! PHP 5.5 or higher required!</span>";
									}else{
									?>
									<span class="version"><?=phpversion();?></span>
									<?php } ?>
								</div>

								
								<?php
								$error = FALSE;
                                if (!extension_loaded('mysqli')) {
                                    $error = false;
									$movetofile=false;
                                } else {
                                    $error = true;
                                }
								?>
								<div class="requirment-field">
									<div class="elements-name"><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i>Mysqli PHP extension loaded!</div>
									<?php 
									if($error==false){
										echo "<span class='error-icon'>Mysqli PHP extension missing!</span>";
									}else{
									?>
									<span class="version">Enable</span>
									<?php } ?>
								</div>

								<?php
								$error = FALSE;
                                if (!extension_loaded('mbstring')) {
                                    $error = false;
									$movetofile=false;
                                } else {
                                    $error = true;
                                }
								?>
								<div class="requirment-field">
									<div class="elements-name"><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i>MBString PHP extension loaded!!</div>
									<?php 
									if($error==false){
										echo "<span class='error-icon'>MBString PHP extension missing!</span>";
									}else{
									?>
									<span class="version">Enable</span>
									<?php } ?>
								</div>

								<?php
								$error = FALSE;
                                if (!extension_loaded('gd')) {
                                    $error = false;
									$movetofile=false;
                                } else {
                                    $error = true;
                                }
								?>
								<div class="requirment-field">
									<div class="elements-name"><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i>GD PHP extension loaded!!</div>
									<?php 
									if($error==false){
										echo "<span class='error-icon'>GD PHP extension missing!</span>";
									}else{
									?>
									<span class="version">Enable</span>
									<?php } ?>
								</div>

								<?php
								$error = FALSE;
                                if (!extension_loaded('pdo')) {
                                    $error = false;
									$movetofile=false;
                                } else {
                                    $error = true;
                                }
								?>
								<div class="requirment-field">
									<div class="elements-name"><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i>PDO PHP extension loaded!!</div>
									<?php 
									if($error==false){
										echo "<span class='error-icon'>PDO PHP extension missing!</span>";
									}else{
									?>
									<span class="version">Enable</span>
									<?php } ?>
								</div>

								<?php
								$error = FALSE;
                                if (!extension_loaded('curl')) {
                                    $error = false;
									$movetofile=false;
                                } else {
                                    $error = true;
                                }
								?>
								<div class="requirment-field">
									<div class="elements-name"><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i>CURL PHP extension loaded!!</div>
									<?php 
									if($error==false){
										echo "<span class='error-icon'>CURL PHP extension missing!</span>";
									}else{
									?>
									<span class="version">Enable</span>
									<?php } ?>
								</div>

								<?php
								$error = FALSE;
                                if (!extension_loaded('openssl')) {
                                    $error = false;
									$movetofile=false;
                                } else {
                                    $error = true;
                                }
								?>
								<div class="requirment-field">
									<div class="elements-name"><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i>OpenSSL PHP extension loaded!!</div>
									<?php 
									if($error==false){
										echo "<span class='error-icon'>OpenSSL PHP extension missing!</span>";
									}else{
									?>
									<span class="version">Enable</span>
									<?php } ?>
								</div>

								<?php
								$error = FALSE;
                                $url_f_open = ini_get('allow_url_fopen');
                                if ($url_f_open != "1" && $url_f_open != 'On') {
                                    $error = false;
									$movetofile=false;
                                } else {
                                    $error = true;
                                }
								?>
								<div class="requirment-field">
									<div class="elements-name"><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i>Allow Url Fopen is loaded!</div>
									<?php 
									if($error==false){
										echo "<span class='error-icon'>Allow_url_fopen is not enabled!</span>";
									}else{
									?>
									<span class="version">Enable</span>
									<?php } ?>
								</div>														
								
							</div>
						</div>
						<div class="add-form-btn widget-next-btn submit-btn">
							<div class="btn-left">
								<a href="javascript:void(0);" class="btn btn-primary btn-icon main-btn prev_btns"><i class="feather-arrow-left"></i>Prev</a>
							</div>
							<div class="btn-left">
								<a href="javascript:void(0);" class="btn btn-primary btn-icon main-btn next_btns <?php if($movetofile==false){ echo 'disabled';} ?> " >Next <i class="feather-arrow-right"></i></a>
							</div>
						</div>
					</fieldset>
					<fieldset class="form-inner card wizard-form-card" style="<?php if($step==3){ echo 'display:block';}else{ echo 'display:none';} ?>">
						<div class="folder-permission">
							<div class="card-title">
								<h4>File & Folder Permission</h4>
								<p>Permissions to the folders</p>
							</div>
							<div class="install-step">
								<ul class="files-list">

								<?php
								$database_file = ".././application/config/database.php";
                                $config_file = ".././application/config/config.php";
                                $htaccess_file = "../.htaccess";
                                $upload_fld = "../uploads";
                                $upload_banner_fld = "../uploads/banners";
                                $upload_profile_fld = "../uploads/profile_img";
                                $upload_service_fld = "../uploads/services";

								$movetodb=true;
								$error = FALSE;
                                if (!is_writeable($config_file)) {
                                    $error = false;
									$movetodb=false;
                                } else {
                                    $error = true;
                                }
								?>
								<li>
									<span class="folder"><i class="fa-regular fa-folder-open"></i>Application / Config / config.php</span>
									<span><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i></span>
								</li>								

								<?php
								$error = FALSE;
                                if (!is_writeable($database_file)) {
                                    $error = false;
									$movetodb=false;
                                } else {
                                    $error = true;
                                }
								?>
								<li>
									<span class="folder"><i class="fa-regular fa-folder-open"></i>Application / Config / database.php</span>
									<span><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i></span>
								</li>
								
								<?php
								$error = FALSE;
                                if (!is_writeable($htaccess_file)) {
                                    $error = false;
									$movetodb=false;
                                } else {
                                    $error = true;
                                }
								?>
									<li>
										<span class="folder"><i class="fa-regular fa-folder-open"></i>.Htaccess</span>
										<span><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i></span>
									</li>

								<?php
								$error = FALSE;
                                if (!is_writeable("../uploads/blogs")) {
                                    $error = false;
									$movetodb=false;
                                } else {
                                    $error = true;
                                }
								?>
								<li>
									<span class="folder"><i class="fa-regular fa-folder-open"></i>Upload / blogs</span>
									<span><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i></span>
								</li>
								<?php
								$error = FALSE;
                                if (!is_writeable("../uploads/category_images")) {
                                    $error = false;
									$movetodb=false;
                                } else {
                                    $error = true;
                                }
								?>
								<li>
									<span class="folder"><i class="fa-regular fa-folder-open"></i>Upload / category_images</span>
									<span><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i></span>
								</li>
								<?php
								$error = FALSE;
                                if (!is_writeable("../uploads/subcategory_images")) {
                                    $error = false;
									$movetodb=false;
                                } else {
                                    $error = true;
                                }
								?>
								<li>
									<span class="folder"><i class="fa-regular fa-folder-open"></i>Upload / subcategory_images</span>
									<span><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i></span>
								</li>
								<?php
								$error = FALSE;
                                if (!is_writeable($upload_banner_fld)) {
                                    $error = false;
									$movetodb=false;
                                } else {
                                    $error = true;
                                }
								?>
								<li>
									<span class="folder"><i class="fa-regular fa-folder-open"></i>Upload / banners</span>
									<span><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i></span>
								</li>
								<?php
								$error = FALSE;
                                if (!is_writeable($upload_profile_fld)) {
                                    $error = false;
									$movetodb=false;
                                } else {
                                    $error = true;
                                }
								?>
								<li>
									<span class="folder"><i class="fa-regular fa-folder-open"></i>Upload / profile_img</span>
									<span><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i></span>
								</li>
								<?php
								$error = FALSE;
                                if (!is_writeable($upload_service_fld)) {
                                    $error = false;
									$movetodb=false;
                                } else {
                                    $error = true;
                                }
								?>
								<li>
									<span class="folder"><i class="fa-regular fa-folder-open"></i>Upload / services</span>
									<span><i class="fa-regular <?php if($error==false){ echo 'fa-circle-xmark error-icon';}else{ echo 'fa-circle-check';} ?>"></i></span>
								</li>
									
									<!-- <li>
										<span class="folder"><i class="fa-regular fa-folder-open"></i>Upload / Audios</span>
										<span><i class="fa-regular fa-circle-check"></i></span>
									</li> -->
									
								</ul>
							</div>
						</div>
						<div class="add-form-btn widget-next-btn submit-btn">
							<div class="btn-left">
								<a href="javascript:void(0);" class="btn btn-primary btn-icon main-btn prev_btns"><i class="feather-arrow-left"></i>Prev</a>
							</div>
							<div class="btn-left">
								<a href="javascript:void(0);" class="btn btn-primary btn-icon main-btn next_btns <?php if($movetodb==false){ echo 'disabled';} ?>">Next <i class="feather-arrow-right"></i></a>
							</div>
						</div>
					</fieldset>
					<fieldset class="form-inner card wizard-form-card" style="<?php if($step==4){ echo 'display:block';}else{ echo 'display:none';} ?>">
						<div class="folder-permission">
						<form id="database" method="post" accept-charset="utf-8">							
							<div class="card-title">
								<h4>Database</h4>
								<p>Detail of your database</p>
							</div>
							<input type="hidden" name="step" value="3">
							<!-- <input type="hidden" name="envato_username" value="' . $_POST['envato_username'] . '">
							<input type="hidden" name="support_email" value="' . $_POST['support_email'] . '"> -->
							<input type="hidden" name="purchase_code" value="<?php echo isset($_POST['purchase_code'])?$_POST['purchase_code']:''; ?>">
								<div class="install-step">
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
												<label>Host</label>
												<input type="text" class="form-control" 
                                               placeholder="hostname"
                                               name="hostname" value="<?php if(isset($_POST['hostname'])){ echo $_POST['hostname'];} ?>">
											</div>
										</div>
										<div class="col-lg-12">
											<div class="form-group">
												<label>Database Name</label>
												<input type="text" class="form-control" placeholder="database name"
                                               name="database" value="<?php if(isset($_POST['database'])){ echo $_POST['database'];} ?>">
											</div>
										</div>
										<div class="col-lg-12">
											<div class="form-group">
												<label>Username</label>
												<input type="text" class="form-control" placeholder="database username"
                                               name="db_username" value="<?php if(isset($_POST['db_username'])){ echo $_POST['db_username'];} ?>">
											</div>
										</div>
										<div class="col-lg-12">
											<div class="form-group mb-0">
												<label>Password</label>
												<input type="password" class="form-control" placeholder="database password"
                                               name="db_password" value="<?php if(isset($_POST['db_password'])){ echo $_POST['db_password'];} ?>">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							
                        if (isset($bug_error) && $bug_error != '') { ?>
                            <div class="alert alert-danger text-center">
                                <?php echo $bug_error; ?>
                            </div>
                        <?php } ?>
							<div class="add-form-btn widget-next-btn submit-btn">
								<div class="btn-left">
									<a href="javascript:void(0);" class="btn btn-primary btn-icon main-btn prev_btns"><i class="feather-arrow-left"></i>Prev</a>
								</div>
								<div class="btn-left">
									<button type="submit" class="btn btn-primary btn-icon main-btn next_btns">Next <i class="feather-arrow-right"></i></button>
								</div>
							</div>
						</form>
					</fieldset>
					<fieldset class="form-inner card wizard-form-card" style="<?php if($step==5){ echo 'display:block';}else{ echo 'display:none';} ?>">
						<div class="folder-permission">
							<div class="card-title">
								<h4>Admin Account</h4>
								<p>Username & Password of Your Account</p>
							</div>
							<form>
								<div class="install-step">
									<table class="install-user">
										<tr>
											<td>Admin URL</td>
											<td>: http://yourdomain.com/admin</td>
										</tr>
										<tr>
											<td>Username</td>
											<td>: admin</td>
										</tr>
										<tr>
											<td>Password</td>
											<td>: admin</td>
										</tr>
									</table>
								</div>
							</form>
							<div class="rechange-details">
								<span>You can change username, email, password from the profile setting section after the installation </span>
							</div>
						</div>
						<div class="add-form-btn widget-next-btn submit-btn">
							<div class="btn-left">
								<a href="javascript:void(0);" class="btn btn-primary btn-icon main-btn prev_btns"><i class="feather-arrow-left"></i>Prev</a>
							</div>
							<div class="btn-left">
								<form action="" id="complete" novalidate="novalidate" class="form-horizontal" method="post" accept-charset="utf-8">
									<input type="hidden" name="step" value="4">
									<input type="hidden" name="hostname" value="<?php echo $_POST['hostname']; ?>">
									<input type="hidden" name="database" value="<?php echo $_POST['database']; ?>">
									<input type="hidden" name="db_username" value="<?php echo $_POST['db_username']; ?>">
									<input type="hidden" name="db_password" value="<?php echo $_POST['db_password']; ?>">
									<button class="btn btn-primary btn-icon main-btn " id="finish">Finish <i class="feather-arrow-right"></i></button>
								</form>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="installation-footer">
					<p>Copyright ⓒ 2024 Truelysell - All Rights Reserved.</p>
				</div>
			</div>			
			</div>			
			</div>			
		</div>
	   </div>
		
		
		<!-- Cursor -->
		<div class="mouse-cursor cursor-outer"></div>
		<div class="mouse-cursor cursor-inner"></div>
		<!-- /Cursor -->
		
	</div>
	
	<!-- jQuery -->
	<script src="assets/js/jquery-3.7.0.min.js"></script>

	<!-- Fearther JS -->
	<script src="assets/js/feather.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js"></script>
	
	<script src="../assets/installer/jquery.validate.min.js"></script>
<script>
    $(function () {
        $('#finish').on('click', function () {
            var ubtn = $(this);
            ubtn.html('Please wait Database Importing...');
            ubtn.addClass('disabled');
			$(".prev_btns").addClass('disabled');
        });
    });
</script>
<script>
    $(function () {
		$("#btn_verify_code").on('click',function() {
            $("#verify").submit();
        });

        $("#database").validate({
            rules: {
                hostname: "required",
                database: "required",
                db_username: "required"
            },

            // Specify the validation error messages
            messages: {
                hostname: "Please enter your hostname usually localhost",
                database: "Please specify your database name",
                db_username: "Please specify your database username"
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $("#complete").validate({
            rules: {
                admin_username: "required",
                admin_fullname: "required",
                admin_pass: "required",
                admin_email: {
                    required: true,
                    email: true
                },
                company_name: "required",
                company_email: {
                    required: true,
                    email: true
                },
            },

            // Specify the validation error messages
            messages: {
                admin_username: "Please enter admin username",
                admin_fullname: "Set your admin full name",
                admin_pass: "Set your admin password",
                admin_email: "Set admin email address",
                company_name: "Set your company name",
                company_email: "Enter your company email address e.g info@domain.com",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

    });
</script>
</body>
</html>