<?php 
$city = $language_content;
?>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-8 offset-xl-2">
	
			<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col">
						<h3 class="page-title"><?php echo(!empty($city['lg_admin_edit_city']))?($city['lg_admin_edit_city']) : 'Edit City'; ?></h3>
					</div>
				</div>
			</div>
			<!-- /Page Header -->
				<div class="card">
					<div class="card-body">
						<?php
						foreach ($datalist as $value) {
						?>
							<form action="<?php echo base_url().'admin/dashboard/edit_city/' . $value['id']; ?>" method="POST" enctype="multipart/form-data" id="edit_city_code_config">
								<div class="form-group">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
								<label><?php echo(!empty($city['lg_admin_state']))?($city['lg_admin_state']) : 'State'; ?> <span class="text-danger">*</span></label>
								<select name="state_id" id="state_id" class="form-control select" required>
									<option value=""><?php echo(!empty($city['lg_admin_select']))?($city['lg_admin_select']) : 'Select'; ?></option>
									<?php foreach($state as $s) {?>
										<option value="<?php echo $s['id']; ?>" <?php if($value['state_id'] == $s['id']) echo 'selected'; ?>><?php echo $s['name'];?></option>
									<?php } ?>
								</select>
							</div>
							
							<div class="form-group">
								<label><?php echo(!empty($city['lg_admin_city']))?($city['lg_admin_city']) : 'City'; ?> <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="city_name" id="city_name" required value="<?php if ($value['name']) { echo $value['name']; } ?>">
							</div>
								<div class="m-t-30">
										<button name="form_submit" type="submit" class="btn btn-primary mr-2" value="true"><?php echo(!empty($city['lg_admin_save_changes']))?($city['lg_admin_save_changes']) : 'Save Changes'; ?></button>
									<a href="<?php echo $base_url; ?>city-list"  class="btn btn-cancel"><?php echo(!empty($city['lg_admin_cancel']))?($city['lg_admin_cancel']) : 'Cancel'; ?></a>
								</div>
							</form>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>