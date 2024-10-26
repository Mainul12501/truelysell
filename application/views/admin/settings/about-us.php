<?php
$admin_settings = $language_content;

$query = $this->db->query("SELECT lke.id,lke.language_value,
	(SELECT hs.title FROM home_settings hs WHERE hs.lang_type=lke.language_value AND hs.modules='about_us' LIMIT 1) as lang_value,
	(SELECT hs.content FROM home_settings hs WHERE hs.lang_type=lke.language_value AND hs.modules='about_us' LIMIT 1) as lang_content 
	FROM `language` lke WHERE lke.status=1;");
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
							<h3 class="page-title"><?php echo (!empty($admin_settings['lg_admin_aboutus'])) ? ($admin_settings['lg_admin_aboutus']) : 'About Us';  ?></h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="card">
					<div class="card-body">
						<form class="form-horizontal" method="POST" enctype="multipart/form-data" id="">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<?php $i=0; foreach ($lang_test as $langval) { ?>
								<div class="form-group">
									<label><?php echo (!empty($admin_settings['lg_admin_page_title'])) ? ($admin_settings['lg_admin_page_title']) : 'Page Title';  ?> <strong>(<?php echo $langval->language_value; ?>)</strong> 
										<?php if($i==0){  echo '<span class="text-danger">*</span>';} ?>										 
									</label>
									<input type="text" class="form-control" name="page_title_<?php echo $langval->id; ?>" value="<?php echo $langval->lang_value; ?>" <?php if($i==0){ $i++; echo "required";} ?> >
								</div>
							<?php } ?>
							<div class="form-group">
								<label><?php echo (!empty($admin_settings['lg_admin_pageslug'])) ? ($admin_settings['lg_admin_pageslug']) : 'Page Slug';  ?></label>
								<input type="text" class="form-control" name="page_slug" value="<?php echo ($pages[0]->page_slug) ? $pages[0]->page_slug : ''; ?>" required readonly>
							</div>
							<?php
							if (!empty($about_us)) {
								$i = 1;
							?>
							<?php foreach ($lang_test as $langval) {
								$editor="editor".($langval->id);
							?>
								<div class="form-group">
									<label><?php echo (!empty($admin_settings['lg_admin_page_content'])) ? ($admin_settings['lg_admin_page_content']) : 'Page Content';  ?> <strong>(<?php echo $langval->language_value; ?>)</strong></label>
									<textarea class='form-control editor lang_editor' id="<?=$editor?>" name='page_content_<?php echo $langval->id; ?>' data-id="<?php echo $langval->id; ?>" ><?php echo $langval->lang_content; ?></textarea>
								</div>
							<?php
									}
								} 
							?>
							<div class="m-t-30 text-center">
								<button name="form_submit" type="submit" class="btn btn-primary mr-2" value="true"><?php echo (!empty($admin_settings['lg_admin_save'])) ? ($admin_settings['lg_admin_save']) : 'Save';  ?></button>
								<a href="<?php echo base_url(); ?>admin/pages" class="btn btn-cancel"><?php echo (!empty($admin_settings['lg_admin_back'])) ? ($admin_settings['lg_admin_back']) : 'Back';  ?></a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>