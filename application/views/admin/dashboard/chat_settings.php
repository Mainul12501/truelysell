<?php 
$admin_settings = $language_content;
?>
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-12">
					<h3 class="page-title"><?php echo(!empty($admin_settings['lg_admin_chat_settings']))?($admin_settings['lg_admin_chat_settings']) : 'Chat Settings';  ?></h3>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		<div class="row">
			<div class=" col-lg-6 col-sm-12 col-12">
				<form class="form-horizontal"  method="POST" enctype="multipart/form-data" id="socket" action="<?php echo base_url('admin/settings/socket'); ?>">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
					<div class="card">
						<div class="card-header">
							<div class="card-heads">
								<h4 class="card-title">
									<?php echo(!empty($admin_settings['lg_admin_socket_details']))?($admin_settings['lg_admin_socket_details']) : 'Chat Details';  ?>
								</h4>
								<div class="col-auto pr-0">
									<div class="status-toggle">
	                                    <input  id="socket_showhide" class="check" type="checkbox" name="socket_showhide"<?=settingValue('socket_showhide')?'checked':'';?>>
	                                    <label for="socket_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label>									
									<?php echo(!empty($admin_settings['lg_admin_chat_type']))?($admin_settings['lg_admin_chat_type']) : 'Chat Type';  ?>
								</label>
								<div class="form-group mb-4">
									<div class="custom-control custom-radios custom-control-inline">
										<input class="custom-control-input" id="php_chat" type="radio"  name="chat_type" value="php_chat" <?php echo (!empty(settingValue('chat_type'))&&settingValue('chat_type')=="php_chat")?"checked":"";?>>
										<label class="custom-control-label" for="php_chat">Php Chat</label>
										<input type="hidden" class="chatype" name="test" value="<?php echo settingValue('chat_type') ?>">
									</div>
									<div class="custom-control custom-radios custom-control-inline">
										<input class="custom-control-input" id="websocket" type="radio"  name="chat_type" value="websocket" <?php echo (!empty(settingValue('chat_type'))&&settingValue('chat_type')=="websocket")?"checked":"";?>>
										<label class="custom-control-label" for="websocket">Web Socket</label>
									</div>
								</div>
							</div>
							<div id="websocket_details">
							<div class="form-group">
	                            <label><?php echo(!empty($admin_settings['lg_admin_server_ip']))?($admin_settings['lg_admin_server_ip']) : 'Server IP';  ?></label>
	                            <input type="text" class="form-control" name="server_ip" value="<?php echo settingValue('server_ip'); ?>">
			                </div>
			                <div class="form-group">
	                            <label>Port</label>
	                            <input type="text" class="form-control" name="server_port" value="<?php echo settingValue('server_port'); ?>">
			                </div>
			            	</div>
							<div class="form-groupbtn">
								<button name="form_submit" type="submit" class="btn btn-primary" value="true"><?php echo(!empty($admin_settings['lg_admin_save']))?($admin_settings['lg_admin_save']) : 'Save';  ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class=" col-lg-6 col-sm-12 col-12 d-flex">
				<div class="card flex-fill">
					<form class="form-horizontal"  method="POST" enctype="multipart/form-data" id="chat" action="<?php echo base_url('admin/settings/chat'); ?>">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
						<div class="card-header">
							<div class="card-heads">
								<h4 class="card-title"><?php echo(!empty($admin_settings['lg_admin_chat_content']))?($admin_settings['lg_admin_chat_content']) : 'Chat Content';  ?></h4>
								<div class="col-auto pr-0">
									<div class="status-toggle">
	                                    <input  id="chat_showhide" class="check" type="checkbox" name="chat_showhide"<?=settingValue('chat_showhide')?'checked':'';?>>
	                                    <label for="chat_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
	                            <label><?php echo(!empty($admin_settings['lg_admin_chat_content_text']))?($admin_settings['lg_admin_chat_content_text']) : 'Chat Content Text';  ?> <span class="text-danger">*</span></label>
	                            <input type="text" class="form-control" name="chat_text" value="<?php echo settingValue('chat_text'); ?>" placeholder="Enter chat content">
			                </div>
							<div class="form-groupbtn">
								<button name="form_submit" type="submit" class="btn btn-primary" value="true"><?php echo(!empty($admin_settings['lg_admin_save']))?($admin_settings['lg_admin_save']) : 'Save';  ?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>