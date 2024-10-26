<?php 
$userLang = $language_content;

$query = $this->db->query("select * from language WHERE status = '1'");
$lang_test = $query->result();

?>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-8 offset-xl-2">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title"><?php echo(!empty($userLang['lg_admin_add_tax']))?($userLang['lg_admin_add_tax']) : 'Create Taxes';  ?></h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="card">
					<div class="card-body">
						<form id="add_tax" method="post" autocomplete="off" enctype="multipart/form-data">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
							<?php foreach ($lang_test as $langval) { ?>
							<div class="form-group">
								<label><?php echo(!empty($userLang['lg_admin_tax_name']))?($userLang['lg_admin_tax_name']) : 'Tax Name';  ?>(<?php echo $langval->language; ?>) <span class="text-danger">* </span></label>
								<input class="form-control" type="text"  name="tax_name_<?php echo $langval->id; ?>"  id="tax_name" placeholder="Enter Tax Name" required>
							</div>
							<?php }  ?>
							<div class="form-group">
								<label><?php echo(!empty($userLang['lg_admin_tax_percentage']))?($userLang['lg_admin_tax_percentage']) : 'Tax Percentage';  ?><span class="text-danger">* </span></label>
								<input class="form-control" type="text"  name="tax_percent" id="tax_percent" placeholder="Enter Tax Percentage" required>
							</div>
							
							<div class="mt-4">
								<button class="btn btn-primary " name="form_submit" value="submit" type="submit"><?php echo(!empty($userLang['lg_admin_add_taxes']))?($userLang['lg_admin_add_taxes']) : 'Add Tax';  ?></button>

								<a href="<?php echo $base_url; ?>admin/tax-settings"  class="btn btn-cancel"><?php echo(!empty($userLang['lg_admin_cancel']))?($userLang['lg_admin_cancel']) : 'Cancel';  ?></a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

					