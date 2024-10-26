<?php 
$admin_settings = $language_content;
$service_module_option = settingValue('service_module');

if($service_module_option==1) {
	$service_val='checked';
	$tag='data-toggle="tooltip" title="Click to Deactivate Service Module..!"';
}
else {
	$service_val='';
	$tag='data-toggle="tooltip" title="Click to Activate Service Module ..!"';
}

?>
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<div class="row">
			<div class="col-xl-8 offset-xl-2">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-12">
							<h3 class="page-title"><?php echo(!empty($admin_settings['lg_admin_service_settings']))?($admin_settings['lg_admin_service_settings']) : 'Service Settings';  ?></h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<form class="form-horizontal"  method="POST" enctype="multipart/form-data" id="reviews" action="<?php echo base_url('admin/service-settings'); ?>">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
					<div class="card">
						<div class="card-body">
							<div class="card-heads">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_admin_reviews_details']))?($admin_settings['lg_admin_reviews_details']) : 'Review Details';  ?></h6>
								<div>
									<div class="status-toggle">
	                                    <input  id="review_showhide" class="check" type="checkbox" name="review_showhide"<?=settingValue('review_showhide')?'checked':'';?>>
	                                    <label for="review_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
							<br>
							<div class="card-heads">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_admin_booking_option']))?($admin_settings['lg_admin_booking_option']) : 'Booking Option';  ?></h6>
								<div>
									<div class="status-toggle">
	                                    <input  id="booking_showhide" class="check" type="checkbox" name="booking_showhide"<?=settingValue('booking_showhide')?'checked':'';?>>
	                                    <label for="booking_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
							<br>
							<div class="card-heads">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_admin_auto_approval']))?($admin_settings['lg_admin_auto_approval']) : 'Auto Approval For Services';  ?></h6>
								<div>
									<div class="status-toggle">
	                                    <input  id="auto_approval" class="check" type="checkbox" name="auto_approval"<?=settingValue('auto_approval')?'checked':'';?>>
	                                    <label for="auto_approval" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
							<br>
							<div class="card-heads">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_service_offered']))?($admin_settings['lg_service_offered']) : 'Service Offered';  ?></h6>
								<div>
									<div class="status-toggle">
	                                    <input  id="service_offered_showhide" class="check" type="checkbox" name="service_offered_showhide"<?=settingValue('service_offered_showhide')?'checked':'';?>>
	                                    <label for="service_offered_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
							<br>
							<div class="card-heads">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_admin_service_availability']))?($admin_settings['lg_admin_service_availability']) : 'Service Availability';  ?></h6>
								<div>
									<div class="status-toggle">
	                                    <input  id="service_availability_showhide" class="check" type="checkbox" name="service_availability_showhide"<?=settingValue('service_availability_showhide')?'checked':'';?>>
	                                    <label for="service_availability_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
							<br>
							<div class="card-heads">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_Additional_Services']))?($admin_settings['lg_Additional_Services']) : 'Additional Services';  ?></h6>
								<div>
									<div class="status-toggle">
	                                    <input  id="additional_services_showhide" class="check" type="checkbox" name="additional_services_showhide"<?=settingValue('additional_services_showhide')?'checked':'';?>>
	                                    <label for="additional_services_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
							<br>
							<div class="card-heads">
								<?php (settingValue('location_type')=='manual'? $location_search = 1: $location_search =0); ?>
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_manual_location_search']))?($admin_settings['lg_manual_location_search']) : 'Manual Location Based Search';  ?></h6>
								<div>
									<div class="status-toggle">
	                                    <input  id="manual_location_search_showhide" class="check" type="checkbox" name="manual_location_search_showhide"<?=$location_search?'checked':'';?>>
	                                    <label for="manual_location_search_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
							<br>
							<div class="card-heads">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_admin_provider_email']))?($admin_settings['lg_admin_provider_email']) : 'Provider Email';  ?></h6>
								<div>
									<div class="status-toggle">
	                                    <input  id="provider_email_showhide" class="check" type="checkbox" name="provider_email_showhide"<?=settingValue('provider_email_showhide')?'checked':'';?>>
	                                    <label for="provider_email_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
							<br>
							<div class="card-heads">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_admin_provider_mobile_no']))?($admin_settings['lg_admin_provider_mobile_no']) : 'Provider Mobile no.';  ?></h6>
								<div>
									<div class="status-toggle">
	                                    <input  id="provider_mobileno_showhide" class="check" type="checkbox" name="provider_mobileno_showhide"<?=settingValue('provider_mobileno_showhide')?'checked':'';?>>
	                                    <label for="provider_mobileno_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
							<br>
							<div class="card-heads">
								<h6 class="card-title"><?php echo(!empty($admin_settings['lg_admin_provider_status']))?($admin_settings['lg_admin_provider_status']) : 'Provider Status';  ?></h6>
								<div>
									<div class="status-toggle">
	                                    <input  id="provider_status_showhide" class="check" type="checkbox" name="provider_status_showhide"<?=settingValue('provider_status_showhide')?'checked':'';?>>
	                                    <label for="provider_status_showhide" class="checktoggle">checkbox</label>
	                        		</div>
								</div>
							</div>
							<div class="text-right mt-4 form-groupbtn">
								<button name="form_submit" type="submit" class="btn btn-primary" value="true"><?php echo(!empty($admin_settings['lg_admin_save']))?($admin_settings['lg_admin_save']) : 'Save';  ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>