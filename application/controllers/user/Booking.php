<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        error_reporting(0);
        if (empty($this->session->userdata('id'))) {
            redirect(base_url());
        }
        $this->data['theme'] = 'user';
        $this->data['model'] = 'home';
        $this->data['base_url'] = base_url();

        $this->load->helper('custom_language');
        $this->load->helper('push_notifications');

        $this->load->model('booking_model', 'booking');
        $this->load->model('service_model', 'service');

        $this->load->model('api_model', 'api');
        $this->load->model('home_model', 'home');
		$this->site_name ='Truelysell';
        $this->load->model('templates_model');

        $this->load->helper('user_timezone_helper');
        $user_id = $this->session->userdata('id');
        $this->data['user_id'] = $user_id;
        $this->load->helper('subscription_helper');



        $this->data['secret_key'] = '';

        $this->data['publishable_key'] = '';

        $this->data['website_logo_front'] = 'assets/img/logo.png';

        $publishable_key = '';
        $secret_key = '';
        $live_publishable_key = '';
        $live_secret_key = '';
        $stripe_option = '';


        $query = $this->db->query("select * from system_settings WHERE status = 1");
        $result = $query->result_array();
        if (!empty($result)) {
            foreach ($result as $data) {

                if ($data['key'] == 'website_name') {
                    $this->website_name = $data['value'];
                }


                if ($data['key'] == 'secret_key') {

                    $secret_key = $data['value'];
                }

                if ($data['key'] == 'publishable_key') {

                    $publishable_key = $data['value'];
                }

                if ($data['key'] == 'live_secret_key') {

                    $live_secret_key = $data['value'];
                }

                if ($data['key'] == 'live_publishable_key') {

                    $live_publishable_key = $data['value'];
                }

                if ($data['key'] == 'stripe_option') {

                    $stripe_option = $data['value'];
                }

                if ($data['key'] == 'logo_front') {
                    $this->data['website_logo_front'] = $data['value'];
                }
            }
        }


        if (@$stripe_option == 1) {

            $this->data['publishable_key'] = $publishable_key;

            $this->data['secret_key'] = $secret_key;
        }

        if (@$stripe_option == 2) {

            $this->data['publishable_key'] = $live_publishable_key;

            $this->data['secret_key'] = $live_secret_key;
        }


        $config['publishable_key'] = $this->data['publishable_key'];

        $config['secret_key'] = $this->data['secret_key'];

        $this->load->library('stripe', $config);


        if (!$this->session->userdata('id')) {
            redirect(base_url());
        }

        $default_language_select = default_language();

        if ($this->session->userdata('user_select_language') == '') {
            $this->data['user_selected'] = $default_language_select['language_value'];
        } else {
            $this->data['user_selected'] = $this->session->userdata('user_select_language');
        }

        $this->data['active_language'] = $active_lang = active_language();

        $lg = custom_language($this->data['user_selected']);

        $this->data['default_language'] = $lg['default_lang'];

        $this->data['user_language'] = $lg['user_lang'];

        $this->user_selected = (!empty($this->data['user_selected'])) ? $this->data['user_selected'] : 'en';

        $this->default_language = (!empty($this->data['default_language'])) ? $this->data['default_language'] : '';

        $this->user_language = (!empty($this->data['user_language'])) ? $this->data['user_language'] : 'en';

        
    }

    public function index() {
        redirect(base_url('book-service'));
    }

    public function book_service() {

        $user_currency = get_user_currency();
        $user_currency_code = $user_currency['user_currency_code'];
        
        removeTag($this->input->post());
        $time = $this->input->post('booking_time');
        $booking_time = explode('-', $time);
        $start_time = strtotime($booking_time[0]);
        $end_time = strtotime($booking_time[1]);
        $from_time = date('G:i:s', ($start_time));
        $to_time = date('G:i:s', ($end_time));

        $inputs = array();
        $service_id = $this->input->post('service_id'); // Package ID
        $records = $this->booking->get_service($service_id);
        $inputs['service_id'] = $service_id;
        $inputs['provider_id'] = $this->input->post('provider_id');
        $inputs['user_id'] = $this->session->userdata('id');
        $inputs['provider_id'] = $this->input->post('provider_id');
        $inputs['currency_code'] = $user_currency_code;
        $inputs['tax_details'] = json_encode($this->input->post('tax_details'));

        $inputs['token'] = 'old type';
        $inputs['service_id'] = $service_id;
        $inputs['provider_id'] = $this->input->post('provider_id');
        $inputs['user_id'] = $this->session->userdata('id');
        $inputs['amount'] = get_gigs_currency($records['service_amount'], $records['currency_code'], $user_currency_code);
        $inputs['service_date'] = date('Y-m-d', strtotime($this->input->post('booking_date')));
        $inputs['location'] = $this->input->post('service_location');
        $inputs['latitude'] = $this->input->post('service_latitude');
        $inputs['longitude'] = $this->input->post('service_longitude');
        $inputs['from_time'] = $from_time;
        $inputs['to_time'] = $to_time;
        $inputs['notes'] = $this->input->post('notes');
		$inputs['cod'] = $this->input->post('cod');
        $inputs['args'] = 'no response that field ld flow';
        $addiamt = 0;
        
       
        //check appointment settings auto confirm
        $appointment_settings = $this->service->check_provider_settings_interval($this->input->post('provider_id'));
        $auto_confirm_showhide = settingValue('appointment_auto_confirm_showhide');

         if(!empty($appointment_settings)) {
            ($appointment_settings->auto_confirm == 1)? $inputs['status'] = 2: $inputs['status'] = 1;
         } else {
            ($auto_confirm_showhide == 1)?$inputs['status'] = 2: $inputs['status'] = 1;
         }
       
        //additional service
		if(!empty($this->input->post('addiser'))){
			$inputs['additional_services'] = implode(',', $this->input->post('addiser'));
			$addiamt = array_sum($this->input->post('addiamt'));
		}
        $total_tax_cal = 0;
        if(settingValue('tax_module') == 1) {
            $taxes = $this->service->taxList();
           
            foreach($taxes as $tax) {
                $totalAmountAdditional = $inputs['amount'] + $addiamt;
                $tax_cal = ($totalAmountAdditional) *($tax['tax_percent']/100);
                $total_tax_cal += $tax_cal;
            }
        }
       
        //Total Calculation 
		$inputs['amount'] = $inputs['amount'] + $addiamt +$total_tax_cal;
      
		if($inputs['amount'] <= 0) $inputs['amount'] = 0;
        //check server side validation while booking
		$this->load->model('api_model', 'api');
		$wallet = $this->api->get_wallet($this->session->userdata('chat_token'));

		$curren_wallet = $wallet['wallet_amt'];

		/* check wallet amount */
		if($inputs['cod'] == 2){ // not cod
			if ($inputs['amount'] > $curren_wallet) {
                $message = (!empty($this->user_language[$this->user_selected]['lg_wallet_topup_error'])) ? $this->user_language[$this->user_selected]['lg_wallet_topup_error'] : $this->default_language['en']['lg_wallet_topup_error'];
				$this->session->set_flashdata('error_message', $message);
				echo json_encode(['success' => false, 'msg' => $message, 'status' => 2]);
				exit;
			}
		}
		/* check wallet amount */

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
                        $message = (!empty($this->user_language[$this->user_selected]['lg_Booking_Not_Available'])) ? $this->user_language[$this->user_selected]['lg_Booking_Not_Available'] : $this->default_language['en']['lg_Booking_Not_Available'];
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

                       
                       
                        $i = 1;
                       
					    foreach ($new_timingarray as $booked_time) {

                            $booked_start_hour = date('H', strtotime($booked_time['start_time']));
                            $booked_end_hour = date('H', strtotime($booked_time['end_time']));
                            $from_start_hour = date('H', strtotime($from_time_railwayhrs));
                            $from_end_hour = date('H', strtotime($to_time_railwayhrs));
                           
                        //old availa
                          
                            // if ($booked_time['start_time'] == $from_time_railwayhrs && $booked_time['end_time'] == $to_time_railwayhrs) {
                            //     $booking = true;
						    // }
                            // if ($booked_time['start_time'] == $from_time_railwayhrs && strtotime($booked_time['end_time']) > $timestamp_end_railwayhrs) {
                            //     $booking = true;
						    // }

                            if ($booked_start_hour == $from_start_hour && $booked_end_hour == $from_end_hour) {
                                $booking = true;
						    }
                            if ($booked_start_hour == $from_time_railwayhrs && ($booked_end_hour) > $from_end_hour) {
                                $booking = true;
						    }
                            //old end
                        }
                        
                        $bookCheck = $this->db->where(array('service_id'=>$service_id,'service_date'=>$service_date,'from_time'=>$from_time_railwayhrs))->get('book_service')->num_rows();
                        
                        if($bookCheck > 0) {
                          
                            $booking = false;
                        }
                       
                            if ($booking == false) {                                                            
                                $message = (!empty($this->user_language[$this->user_selected]['lg_Booking_Exists'])) ? $this->user_language[$this->user_selected]['lg_Booking_Exists'] : $this->default_language['en']['lg_Booking_Exists'];
                                $this->session->set_flashdata('error_message', $message);
                                echo json_encode(['success' => false, 'msg' => $message, 'status' => 3]);
                                exit;
                            }             
                    }
                   
        $result = $this->booking->booking_success($inputs);
       
        if ($result != '') {
           
            $this->data['user'] = $this->session->userdata();

			if($inputs['cod'] == 1){	
				$codData['book_id'] = $result;
				$codData['user_id'] = $this->session->userdata('id');	
				$codData['provider_id'] = $this->input->post('provider_id');	
				$codData['amount'] = $inputs['amount'];	
				$codData['created_on'] = date('Y-m-d');	
				$this->db->insert('book_service_cod', $codData);	
			}
			
			$service=$this->db->where('id',$service_id)->from('services')->get()->row_array();
			$this->data['service'] = $service;
			
			$provider_data = $this->db->where('id',$this->input->post('provider_id'))->from('providers')->get()->row_array();
			$user_data = $this->db->where('id',$this->session->userdata('id'))->from('users')->get()->row_array();
			$this->data['provider'] = $provider_data;
			
			//$preview_link = base_url();
			$bodyid = 2;
			$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
			$body = $tempbody_details['template_content'];
			$body = str_replace('{user_name}', $this->session->userdata('name'), $body);
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
                  $to_email = $this->session->userdata('email');
                  $subject = "Service Booking";
                  $message = $body;
                  $this->load->library('sendemail');
                  $send_mail = $this->sendemail->sendgrid_email($from_email,$to_email,$subject,$message);
                } else {
                    $this->load->library('email');
                    if (!empty($from_email) && isset($from_email)) {
                        $mail = $this->email
                                ->from($from_email)
                                ->to($this->session->userdata('email'))
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
			$providerbody = str_replace('{user_person}',$this->session->userdata('name'), $providerbody);
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
           
            
            $message = (!empty($this->user_language[$this->user_selected]['lg_Booking_Success'])) ? $this->user_language[$this->user_selected]['lg_Booking_Success'] : $this->default_language['en']['lg_Booking_Success'];

            $token = $this->session->userdata('chat_token');

            /* history entry */
			if($inputs['cod'] == 2){ // not cod	
				$this->api->booking_wallet_history_flow($result, $token);	
			}

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

            $providerInfo = $this->db->select('*')->
            from('providers')->
            where('id', (int) $inputs['provider_id'])->
            get()->row_array();

            if (!empty($providerInfo['id']))
            {
                $provider_address = $this->db->select('*')->
                from('provider_address')->
                where('provider_id', (int) $providerInfo['id'])->
                get()->row_array();
            }
            $smsMsg = '';
            try {
//                $msg = "কাস্টমার নাম: ${$user_data['name']}, মোবাইল: ${$user_data['mobileno']}, কোর্স: ${$records['service_title']}, দাম: ${$records['service_amount']}। আগ্রহী, তিনি হয়তো আপনাকে কল করবেন অথবা আপনি তাকে অফিস দেখার জন্য কল করতে পারেন। Dorker.xyz";
                $msg = 'কাস্টমার নাম: '.$user_data['name'].', মোবাইল: '.$user_data['mobileno'].', কোর্স: '.$records['service_title'].', দাম: '.$records['service_amount'].'। আগ্রহী, তিনি হয়তো আপনাকে কল করবেন অথবা আপনি তাকে অফিস দেখার জন্য কল করতে পারেন। Dorker.xyz';
                $smsResponse = About::send_sms($providerInfo['mobileno'], $msg);
                if (!empty($smsResponse))
                    $smsMsg = $smsResponse['message'];

            } catch (Exception $exception)
            {
                $smsMsg = 'Something went wrong. Please try again';
            }

			echo json_encode(['success' => true, 'smsMsg' = $smsMsg, 'msg' => $message, 'status' => 1, 'provider' => $providerInfo, 'provider_address' => $provider_address['address'] ?? '']);
        } else {
            $message = (!empty($this->user_language[$this->user_selected]['lg_something_went_wrong'])) ? $this->user_language[$this->user_selected]['lg_something_went_wrong'] : $this->default_language['en']['lg_something_went_wrong'];
            $this->session->set_flashdata('error_message', $message);
			 echo json_encode(['success' => true, 'msg' => $message, 'status' => 3]);
        }
       
        exit;
    }

    /* stripe booking method OLD METHOD */

    public function stripe_payment() {

        $time = $this->input->post('booking_time');
        $booking_time = explode('-', $time);
        $start_time = strtotime($booking_time[0]);
        $end_time = strtotime($booking_time[1]);
        $from_time = date('G:i:s', ($start_time));
        $to_time = date('G:i:s', ($end_time));

        $inputs = array();
        $service_id = $this->input->post('service_id'); // Package ID
        $records = $this->booking->get_service($service_id);
        $inputs['service_id'] = $service_id;
        $inputs['provider_id'] = $this->input->post('provider_id');
        $inputs['user_id'] = $this->session->userdata('id');
        $inputs['provider_id'] = $this->input->post('provider_id');


        $inputs['token'] = $this->input->post('tokenid');
        $charges_array = array();
        $amount = (!empty($records['service_amount'])) ? $records['service_amount'] : 2;
        $amount = ($amount * 100);
        $charges_array['amount'] = $amount;
        $charges_array['currency'] = settings('currency');
        $charges_array['description'] = (!empty($records['service_amount'])) ? $records['service_amount'] : 'Booking';
        $charges_array['source'] = 'tok_visa';


        $result = $this->stripe->stripe_charges($charges_array);


        $result = json_decode($result, true);
        if (empty($result['error'])) {
            $inputs['token'] = $result['id'];
            $inputs['service_id'] = $service_id;
            $inputs['provider_id'] = $this->input->post('provider_id');
            $inputs['user_id'] = $this->session->userdata('id');
            $inputs['amount'] = $records['service_amount'];
            $inputs['service_date'] = date('Y-m-d', strtotime($this->input->post('booking_date')));
            $inputs['location'] = $this->input->post('service_location');
            $inputs['latitude'] = $this->input->post('service_latitude');
            $inputs['longitude'] = $this->input->post('service_longitude');
            $inputs['from_time'] = $from_time;
            $inputs['to_time'] = $to_time;
            $inputs['notes'] = $this->input->post('notes');
            $inputs['args'] = json_encode($result);
            $result = $this->booking->booking_success($inputs);
            if ($result != '') {


                $message = (!empty($this->user_language[$this->user_selected]['lg_Booking_Success'])) ? $this->user_language[$this->user_selected]['lg_Booking_Success'] : $this->default_language['en']['lg_Booking_Success'];

                $token = $this->session->userdata('chat_token');

                $data = $this->api->get_book_info_b($result);
                $device_token = $this->api->get_device_info_multiple($data['provider_id'], 1);

                $user_name = $this->api->get_user_info($data['user_id'], 2);

                $provider_token = $this->api->get_user_info($data['provider_id'], 1);

                /* Get push notification text based on User or Providers language */
                $user_lang = $this->db->get_where('providers', array('id'=>$data['provider_id']))->row()->language;
                $user_language = ($user_lang)?$user_lang:'en';
                $lang_key = 'lg_has_booked_your_service';
                $lang_value = $this->home->getNotificationLangText($user_language, $lang_key);
            
                $text = $user_name['name']." ".$lang_value;
               
                $this->send_push_notification($token, $result, 1, $msg = $text);


                $this->session->set_flashdata('success_message', $message);
            } else {
                $message = (!empty($this->user_language[$this->user_selected]['lg_something_went_wrong'])) ? $this->user_language[$this->user_selected]['lg_something_went_wrong'] : $this->default_language['en']['lg_something_went_wrong'];
                $this->session->set_flashdata('error_message', $message);
            }
        } else {
            $inputs['token'] = 'Issue - token_already_used';
            $message = (!empty($this->user_language[$this->user_selected]['lg_something_went_wrong'])) ? $this->user_language[$this->user_selected]['lg_something_went_wrong'] : $this->default_language['en']['lg_something_went_wrong'];
            $this->session->set_flashdata('error_message', $message);
        }

        echo json_encode($result);
    }

    /* stripe booking method OLD METHOD */

    public function stripe_payments() {
        $inputs = array();
        $sub_id = $this->input->post('sub_id'); // Package ID
        $records = $this->subscription->get_subscription($sub_id);
        $inputs['subscription_id'] = $sub_id;
        $inputs['user_id'] = $this->session->userdata('id');


        $inputs['token'] = 'Free subscription';
        $inputs['args'] = '';
        $result = $this->subscription->subscription_success($inputs);
        if ($result) {
            $message = (!empty($this->user_language[$this->user_selected]['lg_Subscription_Success'])) ? $this->user_language[$this->user_selected]['lg_Subscription_Success'] : $this->default_language['en']['lg_Subscription_Success'];
            $this->session->set_flashdata('success_message', $message);
        } else {
            $message = (!empty($this->user_language[$this->user_selected]['lg_something_went_wrong'])) ? $this->user_language[$this->user_selected]['lg_something_went_wrong'] : $this->default_language['en']['lg_something_went_wrong'];
            $this->session->set_flashdata('error_message', $message);
        }

        echo json_encode($result);
    }

    /* push notification */

    public function send_push_notification($token, $service_id, $type, $msg) {

        $data = $this->api->get_book_info($service_id);
        if (!empty($data)) {
            if ($type == 1) {
                $device_tokens = $this->api->get_device_info_multiple($data['provider_id'], 1);
            } else {
                $device_tokens = $this->api->get_device_info_multiple($data['user_id'], 2);
            }
            if ($type == 2) {
                $user_info = $this->api->get_user_info($data['user_id'], $type);
            } else {
                $user_info = $this->api->get_user_info($data['provider_id'], $type);
            }



            /* insert notification */
            $msg = ucfirst(strtolower($msg));
            if (!empty($user_info['token'])) {
                $this->api->insert_notification($token, $user_info['token'], $msg);
            }

            $title = $data['service_title'];


            if (!empty($device_tokens)) {
                foreach ($device_tokens as $key => $device) {
                    if (!empty($device['device_type']) && !empty($device['device_id'])) {

                        if (strtolower($device['device_type']) == 'android') {

                            $notify_structure = array(
                                'title' => $title,
                                'message' => $msg,
                                'image' => 'test22',
                                'action' => 'test222',
                                'action_destination' => 'test222',
                            );

                            sendFCMMessage($notify_structure, $device['device_id']);
                        }

                        if (strtolower($device['device_type'] == 'ios')) {
                            $notify_structure = array(
                                'title' => $title,
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
        } else {
            $this->token_error();
        }
    }

    public function refund_request(){
        $inp = $this->input->post();
        $results = $this->db->get_where('book_service',array('id'=>$inp['id']))->row_array();
       
        // Check if the refund request already exists
        $existingRefund = $this->db->get_where('refund_request', array('booking_id' => $results['id']))->row_array();
        if ($existingRefund) {
         echo json_encode("Refund request already exists");
         return;
        }$refund_val = array(
            'booking_id' => $results['id'],
            'provider_id' => $results['provider_id'],
            'user_id' => $results['user_id'],
            'service_id' => $results['service_id'],
            'reason' => $inp['reason'],
            'status' => 0,
            'amount' => $results['amount'],
            'created_at' => date('Y-m-d')
        );
        $this->db->insert('refund_request',$refund_val);
        $this->db->where_in('id',$results['id']);
        $this->db->set('status', 9);
        $this->db->set('updated_on', date('Y-m-d H:i:s'));
        $this->db->update('book_service');
        echo json_encode("success");
    }

}
