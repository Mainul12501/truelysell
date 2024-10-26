<?php 
$admin_settings = $language_content;
?>
<div class="page-wrapper">
    <div class="content container-fluid">
        <?php 
            $page_key = $this->uri->segment(2); 
            $lang_key = $this->uri->segment(3); 
        ?>        
        <div class="language-set-content">
            <div class="setting-title">
            <h3 class="page-title">
                    <h3 class="page-title"><?php echo(!empty($admin_settings['lg_admin_app_keywords']))?($admin_settings['lg_admin_app_keywords']) : 'App Keywords';  ?></h3>
                        <span class=""><?php echo ucfirst($page_key); ?></span>
                        <span class="text-primary">(<?php echo $lang_key; ?>)</span>
                    </h3>
            </div>
            <div class="d-flex align-items-center">
                <div class="page-header mb-0">
                    <div class="back-btn mr-3">
                        <a href="<?php echo $base_url; ?>app-page-list/<?php echo $this->uri->segment(3)?>" class="btn btn-translation"><i class="fas fa-arrow-left mr-2"></i>Back to Translations </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 categories_table" id="categories_table">
                                <thead>
                                    <tr>
                                        <th><?php echo(!empty($admin_settings['lg_admin_#']))?($admin_settings['lg_admin_#']) : '#';  ?></th>
                                        <th width="45%">English</th>
                                        <th width="45%"><?php echo $langName; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $en=false;
                                        if($_GET['language']=="en" || $_GET['language']=="EN"){
                                            $en=true;
                                        }

                                        $i=1; 
                                        
                                        foreach ($lang_keywords as $key => $value)
                                        {                                         
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                            <?php 
                                                echo $value->def_lang_value;
                                            ?>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control applangKeyUpdate" name="<?php echo $value->lang_key; ?>" value="<?php echo $value->lang_value; ?>" data-page_key="<?php echo $page_key; ?>"  data-id="<?php echo $value->sno; ?>" data-key="<?php echo $value->lang_key; ?>" data-lang="<?php echo $lang_key; ?>">
                                            </td>
                                        </tr>
                                     
                                <?php $i++; } ?>
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>