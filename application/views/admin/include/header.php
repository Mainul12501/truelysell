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
				$this->meta_title =  $lang_meta_title['meta_title']??"";
			}
			if($data['key'] == 'meta_description'){
				$this->meta_description =  $lang_meta_title['meta_keyword']??"";
			}
			if($data['key'] == 'meta_keywords'){
				$this->meta_keywords =  $lang_meta_title['meta_desc']??"";
			}
		}
    }
    if(!empty($favicon)) {
		$fav = base_url().'uploads/logo/'.$favicon;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="<?php echo $this->meta_description; ?>">
    <meta name="keywords" content="<?php echo $this->meta_keywords; ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $fav;?>">
    <title><?php echo $this->meta_title;?></title>
    <?php
    $base_url = base_url();
    $page = $this->uri->segment(1); ?>
    
	<?php if($page == 'admin-profile'){ ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/cropper.min.css">
	<?php } ?>

	<?php
	  $page2 = $this->uri->segment(2);
	  $page3 = $this->uri->segment(3);
	  if(($page == 'adminusers' && $page2 == 'edit') || ($page == 'users' && $page2 == 'edit') || ($page == 'providers' && $page2 == 'edit')){ ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/cropper.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/intlTelInput.min.css"> 
	<?php } ?>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables/datatables.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.min.css">
	<?php if($page2 == 'add-service' || $page2 == 'edit-service' || $page == 'edit-blog' || $page == 'add-blog'  || $page == 'add-subcategory' || $page == "add-city" || $page2 == "edit-pages" || $page2 == "home-page" || $page3 == "edit_city" || $page == 'edit-subcategory' || $page == 'add-languages' || $page == "edit-languages") { ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.min.css">
	<?php } ?>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/owlcarousel/owl.carousel.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/owlcarousel/owl.theme.default.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-select.min.css">
	<?php if($page=='add-blog' || $page == 'edit-blog') { ?>
	    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tagsinput.css">
	<?php } ?>
	<?php if ($page == 'service-edit' || $page == "settings" && $page2 == "about-us" || $page2 == "footer-settings" || $page2 == "add-service" || $page == 'settings' && $page2 == 'cookie-policy' ||$page == 'settings' && $page2 == 'help' ||$page == 'settings' && $page2 == 'privacy-policy' || $page == 'settings' && $page2 == 'terms-service') { ?>
	<!-- Ckeditor CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ckeditor.css">
	<?php } ?>
	<?php 
	$ColorList = $this->db->get('theme_color_change')->result_array();

    $Orgcolor = $ColorList[0]['status'];
    $Bluecolor = $ColorList[1]['status'];
    $Redcolor = $ColorList[2]['status'];
    $Greencolor = $ColorList[3]['status'];
    $Defcolor = $ColorList[4]['status']; 

    if (!empty($Orgcolor) && $Orgcolor == 1) { ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin_orange.css">
	<?php } else if(!empty($Bluecolor) && $Bluecolor == 1) { ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin_blue.css">
	<?php } else if(!empty($Redcolor) && $Redcolor == 1) { ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin_red.css">
	<?php } else if(!empty($Greencolor) && $Greencolor == 1) { ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin_green.css">
	<?php } else if(!empty($Defcolor) && $Defcolor == 1) { ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin.css">
	<?php } ?>
</head>

<body>
    <div class="main-wrapper">