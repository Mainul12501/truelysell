<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sitemap extends CI_Controller {

    public $data;
    
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->data['theme']  = 'admin';
        $this->data['model'] = 'sitemap';
        $this->data['base_url'] = base_url();
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->load->model('common_model');
        $this->user_role        = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;

        //Get Language Keywords from content lang file
        $langs = !empty($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
        $lang = $this->db->get_where('language', array('language_value'=>$langs))->row()->language;
        $this->data['language_content'] = $this->lang->load('content', strtolower($lang), true);
        $this->language = $this->lang->load('content', strtolower($lang), true);
    }
    /**
     * Index Page for this controller.
     *
     */
    public function index()
    {
        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    /** Create a Sitemap.xml file */
    public function view_map()
    {
        if($this->session->userdata('role') != 1 && settingValue('demo_access') == 0) {
            $message = (!empty($this->data['language_content']['lg_admin_demo_no_access'])) ? $this->data['language_content']['lg_admin_demo_no_access'] : 'Unable to access this feature in demo mode. ';
            $this->session->set_flashdata('error_message', $message);
            echo 3;
        } else {
            $xmlString = '<?xml version="1.0" encoding="UTF-8"?>';
            $xmlString .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

            $xmlString .= '<url>';
            $xmlString .= '<loc>'.base_url().'</loc>';
            $xmlString .= '<lastmod>'.date('Y-m-d').'</lastmod>';
            $xmlString .= '<changefreq>weekly</changefreq>';
            $xmlString .= '<priority>1.0</priority>';
            $xmlString .= '</url>';

            $categories = $this->db->get_where("categories",array('status'=>1))->result_array();
            $subcategories = $this->db->get_where("subcategories",array('status'=>1))->result_array();
            $services = $this->db->get_where("services",array('status'=>1))->result_array();
            $blogs = $this->db->get_where("blog_posts",array('status'=>1, 'lang_id'=>'28'))->result_array();
            $dynamic_pages = $this->db->get_where("pages_list",array('delete_status'=>1))->result_array();
            $static_pages = $this->db->get_where("page_content",array('status'=>1))->result_array();

            if(!empty($categories)) {
                foreach($categories as $category) {
                    $xmlString .= '<url>';
                    $xmlString .= '<loc>'.base_url().'search/'.$category['category_slug'].'</loc>';
                    $xmlString .= '<lastmod>'.date('Y-m-d').'</lastmod>';
                    $xmlString .= '<changefreq>weekly</changefreq>';
                    $xmlString .= '<priority>1.0</priority>';
                    $xmlString .= '</url>';
                }
            }

            if(!empty($services)) {
                foreach($services as $service) {
                    $xmlString .= '<url>';
                    $xmlString .= '<loc>'.base_url().'service-preview/'.$service['url'].'</loc>';
                    $xmlString .= '<lastmod>'.date('Y-m-d').'</lastmod>';
                    $xmlString .= '<changefreq>weekly</changefreq>';
                    $xmlString .= '<priority>1.0</priority>';
                    $xmlString .= '</url>';
                }
                
            }

            if(!empty($blogs)) {
                foreach($blogs as $blog) {
                    if(!empty($blog['url'])) {
                        $xmlString .= '<url>';
                        $xmlString .= '<loc>'.base_url().'user-blog-details/'.$blog['url'].'</loc>';
                        $xmlString .= '<lastmod>'.date('Y-m-d').'</lastmod>';
                        $xmlString .= '<changefreq>weekly</changefreq>';
                        $xmlString .= '<priority>1.0</priority>';
                        $xmlString .= '</url>';
                    }
                }
            }
            
            if(!empty($subcategories)) {
                foreach($subcategories as $subcategory) {
                    if(!empty($subcategory['subcategory_slug'])) {
                        $xmlString .= '<url>';
                        $xmlString .= '<loc>'.base_url().'search/'.$subcategory['subcategory_slug'].'</loc>';
                        $xmlString .= '<lastmod>'.date('Y-m-d').'</lastmod>';
                        $xmlString .= '<changefreq>weekly</changefreq>';
                        $xmlString .= '<priority>1.0</priority>';
                        $xmlString .= '</url>';
                    }
                }
            }
            
            if(!empty($dynamic_pages)) {
                foreach($dynamic_pages as $dynamic_page) {
                    if(!empty($dynamic_page['slug'])) {
                        $xmlString .= '<url>';
                        $xmlString .= '<loc>'.base_url().'pages_details/'.$dynamic_page['slug'].'</loc>';
                        $xmlString .= '<lastmod>'.date('Y-m-d').'</lastmod>';
                        $xmlString .= '<changefreq>weekly</changefreq>';
                        $xmlString .= '<priority>1.0</priority>';
                        $xmlString .= '</url>';
                    }
                }
            }
            
            if(!empty($static_pages)) {
                foreach($static_pages as $static_page) {
                    if(!empty($static_page['page_slug'])) {
                        $xmlString .= '<url>';
                        $xmlString .= '<loc>'.base_url().$static_page['page_slug'].'</loc>';
                        $xmlString .= '<lastmod>'.date('Y-m-d').'</lastmod>';
                        $xmlString .= '<changefreq>weekly</changefreq>';
                        $xmlString .= '<priority>1.0</priority>';
                        $xmlString .= '</url>';
                    }
                }
            }
            $xmlString .= '</urlset>';

            $dom = new DOMDocument;
            $dom->preserveWhiteSpace = FALSE;
            $dom->loadXML($xmlString);

            $dom->save('sitemap.xml');
        }
    }
}