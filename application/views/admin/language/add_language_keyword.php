<?php 
$admin_settings = $language_content;
?>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-xl-8 offset-xl-2">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="page-title"><?php echo(!empty($admin_settings['lg_admin_add_page']))?($admin_settings['lg_admin_add_page']) : 'Add Page';  ?></h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>insert-language-keyword" id="add_language_keywords" method="post" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                            <input class="form-control" type="hidden"  name="module_id" id="module_id" value="<?php echo $this->uri->segment(2); ?>">
                            <div class="form-group">
                                <label><?php echo(!empty($admin_settings['lg_admin_language_key']))?($admin_settings['lg_admin_language_key']) : 'Language Key';  ?></label>
                                <input class="form-control" type="text"  name="lang_key" id="lang_key" required>
                            </div>
                            <div class="form-group">
                                <label><?php echo(!empty($admin_settings['lg_admin_language_value']))?($admin_settings['lg_admin_language_value']) : 'Language Value';  ?></label>
                                <input class="form-control" type="text"  name="lang_value" id="lang_value" required>
                            </div>
                            <div class="form-group">
                                <label class="mr-sm-2"><?php echo (!empty($admin_settings['lg_admin_select_type'])) ? $admin_settings['lg_admin_select_type'] : 'Select Type' ;?></label>
								<select class="form-control" name="type" required>
									<option value="" <?php if (empty($appointment_settings->appointment_interval)) echo 'selected'; ?>>Select Type</option>
    								<option value="1">Web</option>
    								<option value="3">Admin</option>
								</select>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary " name="form_submit" value="submit" type="submit"><?php echo(!empty($admin_settings['lg_admin_language_add_keywords']))?($admin_settings['lg_admin_language_add_keywords']) : 'Add Keywords';  ?></button>
                                <a href="<?php echo base_url().'language-keyword-list/'.$this->uri->segment(2); ?>"  class="btn btn-cancel"><?php echo(!empty($admin_settings['lg_admin_cancel']))?($admin_settings['lg_admin_cancel']) : 'Cancel';  ?></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

