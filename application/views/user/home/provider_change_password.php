<?php 
?>
<div class="content">
	<div class="container">
		<div class="row">
		 	<?php
			if(!empty($_GET['tbs'])){
				$val=$_GET['tbs'];
			}else{
				$val=1;
			}
			?>
			<input type="hidden" name="tab_ctrl" id="tab_ctrl" value="<?=$val;?>">
			<?php $this->load->view('user/home/provider_sidemenu');?>
		 
            <div class="col-xl-9 col-md-8">
				<div class="tab-content pt-0">
					<div class="tab-pane show active" id="user_profile_settings" >
						<div class="widget">
							<h4 class="widget-title"><?php echo (!empty($user_language[$user_selected]['lg_change_password'])) ? $user_language[$user_selected]['lg_change_password'] : $default_language['en']['lg_change_password']; ?></h4>
							<!-- <form id="update_user_pwd" action="<?php echo base_url()?>user/dashboard/update_provider_password" method="POST" onsubmit="return updatepassword();" enctype="multipart/form-data"> -->
							<form id="update_provider_pwd" action="<?php echo base_url()?>user/dashboard/update_provider_password" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
   
								<div class="row">
									<div class="form-group col-xl-12">
										<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_current_password'])) ? $user_language[$user_selected]['lg_current_password'] : $default_language['en']['lg_current_password']; ?></label>
										<!-- <input class="form-control" onBlur="checkcurpwd();" id="current_password" type="password"   > -->
										<input class="form-control" id="current_password" name="current_password" type="password"   >
										<span id="errchkcp"></span>
										<span id="errchk"></span>
									</div>
									<div class="form-group col-xl-12">
										<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_new_password'])) ? $user_language[$user_selected]['lg_new_password'] : $default_language['en']['lg_new_password']; ?></label>
										<!-- <input class="form-control" onBlur="compcurpwd();" id="new_password" type="password"   > -->
										<input class="form-control" id="new_password" name="new_password" type="password"   >
										<span id="errchkn"></span>
									</div>
									<div class="form-group col-xl-12">
										<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_admin_confirm_password'])) ? $user_language[$user_selected]['lg_admin_confirm_password'] : $default_language['en']['lg_admin_confirm_password']; ?></label>
										<input class="form-control" id="confirm_password" type="password" name="confirm_password">
										
										<span id="errchkc"></span>
									</div>
									<div class="form-group col-xl-12">
										<button name="form_submit" id="form_submit" class="btn btn-primary pl-5 pr-5" type="submit"><?php echo (!empty($user_language[$user_selected]['lg_change'])) ? $user_language[$user_selected]['lg_change'] : $default_language['en']['lg_change']; ?></button>
									</div>
								
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>