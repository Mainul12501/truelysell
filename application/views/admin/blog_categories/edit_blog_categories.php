<?php
	$add_blog = $language_content;
?>
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<div class="row">
			<div class="col-xl-8 offset-xl-2">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title">
								<?php echo(!empty($add_blog['lg_admin_edit_blog_category']))?($add_blog['lg_admin_edit_blog_category']) : 'Edit Blog Category'; ?>
							</h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				
				<div class="card">
					<div class="card-body">
                        <form id="update_blog_category" method="post" autocomplete="off" enctype="multipart/form-data">
                        	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<div class="form-group">
								<label><?php echo(!empty($add_blog['lg_admin_language']))?($add_blog['lg_admin_language']) : 'Language'; ?></label>
								<select name="lang_id" class="form-control">
									<?php foreach ($languages as $language): ?>
										<option value="<?php echo $language['id']; ?>" <?php echo ($categories['lang_id'] == $language['id']) ? 'selected' : ''; ?>><?php echo $language['language']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>

                            <div class="form-group">
                                <label>									
									<?php echo(!empty($add_blog['lg_admin_category_name']))?($add_blog['lg_admin_category_name']) : 'Category Name'; ?>
									<span class="text-danger">*</span>
								</label>
                                <input class="form-control" type="text" value="<?php echo $categories['name'];?>"  name="name" id="name" placeholder="Enter category name">
								<input class="form-control" type="hidden" value="<?php echo $categories['id'];?>"  name="category_id" id="category_id">
                            </div>
							<div class="form-group">
								<label class="control-label">
								<?php echo(!empty($add_blog['lg_admin_category_slug']))?($add_blog['lg_admin_category_slug']) : 'Category Slug'; ?>
									<small>(<?php echo(!empty($pages['lg_admin_auto_slug']))?($pages['lg_admin_auto_slug']) : 'If you leave it empty, it will be generated automatically';  ?>)</small>
								</label>
								<input type="text" class="form-control" name="slug" placeholder="Slug"
									value="<?php echo $categories['slug']; ?>">
							</div>

							<div class="form-group">
								<label class="control-label">
									<?php echo(!empty($add_blog['lg_admin_description']))?($add_blog['lg_admin_description']) : 'Description'; ?>  <?php echo(!empty($add_blog['lg_admin_meta_tag']))?($add_blog['lg_admin_meta_tag']) : '(Meta Tag)'; ?> 
								</label>
								<input type="text" class="form-control" name="description"
									placeholder="Description (Meta Tag)" value="<?php echo $categories['description']; ?>">
							</div>

							<div class="form-group">
								<label class="control-label">
								<?php echo(!empty($add_blog['lg_admin_keywords']))?($add_blog['lg_admin_keywords']) : 'Keywords'; ?>  <?php echo(!empty($add_blog['lg_admin_meta_tag']))?($add_blog['lg_admin_meta_tag']) : '(Meta Tag)'; ?> 
								</label>
								<input type="text" class="form-control" name="keywords"
									placeholder="Keywords (Meta Tag)" value="<?php echo $categories['keywords']; ?>">
							</div>

							<div class="form-group d-none">
								<label>Order</label>
								<input type="number" class="form-control" name="category_order" placeholder="Order"
									value="<?php echo $categories['category_order']; ?>" min="1" required>
							</div>
                            <div class="mt-4">
                                <button class="btn btn-primary" name="form_submit" value="submit" type="submit"><?php echo(!empty($add_blog['lg_admin_save_cahnges']))?($add_blog['lg_admin_save_cahnges']) : 'Save Changes'; ?></button>
								<a href="<?php echo $base_url; ?>blog-categories"  class="btn btn-cancel"><?php echo(!empty($add_blog['lg_admin_cancel']))?($add_blog['lg_admin_cancel']) : 'Cancel'; ?></a>
                            </div>
                        </form>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>