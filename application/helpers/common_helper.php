<?php
if(!function_exists('settings')){
  
  function settings($val){
    $ci =& get_instance();
    $query = $ci->db->query("select * from system_settings");
    
    $settings = $query->result_array();
    
    $result=array();        
        
    if(!empty($settings)){
      foreach($settings as $datas){
        if($datas['key']=='currency_option'){
          $result['currency'] = $datas['value'];
        }
      }
    }
    
    if(!empty($result[$val])) {
      $results= $result[$val];
		}
		else {
      $results= 'INR';
	  }

    return $results;
 }

  function settingValue($key){
    if(!empty($key)){
      $ci =& get_instance();
      $settings_val = $ci->db->select('value')->where('key=',$key)->get('system_settings')->row();
      if($settings_val->value != ''&&$settings_val->value==0){
        $settings_val=($settings_val->value != '')?($settings_val->value):'0';
        return $settings_val; 
      } else {
        $settings_val=$settings_val?($settings_val->value):'';      
        if(!empty($settings_val)){
          return $settings_val;
        }else{
          return "";
        }
      }
    }
  }
  
  function updateExpiredService($id, $usertype){
   
      $ci =& get_instance();
      if($usertype == "user") {   
        $updateBooking = $ci->db->select('id,provider_id,user_id')->where('status',1)->where('user_id',$id)->where('service_date<',date('Y-m-d'))->get('book_service')->result();
      } elseif($usertype == "provider"){
        $updateBooking = $ci->db->select('id,provider_id,user_id')->where('status',1)->where('provider_id',$id)->where('service_date<',date('Y-m-d'))->get('book_service')->result();
      } 
     
      if($updateBooking !='') {
        foreach($updateBooking as $value) {
          $ci->db->query("UPDATE book_service SET status = 7,is_expired = 1, reason = 'Booking Expired.Booking is not confirmed by provider.'  WHERE id =? ", array($value->id));
        }
      }
     
  }
  

  function currencyConverter($from, $to) {
    $url = 'https://free.currconv.com/api/v7/convert?q=' . $from . '_' . $to . ',' . $to . '_' . $from . '&compact=ultra&apiKey=de2f3dcf8b88d2d760d4';

    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    
    $headers = array();
    $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    print_r($result);
  }
}

function removeTag($data){  
  foreach ($data as $key => $value) {
    if(!is_array($value)){
      $_POST[$key]=strip_tags($value);
    }
  }
  return $_POST;
}

//default timezone
function settingDefaultTimezone($key, $time_format){
  if(!empty($key)){
    // Time 00:30 AM is not accept for DateTime format Failed to parse time string (00:30 AM) at position 6 (A): The timezone could not be found in the database
    // Error On Service Availability List
    if(str_contains($key,"00:")){
      $key=str_replace("AM","",$key);
      $key=str_replace("am","",$key);
    }
    
    // Create a DateTime object from the time
    $date = new DateTime($key);    

    // Set the timezone to the desired timezone (retrieved from your settingValue function)
    $new_timezone = new DateTimeZone(settingValue('timezone'));
    $date->setTimezone($new_timezone);

    // Format the date in the new timezone
    $time_n = $date->format('Y-m-d H:i:s');
    if($time_format == 12) {
      $time_original_tz = $date->format('h:ia');
    } elseif($time_format == 24) {
      $time_original_tz = $date->format('H:i:s');
    } else {
      $time_original_tz = $date->format('G:ia');
    }
    return $time_original_tz;
  }
}


