<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Taxsettings extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
		$this->load->model('admin_model','admin');
		$this->load->model('common_model','common_model');
        $this->data['theme'] = 'admin';
        $this->data['model'] = 'taxsettings';
        $this->data['base_url'] = base_url();
        $this->load->helper('custom_language');

        //Get Language Keywords from content lang file
        $langs = !empty($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
        $lang = $this->db->get_where('language', array('language_value'=>$langs))->row()->language;
        $this->data['language_content'] = $this->lang->load('content', strtolower($lang), true);
        $this->language = $this->lang->load('content', strtolower($lang), true);

        $this->session->keep_flashdata('error_message');
        $this->session->keep_flashdata('success_message');
        $this->load->helper('user_timezone_helper');
        $this->data['user_role'] = $this->session->userdata('role');
    }

    public function index() {
        redirect(base_url('tax-settings'));
    }

    public function taxSettings() {
        
		$this->common_model->checkAdminUserPermission(2);
        $this->data['page'] = 'tax_settings';
        $this->data['list_filter'] = $this->admin->taxList();

        if ($this->input->post('form_submit')) {
            $this->common_model->checkAdminLogin();
            extract($_POST);
           
            $tax_name = $this->input->post('search_tax');
            $tax_percent = $this->input->post('search_tax_percent');
            $this->data['list'] = $this->admin->taxListFilter($tax_name, $tax_percent);
        } else {
            $this->data['list'] = $this->admin->taxList();
        }


        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function addTax() {
        
        $this->common_model->checkAdminUserPermission(2);
        if ($this->input->post('form_submit')) {
            
            $this->common_model->checkAdminLogin();
            removeTag($this->input->post());
                   
            $table_data['tax_name'] = strip_tags($this->input->post('tax_name_28'));
            $table_data['tax_percent'] =$this->input->post('tax_percent');
          
            $table_data['created_at'] = date('Y-m-d H:i:s');
               
            $check = $this->checkTaxName();
            if(!$check){
                $message = (!empty($this->data['language_content']['lg_admin_add_tax'])) ? $this->data['language_content']['lg_admin_add_tax'] : 'Tax name already exist. ';
                $this->session->set_flashdata('error_message',  $message);
                redirect(base_url() . "admin/add-tax");
            }else{
                 
                $this->db->insert('tax_settings', $table_data);
                $last_id = $this->db->insert_id();
                    
                $this->admin->addTaxName($last_id);

                $ret_id = $this->db->insert_id();
                   
                if (!empty($ret_id)) { 
                    $message = (!empty($this->data['language_content']['lg_admin_tax_name_exist'])) ? $this->data['language_content']['lg_admin_tax_name_exist'] : 'Tax added successfully. ';
                    $this->session->set_flashdata('success_message', $message);
                    
                } else {
                    $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something went wrong, Try again';
                    $this->session->set_flashdata('error_message', $message);
                    redirect(base_url() . "admin/tax-settings");
                }   
            }
            redirect(base_url() . "admin/tax-settings");
        }

        $this->data['page'] = 'add_tax';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function editTax($id) {
		$this->common_model->checkAdminUserPermission(2);

        if ($this->input->post('form_submit')) {
          
            $this->common_model->checkAdminLogin();
                removeTag($this->input->post());

                $id = $this->input->post('tax_id');
                $table_data['tax_name'] = $this->input->post('tax_name_28');
                $table_data['tax_percent'] = $this->input->post('tax_percent');
                $this->db->where('id', $id);
               
                if ($this->db->update('tax_settings', $table_data)) {

                    $this->admin->updateTaxName($id);
                    $message = (!empty($this->data['language_content']['lg_admin_update_tax'])) ? $this->data['language_content']['lg_admin_update_tax'] : 'Tax updated successfully. ';
                    $this->session->set_flashdata('success_message', $message);
                    redirect(base_url() . "admin/tax-settings");
                } else {
                    $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something went wrong, Try again';
                    $this->session->set_flashdata('error_message', $message);
                    redirect(base_url() . "admin/tax-settings");
                }
        }

        $this->data['page'] = 'edit_tax';
        $this->data['tax'] = $this->admin->tax_details($id);
       
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function image_resize($width = 0, $height = 0, $image_url='', $filename='') {

        $source_path = base_url() . $image_url;
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

        $x0 = ($temp_width - $width) / 2;
        $y0 = ($temp_height - $height) / 2;
        $desired_gdim = imagecreatetruecolor($width, $height);
        imagecopy(
                $desired_gdim, $temp_gdim, 0, 0, $x0, $y0, $width, $height
        );

        /*
         * Render the image
         * Alternatively, you can save the image in file-system or database
         */
        $filename_without_extension = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $image_url = "uploads/category_images/" . $filename_without_extension . "_" . $width . "_" . $height . "." . $extension;

        imagepng($desired_gdim, $image_url);

        return $image_url;

        /*
         * Add clean-up code here
         */
    }

    public function checkTaxName() {
    
        $tax_name =strip_tags($this->input->post('tax_name_28'));
       
        $id = $this->input->post('tax_id');
    
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->where('replace(tax_name," ","")=replace("' . $tax_name . '"," ","")');
            $this->db->where('id !=', $id);
            $this->db->where('deleted_status', 0);
            $this->db->from('tax_settings');
            $result = $this->db->get()->num_rows();
        } else {
            $this->db->select('*');
			$this->db->where('deleted_status', 0);
            $this->db->where('replace(tax_name," ","")=replace("' . $tax_name . '"," ","")');
            $this->db->from('tax_settings');
            $result = $this->db->get()->num_rows();
        }
    
        if ($result > 0) {
            $isAvailable = FALSE;
        } else {
            $isAvailable = TRUE;
        }
        return $isAvailable;
    }

    public function delete_tax() {
		$this->common_model->checkAdminUserPermission(2);
        $this->common_model->checkAdminLogin();
           
            $id = $this->input->post('role_id');
            $table_data['status'] = 0;
            $table_data['deleted_status'] = 1;
                $this->db->where('id', $id);
                if ($this->db->update('tax_settings', $table_data)) {
                    $message = (!empty($this->data['language_content']['lg_admin_delete_tax'])) ? $this->data['language_content']['lg_admin_delete_tax'] : 'Tax deleted successfully. ';
                    $this->session->set_flashdata('success_message', $message); 
                    echo 1;
            } else {
                $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something went wrong, Try again';
                $this->session->set_flashdata('error_message', $message);
               echo 0;
            }
    }

  
    public function update_tax(){
       
        $id=$this->input->post('tax_id');
        $status=$this->input->post('status');
        $table_data['status'] = $status;
        $this->db->where('id',$id);
      
        if($this->db->update('tax_settings',$table_data)){
            echo "success";
        } else {
          echo "error";
        }
  }


  // update settings tax_module
  public function updateTaxmoduleStatus(){
   
    $tax_key=$this->input->post('tax_key');
    $tax_value=$this->input->post('tax_value');
    $table_data['value'] = $tax_value;

    $this->db->where('key',$tax_key);
    if($this->db->update('system_settings',$table_data)){
       
        echo "success";
    } else {
      echo "error";
    }
}
}
