<!DOCTYPE html>
<html>
<head>
<?php
    $query = $this->db->query("select * from system_settings WHERE status = 1");
    $result = $query->result_array();
    $this->website_name = '';
    $this->db->where('modules', 'website');
    $user_lang = ($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
    $this->db->where('lang_type', $user_lang);
    $lang_website_check = $this->db->get('cookies')->row_array();
    $this->db->where('modules', 'seo');
    $user_lang = ($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
    $this->db->where('lang_type', $user_lang);
    $lang_meta_title = $this->db->get('seo')->row_array();
    $this->website_logo_front ='assets/img/logo.png';
     $fav=base_url().'assets/img/favicon.png';
	
    if(!empty($result)) {
		foreach($result as $data){
			if($data['key'] == 'website_name'){
				
				$this->website_name =($lang_website_check)?$lang_website_check['cookie_name']:'Truelysell';


			}
			if($data['key'] == 'favicon'){
				$favicon = $data['value'];
			}
			if($data['key'] == 'logo_front'){
				$this->website_logo_front =  $data['value'];
			}
			if($data['key'] == 'meta_title'){
				$this->meta_title =  $lang_meta_title['meta_title'];
			}
			if($data['key'] == 'meta_description'){
				$this->meta_description =  $lang_meta_title['meta_keyword'];
			}
			if($data['key'] == 'meta_keywords'){
				$this->meta_keywords =  $lang_meta_title['meta_desc'];
			}
		}
    }
    if(!empty($favicon)) {
		$fav = base_url().'uploads/logo/'.$favicon;
    }
?>
  <meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="<?php echo $this->meta_description; ?>">
  <meta name="keywords" content="<?php echo $this->meta_keywords; ?>">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo $fav;?>">
  <title><?php echo $this->meta_title;?></title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/all.min.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="page-wrapper">
      <div class="content settings-content">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card table-list-card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <h3><?=$this->website_name?> &nbsp; - Language Print</h3>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Language</th>
                              <th>Code</th> 
                              <th>Total</th>
                              <th>Done</th>         
                              <th>Progress</th>                                            
                            </tr>
                          </thead>
                            <tbody>
                              <?php 
                              $i=1;
                              foreach ($language as $lang) {  
                              $count_done_keywords = count($this->db->get_where('language_keywords_management', array('language'=> $lang['language_value']))->result());
                              $donePercent = ($count_done_keywords/$total_keyword_count)*100; ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $lang['language'] ?></td>
                                    <td><?= $lang['language_value'] ?></td>
                                    <td><?= $total_keyword_count ?></td>
                                    <td><?= $count_done_keywords ?></td>
                                    <td><?= round($donePercent) ?></td>
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
    <script type="text/javascript">
    	window.print();
    </script>
</body>
</html>
