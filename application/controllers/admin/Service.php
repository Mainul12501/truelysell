<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

 public $data;

 public function __construct() {

  parent::__construct();
  $this->load->model('service_model','service');

  $this->load->model('common_model','common_model');
  $this->data['theme'] = 'admin';
  $this->data['model'] = 'service';
  $this->load->model('admin_model','admin');
  $this->load->model('user_login_model','user_login');
  $this->load->model('templates_model');
  $this->load->helper('custom_language');
  $this->load->model('booking_model', 'booking');
  $this->load->model('api_model', 'api');
  $this->load->model('home_model', 'home');
    //Get Language Keywords from content lang file
    $langs = !empty($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
    $lang = $this->db->get_where('language', array('language_value'=>$langs))->row()->language;
    $this->data['language_content'] = $this->lang->load('content', strtolower($lang), true);
    $this->language = $this->lang->load('content', strtolower($lang), true);

  $this->data['base_url'] = base_url();
  $this->session->keep_flashdata('error_message');
  $this->session->keep_flashdata('success_message');
  $this->load->helper('user_timezone_helper');
  $this->data['user_role']=$this->session->userdata('role');
        $this->load->helper('ckeditor');

  $this->data['ckeditor_editor1'] = array(
            //id of the textarea being replaced by CKEditor
            'id' => 'ck_editor_textarea_id',
            // CKEditor path from the folder on the root folder of CodeIgniter
            'path' => 'assets/js/ckeditor',
            // optional settings
            'config' => array(
                'toolbar' => "Full",
                'filebrowserBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html',
                'filebrowserImageBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Images',
                'filebrowserFlashBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Flash',
                'filebrowserUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                'filebrowserImageUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                'filebrowserFlashUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            )
        );
}

public function index()
{
  redirect(base_url('subscriptions'));
}

public function subscriptions()
{
	$this->common_model->checkAdminUserPermission(9);
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'subscriptions';
    $this->data['model'] = 'service';
    $this->data['currency_code'] = settings('currency');
    $this->data['list'] = $this->service->subscription_list();
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }
  else {
    redirect(base_url()."admin");
  }
}

public function delete_subsciption() 
{
    if($this->session->userdata('role') != 1 && settingValue('demo_access') == 0) {
        echo json_encode("failure"); exit;
    } else {
      $inp = $this->input->post();
      $this->db->where('id', $inp['id']);
      $this->db->update('subscription_fee', ['status'=>0]);
      echo json_encode("success");
    }
}

public function add_subscription()
{
	$this->common_model->checkAdminUserPermission(9);
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'add_subscription';
    $this->data['model'] = 'service';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }
  else {
    redirect(base_url()."admin");
  }
}

public function check_subscription_name()
{
  $subscription_name = $this->input->post('subscription_name_28');
  $id = $this->input->post('subscription_id');
  if(!empty($id))
  {
    $this->db->select('*');
    $this->db->where('subscription_name', $subscription_name);
    $this->db->where('id !=', $id);
    $this->db->from('subscription_fee');
    $result = $this->db->get()->num_rows();
  }
  else
  {
    $this->db->select('*');
    $this->db->where('subscription_name', $subscription_name);
    $this->db->from('subscription_fee');
    $result = $this->db->get()->num_rows();
  }
  if ($result > 0) {
    $isAvailable = FALSE;
  } else {
    $isAvailable = TRUE;
  }
  echo json_encode(
    array(
      'valid' => $isAvailable
    ));
}

public function save_subscription()
{
$this->common_model->checkAdminUserPermission(9);
	removeTag($this->input->post());
    $this->common_model->checkAdminLogin();
  $data['subscription_name'] = $this->input->post('subscription_name_28');
  $data['fee'] = $this->input->post('amount');
  $data['currency_code'] = settings('currency');
  if (!empty($this->input->post('duration'))) {
    $data['duration'] = $this->input->post('duration');
  } else {
    $data['duration'] = 0;
  }
  $data['fee_description'] = $data['duration']." months";
  $data['status'] = 1;
  $result = $this->db->insert('subscription_fee', $data);
  $last_id = $this->db->insert_id();
  $this->admin->add_subscription_name($last_id);
  if(!empty($result))
  {
    $message = (!empty($this->data['language_content']['lg_admin_subscription_add'])) ? $this->data['language_content']['lg_admin_subscription_add'] : 'Subscription added successfully. ';
   $this->session->set_flashdata('success_message',$message);
   redirect(base_url()."subscriptions");
 }
 else
 {
  $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something went wrong, Try again';
  $this->session->set_flashdata('error_message',$message);
  redirect(base_url()."subscriptions");
}
}

public function edit_subscription($id)
{
	$this->common_model->checkAdminUserPermission(9);
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'edit_subscription';
    $this->data['model'] = 'service';
    $this->data['subscription'] = $this->service->subscription_details($id);
    $this->data['currency_code'] = settings('currency');
    //Currency Convertion 
    $currency_code_old = $this->data['subscription']['currency_code'];
    $subscription_amount = get_gigs_currency($this->data['subscription']['fee'], $this->data['subscription']['currency_code'], $this->data['currency_code']);
    $this->data['subscription_amt'] = $subscription_amount;

    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }
  else {
   redirect(base_url()."admin");
 }

}

