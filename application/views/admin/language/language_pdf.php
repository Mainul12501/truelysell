<title><?php 
$user_lang = ($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
$this->db->where('modules', 'seo');
$this->db->where('lang_type', $user_lang);
$lang_seo_check = $this->db->get('seo')->row_array();
echo $lang_seo_check['meta_title'];?></title>
<?php
  
require_once(APPPATH . '../vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf();
$html = '
<div style="border:1px solid #ececec;">
<div style="padding:20px">
<h3>Truelysell - Languages</h3>
<table style="border:1px solid #ececec;font-family:lato;border-spacing: 0px;" cellpadding="20" width="100%" cellspacing="20">
<tr>
<td style="border-right:none;"><b>#</b></td>
<td style="border-right:none;"><b>Language</b></td>
<td style="border-right:none;"><b>Code</b></td> 
<td style="border-right:none;"><b>Total</b></td>
<td style="border-right:none;"><b>Done</b></td>         
<td style="border-right:none;"><b>Progress</b></td>                                            
</tr>';                              
$i=1;
foreach ($language as $lang) {  
  $count_done_keywords = count($this->db->get_where('language_keywords_management', array('language'=> $lang['language_value']))->result());
  $donePercent = ($count_done_keywords/$total_keyword_count)*100;
  $html .= '<tr align="center">
  <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">'.$i++.'</td>
  <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">'.$lang['language'].'</td>
  <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">'.$lang['language_value'].'</td>
  <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">'.$total_keyword_count.'</td>
  <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">'.$count_done_keywords.'</td>
  <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">'.round($donePercent).'</td>

  </tr>';
}
$html .= '</table>
</div>
</div>';

  //  echo $html; // HTML 

/* PDF VIew */
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->curlAllowUnsafeSslRequests = true;  //This code is used for windows server 
$mpdf->WriteHTML($html);
$mpdf->Output("Language-list.pdf","I");