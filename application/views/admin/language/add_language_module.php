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
                            <h3 class="page-title"><?php echo(!empty($admin_settings['lg_admin_add_language_module']))?($admin_settings['lg_admin_add_language_module']) : 'Add Language Module';  ?></h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo $base_url; ?>insert_language_module" id="add_language_module" method="post" autocomplete="off" enctype="multipart/form-data">
                           
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                                
                            <div class="form-group">
                                <label><?php echo(!empty($admin_settings['lg_admin_language_module_name']))?($admin_settings['lg_admin_language_module_name']) : 'Module Name';  ?></label>
                                <input class="form-control" type="text" name="module_name" id="module_name">
                            </div>
                            
                            <div class="mt-4">
                                <button class="btn btn-primary " name="form_submit" value="submit" type="submit"><?php echo(!empty($admin_settings['lg_admin_add_language_module']))?($admin_settings['lg_admin_add_language_module']) : 'Add Language Module';  ?></button>
                                <a href="<?php echo base_url().'language-module/'; ?>"  class="btn btn-cancel"><?php echo(!empty($admin_settings['lg_admin_cancel']))?($admin_settings['lg_admin_cancel']) : 'Cancel';  ?></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

