<?php 
$userLang = $language_content;
$tax_module_option = settingValue('tax_module');
if($tax_module_option==1) {
	$tax_val='checked';
	$tag='data-toggle="tooltip" title="Click to Deactivate Tax Module..!"';
}
else {
	$tax_val='';
	$tag='data-toggle="tooltip" title="Click to Activate Tax Module ..!"';
}

?>
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title"><?php echo(!empty($userLang['lg_admin_Tax_Settings']))?($userLang['lg_admin_Tax_Settings']) : 'Tax Settings';  ?></h3>
				</div>
				<div class="col-auto text-right">
					<a href="<?php echo $base_url; ?>admin/tax-settings" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>
					<a class="btn btn-white filter-btn mr-3" href="javascript:void(0);" id="filter_search">
						<i class="fas fa-filter"></i>
					</a>
					
					<a href="<?php echo $base_url; ?>admin/add-tax" class="btn btn-primary add-button"><i class="fas fa-plus"></i></a>
					
				</div>
				<div class="col-lg-12 d-flex">
				<p class="mr-2 mb-0 pl-2">					
					<?php echo(!empty($userLang['lg_admin_tax_module']))?($userLang['lg_admin_tax_module']) : 'Tax Module';  ?>
				</p>
    				<input id="status_settings_tax" class="check change_Status_tax_module"  type="checkbox" <?php echo $tax_val; ?>>
					<label for="status_settings_tax" class="checktoggle">checkbox</label>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<!-- Search Filter -->
		<form action="<?php echo base_url()?>admin/tax-settings" method="post" id="filter_inputs">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    
			<div class="card filter-card">
				<div class="card-body pb-0">
					<div class="row filter-row">
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label><?php echo(!empty($userLang['lg_admin_tax_name']))?($userLang['lg_admin_tax_name']) : 'Tax Name';  ?></label>
								
								<input class="form-control" type="text" name="search_tax">
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label><?php echo(!empty($userLang['lg_admin_tax_percentage']))?($userLang['lg_admin_tax_percentage']) : 'Tax Percent';  ?></label>
								
								<input class="form-control" type="text" name="search_tax_percent">
							</div>
						</div>
						
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<button class="btn btn-primary btn-block" name="form_submit" value="submit" type="submit"><?php echo(!empty($userLang['lg_admin_submit']))?($userLang['lg_admin_submit']) : 'Submit';  ?></button>
							</div>
						</div>
					</div>

				</div>
			</div>
		</form>
		<!-- /Search Filter -->
				
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-center mb-0 taxes_table" id="taxes_table">
								<thead>
									<tr>
										<th><?php echo(!empty($userLang['lg_admin_#']))?($userLang['lg_admin_#']) : '#';  ?></th>
										<th><?php echo(!empty($userLang['lg_admin_tax_name']))?($userLang['lg_admin_tax_name']) : 'Tax Name';  ?></th>
										<th><?php echo(!empty($userLang['lg_admin_tax_percentage']))?($userLang['lg_admin_tax_percentage']) : 'Tax Percentage';  ?></th>
										
										<th><?php echo(!empty($userLang['lg_admin_status']))?($userLang['lg_admin_status']) : 'Status';  ?></th>
										<th class="text-center"><?php echo(!empty($userLang['lg_admin_action']))?($userLang['lg_admin_action']) : 'Action';  ?></th>		  
									</tr>
								</thead>
								<tbody>
								<?php
								$i=1;
								if(!empty($list)){
								foreach ($list as $rows) {
								
								if($rows['status']==1) {
									$val='checked';
								}
								else {
									$val='';
								}
								if(!empty($rows['created_at'])){
									$date=date(settingValue('date_format'), strtotime($rows['created_at']));
						  		}else{
									$date='-';
								}
								if($rows['status']==1) {
									$val='checked';
									$tag='data-toggle="tooltip" title="Click to Deactivate User ..!"';
								}
								else {
									$val='';
									$tag='data-toggle="tooltip" title="Click to Activate User ..!"';
								}
								$cat_lang = ($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
								$this->db->where('tax_id', $rows['id']);
					            $this->db->where('lang_type', $cat_lang);
					            $cat_name = $this->db->get('tax_lang')->row();
								
								echo'<tr>
								<td>'.$i++.'</td>
								
								<td>'.$rows['tax_name'].'</td>
								<td>'.$rows['tax_percent'].'</td>
								<td>
									<div>
										<div class="status-toggle">
											<input  id="status_'.$rows['id'].'" class="check change_Status_tax" data-id="'.$rows['id'].'" type="checkbox" '.$val.' >
											<label for="status_'.$rows['id'].'" class="checktoggle">checkbox</label>
										</div>
									</div> 
                                </td>
								<td class="text-right">
									<a href="'.base_url().'edit-tax/'.$rows['id'].'" class="btn btn-sm bg-success-light mr-2">
										<i class="far fa-edit mr-1"></i> '.$userLang['lg_admin_edit'].'
									</a>
									<a href="javascript:;" class="on-default remove-row btn btn-sm bg-danger-light mr-2 delete_taxes" id="Onremove_'.$rows['id'].'" data-id="'.$rows['id'].'"><i class="far fa-trash-alt mr-1"></i> '.$userLang['lg_admin_delete'].'</a></td>
								</tr>';
							
								}
								}
								?>
								</tbody>
							</table>
						</div> 
					</div> 
				</div>
			</div>
		</div>
	</div>
</div>