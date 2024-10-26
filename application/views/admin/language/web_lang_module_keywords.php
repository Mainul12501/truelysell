<?php 
$admin_settings = $language_content;
?>
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">
                        <?php echo(!empty($admin_settings['lg_admin_translation']))?($admin_settings['lg_admin_translation']) : 'Translation -';  ?> 
                        <span class=""><?php echo ucfirst($module); ?></span>
                        <span class="text-primary">(<?php echo $langName; ?>)</span>
                    </h3>
                </div>
                <div class="text-right mb-3">
                    <a onclick="history.back()" class="btn btn-primary"><?php echo(!empty($admin_settings['lg_admin_back']))?($admin_settings['lg_admin_back']) : 'Back';  ?></a>
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
                                        <th width="45%"><?php echo(!empty($admin_settings['lg_admin_key']))?($admin_settings['lg_admin_key']) : 'Key';  ?></th>
                                        <th width="45%"><?php echo(!empty($admin_settings['lg_admin_value']))?($admin_settings['lg_admin_value']) : 'Value';  ?></th>
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
                                        $val = str_replace('_', ' ', $value->lang_key); 
                                        $val1 = ltrim($val, 'lg ');
                                        $langKey = ucfirst($val1);
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $langKey; ?></td>
                                            <td>
                                                <input type="text" class="form-control langKeyUpdate" name="<?php echo $value->lang_value; ?>" value="<?php echo $value->lang_value; ?>" data-module_id="<?php echo $module_id; ?>"  data-id="<?php echo $value->id; ?>" data-key="<?php echo $value->lang_key; ?>" data-lang="<?php echo $_GET['language']; ?>">
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