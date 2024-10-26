<?php
class Roles extends CI_Controller
{
    public $data;
    
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->data['theme']  = 'admin';
        $this->data['model'] = 'roles';
        $this->load->model('admin_model', 'admin');
		$this->load->model('common_model','common_model');
        $this->data['base_url'] = base_url();
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role        = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;
        $this->load->helper('custom_language');

         //Get Language Keywords from content lang file
        $langs = !empty($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
        $lang = $this->db->get_where('language', array('language_value'=>$langs))->row()->language;
        $this->data['language_content'] = $this->lang->load('content', strtolower($lang), true);
        $this->language = $this->lang->load('content', strtolower($lang), true);
        
        $this->data['user_role']=$this->session->userdata('role');
    }

    public function index($offset = 0)
    {
    
		$this->common_model->checkAdminUserPermission(18);
        $this->data['page'] = 'index';
        $this->data['roles'] = $this->admin->get_roles_permissions();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

     public function add_roles_permissions() {
        $this->common_model->checkAdminUserPermission(2);
        if ($this->input->post('form_submit')) {
            $this->common_model->checkAdminLogin();
            $role_permissions = is_array($this->input->post('accesscheck'))? array_values($this->input->post('accesscheck')): array(); 
            $permissions = array();
            foreach($role_permissions as $key => $value) {
                $permissions[] = $value;
            }

            $rolePermission = implode(',', $permissions);
            removeTag($this->input->post());
            $languages = $this->db->get_where('language', array('status'=>1))->result();
            $table_data['status'] = 1;
            $table_data['permission_modules'] = $rolePermission;
            $table_data['created_datetime'] = date('Y-m-d H:i:s');
          
            $roles_name_count = $this->db->where('role_name', $this->input->post('role_name_28'))->count_all_results('roles_permissions_lang');
           
            if($roles_name_count > 0 && $this->input->post('role_id') == ''){
                $message = (!empty($this->data['language_content']['lg_admin_role_exist'])) ? $this->data['language_content']['lg_admin_role_exist'] : 'Role Name Already Exist. ';
              $this->session->set_flashdata('error_message', $message);
              redirect(base_url() . "admin/add-roles-permissions");
            }else{
                
                if($this->input->post('role_id') == '') {
                    $this->db->insert('roles_permissions', $table_data);
                    $last_id = $this->db->insert_id();
                    $result = $this->admin->add_role_permissions($last_id);
                } else {
                    $this->db->where('id',$this->input->post('role_id'));
                    $this->db->update('roles_permissions',$table_data);
                    $result = $this->admin->update_roles_permissions($this->input->post('role_id'));
                }
            }
            if ($result > 0) { 
                $message = (!empty($this->data['language_content']['lg_admin_role_update'])) ? $this->data['language_content']['lg_admin_role_update'] : 'Roles details updated successfully. ';
                $this->session->set_flashdata('success_message', $message);
            } else {
                $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something went wrong, Try again';
                $this->session->set_flashdata('error_message', $message);
            }

            redirect(base_url() . "admin/roles");
        }


        $this->data['page'] = 'add_roles';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    
    public function edit_roles_permissions($id=null) {
        $this->data['roles'] = $this->admin->get_roles_permissions($id);
        $this->data['page'] = 'edit_roles';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function deleteRoles() {
        if($this->session->userdata('role') != 1 && settingValue('demo_access') == 0) {
            $message = (!empty($this->data['language_content']['lg_admin_demo_no_access'])) ? $this->data['language_content']['lg_admin_demo_no_access'] : 'Unable to access this feature in Demo mode. ';
            $this->session->set_flashdata('error_message', $message);
            echo 3;
        } else {
            $id = $this->input->post('role_id');
            $table_data['status'] = 0;
            $this->db->where('id', $id);
            if ($this->db->update('roles_permissions', $table_data)) {
                $message = (!empty($this->data['language_content']['lg_admin_role_delete'])) ? $this->data['language_content']['lg_admin_role_delete'] : 'Roles deleted successfully. ';
                $this->session->set_flashdata('success_message', $message);
                echo 1;
            } else {
                $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something went wrong, Try again';
                $this->session->set_flashdata('error_message', $message);
                echo 1;
            }
        }
    }
}
