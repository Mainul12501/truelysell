<?php
	$city_lang = $language_content;
	$country=$this->data['country'] = $this->db->select("id, TRIM(SUBSTRING_INDEX(country_name, '(', 1)) AS country_name")->from('country_table')->order_by('country_name', 'asc')->get()->result_array();;

?>
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title"><?php echo(!empty($city_lang['lg_admin_city']))?($city_lang['lg_admin_city']) : 'City List';  ?></h3>
				</div>
				
				<div class="col-auto text-right">
					<a href="<?php echo $base_url; ?>city-list" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>

					<a href="<?php echo $base_url; ?>add-city" class="btn btn-white add-button"><i class="fas fa-plus"></i></a>
				</div>
			</div>
			<!-- country filter added -->
			<form action="<?php echo base_url()?>city-list" method="post" >
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			<div class="row">
				
			<input type="hidden" id="country_id_value" value="<?= !empty($country_value)?$country_value:'';?>">
            <input type="hidden" id="state_id_value" value="<?= !empty($state_value)?$state_value:'';?>">
				<div class="col-lg-3">
				<div class="form-group">
					<label><?php echo(!empty($city_lang['lg_admin_country']))?($city_lang['lg_admin_country']) : 'Country';  ?> <span class="text-danger">*</span></label>
							<select class="form-control" id="country_id" name="country_id" >
						<option value=''><?php echo(!empty($city_lang['lg_admin_select_country']))?($city_lang['lg_admin_select_country']) : 'Select Country';  ?></option>
						<?php foreach($country as $row){?>
						<option value='<?php echo $row['id'];?>'  <?php if(!empty($country_value)){ echo ($row['id']==$country_value)?'selected':'';}?>><?php echo $row['country_name'];?></option> 
					<?php } ?>
					</select>
				 </div>
				</div>

					<div class="col-lg-3">
						<div class="form-group">
							<label><?php echo(!empty($city_lang['lg_admin_state']))?($city_lang['lg_admin_state']) : 'State';  ?> <span class="text-danger">*</span></label>
							<select class="form-control" name="state_id" id="state_id" >
							</select>
						</div>
					</div>
					<div class="col-lg-3">
							<div class="form-group">
								<label>&nbsp;</label>
								<button class="btn btn-primary btn-block" name="form_submit" value="submit" type="submit" ><?php echo(!empty($city_lang['lg_admin_submit']))?($city_lang['lg_admin_submit']) : 'Submit';  ?></button>
							</div>
						</div>
				</div>
						</form>
                                <!-- end -->
		</div>
		<!-- /Page Header -->
		
		<div class="status-toggle mb-3 d-flex">
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-center mb-0 city_table">
                <thead>
									<tr>
										<th>#</th>		
										<th><?php echo(!empty($city_lang['lg_admin_country_name']))?($city_lang['lg_admin_country_name']) : 'County Name';  ?></th>
										<th><?php echo(!empty($city_lang['lg_admin_state_name']))?($city_lang['lg_admin_state_name']) : 'State Name';  ?></th>
										<th><?php echo(!empty($city_lang['lg_admin_city_name']))?($city_lang['lg_admin_city_name']) : 'City Name';  ?></th>
										<th><?php echo(!empty($city_lang['lg_admin_action']))?($city_lang['lg_admin_action']) : 'Action';  ?></th>
									</tr>
							  </thead>
                <tbody>
								<?php
								if (!empty($lists)) {
									$sno = 0;
									foreach ($lists as $row) {
										$_id = isset($row['id']) ? $row['id'] : '';
										if (!empty($_id)) {
											$country_name = isset($row['cname']) ? $row['cname'] : '';
											$state_name = isset($row['state_name']) ? $row['state_name'] : '';
											$city_name = isset($row['name']) ? $row['name'] : '';
											
								?>
											<tr>
												<td> <?php echo ++$sno; ?></td>	
												<td> <?php echo $country_name; ?></td>												
												<td> <?php echo $state_name; ?></td>
												<td> <?php echo $city_name ?></td>
												<td>
													<a href="<?php echo base_url().'admin/dashboard/edit_city/' . $_id; ?>" class="btn btn-sm bg-success-light me-2"><i class="far fa-edit me-1"></i> Edit</a>&nbsp;
														<a href="javascript:;" class="on-default remove-row btn btn-sm bg-danger-light me-2 delete_city_code_config" id="city_del" data-id="<?php echo $_id; ?>"><i class="far fa-trash-alt me-1"></i> Delete</a>
												</td>
											</tr>
									<?php
										}
									}
								}?>
                                </tbody>
                            </table>
						</div> 
					</div> 
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="city_delete_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5><?php echo(!empty($admin_settings['lg_admin_delete_confiramtion']))?($admin_settings['lg_admin_delete_confiramtion']) : 'Delete Confiramtion';  ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you confirm to delete this City.</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="confirm_delete_city" data-id="" class="btn btn-primary"><?php echo(!empty($admin_settings['lg_admin_yes']))?($admin_settings['lg_admin_yes']) : 'Yes';  ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo(!empty($admin_settings['lg_admin_no']))?($admin_settings['lg_admin_no']) : 'No';  ?></button>
      </div>
    </div>
  </div>
</div>