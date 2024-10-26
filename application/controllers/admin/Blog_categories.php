<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_categories extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
		$this->load->model('admin_model','admin');
		$this->load->model('common_model','common_model');
        $this->data['theme'] = 'admin';
        $this->data['model'] = 'blog_categories';
        $this->data['base_url'] = base_url();
        $this->session->keep_flashdata('error_message');
        $this->session->keep_flashdata('success_message');
        $this->load->helper('user_timezone_helper');

        $langs = !empty($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
        $lang = $this->db->get_where('language', array('language_value'=>$langs))->row()->language;
        $this->data['language_content'] = $this->lang->load('content', strtolower($lang), true);
        $this->language = $this->lang->load('content', strtolower($lang), true);
        
        $this->data['user_role'] = $this->session->userdata('role');
        
    }

    public function index() {
        redirect(base_url('blog_categories'));
    }

    public function blog_categories() {
		$this->common_model->checkAdminUserPermission(2);
        $this->data['page'] = 'blog_categories';
        $this->data['list_filter'] = $this->admin->blog_categories_list();

        if ($this->input->post('form_submit')) {
            extract($_POST);
            $category = $this->input->post('category');
            $this->data['list'] = $this->admin->categories_list_filter($category, $from_date, $to_date);
        } else {
            $this->data['list'] = $this->admin->blog_categories_list();
        }


        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function add_blog_categories() {
		$this->common_model->checkAdminUserPermission(2);
        if ($this->input->post('form_submit')) {
            $this->common_model->checkAdminLogin();
                $data = $this->input->post();
                removeTag($this->input->post());
                unset($data['form_submit']);
                if (empty($data["slug"])) {
                    //slug for title
                    $data["slug"] = strtolower($data["name"]);
                }
                $table_data = $data;
                $table_data['status'] = 1;
                $table_data['createdBy'] = $this->session->userdata('admin_id');
                $this->db->insert('blog_categories', $table_data);
                $ret_id = $this->db->insert_id();
                if (!empty($ret_id)) {
                    $message = (!empty($this->data['language_content']['lg_admin_blog_category_success'])) ? $this->data['language_content']['lg_admin_blog_category_success'] : 'Blog Category added successfully';
                    $this->session->set_flashdata('success_message', $message);
                    redirect(base_url() . "blog-categories");
                } else {
                    $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something wrong, Please try again';
                    $this->session->set_flashdata('error_message', $message);
                    redirect(base_url() . "add-blog-category");
                }
        }

        $this->data['languages'] = $this->admin->language_list();
        $this->data['page'] = 'add_blog_categories';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function edit_blog_categories($id) {
		$this->common_model->checkAdminUserPermission(2);
        $this->data['languages'] = $this->admin->language_list();
        if ($this->input->post('form_submit')) {
            $this->common_model->checkAdminLogin();
                $data = $this->input->post();
                removeTag($this->input->post());

                $id = $this->input->post('category_id');
                unset($data['form_submit'],$data['category_id']);
                if (empty($data["slug"])) {
                    //slug for title
                    $data["slug"] = strtolower($data["name"]);
                }
                $table_data = $data;
                $table_data['updatedBy'] = $this->session->userdata('admin_id');
                $table_data['updatedAt'] = date('Y-m-d H:i:s');

                $this->db->where('id', $id);
                if ($this->db->update('blog_categories', $table_data)) {
                    $message = (!empty($this->data['language_content']['lg_admin_blog_category_update'])) ? $this->data['language_content']['lg_admin_blog_category_update'] : 'Blog Category updated successfully';
                    $this->session->set_flashdata('success_message', $message);
                    redirect(base_url() . "blog-categories");
                } else {
                    $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something wrong, Please try again';
                    $this->session->set_flashdata('error_message', $message);
                    redirect(base_url() . "edit-blog-category/".$id);
                }
        }


        $this->data['page'] = 'edit_blog_categories';
        $this->data['categories'] = $this->admin->blog_categories_details($id);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function check_category_name() {
        $category_name = $this->input->post('category_name');
        $id = $this->input->post('category_id');
        
        $this->db->select('*');
        $this->db->where('replace(name," ","")=replace("' . $category_name . '"," ","")');
        if (!empty($id)) {
            $this->db->where('id !=', $id);
        }
        $this->db->where('status', 1);
        $this->db->from('blog_categories');
        $result = $this->db->get()->num_rows();
        
        if ($result > 0) {
            $isAvailable = FALSE;
        } else {
            $isAvailable = TRUE;
        }
        // return $isAvailable;
        echo json_encode(
                array(
                    'valid' => $isAvailable
        ));
    }

    public function delete_blog_category() {
		$this->common_model->checkAdminUserPermission(2);
        $this->common_model->checkAdminLogin();
            $id = $this->input->post('category_id');
            $table_data['status'] = 0;
                $this->db->where('id', $id);
                if ($this->db->update('blog_categories', $table_data)) {
                    $message = (!empty($this->data['language_content']['lg_admin_blog_category_delete'])) ? $this->data['language_content']['lg_admin_blog_category_delete'] : 'Blog Category deleted successfully';
                    $this->session->set_flashdata('success_message', $message); 
                    echo 1;
            } else {
                $message = (!empty($this->data['language_content']['lg_something_went_wrong'])) ? $this->data['language_content']['lg_something_went_wrong'] : 'Something wrong, Please try again';
                $this->session->set_flashdata('error_message', $message);
               echo 1;
            }
    }

}
