<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('push_notifications');
    }

    /*get information base on token*/
    public function get_token_info($token)
    {        
        if($token == '0dreamsadmin') {
            $admin_table=$this->db->select('user_id,email,username,full_name as name,profile_img,role')->
                        from('administrators')->
                        where('role','1')->
                        get()->row();
            $admin_table->token = '0dreamsadmin';
        } else {
            $user_table=$this->db->select('*')->
                        from('users')->
                        where('token',$token)->
                        get()->row();
            $provider_table=$this->db->select('*')->
                        from('providers')->
                        where('token',$token)->
                        where('delete_status',0)->
                        get()->row();
        }
        
        if(!empty($user_table)){
            return $user_table;
        }else if(!empty($provider_table)) {
            return $provider_table;
        } else {
            return $admin_table;
        }               
    }

    public function get_book_info($book_service_id)
    {
        $ret=$this->db->select('tab_1.provider_id,tab_1.user_id,tab_1.status,tab_2.service_title')->
                from('book_service as tab_1')->
                join('services as tab_2','tab_2.id=tab_1.service_id','LEFT')->
                where('tab_1.id',$book_service_id)->limit(1)->
                order_by('tab_1.id','DESC')->
                get()->row_array();
        return $ret;
    }  

    public function get_user_info($user_id,$user_type)
    {
        if($user_type ==2){
            $val=$this->db->select('*')->from('users')->where('id',$user_id)->where('type',$user_type)->get()->row_array();
        }else{
            $val=$this->db->select('*')->from('providers')->where('id',$user_id)->where('type',$user_type)->get()->row_array();
        }        
        return $val;
    }

    /*get last msg*/
    public function get_last_msg($token)
    {
        $val=$this->db->select('message,created_at')
                    ->from('chat_table')
                    ->where('sender_token',$token)
                    ->or_where('receiver_token',$token)
                    ->order_by('chat_id','DESC')
                    ->limit(1)->get()->row();
        return $val; 
    }

    /*change to read status*/
    public function changeToRead($where,$data,$table)
    {
        $this->db->where($where);
        $ret=$this->db->update($table,$data);
        return $ret; 
    }

    /*get badge count*/    
    public function get_badge_count($send_token,$token)
    {
       
        $val=$this->db->select('count(chat_id) as counts')
                    ->from('chat_table')
                    ->where('sender_token',$send_token)
                    ->where('receiver_token',$token)
                    ->where('status',1)
                    ->where('read_status',0)
                    ->get()->row();
        return $val;
    }

    

    /*get chat list*/
    public function get_chat_list($token)
    {
        $sent=[];
        $receive=[];
        $sent=$this->db->select('receiver_token as token')->
                        from('chat_table')->
                        where('sender_token',$token)->order_by('created_at','desc')->
                        get()->result_array();
        $receive=$this->db->select('sender_token as token')->
                        from('chat_table')->
                        where('receiver_token',$token)->order_by('created_at','desc')->
                        get()->result_array();

        $chat_tokens=(array_merge($receive,$sent));

        $test=[];
        foreach ($chat_tokens as $key => $value) {
           $test[]=$value['token'];
        }

        $token_detail=[];
        foreach (array_unique($test) as $key => $value) {
            $token_detail[]=$this->get_token_info($value);            
        }
        
        return $token_detail;
    }

    /*get chat history*/
    public function get_conversation_info($self_token,$partner_token)
    {
        // $return=$this->db->select('*')->
        //         from('chat_table')->
        //         where("(`sender_token` = '".$self_token."' AND `receiver_token` = '".$partner_token."') OR (`sender_token` = '".$partner_token."' AND `receiver_token` = '".$self_token."')")->
        //         where('status',1)->
        //         group_by('chat_id')->
        //         order_by('chat_id','ASC')->
        //         get()->result();
        // echo $this->db->last_query();exit;
        $this->db->select('*');
        $this->db->from('chat_table');
        $this->db->group_start();
        $this->db->where('sender_token', $self_token);
        $this->db->where('receiver_token', $partner_token);
        $this->db->or_where('sender_token', $partner_token);
        $this->db->where('receiver_token', $self_token);
        $this->db->group_end();
        $this->db->where('status', 1);
        $this->db->group_by('chat_id');
        $this->db->order_by('chat_id', 'ASC');

        $return = $this->db->get()->result();

        return $return;
    }

    /*insert msg*/	
    public function insert_msg($data)
    {
        $val=$this->db->insert("chat_table",$data);
        $insert_id = $this->db->insert_id();
        //echo $insert_id; exit;
        if(!empty($insert_id)) {
            $this->send_push_notification($data['receiver_token'], $insert_id, 1, $data['message']);
        }

        if($val){
          return true;
        }else{
          return false;
        }
    }

    /* push notification */

    public function send_push_notification($token, $user_id, $type, $msg) {

        $data = $this->get_token_info($token);
        //echo 'sd<pre>'; print_r($data); exit;
        if (!empty($data->type)) {
            if ($data->type == 1) {
                $device_tokens = $this->get_device_info_multiple($data->id, 1);
            } else {
                $device_tokens = $this->get_device_info_multiple($data->id, 2);
            }
            
            if ($data->type == 2) {
                $user_info = $this->get_user_info($data->id, $data->type);
            } else {
                $user_info = $this->get_user_info($data->id, $data->type);
            }


            /* insert notification */
            $msg = ucfirst(strtolower($msg));
            if (!empty($user_info['token'])) {
                $this->insert_notification($token, $user_info['token'], $msg);
            }

            if (!empty($device_tokens)) {
                foreach ($device_tokens as $key => $device) {
                    if (!empty($device['device_type']) && !empty($device['device_id'])) {
                        if (strtolower($device['device_type']) == 'android') {
                            $notify_structure = array(
                                'title' => $msg,
                                'message' => $msg,
                                'image' => 'test22',
                                'action' => 'test222',
                                'action_destination' => 'test222',
                            );

                            sendFCMMessage($notify_structure, $device['device_id']);
                        }

                        if (strtolower($device['device_type'] == 'ios')) {
                            $notify_structure = array(
                                'title' => $msg,
                                'message' => $msg,
                                'alert' => $msg,
                                'sound' => 'default',
                                'badge' => 0,
                            );
                            sendApnsMessage($notify_structure, $device['device_id']);
                        }
                    }
                }
            }
            /* apns push notification */
        }
    }

    public function insert_notification($sender, $receiver, $message) {
        $data = array(
            'sender' => $sender,
            'receiver' => $receiver,
            'message' => $message,
            'status' => 1,
            'utc_date_time' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $ret = $this->db->insert('notification_table', $data);
    }

    public function get_device_info_multiple($user_id, $user_type) {
        $val = $this->db->select('*')->from('device_details')->where('user_id', $user_id)->where('type', $user_type)->get()->result_array();
        return $val;
    }

    /*update*/
    public function update_info($where,$data,$table)
    {
        $this->db->where_in('chat_id',$where);
        $ret=$this->db->update($table,$data);
        return $ret;
    }

    public function get_user_token_info($token)
    {        
        $user_table=$this->db->select('*')->
                    from('users')->
                    where('token',$token)->
                    get()->row();
        return $user_table;  
    }

    public function get_provider_token_info($token) 
    {      
        $provider_table=$this->db->select('*')->
                        from('providers')->
                        where('token',$token)->
                        get()->row();
                        return $provider_table;
    }

    public function get_provider_chat_list($token) 
    {
        $sent=[];
        $receive=[];
        $sent=$this->db->select('receiver_token as token')->
                        from('chat_table')->
                        where('sender_token',$token)->order_by('created_at','desc')->
                        get()->result_array();
        $receive=$this->db->select('sender_token as token')->
                        from('chat_table')->
                        where('receiver_token',$token)->order_by('created_at','desc')->
                        get()->result_array();

        $chat_tokens=(array_merge($receive,$sent));

        $test=[];
        foreach ($chat_tokens as $key => $value) {
           $test[]=$value['token'];
        }

        $token_detail=[];
        foreach (array_unique($test) as $key => $value) {
            $token_detail[]=$this->get_provider_token_info($value);            
        }
    
        return $token_detail;
    }

    public function get_user_chat_list($token) 
    {
        $sent=[];
        $receive=[];
        $sent=$this->db->select('receiver_token as token')->
                    from('chat_table')->
                    where('sender_token',$token)->order_by('created_at','desc')->
                    get()->result_array();
        $receive=$this->db->select('sender_token as token')->
                    from('chat_table')->
                    where('receiver_token',$token)->order_by('created_at','desc')->
        get()->result_array();

        $chat_tokens=(array_merge($receive,$sent));

        $test=[];
        foreach ($chat_tokens as $key => $value) {
           $test[]=$value['token'];
        }

        $token_detail=[];
        foreach (array_unique($test) as $key => $value) {
            $token_detail[]=$this->get_user_token_info($value);        
        }    
        return $token_detail;
    }
 
    //delete chat
    public function delete_chat($self_token, $partner_token)
    {        
        $delete_chat=$this->db->query("UPDATE `chat_table` SET status=0, read_status=0  WHERE (sender_token =  '$self_token' AND receiver_token =  '$partner_token') OR (sender_token =  '$partner_token' AND receiver_token =  '$self_token') ");
        return $delete_chat;  
    }

} //Class end.

?>