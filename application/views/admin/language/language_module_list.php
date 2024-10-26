<?php 
$admin_settings = $language_content;
?>
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title"><?php echo(!empty($admin_settings['lg_admin_language_module']))?($admin_settings['lg_admin_language_module']) : 'Modules List';  ?></h3>
                </div>

                <div class="col-auto text-right">
                    <a href="<?php echo base_url().'add-language-module'; ?>" class="btn btn-primary add-button"><i class="fas fa-plus"></i></a>
                </div>
                <div class="text-right mb-3">
                        <a href="<?php echo $base_url; ?>languages-new" class="btn btn-primary"><?php echo(!empty($admin_settings['lg_admin_back']))?($admin_settings['lg_admin_back']) : 'Back';  ?></a>
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 language_table" id="language_table">
                                <thead>
                                    <tr>
                                        <th><?php echo(!empty($admin_settings['lg_admin_#']))?($admin_settings['lg_admin_#']) : '#';  ?></th>
                                        <th><?php echo(!empty($admin_settings['lg_admin_language_module_name']))?($admin_settings['lg_admin_language_module_name']) : 'Module Name';  ?></th>
                                        <th class="text-right"><?php echo(!empty($admin_settings['lg_admin_action']))?($admin_settings['lg_admin_action']) : 'Action';  ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 0;
                                
                                  foreach ($list as $page) {
                                    $i++;
                                    
                                    ?>
                                  <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <div class="service-desc">
                                            <h2><?php echo $page['module_name']; ?></h2>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <a href="<?php echo base_url().'language-keyword-list/'.$page['id']; ?>" class="btn btn-sm bg-success-light mr-2">
                                        <?php echo(!empty($admin_settings['lg_admin_language_keywords']))?($admin_settings['lg_admin_language_keywords']) : 'Keywords';  ?>
                                        </a>
                                        <a href="<?php echo base_url().'edit-language-module/'.$page['id']; ?>" class="btn btn-sm bg-success-light mr-2">
                                        <i class="far fa-edit mr-1"></i> <?php echo(!empty($admin_settings['lg_admin_edit']))?($admin_settings['lg_admin_edit']) : 'Edit';  ?>
                                        </a>
                                    </td>
                                  </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            
                            
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    function update_multi_lang()
    {
        
        
        $("#form_id").submit();
    }

</script>



