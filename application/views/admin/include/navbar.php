<?php
$navbar = $language_content;
 $admin_notification=$this->db->where('n.receiver',$this->session->userdata('chat_token'))->where('n.status',1)->from('notification_table as n')->join('providers as p ','p.token=n.sender','left')->select('n.notification_id,n.message,n.created_at,p.name,p.profile_img,n.utc_date_time')->get()->result_array();

 ?>
<div class="header">
	<div class="header-left">
		<a href="<?php echo $base_url; ?>dashboard" class="logo">
			<img src="<?php echo $base_url.$this->website_logo_front; ?>" width="140" height="46" alt="">
		</a>
		<a href="<?php echo $base_url; ?>dashboard" class="logo logo-small">
			<img src="<?php echo $base_url.$this->website_logo_front; ?>" alt="Logo" width="30" height="30">
		</a>
	</div>
	<a href="javascript:void(0);" id="toggle_btn">
		<i class="fas fa-align-left"></i>
	</a>
	<a class="mobile_btn" id="mobile_btn" href="javascript:void(0);">
		<i class="fas fa-align-left"></i>
	</a>
	
	<ul class="nav user-menu header-navbar-rht  head-chat-badge">
		<!-- Notifications -->
		<li class="nav-item dropdown noti-dropdown logged-item">
			<a>
				<select class="form-control" id="default_nav_lang">
					<?php 
						$lan_list=$this->db->query("SELECT id,language,language_value FROM `language` WHERE status=1 ORDER BY default_language DESC;")->result();
						foreach($lan_list as $value){
					?>
					<option value='<?=$value->id?>'><?=$value->language_value?></option>
					<?php } ?>
				</select>
			</a>
		</li>
		<li class="nav-item dropdown noti-dropdown logged-item">
			<a alt="View Site" data-toggle="tooltip" title="View Site" href="<?php echo $base_url; ?>admin-login" target="_blank"><i class="fas fa-globe"></i> <span> </span></a>
			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
				<i class="far fa-bell"></i> 
				<?php
                if (!empty($admin_notification)) {
                    ?>
                    <span class="badge badge-pill"></span>
                <?php } ?>
			</a>
			<!-- chat -->

			<?php
                $chat_token = $this->session->userdata('chat_token');
				
                              
                if (!empty($chat_token)) {
                    $chat_detail = $this->db->where('receiver_token', $chat_token)->where('read_status=', 0)->get('chat_table')->result_array();
					
                }
            ?>
			<a alt="Chat" data-toggle="tooltip" class="nav-link" title="Chat" href="<?php echo $base_url; ?>admin/chat">
			<i class="far fa-comment-dots"></i> 
			<div class="chat_counts">
				<?php  if (count($chat_detail) != 0) { ?>
					<span class="chat_count position-absolute chat_color badge_col bg-yellow-chat chat-bg-yellow" id="chat_counts">
						<?php echo count($chat_detail); ?>
					</span>
	        	<?php } else {?>
					<span  class='chat_count position-absolute badge badge-theme' id="chat_counts"></span>
				<?php }?>
			</div>
			</a>
			
			<div class="dropdown-menu dropdown-menu-right notifications">
				<div class="topnav-dropdown-header">
					<span class="notification-title"><?php echo(!empty($navbar['lg_admin_notifications']))?($navbar['lg_admin_notifications']) : 'Notifications';  ?></span>
					<a href="javascript:void(0)" class="clear-noti noty_clear" data-token="<?php echo $this->session->userdata('chat_token'); ?>"> <?php echo(!empty($navbar['lg_admin_clear_all']))?($navbar['lg_admin_clear_all']) : 'Clear All';  ?> </a>
				</div>
				<div class="noti-content">
					<ul class="notification-list">
						<?php foreach($admin_notification as $value){
								$full_date =date('Y-m-d H:i:s', strtotime($value['created_at']));
								$date=date(settingValue('date_format'),strtotime($full_date));
								$date_f=date(settingValue('date_format'),strtotime($full_date));
								$yes_date=date(settingValue('date_format'),(strtotime ( '-1 day' , strtotime (date('Y-m-d')) ) ));
								$time=date('H:i',strtotime($full_date));
								$session = date('h:i A', strtotime($time));
								if($date == date('Y-m-d')){
								$timeBase ="Today ".$session;
								}elseif($date == $yes_date){
								$timeBase ="Yester day ".$session;
								}else{
								$timeBase =$date_f." ".$session;
								}
							?>
						<li class="notification-message">
							<a href="<?= base_url().'admin-notification';?>">
								<div class="media">
									<span class="avatar avatar-sm">
										<?php
										if(file_exists($value['profile_img'])){
											$image=base_url().$value['profile_img'];
										}else{
											$image=base_url().'assets/img/user.jpg';
										}
										?>
										<img class="avatar-img rounded-circle" alt="User Image" src="<?php echo $image;?>">
									</span>
									<div class="media-body">
										<p class="noti-details"><span class="noti-title"></span>  <span class="noti-title"><?= $value['message'];?></span></p>
										<p class="noti-time"><span class="notification-time"><?= $timeBase;?></span></p>
									</div>
								</div>
							</a>
						</li>
					<?php }?>
						
					</ul>
				</div>
				<div class="topnav-dropdown-footer">
					<a href="<?= base_url().'admin-notification'?>"><?php echo(!empty($navbar['lg_admin_view_all_notifications']))?($navbar['lg_admin_view_all_notifications']) : 'View all Notifications';  ?></a>
				</div>
			</div>
		</li>
		<!-- /Notifications -->
		
		<li class="nav-item dropdown">
			<a href="javascript:void(0)" class="dropdown-toggle user-link  nav-link" data-toggle="dropdown">
				<span class="user-img">
				  <?php
				 $admin_id=$this->session->userdata('admin_id');
				 $admin_profile=$this->db->where('user_id',$admin_id)->get('administrators')->row_array();
				   if(file_exists($admin_profile['profile_img'])){
				   	$prof_img = $admin_profile['profile_img'];
				   }else{
				   	$prof_img = "";
				   }
				   
				   $navprofile_img = (!empty($prof_img))?$prof_img:'assets/img/user.jpg';?>
					<img class="rounded-circle" src="<?php echo $base_url.$navprofile_img; ?>" width="40" alt="Admin">
				</span>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item" href="<?php echo $base_url; ?>admin-profile"><?php echo(!empty($navbar['lg_admin_profile']))?($navbar['lg_admin_profile']) : 'Profile';  ?></a>
				<a class="dropdown-item" href="<?php echo $base_url; ?>admin/logout"><?php echo(!empty($navbar['lg_admin_logout']))?($navbar['lg_admin_logout']) : 'Logout';  ?></a>
			</div>
		</li>
	</ul>
</div>

                <?php if($this->session->flashdata('error_message')) {  ?>
		<div class="alert alert-danger text-center" id="flash_error_message"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;<?php echo $this->session->flashdata('error_message');?></div>
		<?php $this->session->unset_userdata('error_message');
		} ?>
		<?php if($this->session->flashdata('success_message')) {  ?>
		<div class="alert alert-success text-center" id="flash_succ_message"><i class="fas fa-check" aria-hidden="true"></i>&nbsp;
		<?php echo $this->session->flashdata('success_message');?></div>
		<?php $this->session->unset_userdata('success_message');
		} ?>