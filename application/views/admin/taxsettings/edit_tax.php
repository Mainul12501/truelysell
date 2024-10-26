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
							<h3 class="page-title"><?php echo(!empty($userLang['lg_admin_edit_taxes']))?($userLang['lg_admin_edit_taxes']) : 'Edit Tax';  ?></h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				
				<div class="card">
					<div class="card-body">
                        <form id="update_tax" method="post" autocomplete="off" enctype="multipart/form-data">
                        	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    						<input class="form-control" type="hidden" value="<?php echo $tax['id'];?>"  name="tax_id" id="tax_id">
    						<?php foreach ($lang_test as $langval) { 
    							$this->db->where('tax_id', $tax['id']);
						        $this->db->where('lang_type', $langval->language_value);
						        $lang_category = $this->db->get('tax_lang')->row();
								
    						?>
                            <div class="form-group">
                                <label><?php echo(!empty($userLang['lg_admin_tax_name']))?($userLang['lg_admin_tax_name']) : 'Tax Name';  ?>(<?php echo $langval->language; ?>) <span class="text-danger">* </span></label>
                                <input class="form-control" type="text" value="<?php echo (!empty($lang_category)) ? $lang_category->tax_name : ""; ?>"  name="tax_name_<?php echo $langval->id; ?>" id="tax_name" required placeholder="Enter tax name">
                            </div>
                            <?php }  ?>
                            <div class="form-group">
								<label><?php echo(!empty($userLang['lg_admin_tax_percentage']))?($userLang['lg_admin_tax_percentage']) : 'Tax Percent';  ?><span class="text-danger">* </span></label>
								<input class="form-control" type="text"  name="tax_percent" id="tax_percent" value="<?php echo $tax['tax_percent'];?>" placeholder="Enter tax percent">
							</div>

                            <div class="mt-4">
                                <button class="btn btn-primary" name="form_submit" value="submit" type="submit"><?php echo(!empty($categories_lang['lg_admin_save_changes']))?($categories_lang['lg_admin_save_changes']) : 'Save Changes';  ?></button>

								<a href="<?php echo $base_url; ?>admin/tax-settings"  class="btn btn-cancel"><?php echo(!empty($categories_lang['lg_admin_cancel']))?($categories_lang['lg_admin_cancel']) : 'Cancel';  ?></a>
                            </div>
                        </form>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>