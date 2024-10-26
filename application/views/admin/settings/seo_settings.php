<?php 
$admin_settings = $language_content;

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
								<div class="col-12">
									<h3 class="page-title"><?php echo(!empty($admin_settings['lg_admin_seo_settings']))?($admin_settings['lg_admin_seo_settings']) : 'SEO Settings';  ?></h3>
								</div>
							</div>
						</div>
						<!-- /Page Header -->
						<form accept-charset="utf-8" id="seo_settings" action="" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>">

							<div class="card">
								<div class="card-body">
									<?php 
									foreach ($lang_test as $langval) {
										$row = $this->db->where('lang_type',$langval->language_value)->get('seo')->row_array();
											if(!empty($row)) {
									?>
									<div class="form-group">
										<label><?php echo(!empty($admin_settings['lg_admin_meta_title']))?($admin_settings['lg_admin_meta_title']) : 'Meta Title';  ?> <strong>(<?php echo $langval->language; ?>)</strong> <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="meta_title_<?php echo $langval->id; ?>" id="meta_title" value="<?php echo ($row['meta_title'])?$row['meta_title']:''; ?>">
									</div>
									<?php } else { ?> 
									<div class="form-group">
										<label><?php echo(!empty($admin_settings['lg_admin_meta_title']))?($admin_settings['lg_admin_meta_title']) : 'Meta Title';  ?> <strong>(<?php echo $langval->language; ?>)</strong> <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="meta_title_<?php echo $langval->id; ?>" id="meta_title" value="">
									</div>
									<?php } } ?>
									<?php 
									foreach ($lang_test as $langval) {
										$row = $this->db->where('lang_type',$langval->language_value)->get('seo')->row_array();
											if(!empty($row)) {
									?>
									<div class="form-group">
										<label><?php echo(!empty($admin_settings['lg_admin_meta_keywords']))?($admin_settings['lg_admin_meta_keywords']) : 'Meta Keywords';  ?> <strong>(<?php echo $langval->language; ?>)</strong> <span class="text-danger">*</span></label>
										<input type="text" data-role="tagsinput" class="input-tags form-control"  name="meta_keyword_<?php echo $langval->id; ?>"  id="services" value="<?php echo ($row['meta_keyword'])?$row['meta_keyword']:''; ?>">
									</div>
									<?php } else { ?> 
									 	<div class="form-group">
										<label><?php echo(!empty($admin_settings['lg_admin_meta_keywords']))?($admin_settings['lg_admin_meta_keywords']) : 'Meta Keywords';  ?> <strong>(<?php echo $langval->language; ?>)</strong> <span class="text-danger">*</span></label>
										<input type="text" data-role="tagsinput" class="input-tags form-control"  name="meta_keyword_<?php echo $langval->id; ?>"  id="services" value="">
									</div>
									<?php } } ?>
									<?php 
									foreach ($lang_test as $langval) {
										$row = $this->db->where('lang_type',$langval->language_value)->get('seo')->row_array();
											if(!empty($row)) {
									?>
									<div class="form-group">
										<label><?php echo(!empty($admin_settings['lg_admin_meta_description']))?($admin_settings['lg_admin_meta_description']) : 'Meta Description';  ?> <strong>(<?php echo $langval->language; ?>)</strong>  <span class="text-danger">*</span></label>
										<textarea class="form-control" rows="4" name="meta_desc_<?php echo $langval->id; ?>" id="meta_desc" value="<?php if (isset($meta_desc ))  ?>"><?php echo ($row['meta_desc'])?$row['meta_desc']:''; ?></textarea>
									</div>
									<?php } else { ?> 
									<div class="form-group">
										<label><?php echo(!empty($admin_settings['lg_admin_meta_description']))?($admin_settings['lg_admin_meta_description']) : 'Meta Description';  ?> <strong>(<?php echo $langval->language; ?>)</strong>  <span class="text-danger">*</span></label>
										<textarea class="form-control" rows="4" name="meta_desc_<?php echo $langval->id; ?>" id="meta_desc" value=""></textarea>
									</div>
									<?php } } ?>
									<div class="form-groupbtn">
										<button name="form_submit" type="submit" class="btn btn-update me-2" value="true"><?php echo(!empty($admin_settings['lg_admin_update']))?($admin_settings['lg_admin_update']) : 'Update';  ?></button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>