public function update_subscription()
{ 
$this->common_model->checkAdminUserPermission(9);
removeTag($this->input->post());
    $this->common_model->checkAdminLogin();
  $where['id'] = $this->input->post('subscription_id');
  $data['subscription_name'] = $this->input->post('subscription_name_28');
  $data['fee'] = $this->input->post('amount');
  $data['currency_code'] = settings('currency');
  $data['duration'] = $this->input->post('duration');
  $data['fee_description'] = $this->input->post('subscription_description');
  $data['status'] = $this->input->post('status');
  $result = $this->db->update('subscription_fee', $data, $where);
  $this->admin->update_subscription_name($where['id']);
  if(!empty($result))
  {
    $message = (!empty($this->data['language_content']['lg_admin_subscription_update'])) ? $this->data['language_content']['lg_admin_subscription_update'] : 'Subscription updated successfully. ';
   $this->session->set_flashdata('success_message', $message);
   redirect(base_url()."subscriptions");
 }
 else
 {
  $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something went wrong, Try again';
  $this->session->set_flashdata('error_message',$message);
  redirect(base_url()."subscriptions");
}
}

  public function service_providers()
  {
    $this->common_model->checkAdminUserPermission(12);
	
    if($this->input->post('form_submit'))
      {      
        $username = $this->input->post('username');
        $email = $this->input->post('email'); 
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $subcategory=$this->input->post('subcategory');
      $service_location = $this->input->post('service_location');
        $this->data['lists'] = $this->service->provider_filter($username,$email,$from,$to,$subcategory, $service_location);
        
      }
      else
      {
        $lists = $this->data['lists'] = $this->service->provider_list();
    }
    
      $this->data['page'] = 'service_providers';
      $this->data['subcategory']=$this->service->get_subcategory();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
  }

  public function provider_details($value='')
  {
    $this->common_model->checkAdminUserPermission(12);
    $this->data['page'] = 'provider_details';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }

  public function provider_list()
  {
	$user_role=$this->session->userdata('role');
    $this->common_model->checkAdminUserPermission(12);
    extract($_POST);
    if($this->input->post('form_submit'))
    {
      $this->common_model->checkAdminLogin();
      $this->data['page'] = 'service_providers';
      $username = $this->input->post('username');
      $email = $this->input->post('email'); 
      $from = $this->input->post('from');
      $to = $this->input->post('to');
      $subcategory=$this->input->post('subcategory');
      $this->data['lists'] = $this->service->provider_filter($username,$email,$from,$to,$subcategory);
      $this->data['subcategory']=$this->service->get_subcategory();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
    }
    else
    {
      $lists = $this->service->provider_list();
      $data = array();
      $no = $_POST['start'];
      foreach ($lists as $template) {
        if (!empty($template->subscription_name)) {
        $this->db->where('subscription_name', $template->subscription_name);
        $sub_name_check = $this->db->get('subscription_lang')->row_array();
        
        $sub_lang = ($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
        $this->db->where('sub_id', $sub_name_check['sub_id']);
        $this->db->where('lang_type', $sub_lang);
        $sub_name = $this->db->get('subscription_lang')->row_array();
        }
        if (!empty($template->subscription_name)) {
          $subscription_name = $sub_name['subscription_name'];
        } else {
          $subscription_name = '';
        }
        $no++;
        $row    = array();
        $row[]  = $no;
        $profile_img = $template->profile_img;
        if(empty($profile_img)){
          $profile_img = 'assets/img/user.jpg';
        }
        if(!empty($template->country_code)) {
            $mobileNumber = '(+'.$template->country_code.')-'.$template->mobileno;
        } else {
            $mobileNumber = $template->mobileno;
        }
        $user_lang = ($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
        $this->db->where('modules', 'provider');
        if(!empty($template->id)){
        $this->db->where('name_id', $template->id);
        }
        $this->db->where('lang_type', $user_lang);
        $lang_pro = $this->db->get('users_lang')->row();
        $pro_name = (!empty($lang_pro->name))?$lang_pro->name:$template->name;
        $row[]  = '<h2 class="table-avatar"><a href="#" class="avatar avatar-sm mr-2"> <img class="avatar-img rounded-circle" alt="" src="'.$profile_img.'"></a><a href="'.base_url().'provider-details/'.$template->id.'">'.$pro_name.'</a></h2>';
        $row[]  = $template->email;
        $row[]  = $mobileNumber;
        $created_at='-';
        if (isset($template->created_at)) {
          if (!empty($template->created_at) && $template->created_at != "0000-00-00 00:00:00") {
            $date_time = $template->created_at;
            $date_time = utc_date_conversion($date_time);
            $created_at = date(settingValue('date_format'), strtotime($date_time));
          }
        }
        $row[]  = $created_at;
        $row[]  = $subscription_name;
        $val = '';

        if($this->session->userdata('role') == 1) { 
            $display_status = '';
        } else {
            $display_status = 'disabled';
        }
        $status = $template->status;
        $delete_status = $template->status;

        if($status == 2) {
          $val = '';
        }
        elseif($status == 1) {
          $val = 'checked';
        }
        $row[] ='<div class="status-toggle mb-2"><input id="status_'.$template->id.'" class="check change_Status_provider1" data-id="'.$template->id.'" type="checkbox" '.$val.' '.$display_status.'><label for="status_'.$template->id.'" class="checktoggle">checkbox</label></div>';
                
        $base_url=base_url()."providers/edit/".$template->id;
        if ($this->session->userdata('role') == 1) {
          $action = "<a href='".$base_url."'' class='btn btn-sm bg-success-light mr-2'>
        <i class='far fa-edit mr-1'></i> Edit </a>
        <a href='javascript:;'' class='on-default remove-row btn btn-sm bg-danger-light mr-2 delete_provider_data' id='Onremove_'".$template->id."' data-id='".$template->id."'><i class='far fa-trash-alt mr-1'></i> Delete</a>";
        } else {
          $action = "<a href='".$base_url."'' class='btn btn-sm bg-success-light mr-2'>
        <i class='far fa-edit mr-1'></i> Edit </a>";
        }

        $row[] =$action;
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->service->provider_list_all(),
        "recordsFiltered" => $this->service->provider_list_filtered(),
        "data" => $data,
      );
      echo json_encode($output);
    }
  }

public function service_list()
{
  $this->common_model->checkAdminUserPermission(4);
  extract($_POST);
  
  $this->data['page'] = 'service_list';
  $this->data['approval_status'] = $this->db->get_where('system_settings', array('key'=>'auto_approval'))->row();
  if ($this->input->post('form_submit')) {  
    $this->common_model->checkAdminLogin();
    $service_title = $this->input->post('service_title');
    $category = $this->input->post('category');
    $subcategory = $this->input->post('subcategory');
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $this->data['list'] =$this->service->service_filter($service_title,$category,$subcategory,$from,$to);
  }
  else {
    $this->data['list'] = $this->service->service_list();
  }
  
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

public function deleted_service_list()
{
  $this->common_model->checkAdminUserPermission(4);
  extract($_POST);
 
  $this->data['page'] = 'deleted_service_list';
  if ($this->input->post('form_submit')) { 
    $this->common_model->checkAdminLogin();
    $service_title = $this->input->post('service_title');
    $category = $this->input->post('category');
    $subcategory = $this->input->post('subcategory');
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $this->data['list'] =$this->service->delete_service_filter($service_title,$category,$subcategory,$from,$to);
  }
  else {
    $this->data['list'] = $this->service->deleted_service_list();
  }
  $this->load->vars($this->data);
  
  $this->load->view($this->data['theme'].'/template');
}

public function inactive_service_list()
{
  $this->common_model->checkAdminUserPermission(71);
  extract($_POST);
 
  $this->data['page'] = 'inactive_service_list';
  if ($this->input->post('form_submit')) {  
    $this->common_model->checkAdminLogin();
    $service_title = $this->input->post('service_title');
    $category = $this->input->post('category');
    $subcategory = $this->input->post('subcategory');
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $this->data['list'] =$this->service->inactive_service_filter($service_title,$category,$subcategory,$from,$to);
  }
  else {
    $this->data['list'] = $this->service->inactive_service_list();
  }
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

public function service_details($value='')
{
	$this->common_model->checkAdminUserPermission(4);
  $this->data['page'] = 'service_details';
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

public function deleted_service_details($value='')
{
  $this->common_model->checkAdminUserPermission(4);
  $this->data['page'] = 'deleted_service_details';
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}
public function inactive_service_details($value='')
{
  $this->common_model->checkAdminUserPermission(4);
  $this->data['page'] = 'inactive_service_details';
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

public function pending_service_details($value='') {
  $this->common_model->checkAdminUserPermission(69);
  $this->data['page'] = 'pending_service_details';
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

/*change service list */
public function change_Status_service_list1(){
    $this->common_model->checkAdminLogin();
      $id=$this->input->post('id');
      $status=$this->input->post('status');

      if($status==0){
        $avail=$this->service->check_booking_list($id);
        if($avail==0){
          $this->db->where('id',$id);
          if($this->db->update('services',array('status' =>$status, 'admin_verification' =>1))){
            echo "success";
          }else{
            echo "error";
          }
        }else{
          echo "1";
        }
      }else{
        $this->db->where('id',$id);
        if($this->db->update('services',array('status' =>$status, 'admin_verification' =>0))){
          echo "success";
        }else{
          echo "error";
        }
      }
}

/*change service list */
public function change_Status_service_list(){
$this->common_model->checkAdminLogin();
  $id=$this->input->post('id');
  $status=$this->input->post('status');
  $avail=$this->db->get_where('services', array('id'=>$id))->row();
    if($avail->admin_verification==0){
      $this->db->where('id',$id);
      if($this->db->update('services',array('status' =>1, 'admin_verification' =>1))){
        $status="success";
      }else{
        $status="error";
      }
  }else{
    $this->db->where('id',$id);
    if($this->db->update('services',array('status' =>2, 'admin_verification' =>0))){
      $status="success";
    }else{
      $status="error";
    }
  }
  echo $status;
  $status_mail=$this->db->select('*')->
                      from('providers')->
                      where('id',$avail->user_id)->
                      get()->row_array();

  $bodyid = 6;
  $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
  $body = $tempbody_details['template_content'];
  $body = str_replace('{user_name}', $status_mail['name'], $body);
  $preview_link = base_url();
  $body = str_replace('{service_name}',$avail->service_title, $body);
      
  $phpmail_config=settingValue('mail_config');
  if(isset($phpmail_config)&&!empty($phpmail_config)){
    if ($phpmail_config=="phpmail") {
      $from_email=settingValue('email_address');
    }
    if ($phpmail_config == "smtp") {
      $from_email=settingValue('smtp_email_address');
    }
    if ($phpmail_config == "sendgrid") {
      $from_email = settingValue('sendgrid_email');
      $to_email = $status_mail['email'];
      $subject = "Admin Approval";
      $message = $body;
      $this->load->library('sendemail');
      $send_mail = $this->sendemail->sendgrid_email($from_email,$to_email,$subject,$message);
    } else {
        $this->load->library('email');
        if(!empty($from_email)){
          $mail = $this->email
          ->from($from_email)
          ->to($status_mail['email'])
          ->subject('Admin Approval')
          ->message($body)
          ->send();
      }
    }
  }
  

}
public function change_Status()
{
  $id=$this->input->post('id');
  $status=$this->input->post('status');

  $this->db->where('id',$id);
  $this->db->update('providers',array('status' =>$status));
}
public function delete_provider()
{
  $id=$this->input->post('id');
  $data=array('status'=>2 , 'delete_status'=>1);
  $this->db->where('id',$id);
  
  if($this->db->update('providers',$data))
  {
    echo 1;
  }
}
public function service_requests()
{
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'service_requests';
    $this->data['model'] = 'service';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');		
  }
  else {
   redirect(base_url()."admin");
 }
}

public function request_list()
{
 $lists = $this->service->request_list();
 $data = array();
 $no = $_POST['start'];
 foreach ($lists as $template) {
   $no++;
   $row    = array();
   $row[]  = $no;
   $profile_img = $template['profile_img'];
   if(empty($profile_img)){
    $profile_img = 'assets/img/user.jpg';
  }
  $row[]  = '<a href="#" class="avatar"> <img alt="" src="'.$profile_img.'"></a><h2><a href="#">'.$template['username'].'</a></h2>';
  $row[]  = $template['contact_number'];
  $row[]  = $template['title'];
  $row[]  = '<p class="price-sup"><sup>RM</sup>'.$template['proposed_fee'].'</p>';
  $row[]  = '<span class="service-date">'.date("d M Y", strtotime($template['request_date'])).'<span class="service-time">'.date("H.i A", strtotime($template['request_time'])).'</span></span>';
  $row[]  = date("d M Y", strtotime($template['created']));
  $val = '';
  $status = $template['status'];
  if($status == -1)
  {
    $val = '<span class="label label-danger-border">Expired</span>';
  }
  if($status == 0)
  {
    $val = '<span class="label label-warning-border">Pending</span>';
  }
  elseif($status == 1)
  {
    $val = '<span class="label label-info-border">Accepted</span>';
  }
  elseif($status == 2)
  {
    $val = '<span class="label label-success-border">Completed</span>';
  }
  elseif($status == 3)
  {
    $val = '<span class="label label-danger-border">Declined</span>';
  }
  elseif($status == 4)
  {
    $val = '<span class="label label-danger-border">Deleted</span>';
  }
  $row[]  = $val;
  $data[] = $row;
}

$output = array(
  "draw" => $_POST['draw'],
  "recordsTotal" => $this->service->request_list_all(),
  "recordsFiltered" => $this->service->request_list_filtered(),
  "data" => $data,
);

        //output to json format
echo json_encode($output);

}

  public function delete_service()
  {
    $id=$this->input->post('service_id');
    //start check num_rows();
    $this->db->where('status in (1,2,3,9)');
    $this->db->where('service_id', $id);
    $service_status=$this->db->from('book_service')->count_all_results();
    //end check
    if($service_status==0){
        $inputs['status']= '0';
        $WHERE =array('id' => $id);
        $result=$this->service->update_service($inputs,$WHERE);
        if($result) {
          $message = (!empty($this->data['language_content']['lg_admin_service_delete'])) ? $this->data['language_content']['lg_admin_service_delete'] : 'Service deleted successfully. ';
          $this->session->set_flashdata('success_message', $message);    
         echo 1;exit; 
        }
        else {
          $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something went wrong, Try again';
          $this->session->set_flashdata('error_message',$message);
          echo 0;exit;
        } 
    }else{
      $message = (!empty($this->data['language_content']['lg_admin_service_status'])) ? $this->data['language_content']['lg_admin_service_status'] : 'Service not completed. ';
      $this->session->set_flashdata('error_message','Service not completed');
      echo 2;exit;
    }
  }

  //Added New
  public function edit_providers($id=NULL)
  {
    $this->common_model->checkAdminUserPermission(12);
    $this->data['countrycode']= $this->admin->get_country_code_config();
    $this->data['category']=$this->service->get_category();
    $this->data['subcategory']=$this->service->get_subcategory();
    if(!empty($id)){
      $this->data['id']=$id;
      $this->data['user']=$this->service->edit_provider_data($id);
      $this->data['title']="Edit Provider";
    }else{
      $this->data['id']=0;
      $this->data['user']=array();
      $this->data['title']="Add Provider";
    }
    $this->data['page']="edit_provider";
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');  
  }

  public function fetch_subcategorys() {    
    $this->db->where('status', 1);
    $this->db->where('category', $_POST['id']);
    $query = $this->db->get('subcategories');
    $result = $query->result();
    $data = array();
    $json = array();
    if (!empty($result)) {
        foreach ($result as $r) {
            $data['value'] = $r->id;
            $data['label'] = $r->subcategory_name;
            $json[] = $data;
        }
    } 
    echo json_encode($json);
  }

  public function check_provider_name()
  {
    $name = $this->input->post('name');
    $id = $this->input->post('id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('name', $name);
      $this->db->where('id !=', $id);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('name', $name);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    if ($result > 0) {
      $isAvailable = FALSE;
    } else {
      $isAvailable = TRUE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
      ));
  }

  public function check_provider_mobile()
  {
    $mobileno = $this->input->post('mobileno');
    $country_code = $this->input->post('country_code');
    $id = $this->input->post('id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('country_code', $country_code);
      $this->db->where('mobileno', $mobileno);
      $this->db->where('id !=', $id);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('country_code', $country_code);
      $this->db->where('mobileno', $mobileno);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    if ($result > 0) {
      $isAvailable = FALSE;
    } else {
      $isAvailable = TRUE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
      ));
  }

  public function check_provider_email()
  {
    $email = $this->input->post('email');
    $id = $this->input->post('id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('email', $email);
      $this->db->where('id !=', $id);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('email', $email);
      $this->db->from('providers');
      $result = $this->db->get()->num_rows();
    }
    if ($result > 0) {
      $isAvailable = FALSE;
    } else {
      $isAvailable = TRUE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
      ));
  }

  public function update_provider()
  {
    $this->common_model->checkAdminUserPermission(12);
    if($this->session->userdata('role') != 1 && settingValue('demo_access') == 0) {
        echo json_encode(['status'=>false,'msg'=>"Unable to access this feature in Demo mode"]);
    } else {
        $params=$this->input->post();
        $user_id='';
        $uploaded_file_name = '';

        $profile_image = $this->input->post('profile_img');
        if (!file_exists($profile_image)) { 
          $params['profile_img'] = $profile_image;
        }else{
          unset($params['profile_img']);
        }
        if (!file_exists($profile_image)) { 
          $profile_image1 = $params['profile_img'];
        }else{
          $profile_image1 = '';
        }
        $table_data = array(
                  'name' => $params['name_28'],
                  'country_code' => $params['country_code'],
                  'mobileno' => $params['mobileno'],
                  'email' => $params['email'],
                  'profile_img' => $profile_image1,
                  'status' => $params['status']
              );
        if(!empty($params['id'])){
          $user_id=$params['id'];
          $params['updated_at'] = date('Y-m-d H:i:s'); 
          $result=$this->db->where('id',$user_id)->update('providers',$table_data);
          $this->admin->add_provider_name($user_id);
        }else{
          $table_data1 = array(
            'name' => $params['name_28'],
            'country_code' => $params['country_code'],
            'mobileno' => $params['mobileno'],
            'email' => $params['email'],
            'profile_img' => $profile_image1,
            'status' => $params['status'],
            'currency_code' => settings('currency'),
            'otp' => '1234',
            'share_code' => $this->service->ShareCode(6,$params['name_28']),
            'created_at' => date('Y-m-d H:i:s'),
            'is_agree' => '1'
          );

          $params['currency_code'] = settings('currency');  
          $params['otp'] = '1234';  
          $params['share_code'] = $this->service->ShareCode(6,$params['name_28']);
          $params['created_at'] = date('Y-m-d H:i:s');
          $params['is_agree'] = 1;
          $result=$this->db->insert('providers',$table_data1);
          $user_id = $this->db->insert_id();
          $token = $this->service->getToken(14,$user_id);
          $this->db->where('id', $user_id);
          $this->db->update('providers', array('token'=>$token));
          $this->admin->add_provider_name($user_id);
           if(settingValue('chat_showhide') == 1 && settingValue('chat_text')) {
            $chat_text = settingValue('chat_text');
          } else {
            $chat_text = 'Hi! Welcome to '.settingValue('website_name');
          }
          //insert chat
          $chat_arr = ['sender_token'=>'0dreamsadmin', 'receiver_token'=>$token, 'message'=>$chat_text, 'status'=>'1', 'read_status'=>'0', 'utc_date_time'=>date('Y-m-d H:i:s')];
          $this->db->insert('chat_table', $chat_arr);
          //insert wallet
          $data = array("token" => $token, 'currency_code' => settings('currency'), "user_provider_id" => $user_id, "type" => 1, "wallet_amt" => 0, "created_at" => date('Y-m-d H:i:s'));
          $wallet_result = $this->db->insert('wallet_table', $data);
        }
        
        if($result==true){
          if(empty($user_id)){
            echo json_encode(['status'=>true,'msg'=>"Provider Details Added Successfully..."]);
          }else{
            echo json_encode(['status'=>true,'msg'=>"Provider Details Updated Successfully..."]);
          }
        }else{
          echo json_encode(['status'=>false,'msg'=>"Someting Went wrong in server end..."]);
        }
    }
  }

  public function delete_provider_data()
  {
    $adminId = $this->session->userdata('admin_id');
    if ($adminId > 1) {
      echo json_encode(['status'=>false,'msg'=>"Permission Denied.!!"]);
    }else{
      $id = $this->input->post('user_id');
      if (!empty($id)) {
        $data=array('status'=>2 , 'delete_status'=>1);
        $this->db->where('id',$id);
        if($this->db->update('providers',$data)) {
          echo json_encode(['status'=>true,'msg'=>"Providers Details Deleted Successfully."]);
        }else {
          echo json_encode(['status'=>false,'msg'=>"Someting went wrong on server end.."]);
        }
      }else {
        echo json_encode(['status'=>false,'msg'=>"Someting went wrong, Please try again !!"]);
      }
    }
  }

public function changeAutoApprovalStatus() {

    $this->common_model->checkAdminLogin();
        $status=$this->input->post('status');
        //Get not approved service id's
        $serviceId = $this->db->select('GROUP_CONCAT(id) as id')->get_where('services', array('status'=>2))->row();

        $autoApproval = $this->db->where('key', 'auto_approval')->get('system_settings')->row();
            $data = array(
                'key'=>'auto_approval', 
                'value'=>$status, 
                'system'=>'1', 
                'groups'=>'config', 
                'status'=>1, 
                'update_date'=>date('Y-m-d')
            );
        if(!$autoApproval) {
            $this->db->insert('system_settings', $data);
        } else {
            $this->db->where('key','auto_approval');
            $this->db->update('system_settings',array('value' =>$status));
        }
        if($this->db->affected_rows() > 0) {
            echo '1';    
        } else {
            echo '0';  
        }
}

  public function add_service() {
    $this->common_model->checkAdminUserPermission(4);
    $this->data['country']=$this->db->select('id,country_name')->from('country_table')->order_by('country_name','asc')->get()->result_array();
    $this->data['city']=$this->db->select('id,name')->from('city')->get()->result_array();
    $this->data['state']=$this->db->select('id,name')->from('state')->get()->result_array();
    $this->data['page'] = 'add_service';
    $this->data['provider_list'] = $this->admin->provider_list();
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }

  public function add_service_ajax() {
    $inputs = array();
    $description = $this->input->post('about');
    removeTag($this->input->post());
    $this->common_model->checkAdminLogin();
        $config["upload_path"] = './uploads/services/';
        $config["allowed_types"] = '*';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $service_image = array();
        $service_details_image = array();
        $thumb_image = array();
        $mobile_image = array();
        
       
        if ($_FILES["images"]["name"] != '') {
            if(!is_dir('uploads/blogs')) {
                mkdir('./uploads/services/', 0777, TRUE);
            }
            for ($count = 0; $count < count($_FILES["images"]["name"]); $count++) {
                $_FILES["file"]["name"] = 'full_' . time() . $_FILES["images"]["name"][$count];
                $_FILES["file"]["type"] = $_FILES["images"]["type"][$count];
                $_FILES["file"]["tmp_name"] = $_FILES["images"]["tmp_name"][$count];
                $_FILES["file"]["error"] = $_FILES["images"]["error"][$count];
                $_FILES["file"]["size"] = $_FILES["images"]["size"][$count];
                if ($this->upload->do_upload('file')) {
                    $data = $this->upload->data();
                    $image_url = 'uploads/services/' . $data["file_name"];
                    $upload_url = 'uploads/services/';
                    $service_image[] = $this->image_resize($image_url, 'se_' . $data["file_name"], $upload_url,360, 220);
                    $service_details_image[] = $this->image_resize( $image_url, 'de_' . $data["file_name"], $upload_url, 820, 440);
                    $thumb_image[] = $this->image_resize( $image_url, 'th_' . $data["file_name"], $upload_url,60, 60);
                    $mobile_image[] = $this->image_resize( $image_url, 'mo_' . $data["file_name"], $upload_url,280, 160);
                }
            }
        } else {
            for ($count = 0; $count < count($_FILES["images2"]["name"]); $count++) {
              $_FILES["file"]["name"] = 'full_' . time() . $_FILES["images2"]["name"][$count];
              $_FILES["file"]["type"] = $_FILES["images2"]["type"][$count];
              $_FILES["file"]["tmp_name"] = $_FILES["images2"]["tmp_name"][$count];
              $_FILES["file"]["error"] = $_FILES["images2"]["error"][$count];
              $_FILES["file"]["size"] = $_FILES["images2"]["size"][$count];
              if ($this->upload->do_upload('file')) {
                  $data = $this->upload->data();
                  $image_url = 'uploads/services/' . $data["file_name"];
                  $upload_url = 'uploads/services/';
                  $service_image[] = $this->image_resize($image_url, 'se_' . $data["file_name"], $upload_url,360, 220);
                  $service_details_image[] = $this->image_resize($image_url, 'de_' . $data["file_name"], $upload_url,820, 440);
                  $thumb_image[] = $this->image_resize( $image_url, 'th_' . $data["file_name"], $upload_url, 60, 60);
                  $mobile_image[] = $this->image_resize($image_url, 'mo_' . $data["file_name"], $upload_url, 280, 160);
                }
            }
        }
        $approveStatus = settingValue('auto_approval');
        if($approveStatus == 1) {
            $status = 1;
            $approve_status = 1;
        } else {
            $status = 2;
            $approve_status = 0;
        }

        $country_exp = $this->db->select('id, country_name')->get_where('country_table', array('id'=>$this->input->post('country_id')))->row_array();
        $country_name = explode ("(", $country_exp['country_name']);
        $country_name = !empty($country_name[0]) ? $country_name[0] : '';

        $state_name = $this->db->select('id, name')->get_where('state', array('id'=>$this->input->post('state_id')))->row_array();
        $city_name = $this->db->select('id, name')->get_where('city', array('id'=>$this->input->post('city_id')))->row_array();
        
        $service_offered = json_encode($this->input->post('service_offered'));
        $location = $country_name.','.$state_name['name'].','.$city_name['name'];
        $inputs['user_id'] = $_POST['username'];
        $service_count = $this->db->where('service_title', $this->input->post('service_title_28'))->where('id !=',$inputs['user_id'])->count_all_results('services');
        if($service_count > 0){
          $message = (!empty($this->data['language_content']['lg_admin_service_title_exists'])) ? $this->data['language_content']['lg_admin_service_title_exists'] : 'Service Title Already Exist. ';
          $this->session->set_flashdata('error_message', $message);
          redirect(base_url() . "service-list");
        }else{
          $inputs['service_title'] = $this->input->post('service_title_28');
        }
        $inputs['currency_code'] = $this->input->post('currency_code');;
        $inputs['service_sub_title'] = $this->input->post('service_sub_title');
        $inputs['category'] = $this->input->post('category');
        $inputs['subcategory'] = $this->input->post('subcategory');
        $inputs['service_location'] = ($this->input->post('service_location'))?$this->input->post('service_location'):$location;
        $inputs['service_latitude'] = ($this->input->post('service_latitude'))?$this->input->post('service_latitude'):'';
        $inputs['service_longitude'] = ($this->input->post('service_longitude'))?$this->input->post('service_longitude'):'';
        $inputs['service_amount'] = $this->input->post('service_amount');
        $inputs['about'] = $description;
        $inputs['service_image'] = implode(',', $service_image);
        $inputs['service_details_image'] = implode(',', $service_details_image);
        $inputs['thumb_image'] = implode(',', $thumb_image);
        $inputs['mobile_image'] = implode(',', $mobile_image);
        $inputs['created_at'] = date('Y-m-d H:i:s');
        $inputs['updated_at'] = date('Y-m-d H:i:s');
        $inputs['status'] = $status;
        $inputs['admin_verification'] = $approve_status;
        $inputs['service_offered'] = $service_offered;
        $inputs['created_by'] = 'admin';
        $inputs['service_country'] = ($country_exp['id'])?$country_exp['id']:'';
        $inputs['service_state'] = ($state_name['id'])?$state_name['id']:'';
        $inputs['service_city'] = ($city_name['id'])?$city_name['id']:'';

        $RemoveSpecialChar = $this->RemoveSpecialChar($inputs['service_title']);
        $output = preg_replace ('/[^\p{L}\p{N}]/u', ' ', $RemoveSpecialChar);
        $service_url = str_replace(" ","-",trim($output));
        $inputs['url'] = strtolower($service_url);
       
        $result = $this->service->create_service($inputs);
        $this->service->add_service_name($result);

        // if (count($_POST['service_offered']) > 0) {
          if (is_countable($_POST['service_offered']) && count($_POST['service_offered']) > 0) {
            $service_data = array(
                    'service_id' => $result,
                    'service_offered' => $service_offered);

            $this->db->insert('service_offered', $service_data);
        }
        
        if (isset($_POST['addi_servicename']) && is_countable($_POST['addi_servicename']) && count($_POST['addi_servicename']) > 0) {
          $post = $this->input->post();
        
          foreach ($post['addi_servicename'] as $key => $value) {               
            $addi_service_data = array(
                        'service_id' => $result,
                        'provider_id' =>  $_POST['username'],
                        'service_name' => $post['addi_servicename'][$key],
                        'amount' => $post['addi_serviceamnt'][$key],
                        'duration' => $post['addi_servicedura'][$key],
                        'created_at' => date('Y-m-d H:i:s')
            );
           
            $this->db->insert('additional_services', $addi_service_data);
          }
        }
        $temp = count($service_image); //counting number of row's
        $service_image = $service_image;
        $service_details_image = $service_details_image;
        $thumb_image = $thumb_image;
        $mobile_image = $mobile_image;
        $service_id = $result;

        for ($i = 0; $i < $temp; $i++) {
            $image = array(
                'service_id' => $service_id,
                'service_image' => $service_image[$i],
                'service_details_image' => $service_details_image[$i],
                'thumb_image' => $thumb_image[$i],
                'mobile_image' => $mobile_image[$i]
            );
            $serviceimage = $this->service->insert_serviceimage($image);
        }

        if ($serviceimage == true) {
            if($approveStatus == 1) {
              $message = (!empty($this->data['language_content']['lg_admin_add_service_success'])) ? $this->data['language_content']['lg_admin_add_service_success'] : 'Service created successfully. ';
                $this->session->set_flashdata('success_message', $message);
            } else {
              $message = (!empty($this->data['language_content']['lg_admin_service_approval'])) ? $this->data['language_content']['lg_admin_service_approval'] : 'Service created successfully and is waiting for admin approval. ';
                $this->session->set_flashdata('success_message', $message);
            }
            redirect(base_url() . "service-list");
        } else {
          $message = (!empty($this->data['language_content']['lg_admin_add_service_error'])) ? $this->data['language_content']['lg_admin_add_service_error'] : 'Service created faileds. ';
            $this->session->set_flashdata('error_message', $message);
            redirect(base_url() . "service-list");
        }
  }

  public function service_edit($id)
  {
   
    $this->data['country']=$this->db->select('id,country_name')->from('country_table')->order_by('country_name','asc')->get()->result_array();
    $this->data['city']=$this->db->select('id,name')->from('city')->get()->result_array();
    $this->data['state']=$this->db->select('id,name')->from('state')->get()->result_array();
    $this->data['provider_list'] = $this->admin->provider_list();
    $this->data['services'] = $this->admin->edit_service_list($id);
    $this->data['serv_offered'] = $this->db->from('service_offered')->where('service_id', $id)->get()->result_array();
    $this->common_model->checkAdminUserPermission(4);
    $this->data['page'] = 'edit_service';   
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }

  public function update_service() {
   
    $this->common_model->checkAdminLogin();
   

    $description = $this->input->post('about');
        removeTag($this->input->post());
        $service_offered = json_encode($this->input->post('service_offered'));
        $inputs = array();

       $config["upload_path"] = './uploads/services/';
    $config["allowed_types"] = '*';
    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    $service_image = array();
    $service_details_image = array();
    $thumb_image = array();
    $mobile_image = array();
    
    if ($_FILES["images"]["name"] != '') {
        if(!is_dir('uploads/blogs')) {
            mkdir('./uploads/services/', 0777, TRUE);
        }
        for ($count = 0; $count < count($_FILES["images"]["name"]); $count++) {
            $_FILES["file"]["name"] = 'full_' . time() . $_FILES["images"]["name"][$count];
            $_FILES["file"]["type"] = $_FILES["images"]["type"][$count];
            $_FILES["file"]["tmp_name"] = $_FILES["images"]["tmp_name"][$count];
            $_FILES["file"]["error"] = $_FILES["images"]["error"][$count];
            $_FILES["file"]["size"] = $_FILES["images"]["size"][$count];
            if ($this->upload->do_upload('file')) {
                $data = $this->upload->data();
                $image_url = 'uploads/services/' . $data["file_name"];
                $upload_url = 'uploads/services/';
                $service_image[] = $this->image_resize( $image_url, 'se_' . $data["file_name"], $upload_url,360, 220);
                $service_details_image[] = $this->image_resize( $image_url, 'de_' . $data["file_name"], $upload_url,820, 440);
                $thumb_image[] = $this->image_resize( $image_url, 'th_' . $data["file_name"], $upload_url,60, 60);
                $mobile_image[] = $this->image_resize($image_url, 'mo_' . $data["file_name"], $upload_url,280, 160);
            }
        }
    } else {
        for ($count = 0; $count < count($_FILES["images2"]["name"]); $count++) {
          $_FILES["file"]["name"] = 'full_' . time() . $_FILES["images2"]["name"][$count];
          $_FILES["file"]["type"] = $_FILES["images2"]["type"][$count];
          $_FILES["file"]["tmp_name"] = $_FILES["images2"]["tmp_name"][$count];
          $_FILES["file"]["error"] = $_FILES["images2"]["error"][$count];
          $_FILES["file"]["size"] = $_FILES["images2"]["size"][$count];
          if ($this->upload->do_upload('file')) {
              $data = $this->upload->data();
              $image_url = 'uploads/services/' . $data["file_name"];
              $upload_url = 'uploads/services/';
              $service_image[] = $this->image_resize($image_url, 'se_' . $data["file_name"], $upload_url,360, 220);
              $service_details_image[] = $this->image_resize( $image_url, 'de_' . $data["file_name"], $upload_url,820, 440);
              $thumb_image[] = $this->image_resize( $image_url, 'th_' . $data["file_name"], $upload_url,60, 60);
              $mobile_image[] = $this->image_resize( $image_url, 'mo_' . $data["file_name"], $upload_url,280, 160);
            }
        }
    }
        $country_exp = $this->db->select('id, country_name')->get_where('country_table', array('id'=>$this->input->post('country_id')))->row_array();
        $country_name = explode ("(", $country_exp['country_name']);
        $country_name = !empty($country_name[0]) ? $country_name[0] : '';

        $state_name = $this->db->select('id, name')->get_where('state', array('id'=>$this->input->post('state_id')))->row_array();
        $city_name = $this->db->select('id, name')->get_where('city', array('id'=>$this->input->post('city_id')))->row_array();

        $location = $country_name.','.$state_name['name'].','.$city_name['name'];
        $inputs['user_id'] = $_POST['username'];
        $inputs['service_image'] = implode(',', $service_image);
        $inputs['service_details_image'] = implode(',', $service_details_image);
        $inputs['thumb_image'] = implode(',', $thumb_image);
        $inputs['mobile_image'] = implode(',', $mobile_image);

        $inputs['service_title'] = $this->input->post('service_title_28');
        $inputs['service_sub_title'] = $this->input->post('service_sub_title');
        $inputs['category'] = $this->input->post('category');
        $inputs['subcategory'] = $this->input->post('subcategory');
        $inputs['service_location'] = ($this->input->post('service_location'))?$this->input->post('service_location'):$location;
        $inputs['service_latitude'] = ($this->input->post('service_latitude'))?$this->input->post('service_latitude'):'';
        $inputs['service_longitude'] = ($this->input->post('service_longitude'))?$this->input->post('service_longitude'):'';
        $inputs['service_amount'] = $this->input->post('service_amount');

        $inputs['about'] = $description;
        $inputs['service_offered'] = $service_offered;
        $inputs['currency_code'] = $this->input->post('currency_code');
        $inputs['service_country'] = ($country_exp['id'])?$country_exp['id']:'';
        $inputs['service_state'] = ($state_name['id'])?$state_name['id']:'';
        $inputs['service_city'] = ($city_name['id'])?$city_name['id']:'';

        $service_count = $this->db->where('service_title', $this->input->post('service_title_28'))->where('id !=',$_POST['service_id'])->count_all_results('services');
        if($service_count > 0){
          $message = (!empty($this->data['language_content']['lg_admin_service_title_exists'])) ? $this->data['language_content']['lg_admin_service_title_exists'] : 'Service Title Already Exist. ';
          $this->session->set_flashdata('error_message', $message);
          redirect(base_url() . "service-list");
        }else{
          $inputs['service_title'] = $this->input->post('service_title_28');
        }

        $inputs['updated_at'] = date('Y-m-d H:i:s');
        $RemoveSpecialChar = $this->RemoveSpecialChar($this->input->post('service_title_28'));
        $output = preg_replace ('/[^\p{L}\p{N}]/u', ' ', $RemoveSpecialChar);
        $service_url = str_replace(" ","-",trim($output));
        $inputs['url'] = strtolower($service_url);
        $service_image = implode(',', $service_image);
        $service_details_image = implode(',', $service_details_image);
        $thumb_image = implode(',', $thumb_image);
        $mobile_image = implode(',', $mobile_image);
        $input_data = array(
            'user_id' => $_POST['username'],
            'service_image' => $service_image,
            'service_details_image' => $service_details_image,
            'thumb_image' => $thumb_image,
            'mobile_image' => $mobile_image,
            'service_title' => $this->input->post('service_title_28'),
            'service_sub_title' => $this->input->post('service_sub_title'),
            'currency_code' => $this->input->post('currency_code'),
            'category' => $this->input->post('category'),
            'subcategory' => $this->input->post('subcategory'),
            'service_location' => $this->input->post('service_location'),
            'service_latitude' => $this->input->post('service_latitude'),
            'service_longitude' => $this->input->post('service_longitude'),
            'service_amount' => $this->input->post('service_amount'),
            'service_offered' => $service_offered,
            'about' => $description,
            'updated_at' => date('Y-m-d H:i:s'),
            'created_by' => 'admin',            
        );
        $where = array('id' => $_POST['service_id']);
        $id = $this->input->post('service_id'); 
        $this->db->set($inputs);
        $this->db->where($where);
        $result = $this->db->update('services');
        $this->service->update_service_name($id);

        if (!empty($_POST['service_offered']) && count($_POST['service_offered']) > 0) {
            $get_service = $this->db->where(array('service_id' => $_POST['service_id']))->count_all_results('service_offered');
            if($get_service > 0) {
                $offered_data = array('service_offered'=>$service_offered); 
                $this->db->set($offered_data);
                $this->db->where(array('service_id' => $_POST['service_id']));
                $this->db->update('service_offered');
            } else {
                $offered_data = array('service_offered'=>$service_offered, 'service_id' => $_POST['service_id']);
                $this->db->insert('service_offered', $offered_data);
            }
        }else{
            $this->db->where('service_id', $this->input->post('service_id'))->delete('service_offered');
        }
        
         //additional service
        if(isset($_POST['addi_servicename'])) {
          if (is_countable($_POST['addi_servicename']) && count($_POST['addi_servicename']) > 0) {
         
            $this->db->where('service_id', $this->input->post('service_id'))->delete('additional_services');
            $post = $this->input->post();
            foreach ($post['addi_servicename'] as $key => $value) {               
              $addi_service_data = array(
                'service_id' => $this->input->post('service_id'),
                'provider_id' => $_POST['username'],
                'service_name' => $post['addi_servicename'][$key],
                'amount' => $post['addi_serviceamnt'][$key],
                'duration' => $post['addi_servicedura'][$key],
                'created_at' => date('Y-m-d H:i:s')
              );
              $this->db->insert('additional_services', $addi_service_data);
              $inserid = $this->db->insert_id();
              if($post['addiserid'][$key] > 0){
                $idupdate['id'] = $post['addiserid'][$key];
                $idupdate['updated_at'] = date('Y-m-d H:i:s');
                $this->db->where('id', $inserid);
                $this->db->update('additional_services', $idupdate);
              } 
            }
          }
        } else {
          $this->db->where('service_id', $this->input->post('service_id'))->delete('additional_services');
        }
        //additional service end
        if (!empty($service_image)) {
            $temp = count(explode(',', $service_image));
            $service_image = explode(',', $service_image);
            $service_details_image = explode(',', $service_details_image);
            $thumb_image = explode(',', $thumb_image);
            $mobile_image = explode(',', $mobile_image);
            $service_id = $this->input->post('service_id');



            for ($i = 0; $i < $temp; $i++) {
                $image = array(
                    'service_id' => $service_id,
                    'service_image' => $service_image[$i],
                    'service_details_image' => $service_details_image[$i],
                    'thumb_image' => $thumb_image[$i],
                    'mobile_image' => $mobile_image[$i]
                );
                $serviceimage = $this->service->insert_serviceimage($image);
            }
        }
        if ($result) {
          $message = (!empty($this->data['language_content']['lg_admin_update_service_success'])) ? $this->data['language_content']['lg_admin_update_service_success'] : 'Service Updated successfully. ';
            $this->session->set_flashdata('success_message', $message);
            redirect(base_url() . "service-list");
        } else {
          $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something went wrong, Try again';
            $this->session->set_flashdata('error_message', $message);
            redirect(base_url() . "service-list");
        }
  }

  public function refund_request_list()
  {
    $this->common_model->checkAdminUserPermission(4);
    extract($_POST);
   
    $this->data['page'] = 'refund_request';
    $this->data['list'] = $this->service->refund_request_list();
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }

  public function get_category() {
      $this->db->where('status', 1);
      $query = $this->db->get('categories');
      $result = $query->result();
      $data = array();
      $json = array();
      foreach ($result as $r) {
          $data['value'] = $r->id;
          $data['label'] = $r->category_name;
          $json[] = $data;
      }
      echo json_encode($json);
  }

  public function get_subcategory() {
   
    $this->db->where('status', 1);
    $this->db->where('category', $_POST['id']);
    $query = $this->db->get('subcategories');
    $result = $query->result();
    $data = array();
    $json = array();
    if (!empty($result)) {
        foreach ($result as $r) {
            $data['value'] = $r->id;
            $data['label'] = $r->subcategory_name;
            $json[] = $data;
        }
    } 
    echo json_encode($json);
  }

  public function image_resize( $image_url, $filename, $upload_url,$width = 0, $height = 0) {
        $source_path = $image_url;
        list($source_width, $source_height, $source_type) = getimagesize($source_path);
        switch ($source_type) {
            case IMAGETYPE_GIF:
                $source_gdim = imagecreatefromgif($source_path);
                break;
            case IMAGETYPE_JPEG:
                $source_gdim = imagecreatefromjpeg($source_path);
                break;
            case IMAGETYPE_PNG:
                $source_gdim = imagecreatefrompng($source_path);
                break;
        }

        $source_aspect_ratio = $source_width / $source_height;
        $desired_aspect_ratio = $width / $height;

        if ($source_aspect_ratio > $desired_aspect_ratio) {
            /*
             * Triggered when source image is wider
             */
            $temp_height = $height;
            $temp_width = (int) ($height * $source_aspect_ratio);
        } else {
            /*
             * Triggered otherwise (i.e. source image is similar or taller)
             */
            $temp_width = $width;
            $temp_height = (int) ($width / $source_aspect_ratio);
        }

        /*
         * Resize the image into a temporary GD image
         */

        $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
        imagecopyresampled(
                $temp_gdim, $source_gdim, 0, 0, 0, 0, $temp_width, $temp_height, $source_width, $source_height
        );

        /*
         * Copy cropped region from temporary image into the desired GD image
         */

        $x0 = intval (($temp_width - $width) / 2);
        $y0 = intval (($temp_height - $height) / 2);
        $desired_gdim = imagecreatetruecolor($width, $height);
        imagecopy($desired_gdim, $temp_gdim, 0, 0, $x0, $y0, $width, $height);

        /*
         * Render the image
         * Alternatively, you can save the image in file-system or database
         */

        $image_url = $upload_url . $filename;

        imagepng($desired_gdim, $image_url);

        return $image_url;

        /*
         * Add clean-up code here
         */
    }

    // Function to remove the spacial 
  function RemoveSpecialChar($str){
  
     
    $res = str_ireplace( array( '\'', '"',
    ',' , ';', '<', '>','&','-' ), ' ', $str);
    return $res;
    }

    //Get Pending Services List
    public function pendingServiceList() {
        extract($_POST);
        if ($this->input->post('form_submit')) { 
          $this->common_model->checkAdminLogin();
          $service_title = $this->input->post('service_title');
          $category = $this->input->post('category');
          $subcategory = $this->input->post('subcategory');
          $from = $this->input->post('from');
          $to = $this->input->post('to');
          $this->data['list'] =$this->service->pending_service_list($service_title,$category,$subcategory,$from,$to);
        }
      else {
            $this->data['list'] = $this->service->pending_service_list();
        }
        $this->data['page'] = 'pending_service_list';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }

    public function bookingReschedule() {
    
      extract($_POST);
     
      if (empty($this->session->userdata('admin_id'))) {
          $message = "";
          echo json_encode(['success' => false, 'msg' => $message, 'status' => 5]);
          return false;
      }
     
      $bookingId = $_POST['booking_id'];
      $userId = $_POST['user_id'];
      $bookingDate = $_POST['booking_date'];
     
      $user_currency = settings('currency');
      $user_currency_code = $user_currency;

      
      removeTag($this->input->post());
     
      $time = $this->input->post('booking_time');
      $booking_time = explode('-', $time);
      $start_time = strtotime($booking_time[0]);
      $end_time = strtotime($booking_time[1]);
      $from_time = date('G:i:s', ($start_time));
      $to_time = date('G:i:s', ($end_time));
     
      $inputs = array();
      $service_id = $this->input->post('service_id'); // Package ID
      $service_records = $this->booking->get_service($this->input->post('service_id'));
      $booking_records = $this->booking->get_booking($this->input->post('booking_id'));
      if(!empty($booking_records)) {
        $currentDateTime = new DateTime();
        $service_date = $booking_records['service_date'];
        $service_time = $booking_records['from_time'];
      
        $bookedDateTime = new DateTime($service_date . ' ' . $service_time);
        // Calculate the time difference      
       
        $interval = $currentDateTime->diff($bookedDateTime);
        // Calculate the time difference in hours and minutes
       
        $hoursDifference = $interval->h;
        $minutesDifference = $interval->i;
        $reschedule_time_before_appointment = settingValue('appointment_reschedule_time_showhide');
        
        if ($hoursDifference < $reschedule_time_before_appointment || ($hoursDifference == $reschedule_time_before_appointment  && $minutesDifference > 0 )) {
            $message = 'Booking Reschedule cannot be permitted';
            $message = (!empty($this->data['language_content']['lg_admin_booking_reschedule_error'])) ? $this->data['language_content']['lg_admin_booking_reschedule_error'] : 'Booking Reschedule cannot be permitted. ';
            $this->session->set_flashdata('error_message', $message);
            echo json_encode(['success' => false, 'msg' => $message, 'status' => 7]);
            exit;
        }
      }
      
      $inputs['service_id'] = $service_id;
      $inputs['provider_id'] = $this->input->post('provider_id');
      $inputs['user_id'] = $this->input->post('user_id');
      $inputs['currency_code'] = $user_currency_code;
      $inputs['token'] = 'old type';
      $inputs['service_id'] = $service_id;
      $inputs['amount'] = get_gigs_currency($service_records['service_amount'], $service_records['currency_code'], $user_currency_code);
      $inputs['service_date'] = date('Y-m-d', strtotime($this->input->post('booking_date')));
      $inputs['location'] = $booking_records['location'];
      $inputs['latitude'] = $booking_records['latitude'];
      $inputs['longitude'] = $booking_records['longitude'];
      $inputs['from_time'] = $from_time;
      $inputs['to_time'] = $to_time;
      $inputs['notes'] = $booking_records['notes'];
      $inputs['cod'] = $booking_records['cod'];
      $inputs['args'] = 'no response that field ld flow';
      $inputs['additional_services'] = $booking_records['additional_services'];
      $addiamt = 0;
     
      
      //check appointment settings auto confirm
      $appointment_settings = $this->service->check_provider_settings_interval($this->input->post('provider_id'));
      $auto_confirm_showhide = settingValue('appointment_auto_confirm_showhide');

       if(!empty($appointment_settings)) {
          ($appointment_settings->auto_confirm == 1)? $inputs['status'] = 2: $inputs['status'] = 1;
       } else {
          ($auto_confirm_showhide == 1)?$inputs['status'] = 2: $inputs['status'] = 1;
       }
      
      //check booking availability
      $timestamp = strtotime($inputs['service_date']);
      $day = date('D', $timestamp);


      $inputs1 = $inputs['service_id'];

      $result = $this->api->get_service_id($inputs1);
      
      $provider_details = $this->api->provider_hours($result['user_id']);
      $availability_details = json_decode($provider_details['availability'], true);
    
      $alldays = false;
      foreach ($availability_details as $details) {

          if (isset($details['day']) && $details['day'] == 0) {

              if (isset($details['from_time']) && !empty($details['from_time'])) {

                  if (isset($details['to_time']) && !empty($details['to_time'])) {
                      $from_time1 = $details['from_time'];
                      $to_time1 = $details['to_time'];
                      $alldays = true;
                      break;
                  }
              }
          }
      }

      if ($alldays == false) {


          if ($day == 'Mon') {
              $weekday = '1';
          } elseif ($day == 'Tue') {
              $weekday = '2';
          } elseif ($day == 'Wed') {
              $weekday = '3';
          } elseif ($day == 'Thu') {
              $weekday = '4';
          } elseif ($day == 'Fri') {
              $weekday = '5';
          } elseif ($day == 'Sat') {
              $weekday = '6';
          } elseif ($day == 'Sun') {
              $weekday = '7';
          } elseif ($day == '0') {
              $weekday = '0';
          }


          foreach ($availability_details as $availability) {

              if ($weekday == $availability['day'] && $availability['day'] != 0) {

                  $availability_day = $availability['day'];
                  $from_time1 = $availability['from_time'];
                  $to_time1 = $availability['to_time'];
              }
          }
      }

      if (!empty($from_time1)) {
          $temp_start_time = $from_time1;
          $temp_end_time = $to_time1;
      } else {                       
          $message = 'Booking not available';
          $message = (!empty($this->data['language_content']['lg_admin_Booking_Not_Available'])) ? $this->data['language_content']['lg_admin_Booking_Not_Available'] : 'Booking not available. ';
          $this->session->set_flashdata('error_message', $message);
          echo json_encode(['success' => false, 'msg' => $message, 'status' => 3]);exit;
      }

      $start_time_array = '';
      $end_time_array = '';
      $timestamp_start = strtotime($temp_start_time);
      $timestamp_end = strtotime($temp_end_time);

      $timing_array = array();

      $counter = 1;

      $from_time_railwayhrs = date('H:i:s', ($timestamp_start));
      $to_time_railwayhrs = date('H:i:s', ($timestamp_end));

      $timestamp_start_railwayhrs = strtotime($from_time_railwayhrs);
      $timestamp_end_railwayhrs = strtotime($to_time_railwayhrs);

      $i = 1;
      while ($timestamp_start_railwayhrs < $timestamp_end_railwayhrs) {

          $temp_start_time_ampm = date('H:i:s', ($timestamp_start_railwayhrs));
          $temp_end_time_ampm = date('H:i:s', (($timestamp_start_railwayhrs) + 60 * 60 * 1));

          $timestamp_start_railwayhrs = strtotime($temp_end_time_ampm);

          $timing_array[] = array('id' => $i, 'start_time' => $temp_start_time_ampm, 'end_time' => $temp_end_time_ampm);

          if ($counter > 24) {
              break;
          }

          $counter += 1;
          $i++;
      }
      
      // Booking availability
      $booking_from_time = $booking_time[0];
      $booking_end_time = $booking_time[1];

      $timestamp_from = strtotime($booking_from_time);
      $timestamp_to = strtotime($booking_end_time);

      $from_time_railwayhrs = date('H:i:s', ($timestamp_from));
      $to_time_railwayhrs = date('H:i:s', ($timestamp_to));

      $service_date = $inputs['service_date'];
      $service_id = $inputs['service_id'];

      $booking_count = $this->api->get_bookings($service_date, $service_id);
     
      $new_timingarray = array();
     
      if (is_array($booking_count) && empty($booking_count)) {
        
          $new_timingarray = $timing_array;
      } elseif (is_array($booking_count) && $booking_count != '') {
         
          foreach ($timing_array as $timing) {
              $match_found = false;

              $explode_st_time = explode(':', $timing['start_time']);
              $explode_value = $explode_st_time[0];

              $explode_endtime = explode(':', $timing['end_time']);
              $explode_endval = $explode_endtime[0];


              if (strlen($explode_value) == 1) {
                  $timing['start_time'] = "0" . $explode_st_time[0] . ":" . $explode_st_time[1] . ":" . $explode_st_time[2];
              }

              if (strlen($explode_endval) == 1) {
                  $timing['end_time'] = "0" . $explode_endtime[0] . ":" . $explode_endtime[1] . ":" . $explode_endtime[2];
              }

              foreach ($booking_count as $bookings) {

                  if ($timing['start_time'] == $bookings['from_time'] && $timing['end_time'] == $bookings['to_time']) {
                      $match_found = true;
                      break;
                  }
              }

              if ($match_found == false) {
                  $new_timingarray[] = array('start_time' => $timing['start_time'], 'end_time' => $timing['end_time']);
              }
          }
          $new_timingarray = array_filter($new_timingarray);
     
      $timestamp_start_railwayhrs = strtotime($from_time_railwayhrs);
      $timestamp_end_railwayhrs = strtotime($to_time_railwayhrs);
      $booking = false;
     
      foreach ($new_timingarray as $booked_time) {

          if ($booked_time['start_time'] == $from_time_railwayhrs && $booked_time['end_time'] == $to_time_railwayhrs) {
              $booking = true;
          }
          if ($booked_time['start_time'] == $from_time_railwayhrs && strtotime($booked_time['end_time']) > $timestamp_end_railwayhrs) {
              $booking = true;
          }
      }
      
      if ($booking == false) {

          //$message = 'Booking already exists on this time';
          $message = (!empty($this->data['language_content']['lg_admin_Booking_Exists'])) ? $this->data['language_content']['lg_admin_Booking_Exists'] : 'Booking already exists on this time. ';
          $this->session->set_flashdata('error_message', $message);
          echo json_encode(['success' => false, 'msg' => $message, 'status' => 6]);
          exit;
      }
      }
      
      //booking success
      $result = $this->booking->booking_success($inputs);
     
      if ($result != '') {
          $this->data['user'] = $this->session->userdata();

      if($inputs['cod'] == 1){	
        $codData['book_id'] = $result;
        $codData['user_id'] = $this->input->post('user_id');	
        $codData['provider_id'] = $this->input->post('provider_id');	
        $codData['amount'] = $inputs['amount'];	
        $codData['created_on'] = date('Y-m-d');	
        $this->db->insert('book_service_cod', $codData);	
      }
    
          $rescheduleStatus = 12;
          $oldBookDetails['status'] = $rescheduleStatus;
          $oldBookDetails['updated_on'] = (date('Y-m-d H:i:s'));
          $oldBookDetails['reschedule_id'] = $result;
          $this->db->set($oldBookDetails);
        $this->db->where('id', $this->input->post('booking_id'));
        $this->db->update('book_service');
         

    $service=$this->db->where('id',$service_id)->from('services')->get()->row_array();
    $this->data['service'] = $service;
    
    $provider_data = $this->db->where('id',$this->input->post('provider_id'))->from('providers')->get()->row_array();
    $user_data = $this->db->where('id',$this->input->post('user_id'))->from('users')->get()->row_array();
    $this->data['provider'] = $provider_data;
   
    //$preview_link = base_url();
    $bodyid = 2;
    $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
    $body = $tempbody_details['template_content'];
    $body = str_replace('{user_name}', $user_data['name'], $body);
    $body = str_replace('{sitetitle}',$this->site_name, $body);
    $preview_link = '<p style="margin-left:15px; margin-right:15px"><a href="'.base_url().'" style="color:#ffffff; padding:10px 20px 10px 20px; background:#ff0080; display:inline-block; text-decoration:none; border-radius:8px;">View</a></p>';
    $body = str_replace('{preview_link}',$preview_link, $body);
    $body = str_replace('{service_title}',$service['service_title'], $body);
    $body = str_replace('{location_user}',$service['service_location'], $body);
    
          $phpmail_config = settingValue('mail_config');
          if (isset($phpmail_config) && !empty($phpmail_config)) {
              if ($phpmail_config == "phpmail") {
                  $from_email = settingValue('email_address');
              } 
              if ($phpmail_config == "smtp") {
                $from_email=settingValue('smtp_email_address');
              }
              if ($phpmail_config == "sendgrid") {
                $from_email = settingValue('sendgrid_email');
                $to_email = $user_data['email'];
                $subject = "Service Booking";
                $message = $body;
                $this->load->library('sendemail');
                $send_mail = $this->sendemail->sendgrid_email($from_email,$to_email,$subject,$message);
              } else {
                  $this->load->library('email');
                  if (!empty($from_email) && isset($from_email)) {
                      $mail = $this->email
                              ->from($from_email)
                              ->to($to_email)
                              ->subject('Service Booking')
                              ->message($body)
                              ->send();
                  }
              }
          }

    $bodyid = 3;
    $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
    $providerbody = $tempbody_details['template_content'];
    $providerbody = str_replace('{user_name}', $provider_data['name'], $providerbody);
    $providerbody = str_replace('{sitetitle}',$this->site_name, $providerbody);
    $providerbody = str_replace('{user_person}',$user_data['name'], $providerbody);
    $providerbody = str_replace('{service_title}',$service['service_title'], $providerbody);
    $providerbody = str_replace('{service_date}',$this->input->post('booking_date'), $providerbody);
    $providerbody = str_replace('{service_time}',$time, $providerbody);
    $providerbody = str_replace('{location_user}',$service['service_location'], $providerbody);
    $providerbody = str_replace('{preview_link}',$preview_link, $providerbody);
    
    
    $phpmail_config=settingValue('mail_config');
      if(isset($phpmail_config)&&!empty($phpmail_config)){
      if($phpmail_config=="phpmail"){
        $from_email=settingValue('email_address');
      }
              if ($phpmail_config == "smtp") {
        $from_email=settingValue('smtp_email_address');
      }
              if ($phpmail_config == "sendgrid") {
                $from_email = settingValue('sendgrid_email');
                $to_email = $provider_data['email'];
                $subject = "Service Booking";
                $message = $providerbody;
                $this->load->library('sendemail');
                $send_mail = $this->sendemail->sendgrid_email($from_email,$to_email,$subject,$message);
              } else {
                   $this->load->library('email');
                   $this->load->library('sms');

                    //Send mail to provider
                    if(!empty($from_email)&&isset($from_email)){
                      $mail = $this->email
                      ->from($from_email)
                      ->to($provider_data['email'])
                      ->subject('Service Booking')
                      ->message($providerbody)
                      ->send();
                    }
              }
      }

          // $body = $this->load->view('user/email/service_email', $this->data, true);
          // $message = 'You have booked successfully';
          $message = (!empty($this->data['language_content']['lg_admin_Booking_Success'])) ? $this->data['language_content']['lg_admin_Booking_Success'] : 'You have booked successfully. ';
          // $token = $this->session->userdata('chat_token');
        $token = $user_data['token'];
        //   /* history entry */
        // if($inputs['cod'] == 2){ // not cod	
        //   $this->api->booking_wallet_history_flow($result, $token);	
        // }

          /* history entry */
          
          $data = $this->api->get_book_info_b($result);
        
          $device_token = $this->api->get_device_info_multiple($data['provider_id'], 1);
          $user_name = $this->api->get_user_info($data['user_id'], 2);
          $provider_token = $this->api->get_user_info($data['provider_id'], 1);
          /* Get push notification text based on User or Providers language */
          $user_lang = $this->db->get_where('providers', array('id'=>$inputs['provider_id']))->row()->language;
          $user_language = ($user_lang)?$user_lang:'en';
          $lang_key = 'lg_has_booked_your_service';
          $lang_value = $this->home->getNotificationLangText($user_language, $lang_key);
          $text = $user_name['name'] ." ".$lang_value." - " . $service['service_title'];
        
          $this->send_push_notification($token, $result, 1, $msg = $text);
          $this->session->set_flashdata('success_message', $message);
         
          echo json_encode(['success' => true, 'msg' => $message, 'status' => 1]);
      } else {
          //$message = 'Sorry, something went wrong';
          $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something went wrong, Try again';
          $this->session->set_flashdata('error_message', $message);
          echo json_encode(['success' => true, 'msg' => $message, 'status' => 2]);
      }
      exit;
  }

  //new reschedule 
  public function bookReschedule() {

    extract($_POST);
   
    if (empty($this->session->userdata('admin_id'))) {
        $message = "";
        echo json_encode(['success' => false, 'msg' => $message, 'status' => 5]);
        return false;
    }   
    $bookingId = $_POST['booking_id'];
    $userId = $_POST['user_id'];
    $bookingDate = $_POST['booking_date'];
   
    $user_currency = settings('currency');
    $user_currency_code = $user_currency;
    
    removeTag($this->input->post());
   
    $time = $this->input->post('booking_time');
    $booking_time = explode('-', $time);
    $start_time = strtotime($booking_time[0]);
    $end_time = strtotime($booking_time[1]);
    $from_time = date('G:i:s', ($start_time));
    $to_time = date('G:i:s', ($end_time));
   
    $inputs = array();
    $service_id = $this->input->post('service_id'); // Package ID
    $service_records = $this->booking->get_service($this->input->post('service_id'));
    $booking_records = $this->booking->get_booking($this->input->post('booking_id'));
    if(!empty($booking_records)) {
      $currentDateTime = new DateTime();
      $service_date = $booking_records['service_date'];
      $service_time = $booking_records['from_time'];
    
      $bookedDateTime = new DateTime($service_date . ' ' . $service_time);
      // Calculate the time difference      
     
      $interval = $currentDateTime->diff($bookedDateTime);
      // Calculate the time difference in hours and minutes
     
      $hoursDifference = $interval->h;
      $minutesDifference = $interval->i;
      $reschedule_time_before_appointment = settingValue('appointment_reschedule_time_showhide');
      
      if ($hoursDifference < $reschedule_time_before_appointment || ($hoursDifference == $reschedule_time_before_appointment  && $minutesDifference > 0 )) {
          //$message = 'Booking Reschedule cannot be permitted time';
          $message = (!empty($this->data['language_content']['lg_admin_booking_reschedule'])) ? $this->data['language_content']['lg_admin_booking_reschedule'] : 'Booking Reschedule cannot be permitted time. ';
          $this->session->set_flashdata('error_message', $message);
          echo json_encode(['success' => false, 'msg' => $message, 'status' => 7]);
          exit;
      }
    }
    
    $inputs['service_id'] = $service_id;
    $inputs['service_date'] = date('Y-m-d', strtotime($this->input->post('booking_date')));
    $inputs['from_time'] = $from_time;
    $inputs['to_time'] = $to_time;
    
    //check appointment settings auto confirm
    $appointment_settings = $this->service->check_provider_settings_interval($this->input->post('provider_id'));
    $auto_confirm_showhide = settingValue('appointment_auto_confirm_showhide');

     if(!empty($appointment_settings)) {
        ($appointment_settings->auto_confirm == 1)? $inputs['status'] = 2: $inputs['status'] = 1;
     } else {
        ($auto_confirm_showhide == 1)?$inputs['status'] = 2: $inputs['status'] = 1;
     }
    
    //check booking availability
    $timestamp = strtotime($inputs['service_date']);
    $day = date('D', $timestamp);

    $inputs1 = $inputs['service_id'];

    $result = $this->api->get_service_id($inputs1);
    
    $provider_details = $this->api->provider_hours($result['user_id']);
    $availability_details = json_decode($provider_details['availability'], true);
  
    $alldays = false;
    foreach ($availability_details as $details) {

        if (isset($details['day']) && $details['day'] == 0) {

            if (isset($details['from_time']) && !empty($details['from_time'])) {

                if (isset($details['to_time']) && !empty($details['to_time'])) {
                    $from_time1 = $details['from_time'];
                    $to_time1 = $details['to_time'];
                    $alldays = true;
                    break;
                }
            }
        }
    }

    if ($alldays == false) {


        if ($day == 'Mon') {
            $weekday = '1';
        } elseif ($day == 'Tue') {
            $weekday = '2';
        } elseif ($day == 'Wed') {
            $weekday = '3';
        } elseif ($day == 'Thu') {
            $weekday = '4';
        } elseif ($day == 'Fri') {
            $weekday = '5';
        } elseif ($day == 'Sat') {
            $weekday = '6';
        } elseif ($day == 'Sun') {
            $weekday = '7';
        } elseif ($day == '0') {
            $weekday = '0';
        }


        foreach ($availability_details as $availability) {

            if ($weekday == $availability['day'] && $availability['day'] != 0) {

                $availability_day = $availability['day'];
                $from_time1 = $availability['from_time'];
                $to_time1 = $availability['to_time'];
            }
        }
    }

    if (!empty($from_time1)) {
        $temp_start_time = $from_time1;
        $temp_end_time = $to_time1;
    } else {                       
        //$message = 'Booking not available';
        $message = (!empty($this->data['language_content']['lg_admin_Booking_Not_Available'])) ? $this->data['language_content']['lg_admin_Booking_Not_Available'] : 'Booking not available. ';
        $this->session->set_flashdata('error_message', $message);
        echo json_encode(['success' => false, 'msg' => $message, 'status' => 3]);exit;
    }

    $start_time_array = '';
    $end_time_array = '';
    $timestamp_start = strtotime($temp_start_time);
    $timestamp_end = strtotime($temp_end_time);

    $timing_array = array();

    $counter = 1;

    $from_time_railwayhrs = date('H:i:s', ($timestamp_start));
    $to_time_railwayhrs = date('H:i:s', ($timestamp_end));

    $timestamp_start_railwayhrs = strtotime($from_time_railwayhrs);
    $timestamp_end_railwayhrs = strtotime($to_time_railwayhrs);

    $i = 1;
    while ($timestamp_start_railwayhrs < $timestamp_end_railwayhrs) {

        $temp_start_time_ampm = date('H:i:s', ($timestamp_start_railwayhrs));
        $temp_end_time_ampm = date('H:i:s', (($timestamp_start_railwayhrs) + 60 * 60 * 1));

        $timestamp_start_railwayhrs = strtotime($temp_end_time_ampm);

        $timing_array[] = array('id' => $i, 'start_time' => $temp_start_time_ampm, 'end_time' => $temp_end_time_ampm);

        if ($counter > 24) {
            break;
        }

        $counter += 1;
        $i++;
    }
    
    // Booking availability
    $booking_from_time = $booking_time[0];
    $booking_end_time = $booking_time[1];

    $timestamp_from = strtotime($booking_from_time);
    $timestamp_to = strtotime($booking_end_time);

    $from_time_railwayhrs = date('H:i:s', ($timestamp_from));
    $to_time_railwayhrs = date('H:i:s', ($timestamp_to));

    $service_date = $inputs['service_date'];
    $service_id = $inputs['service_id'];

    $booking_count = $this->api->get_bookings($service_date, $service_id);
   
    $new_timingarray = array();
   
    if (is_array($booking_count) && empty($booking_count)) {
      
        $new_timingarray = $timing_array;
    } elseif (is_array($booking_count) && $booking_count != '') {
       
        foreach ($timing_array as $timing) {
            $match_found = false;

            $explode_st_time = explode(':', $timing['start_time']);
            $explode_value = $explode_st_time[0];

            $explode_endtime = explode(':', $timing['end_time']);
            $explode_endval = $explode_endtime[0];


            if (strlen($explode_value) == 1) {
                $timing['start_time'] = "0" . $explode_st_time[0] . ":" . $explode_st_time[1] . ":" . $explode_st_time[2];
            }

            if (strlen($explode_endval) == 1) {
                $timing['end_time'] = "0" . $explode_endtime[0] . ":" . $explode_endtime[1] . ":" . $explode_endtime[2];
            }

            foreach ($booking_count as $bookings) {

                if ($timing['start_time'] == $bookings['from_time'] && $timing['end_time'] == $bookings['to_time']) {
                    $match_found = true;
                    break;
                }
            }

            if ($match_found == false) {
                $new_timingarray[] = array('start_time' => $timing['start_time'], 'end_time' => $timing['end_time']);
            }
        }
        $new_timingarray = array_filter($new_timingarray);
   
    $timestamp_start_railwayhrs = strtotime($from_time_railwayhrs);
    $timestamp_end_railwayhrs = strtotime($to_time_railwayhrs);
    $booking = false;
   
    foreach ($new_timingarray as $booked_time) {

        if ($booked_time['start_time'] == $from_time_railwayhrs && $booked_time['end_time'] == $to_time_railwayhrs) {
            $booking = true;
        }
        if ($booked_time['start_time'] == $from_time_railwayhrs && strtotime($booked_time['end_time']) > $timestamp_end_railwayhrs) {
            $booking = true;
        }
    }
    
    if ($booking == false) {

        //$message = 'Booking already exists on this time';
        $message = (!empty($this->data['language_content']['lg_admin_Booking_Exists'])) ? $this->data['language_content']['lg_admin_Booking_Exists'] : 'Booking already exists on this time. ';
        $this->session->set_flashdata('error_message', $message);
        echo json_encode(['success' => false, 'msg' => $message, 'status' => 6]);
        exit;
    }
    }
 
        $this->data['user'] = $this->session->userdata();  
        $oldBookDetails['service_date'] = date('Y-m-d', strtotime($this->input->post('booking_date')));         
        $oldBookDetails['from_time'] = $from_time;
        $oldBookDetails['to_time'] = $to_time;
        $oldBookDetails['updated_on'] = (date('Y-m-d H:i:s'));
        $oldBookDetails['reschedule_id'] = $booking_records['id'];
        $this->db->set($oldBookDetails);
        $this->db->where('id', $this->input->post('booking_id'));
        if($this->db->update('book_service')) {

          $service=$this->db->where('id',$service_id)->from('services')->get()->row_array();
          $this->data['service'] = $service;
  
          $provider_data = $this->db->where('id',$this->input->post('provider_id'))->from('providers')->get()->row_array();
          $user_data = $this->db->where('id',$this->input->post('user_id'))->from('users')->get()->row_array();
          $this->data['provider'] = $provider_data;
 
          //$preview_link = base_url();
          $bodyid = 2;
          $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
          $body = $tempbody_details['template_content'];
          $body = str_replace('{user_name}', $user_data['name'], $body);
          $body = str_replace('{sitetitle}',$this->site_name, $body);
          $preview_link = '<p style="margin-left:15px; margin-right:15px"><a href="'.base_url().'" style="color:#ffffff; padding:10px 20px 10px 20px; background:#ff0080; display:inline-block; text-decoration:none; border-radius:8px;">View</a></p>';
          $body = str_replace('{preview_link}',$preview_link, $body);
          $body = str_replace('{service_title}',$service['service_title'], $body);
          $body = str_replace('{location_user}',$service['service_location'], $body);
  
          $phpmail_config = settingValue('mail_config');
          if(isset($phpmail_config) && !empty($phpmail_config)) {
            if($phpmail_config == "phpmail") {
              $from_email = settingValue('email_address');
            } 
            if($phpmail_config == "smtp") {
              $from_email=settingValue('smtp_email_address');
            }
            if($phpmail_config == "sendgrid") {
              $from_email = settingValue('sendgrid_email');
              $to_email = $user_data['email'];
              $subject = "Service Booking";
              $message = $body;
              $this->load->library('sendemail');
              $send_mail = $this->sendemail->sendgrid_email($from_email,$to_email,$subject,$message);
            }else {
              $this->load->library('email');
              if(!empty($from_email) && isset($from_email)) {
                    $mail = $this->email
                            ->from($from_email)
                            ->to($to_email)
                            ->subject('Service Booking')
                            ->message($body)
                            ->send();
              }
            }
          }

          $bodyid = 3;
          $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
          $providerbody = $tempbody_details['template_content'];
          $providerbody = str_replace('{user_name}', $provider_data['name'], $providerbody);
          $providerbody = str_replace('{sitetitle}',$this->site_name, $providerbody);
          $providerbody = str_replace('{user_person}',$user_data['name'], $providerbody);
          $providerbody = str_replace('{service_title}',$service['service_title'], $providerbody);
          $providerbody = str_replace('{service_date}',$this->input->post('booking_date'), $providerbody);
          $providerbody = str_replace('{service_time}',$time, $providerbody);
          $providerbody = str_replace('{location_user}',$service['service_location'], $providerbody);
          $providerbody = str_replace('{preview_link}',$preview_link, $providerbody);
  
          $phpmail_config=settingValue('mail_config');
          if(isset($phpmail_config)&&!empty($phpmail_config)){
            if($phpmail_config=="phpmail"){
              $from_email=settingValue('email_address');
            }
            if($phpmail_config == "smtp") {
              $from_email=settingValue('smtp_email_address');
            }
            if($phpmail_config == "sendgrid") {
              $from_email = settingValue('sendgrid_email');
              $to_email = $provider_data['email'];
              $subject = "Service Booking";
              $message = $providerbody;
              $this->load->library('sendemail');
              $send_mail = $this->sendemail->sendgrid_email($from_email,$to_email,$subject,$message);
            } else {
              $this->load->library('email');
              $this->load->library('sms');
                  //Send mail to provider
              if(!empty($from_email)&&isset($from_email)){
                    $mail = $this->email
                    ->from($from_email)
                    ->to($provider_data['email'])
                    ->subject('Service Booking')
                    ->message($providerbody)
                    ->send();
              }
            }
          }

        // $body = $this->load->view('user/email/service_email', $this->data, true);
        //$message = 'You have booked successfully';
        $message = (!empty($this->data['language_content']['lg_admin_Booking_Success'])) ? $this->data['language_content']['lg_admin_Booking_Success'] : 'You have booked successfully. ';
        // $token = $this->session->userdata('chat_token');
        $token = $user_data['token'];
      //   /* history entry */
      // if($inputs['cod'] == 2){ // not cod	
      //   $this->api->booking_wallet_history_flow($result, $token);	
      // }

        /* history entry */
        
        $data = $this->api->get_book_info_b($this->input->post('booking_id'));
      
        $device_token = $this->api->get_device_info_multiple($data['provider_id'], 1);
        $user_name = $this->api->get_user_info($data['user_id'], 2);
        $provider_token = $this->api->get_user_info($data['provider_id'], 1);
        /* Get push notification text based on User or Providers language */
        $user_lang = $this->db->get_where('providers', array('id'=>$this->input->post('provider_id')))->row()->language;
        $user_language = ($user_lang)?$user_lang:'en';
        $lang_key = 'lg_has_booked_your_service';
        $lang_value = $this->home->getNotificationLangText($user_language, $lang_key);
        $text = $user_name['name'] ." ".$lang_value." - " . $service['service_title'];
      
        $this->send_push_notification($token, $bookingId, 1, $msg = $text);
        $this->session->set_flashdata('success_message', $message);
        
        echo json_encode(['success' => true, 'msg' => $message, 'status' => 1]);
    } else {
        //$message = 'Sorry, something went wrong';
        $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something went wrong, Try again';
        $this->session->set_flashdata('error_message', $message);
        echo json_encode(['success' => true, 'msg' => $message, 'status' => 2]);
    }
    exit;
}

   /* push notification */
   public function send_push_notification($token, $service_id, $type, $msg = '') 
   {
     $data = $this->api->get_book_info($service_id);
     if (!empty($data)) {
       //get userInfo        
       $user_info = $this->api->get_user_info($data['user_id'], 2);
       $provider_info = $this->api->get_user_info($data['provider_id'], 1);
 
       /* insert notification */
     $msg = 'Admin changed status as ' . strtolower($msg);
 
       if(!empty($user_info['token'])) {
         $this->api->insert_notification($token, $user_info['token'], $msg);
       }
       if(!empty($provider_info['token'])) {
         $this->api->insert_notification($token, $provider_info['token'], $msg);
       }
 
     } else {
         $this->token_error();
     }
   }
 

}//Class end.