<?php 
$admin_settings = $language_content;
?>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-8 offset-xl-2">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-12">
							<h3 class="page-title"><?php echo(!empty($admin_settings['lg_admin_appointment_settings']))?($admin_settings['lg_admin_appointment_settings']) : 'Appointment Settings';  ?></h3>		
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<form class="form-horizontal"  method="POST" enctype="multipart/form-data" id="appointment-settings" action="<?php echo base_url('admin/appointment-settings'); ?>">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
					<div class="card">
						<div class="card-body">
							<div class="card-heads head-appoints">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_Appointment_Auto_Confirm']))?($admin_settings['lg_Appointment_Auto_Confirm']) : 'Appointment Auto Confirm';  ?></h6>
								<div>
									<div class="status-toggle">
	                                    <input  id="appointment_auto_confirm_showhide" class="check" type="checkbox" name="appointment_auto_confirm_showhide"<?=settingValue('appointment_auto_confirm_showhide')?'checked':'';?>>
	                                    <label for="appointment_auto_confirm_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
							<br>
							<div class="card-heads head-appoints">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_admin_appointment_time_intervals']))?($admin_settings['lg_admin_appointment_time_intervals']) : 'Appointment Time Intervals';  ?> (in mins)	</h6>
								<div>
									<div class="status-toggle">
									<select id="appointment_intervals_showhide" class="form-control appoint-control" name="appointment_intervals_showhide">
										<option value="0" <?php if (settingValue('appointment_intervals_showhide') == 0) echo 'selected'; ?>>No Interval</option>
    									<option value="10" <?php if (settingValue('appointment_intervals_showhide') == 10) echo 'selected'; ?>>10 minutes</option>
    									<option value="15" <?php if (settingValue('appointment_intervals_showhide') == 15) echo 'selected'; ?>>15 minutes</option>
    									<option value="20" <?php if (settingValue('appointment_intervals_showhide') == 20) echo 'selected'; ?>>20 minutes</option>
    									<option value="30" <?php if (settingValue('appointment_intervals_showhide') == 30) echo 'selected'; ?>>30 minutes</option>
    									<option value="45" <?php if (settingValue('appointment_intervals_showhide') == 45) echo 'selected'; ?>>45 minutes</option>
										<option value="60" <?php if (settingValue('appointment_intervals_showhide') == 60) echo 'selected'; ?>>1 Hour</option>
									</select>
	                        		</div>
								</div>
							</div>
							<br>
							
							<div class="card-heads head-appoints">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_cancel_time_before_appointment']))?($admin_settings['lg_cancel_time_before_appointment']) : 'Cancellation Time Before Appointment Scheduled';  ?> </h6>
								<div>
									<div class="status-toggle">
									<select id="appointment_cancel_time_showhide" class="form-control appoint-control" name="appointment_cancel_time_showhide">
										<option value="0" <?php if (settingValue('appointment_cancel_time_showhide') == 0) echo 'selected'; ?>>No Cancellation Time</option>
    									<option value="1" <?php if (settingValue('appointment_cancel_time_showhide') == 1) echo 'selected'; ?>>1 Hours</option>
    									<option value="2" <?php if (settingValue('appointment_cancel_time_showhide') == 2) echo 'selected'; ?>>2 Hours</option>
    									<option value="3" <?php if (settingValue('appointment_cancel_time_showhide') == 3) echo 'selected'; ?>>3 Hours</option>
    									<option value="4" <?php if (settingValue('appointment_cancel_time_showhide') == 4) echo 'selected'; ?>>4 Hours</option>
									</select>
	                                    
	                        		</div>
								</div>
							</div>
							<br>
							<div class="card-heads head-appoints">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_admin_rescheduling_time_before_appointment']))?($admin_settings['lg_admin_rescheduling_time_before_appointment']) : 'Rescheduling Time Before Appointment Scheduled';  ?></h6>
								<div>
									<div class="status-toggle">
										<select id="appointment_reschedule_time_showhide" class="form-control appoint-control" name="appointment_reschedule_time_showhide">
											<option value="0" <?php if (settingValue('appointment_reschedule_time_showhide') == 0) echo 'selected'; ?>>No Appointment Reschedule Time</option>
    										<option value="1" <?php if (settingValue('appointment_reschedule_time_showhide') == 1) echo 'selected'; ?>>1 Hours</option>
    										<option value="2" <?php if (settingValue('appointment_reschedule_time_showhide') == 2) echo 'selected'; ?>>2 Hours</option>
    										<option value="3" <?php if (settingValue('appointment_reschedule_time_showhide') == 3) echo 'selected'; ?>>3 Hours</option>
    										<option value="4" <?php if (settingValue('appointment_reschedule_time_showhide') == 4) echo 'selected'; ?>>4 Hours</option>
										</select>
	                                   
	                        		</div>
								</div>
							</div>
							<div class="form-groupbtn text-right mt-4">
								<button name="form_submit" type="submit" class="btn btn-primary" value="true"><?php echo(!empty($admin_settings['lg_admin_save']))?($admin_settings['lg_admin_save']) : 'Save';  ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>