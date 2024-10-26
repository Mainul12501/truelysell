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
							<h3 class="page-title"><?php echo(!empty($userLang['lg_admin_language_edit_keywords']))?($userLang['lg_admin_language_edit_keywords']) : 'Edit Keywords';  ?></h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				
				<div class="card">
					<div class="card-body">
                    <form action="<?php echo $base_url."edit-language-module/".$pages->id;?>"  id="edit_language_module" method="post" autocomplete="off" enctype="multipart/form-data">
                        	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    						<input class="form-control" type="hidden" value="<?php echo $pages->id;?>"  name="id" id="id">
    						
                           
                            <div class="form-group">
								<label><?php echo(!empty($userLang['lg_admin_language_module_name']))?($userLang['lg_admin_language_module_name']) : 'Module Name';  ?><span class="text-danger">* </span></label>
								<input class="form-control" type="text"  name="module_name" id="module_name" value="<?php echo $pages->module_name;?>" placeholder="Enter Module Name" required>
							</div>

                            <div class="mt-4">
                                <button class="btn btn-primary" name="form_submit" value="submit" type="submit"><?php echo(!empty($categories_lang['lg_admin_save_changes']))?($categories_lang['lg_admin_save_changes']) : 'Save Changes';  ?></button>

								<a href="<?php echo $base_url."language-module"; ?>"  class="btn btn-cancel"><?php echo(!empty($categories_lang['lg_admin_cancel']))?($categories_lang['lg_admin_cancel']) : 'Cancel';  ?></a>
                            </div>
                        </form>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>