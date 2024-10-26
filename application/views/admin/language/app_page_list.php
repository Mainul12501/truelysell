<?php 
$admin_settings = $language_content;
?>

<div class="page-wrapper">
    <div class="content settings-content">
        <div class="row">
            <div class="col-xl-12">
                <div class="settings-wrapper">
                    <div class="settings-page-wrap">
                    <div class="language-set-content">
                            <div class="setting-title">
                                <h3 class="page-title">
                                    <?php echo(!empty($admin_settings['lg_admin_app_language']))?($admin_settings['lg_admin_app_language']) : 'App Language';  ?>
                                </h3>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="page-header mb-0">
                                    <div class="back-btn mr-3">
                                        <a href="<?php echo $base_url; ?>languages-settings" class="btn btn-translation"><i class="fas fa-arrow-left mr-2"></i>
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
                        <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">                                       
                                        <div class="table-responsive">
                                            <table class="table  language_table dataTable">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo(!empty($admin_settings['lg_admin_#']))?($admin_settings['lg_admin_#']) : '#';  ?></th>
                                                        <th><?php echo(!empty($admin_settings['lg_admin_language_module_name']))?($admin_settings['lg_admin_language_module_name']) : 'Module Name';  ?></th>
                                                        <th><?php echo(!empty($admin_settings['lg_admin_total']))?($admin_settings['lg_admin_total']) : 'Total ';  ?></th>
                                                        <th><?php echo(!empty($admin_settings['lg_admin_complete']))?($admin_settings['lg_admin_complete']) : 'Complete ';  ?></th>
                                                        <th><?php echo(!empty($admin_settings['lg_admin_progress']))?($admin_settings['lg_admin_progress']) : 'Progress ';  ?></th>
                                                        <th class="text-right no-sorted"><?php echo(!empty($admin_settings['lg_admin_action']))?($admin_settings['lg_admin_action']) : 'Action';  ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($list as $page) {
                                                    $i++;
                                                    
                                                    $total_keyword_count = count($this->db->get_where('app_language_management', array('language'=> 'en','page_key' => $page['page_key']))->result()); 
                                                    $total_keyword_count = ($total_keyword_count) ? $total_keyword_count : 0;

                                                    $count_done_keywords = count($this->db->get_where('app_language_management', array('language'=> $lang,'lang_value !='=> '','page_key' => $page['page_key']))->result());

                                                    $count_done_keywords = ($count_done_keywords) ? $count_done_keywords : 0;

                                                    if($count_done_keywords > 0) {
                                                        $donePercent = ($count_done_keywords/$total_keyword_count)*100;
                                                    } else {
                                                        $donePercent = 0;
                                                    }
                                                    ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <div class="service-desc">
                                                            <h2><?php echo $page['page_title']; ?></h2>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $total_keyword_count; ?></td>
                                                    <td><?php echo $count_done_keywords; ?></td>
                                                    <td>
                                                        <div class="position-relative">
                                                            <div class="progress attendance language-progress">																			
                                                                <div class="progress-bar bg-success" role="progressbar" style="width:<?php echo round($donePercent); ?>%">
                                                                    <span><?php echo floor($donePercent); ?>%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="mr-2 p-2 show-edit" href="<?php echo base_url().'app_page_list/'.$page['page_key'].'/'.$this->uri->segment(2); ?>" >
                                                                <i class="far fa-edit"></i>
                                                            </a>
                                                        </div>
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



