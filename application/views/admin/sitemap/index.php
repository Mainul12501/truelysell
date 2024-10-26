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
						<div class="col-12">
							<h3 class="page-title">                                
                                <?php echo(!empty($admin_settings['lg_admin_sitemap']))?($admin_settings['lg_admin_sitemap']) : 'Sitemap';  ?>
                            </h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-heads">
                            <h4 class="card-title">
                            <?php echo(!empty($admin_settings['lg_admin_sitemap']))?($admin_settings['lg_admin_sitemap']) : 'Sitemap';  ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="user_csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                        <div class="mb-3">
                            <label>                                
                                <?php echo(!empty($admin_settings['lg_admin_sitemap_url']))?($admin_settings['lg_admin_sitemap_url']) : 'Sitemap Url';  ?>    
                            </label>
                            <input type="text" class="form-control" name="sitemap_url" id="sitemap_url" placeholder="Enter Website Name" value="<?php echo base_url().'sitemap.xml'; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="d-block">                                
                                <?php echo(!empty($admin_settings['lg_admin_sitemap_file']))?($admin_settings['lg_admin_sitemap_file']) : 'Sitemap File';  ?>    
                            </label>
                            <a target="_blank" href="<?php echo base_url().'sitemap.xml'; ?>" class="btn btn-success btn-sm"><i class="fa fa-link"></i> 
                                <?php echo(!empty($admin_settings['lg_admin_view_sitemap_file']))?($admin_settings['lg_admin_view_sitemap_file']) : 'View Sitemap File';  ?>    
                            </a>
                        </div>
                        <div>
                            <label class="d-block">                                
                                <?php echo(!empty($admin_settings['lg_admin_rebulid_sitemap']))?($admin_settings['lg_admin_rebulid_sitemap']) : 'Rebuild Your Sitemap';  ?>    
                            </label>
                            <a href="#" class="btn btn-primary btn-sm" title="Rebuild Your Sitemap" id="rebuild_sitemap"><i class="fa fa-link"></i>                                 
                                <?php echo(!empty($admin_settings['lg_admin_rebulid_sitemap']))?($admin_settings['lg_admin_rebulid_sitemap']) : 'Rebuild Your Sitemap';  ?>    
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>