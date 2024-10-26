<?php 
	$get_details = $this->db->where('id',$this->session->userdata('id'))->get('providers')->row_array();
	$appointmentCheck = $this->db->where('provider_id',$this->session->userdata('id'))->get('provider_appointment_settings')->num_rows();
	
?>
<div class="content">
	<div class="container">
		<div class="row">
			<?php $this->load->view('user/home/provider_sidemenu');?>
			<div class="col-xl-9 col-md-8">
				<form id="appointment-settings" action="<?php echo base_url()?>user/dashboard/update_appointment_settings" method="POST" enctype="multipart/form-data">
					<div class="widget">
						<h4 class="widget-title">
							<?php echo (!empty($user_language[$user_selected]['lg_Appointment_settings'])) ? $user_language[$user_selected]['lg_Appointment_settings'] : $default_language['en']['lg_Appointment_settings'] ;?>
						</h4>
						<p class="chide add-membership">
							<?php echo (!empty($user_language[$user_selected]['lg_Appointment_settings_not_yet_updated'])) ? $user_language[$user_selected]['lg_Appointment_settings_not_yet_updated'] : $default_language['en']['lg_Appointment_settings_not_yet_updated'] ;?>
						</p>
						<input type="hidden" id= "appointment-check" name="appointmentCheck" value="<?php echo $appointmentCheck; ?>">
						<p>							
							<?php echo (!empty($user_language[$user_selected]['lg_Appointment_settings_modified_default'])) ? $user_language[$user_selected]['lg_Appointment_settings_modified_default'] : $default_language['en']['lg_Appointment_settings_modified_default'] ;?>
						</p>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<div class="row">
		
							<div class="form-group col-xl-9">
								<div class="appoint-status-tog">
    							<label class="mr-sm-2">
									<?php echo (!empty($user_language[$user_selected]['lg_Appointment_Time_Interval'])) ? $user_language[$user_selected]['lg_Appointment_Time_Interval'] : $default_language['en']['lg_Appointment_Time_Interval'] ;?>
								</label>
								<select class="form-control" name="appointment_interval" required>
									<option value="" <?php if (empty($appointment_settings->appointment_interval)) echo 'selected'; ?>><?php echo (!empty($user_language[$user_selected]['lg_select_interval'])) ? $user_language[$user_selected]['lg_select_interval'] : $default_language['en']['lg_select_interval'] ;?></option>
									<option value="0" <?php if (!empty($appointment_settings->appointment_interval) && $appointment_settings->appointment_interval == 0) echo 'selected'; ?>>No Interval</option>
    								<option value="15" <?php if (!empty($appointment_settings->appointment_interval) && $appointment_settings->appointment_interval == 15) echo 'selected'; ?>>15 <?php echo (!empty($user_language[$user_selected]['lg_mints'])) ? $user_language[$user_selected]['lg_mints'] : $default_language['en']['lg_mints'] ;?></option>
    								<option value="20" <?php if (!empty($appointment_settings->appointment_interval) && $appointment_settings->appointment_interval == 20) echo 'selected'; ?>>20 <?php echo (!empty($user_language[$user_selected]['lg_mints'])) ? $user_language[$user_selected]['lg_mints'] : $default_language['en']['lg_mints'] ;?></option>
    								<option value="30" <?php if (!empty($appointment_settings->appointment_interval) && $appointment_settings->appointment_interval == 30) echo 'selected'; ?>>30 <?php echo (!empty($user_language[$user_selected]['lg_mints'])) ? $user_language[$user_selected]['lg_mints'] : $default_language['en']['lg_mints'] ;?></option>
    								<option value="45" <?php if (!empty($appointment_settings->appointment_interval) && $appointment_settings->appointment_interval == 45) echo 'selected'; ?>>45 <?php echo (!empty($user_language[$user_selected]['lg_mints'])) ? $user_language[$user_selected]['lg_mints'] : $default_language['en']['lg_mints'] ;?></option>
									<option value="60" <?php if (!empty($appointment_settings->appointment_interval) && $appointment_settings->appointment_interval == 60) echo 'selected'; ?>>1 Hour</option>
    								
								</select>
								</div>

							</div>

							<div class="form-group col-xl-9">
								<div class="appoint-status-tog">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Appointment_Auto_Confirm'])) ? $user_language[$user_selected]['lg_Appointment_Auto_Confirm'] : $default_language['en']['lg_Appointment_Auto_Confirm']; ?></label>
								<div class="status-toggle mr-3">
                                    <input  id="auto_confirm" class="check" type="checkbox" name="auto_confirm"<?= (!empty($appointment_settings->auto_confirm))?'checked':'';?>>
                                    <label for="auto_confirm" class="checktoggle">checkbox</label>
                        		</div>
								</div>
							</div>
							
							<div class="form-group col-xl-12">
								<button name="form_submit" id="form_submit" class="btn btn-primary pl-5 pr-5" type="submit"><?php echo (!empty($user_language[$user_selected]['lg_Update'])) ? $user_language[$user_selected]['lg_Update'] : $default_language['en']['lg_Update']; ?></button>
							</div>
							
						</div>
					</form>
				</div>
			</div>
		</div>
   </div>
</div>