if(!function_exists('language_file_create')){
    function language_file_create(){
        $ci =& get_instance();
        $language=$ci->db->where('status',1)->get('language')->result_array();

        $en_language_array=$ci->db->where('language','en')->get('language_keywords_management')->result_array();
        $en_txt='';
        if(!empty($en_language_array)){
            foreach ($en_language_array as $lrows) {
                $en_key_value='lang["'.$lrows['lang_key'].'"]="";';
                $en_txt .= "\r\n".$en_key_value;
            }
        }

        if(!empty($language)){
            foreach ($language as $rows) {
                $path = APPPATH.'/language/'.strtolower($rows['language']);
                if(!is_dir($path)){
                  mkdir($path);                           
                }
                $new=false;
                if(file_exists($path.'/content_lang.php')){
                  $new=true;
                }
                // $language_management=$ci->db->where('language',$rows['language_value'])->get('language_keywords_management')->result_array();
                // if(!empty($language_management)){
                //     foreach ($language_management as $lrows) {
                //         $language_key_value='lang["'.$lrows['lang_key'].'"]="'.str_replace('"', '', $lrows['lang_value']).'";';
                //         $txt .= "\r\n".$language_key_value;
                //     }
                // } else {
                //     $lang_array = array(
                //         'lang_key' => $lrows['lang_key'],
                //         'lang_value' => $lrows['lang_value'],
                //         'language' => $rows['language_value'],
                //         'type' => 'admin'
                //     );
                //     $language_management_english=$ci->db->where('language','en')->get('language_keywords_management')->result_array();
                //     foreach ($language_management_english as $lrows) {
                //         $keys=$lrows['lang_key'];
                //         $language_key_value='lang["'.$keys.'"]="'.str_replace('"', '', $lrows['lang_value']).'";';
                //         $txt .= "\r\n".$language_key_value;
                //     }
                // }
                if($new==false){
                  $path = APPPATH.'/language/'.strtolower($rows['language']).'/';
                  $myfile = fopen($path. "content_lang.php", "w"); 
                  $txt ='<?php';
                  $txt .=$en_txt;
                  fwrite($myfile, $txt);
                  $rewritedata = file_get_contents($path.'content_lang.php');
                  // $rewritedata = str_replace('lang', '$lang', $rewritedata);
                  $rewritedata = str_replace('lang["', '$lang["', $rewritedata);
                  write_file($path.'content_lang.php', $rewritedata);
                  fclose($myfile);
                }else{

                }
            } 
        }  
    }
}


if(!function_exists('language_module_file_create')){
    function language_module_file_create($lang,$keys,$value){
        $ci =& get_instance();
        $rows=$ci->db->where('language_value',$lang)->get('language')->row_array();
        if(!empty($rows))
        {
              $path = APPPATH.'/language/'.strtolower($rows['language']);
              $file_path = APPPATH.'/language/'.strtolower($rows['language']).'/content_lang.php';
              $new=false;
              if(!is_dir($path)){
                mkdir($path); 
              }
              if(!is_file($file_path)){
                $new=true;
              }
                            
              $key_to_update = $keys;
              $new_value = $value;

              // Open the file for reading
              $file_content = file_get_contents($file_path);

              // Use a regular expression to check if the key exists
              $pattern = '/(\$lang\["' . preg_quote($key_to_update, '/') . '"\]\s*=\s*)("([^"]*)")/';
              $matches = [];
              $key_exists = preg_match($pattern, $file_content, $matches);

              if ($key_exists) {
                  // If the key exists, update the value
                  $new_content = preg_replace($pattern, '$1"' . addslashes($new_value) . '"', $file_content);
              } else {
                  if($new==true){
                    $new_content = $file_content . "<?php\n\$lang[\"$key_to_update\"] = \"$new_value\";";
                  }
                  else{
                    $new_content = $file_content . "\n\$lang[\"$key_to_update\"] = \"$new_value\";";
                  }
              }
              file_put_contents($file_path, $new_content);
        }  
    }
}

if(!function_exists('language_file_content_change')){
  function language_file_content_change($language_code){
      $ci =& get_instance();
      $rows=$ci->db->where('language_value',$language_code)->get('language')->row_array();
      
      $path = APPPATH.'/language/'.strtolower($rows['language']);
      if(!is_dir($path)){
        mkdir($path);                           
      }
      $txt ='<?php';
      $language_management=$ci->db->where('language',$rows['language_value'])->get('language_keywords_management')->result_array();
      if(!empty($language_management)){
          foreach ($language_management as $lrows) {
              $language_key_value='lang["'.$lrows['lang_key'].'"]="'.str_replace('"', '', $lrows['lang_value']).'";';
              $txt .= "\r\n".$language_key_value;
          }
      }
      
      $path = APPPATH.'/language/'.strtolower($rows['language']).'/';
      $myfile = fopen($path. "content_lang.php", "w"); 
      
      fwrite($myfile, $txt);
      $rewritedata = file_get_contents($path.'content_lang.php');
      $rewritedata = str_replace('lang["', '$lang["', $rewritedata);
      write_file($path.'content_lang.php', $rewritedata);
      fclose($myfile);     
  
  }
}
?>