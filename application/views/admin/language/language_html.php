<?php
$admin_settings = $language_content;
?>
<div class="page-wrapper">
    <div class="content settings-content">
        <div class="row">
            <div class="col-xl-12">
                <div class="settings-wrapper">
                    <div class="settings-page-wrap">
                        <div class="setting-title">
                            <h4>                                
                                <?php echo (!empty($admin_settings['lg_admin_languages'])) ? ($admin_settings['lg_admin_languages']) : 'Language'; ?>
                            </h4>
                        </div>
                        <div class="page-header">
                            <ul class="table-top-head me-auto pl-0 mb-0">
                                <li>
                                    <a data-toggle="tooltip" download href="<?= base_url() ?>admin/language_new/language_pdf" data-placement="top" title="Pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>
                                </li>
                                <li>
                                    <a data-toggle="tooltip" href="<?= base_url() ?>admin/language_new/language_export" data-placement="top" title="Excel"><img src="assets/img/icons/excel.svg" alt="img"></a>
                                </li>
                                <li>
                                    <a data-toggle="tooltip"  target="blank" href="<?= base_url() ?>admin/language_new/language_print" data-placement="top" title="Print"><i class="fas fa-print"></i></a>
                                </li>
                            </ul>
                            <form action="<?php echo base_url('add-language-list') ?>" method="post">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                <div class="page-btn d-flex align-items-center ml-0">
                                    <div class="select-language">
                                        <select class="select" name="language_id">
                                            <option>Select Language</option>
                                            <?php foreach ($language_default as $lang) { 
                                                $selected = ($lang->id == 1) ? 'selected' : '';
                                                ?>
                                                
                                                <option value="<?php echo $lang->id; ?>" <?php echo $selected; ?> ><?php echo $lang->language; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <button name="form_submit" type="submit" class="btn btn-primary btn-added ml-2">                                        
                                        <?php echo (!empty($admin_settings['lg_admin_add_language'])) ? ($admin_settings['lg_admin_add_language']) : 'Add Language'; ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table custom-table mb-0 datatable">
                                                <thead>
                                                    <tr>
                                                        <th>
											                <?php echo (!empty($admin_settings['lg_admin_#'])) ? ($admin_settings['lg_admin_#']) : '#'; ?>
										                </th>
                                                        <th>
											                <?php echo (!empty($admin_settings['lg_admin_language'])) ? ($admin_settings['lg_admin_language']) : 'Language'; ?>
										                </th>
										                <th>
											                <?php echo (!empty($admin_settings['lg_admin_code'])) ? ($admin_settings['lg_admin_code']) : 'Code'; ?>
										                </th>
										                <th>
											                <?php echo (!empty($admin_settings['lg_admin_rtl'])) ? ($admin_settings['lg_admin_rtl']) : 'RTL'; ?>
										                </th>
                                                        <th>
											                <?php echo (!empty($admin_settings['lg_admin_default_language'])) ? ($admin_settings['lg_admin_default_language']) : 'Default Language'; ?>
										                </th>
                                                        <th><?php echo (!empty($admin_settings['lg_admin_total'])) ? ($admin_settings['lg_admin_total']) : 'Total'; ?></th>
                                                        <th><?php echo (!empty($admin_settings['lg_admin_done'])) ? ($admin_settings['lg_admin_done']) : 'Done'; ?></th>
                                                        <th><?php echo (!empty($admin_settings['lg_admin_Progress'])) ? ($admin_settings['lg_admin_Progress']) : 'Progress'; ?></th>
                                                        <th>
											                <?php echo (!empty($admin_settings['lg_admin_status'])) ? ($admin_settings['lg_admin_status']) : 'Status'; ?>
										                </th>
                                                        <th class="text-end" >
											                <?php echo (!empty($admin_settings['lg_admin_action'])) ? ($admin_settings['lg_admin_action']) : 'Action'; ?>
										                </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
									                    foreach ($language as $lang) {
										                    if ($lang->language_value == 'en') {
											                    $attr = 'disabled';
										                    } else {
											                    $attr = '';
										                    } 
                                                           
                                                            $count_done_keywords = count($this->db->get_where('language_keywords_management', array('language'=> $lang->language_value,'lang_value !=' => ''))->result());
                                                           
                                                            $donePercent = ($count_done_keywords/$total_keyword_count)*100;
                                                            ($lang->status == 1) ? ($status = "Active") : ($status = "Inactive");
                                                            ?>
                                                    <tr>
                                                        <td>
												            <?php echo $i; ?>
											            </td>
                                                        <td>
												            <?php echo $lang->language; ?>
											            </td>
											            <td>
												            <?php echo $lang->language_value; ?>
											            </td>
                                                        <td>
												            <div>
													            <div class="status-toggle">
														            <input id="tag_<?php echo $lang->id; ?>" class="check language_tag" data-id="<?php echo $lang->id; ?>" type="checkbox" <?php if ($lang->tag == 'rtl') {
																   echo 'checked';} 
                                                                    if ($this->session->userdata('role') != 1) {
															        echo 'disabled';} ?>>
														            <label for="tag_<?php echo $lang->id; ?>"
															class="checktoggle">checkbox</label>
													            </div>
												            </div>
											            </td>
                                                        <td>
												            <div>
													            <div class="status-toggle">
														            <input id="default_<?php echo $lang->id; ?>" class="check default_lang" data-id="<?php echo $lang->id; ?>" data-status="<?php echo $lang->default_language; ?>"
															        type="checkbox" <?php if ($lang->default_language == 1) {
																        echo 'checked';
															        } ?> 	<?php if ($this->session->userdata('role') != 1) {
																	  echo 'disabled';
																  } ?>>
														            <label for="default_<?php echo $lang->id; ?>"class="checktoggle">checkbox</label>
													            </div>
												            </div>
											            </td>
                                                        <td><?php echo $total_keyword_count ?></td>
                                                        <td><?php echo $count_done_keywords ?></td>
                                                        <td>
                                                            <div class="position-relative">
                                                                <div class="progress attendance language-progress">											
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width:<?php echo round($donePercent); ?>%">
                                                                        <span><?php echo floor($donePercent) ?>%</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </td>
                                                        <td class="d-flex">
                                                            <?php ($lang->status == 1) ? ($statusClass = "badge badge-linesuccess") : ($statusClass = "badge badge-linedanger"); 
                                                            ?>
                                                            <span class="<?php echo $statusClass ?>"><?php echo $status ?>
                                                            </span>
																
															
                                                                <div class="status-toggle ml-1">
                                                                        <input <?php echo $attr; ?> id="status_<?php echo $lang->id; ?>"
															class="check language_status" data-id="<?php echo $lang->id; ?>" type="checkbox" <?php if ($lang->status == 1) {
																echo 'checked';
															} ?> 	<?php if ($this->session->userdata('role') != 1) {
																	  echo 'disabled';
																  } ?>>
																	<label for="status_<?php echo $lang->id; ?>" class="checktoggle">checkbox</label>
                                                                </div>
                                                        </td>

                                                        <td class="action-table-data">
                                                            <div class="edit-delete-action language-action">

                                                                <a class="btn btn-primary btn-sm mr-2 export_language" id="<?php echo $lang->id; ?>"  title="Export to csv">
                                                                <i class="fas fa-download"></i>
                                                                </a>
                                                                <a class="btn btn-primary btn-sm mr-2 import_language" id="<?php echo $lang->id; ?>"  title="Upload csv">
                                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                                </a>
                                                                <a href="<?php echo base_url() . 'languages-module?type=web&language=' . $lang->language_value; ?>" class="btn btn-secondary  bg-info-light mr-2"><?php echo (!empty($admin_settings['lg_admin_web'])) ? ($admin_settings['lg_admin_web']) : 'Web'; ?></a>
                                                                <a href="<?php echo base_url() . 'app-page-list/' . $lang->language_value; ?>" title="App Translation"  class="btn btn-secondary bg-warning-light mr-2"><?php echo (!empty($admin_settings['lg_admin_app'])) ? ($admin_settings['lg_admin_app']) : 'App'; ?></a>

                                                                <a href="<?php echo base_url() . 'languages-module?type=admin&language=' . $lang->language_value; ?>" class="btn btn-secondary btn-sm bg-primary-light mr-2"><?php echo (!empty($admin_settings['lg_admin_admin'])) ? ($admin_settings['lg_admin_admin']) : 'Admin'; ?></a>
                                                                <?php if ($lang->language_value != 'en') { ?>
                                                                <a class="confirm-text p-0 delete_language" data-id="<?php echo $lang->language_value; ?>" href="javascript:void(0);">
                                                                   <i class="fas fa-trash-alt"></i>
                                                                </a>
                                                                <?php } ?>
                                                            </div>
                                                                <div class="modal" id="export_modal_<?php echo $lang->id; ?>" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5>                                                                                
                                                                                <?php echo(!empty($admin_settings['lg_admin_export_language_keywords']))?($admin_settings['lg_admin_export_language_keywords']) : 'Export Language Keywords';  ?>
                                                                            </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>&nbsp;
                                                                                <?php echo(!empty($admin_settings['lg_admin_web_keywords']))?($admin_settings['lg_admin_web_keywords']) : 'Web Keywords';  ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary btn-sm mr-2 col-sm-1 d-inline" href="<?php echo base_url() . 'admin/Language_new/exportlangType/' . $lang->language_value.'/1' ?>" title="Export to csv">
                                                                                <i class="fas fa-download"></i>
                                                                            </a>
                                                                            </p>
                                                                            <p>&nbsp;
                                                                                <?php echo(!empty($admin_settings['lg_admin_admin_keywords']))?($admin_settings['lg_admin_admin_keywords']) : 'Admin Keywords';  ?> &nbsp;&nbsp;<a class="btn btn-primary btn-sm mr-2 col-sm-1 d-inline" href="<?php echo base_url() . 'admin/Language_new/exportlangType/' . $lang->language_value.'/3' ?>" title="Export to csv">
                                                                                <i class="fas fa-download"></i>
                                                                            </a>
                                                                            </p>
                                                                            <p>&nbsp;
                                                                            <?php echo(!empty($admin_settings['lg_admin_app_keywords']))?($admin_settings['lg_admin_app_keywords']) : 'App Keywords';  ?>
                                                                             &nbsp;&nbsp; &nbsp;<a class="btn btn-primary btn-sm mr-2 col-sm-1 d-inline" href="<?php echo base_url() . 'admin/Language_new/exportlangType/' . $lang->language_value.'/2' ?>" title="Export to csv">
                                                                                <i class="fas fa-download"></i>
                                                                            </a>
                                                                            </p>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal" id="import_modal_<?php echo $lang->id; ?>" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5>                                                                                
                                                                                <?php echo(!empty($admin_settings['lg_admin_upload_language_keywords']))?($admin_settings['lg_admin_upload_language_keywords']) : 'Upload Language Keywords';  ?>
                                                                            </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>
                                                                                <b><?php echo(!empty($admin_settings['lg_admin_web_keywords']))?($admin_settings['lg_admin_web_keywords']) : 'Web Keywords';  ?> </b>
                                                                                <form class="d-flex" action="<?php echo base_url() . 'admin/language_new/importlang' ?>" method="post"
                                                                                    enctype="multipart/form-data">
                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                                                        value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                    <input type="file" id="add_language" name="add_language" placeholder="Select file" required
                                                                                        accept=".csv" require>
                                                                                    <input type="hidden" name="lang_code" id="code_value" value="<?php echo $lang->language_value; ?>">
                                                                                    <input type="hidden" name="lang_type" value="1">
                                                                                    <button type="submit" class="btn btn-primary">
                                                                                    <?php echo(!empty($admin_settings['lg_admin_upload']))?($admin_settings['lg_admin_upload']) : 'Upload';  ?>
                                                                                    </button>
                                                                                </form>
                                                                            </p>
                                                                            <br>
                                                                            <p>
                                                                                <b><?php echo(!empty($admin_settings['lg_admin_admin_keywords']))?($admin_settings['lg_admin_admin_keywords']) : 'Admin Keywords';  ?> </b>
                                                                                <form class="d-flex" action="<?php echo base_url() . 'admin/language_new/importlang' ?>" method="post"
                                                                                    enctype="multipart/form-data">

                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                                                        value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                    <input type="file" id="add_language" name="add_language" placeholder="Select file" required
                                                                                        accept=".csv" require>
                                                                                    <input type="hidden" name="lang_code" id="code_value" value="<?php echo $lang->language_value; ?>">
                                                                                    <input type="hidden" name="lang_type" value="3">
                                                                                    <button type="submit" class="btn btn-primary">
                                                                                    <?php echo(!empty($admin_settings['lg_admin_upload']))?($admin_settings['lg_admin_upload']) : 'Upload';  ?>
                                                                                    </button>
                                                                                </form>
                                                                            </p>
                                                                            <p>
                                                                                <b><?php echo(!empty($admin_settings['lg_admin_app_keywords']))?($admin_settings['lg_admin_app_keywords']) : 'App Keywords';  ?> </b>
                                                                                <form class="d-flex" action="<?php echo base_url() . 'admin/language_new/importapplang' ?>" method="post"
                                                                                    enctype="multipart/form-data">

                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                                                        value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                    <input type="file" id="add_app_language" name="add_app_language" placeholder="Select file" required
                                                                                        accept=".csv" require>
                                                                                    <input type="hidden" name="lang_code" id="code_value" value="<?php echo $lang->language_value; ?>">
                                                                                    <input type="hidden" name="lang_type" value="2">
                                                                                    <button type="submit" class="btn btn-primary">
                                                                                    <?php echo(!empty($admin_settings['lg_admin_upload']))?($admin_settings['lg_admin_upload']) : 'Upload';  ?>
                                                                                    </button>
                                                                                </form>
                                                                            </p>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </td>
                                                    </tr>	
                                                    <?php $i++;
									                } ?>
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

<div class="modal" id="importmodal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5>
					<?php echo (!empty($admin_settings['lg_admin_web_language_upload'])) ? ($admin_settings['lg_admin_web_language_upload']) : 'Web Language File Upload'; ?>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url() . 'admin/language_new/importlang' ?>" method="post"
					enctype="multipart/form-data">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
						value="<?php echo $this->security->get_csrf_hash(); ?>" />
					<input type="file" id="add_language" name="add_language" placeholder="Select file" required
						accept=".csv">
					<input type="hidden" name="lang_code" id="code_value">
			</div>
			<div class="modal-footer">
				<button type="submit" id="confirm_delete_sub" data-id="" class="btn btn-primary">
					<?php echo (!empty($admin_settings['lg_admin_confirm'])) ? ($admin_settings['lg_admin_confirm']) : 'Confirm'; ?>
				</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">
					<?php echo (!empty($admin_settings['lg_admin_cancel'])) ? ($admin_settings['lg_admin_cancel']) : 'Cancel'; ?>
				</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="lang_delete_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Delete Confiramtion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Deleting language will also delete its related all datas!!</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="confirm_delete_lang" data-id="" class="btn btn-primary">Confirm</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>