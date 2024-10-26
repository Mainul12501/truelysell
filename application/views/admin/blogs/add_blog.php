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
								<div class="col-sm-12">
									<h3 class="page-title"><?php echo(!empty($add_blog['lg_admin_add_blog']))?($add_blog['lg_admin_add_blog']) : 'Add Blog'; ?></h3>
								</div>
							</div>
						</div>
						<!-- /Page Header -->
						<form method="POST" id="add_blog" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                            <div class="card">
                                <div class="card-body">
                                    <div class="bank-inner-details">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label><?php echo(!empty($add_blog['lg_admin_title']))?($add_blog['lg_admin_title']) : 'Title'; ?> <span class="text-danger">*</span></label>
                                                    <input type="text" name="title" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label><?php echo(!empty($add_blog['lg_admin_language']))?($add_blog['lg_admin_language']) : 'Language'; ?></label>
                                                    <select name="lang_id" class="form-control"  onchange="get_blog_categories_by_lang(this.value);">

                                                        <?php foreach ($languages as $language): ?>
                                                            <option value="<?php echo $language['id']; ?>" ><?php echo $language['language']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group modal-select-box">
                                                    <label><?php echo(!empty($add_blog['lg_admin_category']))?($add_blog['lg_admin_category']) : 'Category'; ?> <span class="text-danger">*</span></label>
                                                    <select class="select" name="category_id" id="categories">
                                                        <option value=""><?php echo(!empty($add_blog['lg_admin_select']))?($add_blog['lg_admin_select']) : 'Select'; ?></option>
                                                        <?php
                                                         if($categories){
                                                            foreach($categories as $category){ ?>
                                                                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo(!empty($add_blog['lg_admin_slug']))?($add_blog['lg_admin_slug']) : 'Slug'; ?>
                                                        <small>(<?php echo(!empty($pages['lg_admin_auto_slug']))?($pages['lg_admin_auto_slug']) : 'If you leave it empty, it will be generated automatically'; ?>)</small>
                                                    </label>
                                                    <input type="text" class="form-control" name="slug" value="">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        <?php echo(!empty($add_blog['lg_admin_description']))?($add_blog['lg_admin_description']) : 'Description'; ?> 
                                                        <?php echo(!empty($add_blog['lg_admin_meta_tag']))?($add_blog['lg_admin_meta_tag']) : '(Meta Tag)'; ?> 
                                                    </label>
                                                    <input type="text" class="form-control" name="summary" value="">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo(!empty($add_blog['lg_admin_keywords']))?($add_blog['lg_admin_keywords']) : 'Keywords'; ?> <?php echo(!empty($add_blog['lg_admin_meta_tag']))?($add_blog['lg_admin_meta_tag']) : '(Meta Tag)'; ?> </label>
                                                    <input type="text" class="form-control" name="keywords" value="">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label><?php echo(!empty($add_blog['lg_admin_tag']))?($add_blog['lg_admin_tag']) : 'Tag'; ?></label>
                                                    <input type="text" data-role="tagsinput" class="input-tags form-control" name="tags">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label><?php echo(!empty($add_blog['lg_admin_blog_image']))?($add_blog['lg_admin_blog_image']) : 'Blog Image'; ?></label>
                                                    <div class="change-photo-btn">
                                                        <input type="file" name="image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label>
                                                        <?php echo(!empty($add_blog['lg_admin_description']))?($add_blog['lg_admin_description']) : 'Description'; ?></label>
                                                    <textarea id="editor" name="content"></textarea>
                                                </div>
                                                <small class="error blog_content_emp d-none">
                                                <?php echo(!empty($add_blog['lg_admin_fill_blog_content']))?($add_blog['lg_admin_fill_blog_content']) : 'Please Fill Blog Content'; ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="service-fields-btns text-center">
										<button type="submit" id="blog_submit_btn" class="btn btn-primary mr-2"><?php echo(!empty($add_blog['lg_admin_add_post']))?($add_blog['lg_admin_add_post']) : 'Add Post'; ?></button>
										<a href="<?php echo base_url();?>blogs" class="btn btn-cancel"><?php echo(!empty($add_blog['lg_admin_cancel']))?($add_blog['lg_admin_cancel']) : 'Cancel'; ?></a>
									</div>
                                </div>
                            </div> 
                        </form>
						
					</div>
				</div>
			</div>
		</div> 
        <!-- ckeditor JS -->
	<script src="assets/js/ckeditor.js"></script>
    <!-- Ckeditor CSS-->
    <link rel="stylesheet" href="assets/css/ckeditor.css">
    <script type="text/javascript">
        
        
        //get blog categories
function get_blog_categories_by_lang(val) { 
    var base_url=$('#base_url').val();
    var csrf_token=$('#admin_csrf').val();
  var data = {
      "lang_id": val
  };
  data["csrf_token_name"] = csrf_token;

  $.ajax({
      type: "POST",
      url: base_url + "blogs/get_blog_categories_by_lang",
      data: data,
      success: function (response) {
          $('#categories').children('option:not(:first)').remove();
          $("#categories").append(response);
      }
  });
}
    </script>