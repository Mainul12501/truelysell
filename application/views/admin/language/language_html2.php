<?php 
$admin_settings = $language_content;
?>
<div class="page-wrapper">
    <div class="content settings-content">
    <div class="language-set-content">
                            <div class="setting-title">
                                <h3 class="page-title"><?php echo (!empty($admin_settings['lg_admin_languages'])) ? ($admin_settings['lg_admin_languages']) : 'Language'; ?></h3>
                            </div>
                            <div class=" align-items-center">
                                <div class="d-flex page-header mb-0">
                                    <div class="back-btn mr-3">
                                        <a href="<?php echo base_url() . 'languages-module?type=admin&language=' . $lang_val; ?>" class="btn btn-translation"><i class="fas fa-arrow-left mr-2"></i>
                                        <?php echo(!empty($admin_settings['lg_admin_back_to_translations']))?($admin_settings['lg_admin_back_to_translations']) : 'Back to Translations ';  ?>
                                     </a>
                                    </div>
                                    <div class="page-btn">
                                        <a href="javascript:void(0);" class="d-flex align-items-center selected-language"><?php echo $langName; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="page-wrapper-new">
                    <div class="content">                        
                        
                        <div class="table-responsive">
                            <input type='hidden' id='type' value='<?php echo $_GET['type'];?>'>
                            <table class="table categories_table dataTable">
                                <thead>
                                    <tr>
                                        <th class="no-sort fixed-width">English</th>
                                        <th class="no-sort fixed-width"><?php echo $langName; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $en=false;
                                        if($_GET['language']=="en" || $_GET['language']=="EN"){
                                            $en=true;
                                        }

                                        $i=1; 
                                        
                                        foreach ($lang_keywords as $key => $value) { 
                                    ?>
                                    <tr>
                                        <td><?php echo $value->def_lang_value; ?></td>
                                        <td>
                                            <div>
                                                <input type="text" class="form-control langKeyUpdate" name="<?php echo $value->lang_value; ?>" value="<?php echo $value->lang_value; ?>" data-module_id="<?php echo $module_id; ?>"  data-id="<?php echo $value->id; ?>" data-key="<?php echo $value->lang_key; ?>" data-lang="<?php echo $_GET['language']; ?>">
                                            </div>
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
