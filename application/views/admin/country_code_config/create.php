<?php 
$admin_settings = $language_content;
?>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-8 offset-xl-2">
				<div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="page-title"><?php echo(!empty($admin_settings['lg_admin_create_new_countrycode']))?($admin_settings['lg_admin_create_new_countrycode']) : 'Create New Country code';  ?></h3>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<form id="add_country_code_config" action="<?php echo base_url().'admin/country-code-config/create'; ?>" method="POST" enctype="multipart/form-data">
							<div class="form-group">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
								<label><?php echo(!empty($admin_settings['lg_admin_country_code']))?($admin_settings['lg_admin_country_code']) : 'Country Code';  ?> <span class="text-danger">*</span></label>
								<input type="text" class="form-control" maxlength = "10" name="country_code" id="country_code" required>
							</div>
							<div class="form-group">
								<label><?php echo(!empty($admin_settings['lg_admin_country_id']))?($admin_settings['lg_admin_country_id']) : 'Country ID';  ?> <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="country_id" id="country_id" required>
							</div>
							<div class="form-group">
								<label><?php echo(!empty($admin_settings['lg_admin_country_name']))?($admin_settings['lg_admin_country_name']) : 'Country Name';  ?> <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="country_name" id="country_name" required>
							</div>
							<div class="m-t-30">
								<button name="form_submit" type="submit" class="btn btn-primary mr-2" value="true"><?php echo(!empty($admin_settings['lg_admin_save_changes']))?($admin_settings['lg_admin_save_changes']) : 'Save Changes';  ?></button>
								<a href="<?php echo $base_url; ?>admin/country-code-config"  class="btn btn-cancel"><?php echo(!empty($admin_settings['lg_admin_cancel']))?($admin_settings['lg_admin_cancel']) : 'Cancel';  ?></a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>