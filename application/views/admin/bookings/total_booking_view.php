<?php
$category = $this->db->get('categories')->result_array();
$subcategory = $this->db->get('subcategories')->result_array();
$services = $this->db->get('services')->result_array();
$user_list = $this->db->get('users')->result_array();
$provider_list = $this->db->select('id,name')->where('delete_status',0)->get('providers')->result_array();

$servie_staus = array(
array("id"=>2,'value'=>'Inprogress'),
array("id"=>3,'value'=>'Provider Complete'),
array("id"=>4,'value'=>'Accept User Request'),
array("id"=>5,'value'=>'Reject'),
array("id"=>6,'value'=>'Complete'),
array("id"=>7,'value'=>'Cancel'),
array("id"=>8,'value'=>'Cod Completed'),
array("id"=>9,'value'=>'Waiting for approval'),
array("id"=>10,'value'=>'Approved'),
array("id"=>12,'value'=>'Reschedule')
);


$booking = $language_content;
?>
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title"><?php echo(!empty($booking['lg_admin_booking_list']))?($booking['lg_admin_booking_list']) : 'Booking List';  ?></h3>
				</div>
				<div class="col-auto text-right">
					<a href="<?php echo $base_url; ?>admin/total-report" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>
					<a class="btn btn-white filter-btn mr-3" href="javascript:void(0);" id="filter_search">
						<i class="fas fa-filter"></i>
					</a>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<!-- Search Filter -->
		<form action="<?php echo base_url();?>admin/total-report" method="post" id="filter_inputs">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    

			<div class="card filter-card">
				<div class="card-body pb-0">
					<div class="row filter-row">
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label><?php echo(!empty($booking['lg_admin_service_title']))?($booking['lg_admin_service_title']) : 'Service Title';  ?></label>
								<select class="form-control" id="service_id_f" name="service_title">
									<option value=""> <?php echo(!empty($booking['lg_admin_select_service']))?($booking['lg_admin_select_service']) : 'Select service';  ?></option>
									<?php foreach ($services as $pro) {
									if(!empty($filter['service_t'])==$pro['id']){
										$select='selected';
									}else{
										$select='';
									}
									$ser_lang = ($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
                                    $this->db->where('service_id', $pro['id']);
                                    $this->db->where('lang_type', $ser_lang);
                                    $service_name = $this->db->get('service_lang')->row_array();
									?>
									<option <?=$select;?> value="<?=$pro['id']?>"><?php echo $service_name['service_name']??"";?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label><?php echo(!empty($booking['lg_admin_status']))?($booking['lg_admin_status']) : 'Status';  ?></label>
								<select class="form-control" id="status_f" name="service_status">
									<option value=""><?php echo(!empty($booking['lg_admin_select_status']))?($booking['lg_admin_select_status']) : 'Select Status';  ?></option>
									<?php foreach ($servie_staus as $pro) {
									if(!empty($filter['service_s'])==$pro['id']){
										$select='selected';
									}else{
										$select='';
									}
									?>
									<option  value="<?=$pro['id']?>"><?php echo $pro['value']?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo(!empty($booking['lg_admin_user']))?($booking['lg_admin_user']) : 'User';  ?></label>
								<select class="form-control" id="user_id_f" name="user_id">
									<option value=""><?php echo(!empty($booking['lg_admin_select_user']))?($booking['lg_admin_select_user']) : 'Select User';  ?></option>
									<?php foreach ($user_list as $user) {
										
									if(!empty($filter['user_i'])==$user['id']){
										$select='selected';
									}else{
										$select='';
									}
									$user_lang = ($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
			                        $this->db->where('modules', 'user');
			                        if (!empty($user['id'])) {
			                        $this->db->where('name_id', $user['id']);
			                        }
			                        $this->db->where('lang_type', $user_lang);
			                        $lang_user = $this->db->get('users_lang')->row_array();
									$user_name = (!empty($lang_user['name'])) ? $lang_user['name'] : $user['name'];
									?>

									<option value="<?=$pro['id']?>"><?php echo ucfirst($user_name);?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo(!empty($booking['lg_admin_provider']))?($booking['lg_admin_provider']) : 'Provider';  ?></label>
								<select class="form-control" id="provider_id_f" name="provider_id">
									<option value=""><?php echo(!empty($booking['lg_admin_select_provider']))?($booking['lg_admin_select_provider']) : 'Select Provider';  ?></option>
									<?php foreach ($provider_list as $pro) {
									if(isset($filter['provider_i'])==$pro['id']){
										$select='selected';
									}else{
										$select='';
									}
									$user_lang = ($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
			                        $this->db->where('modules', 'provider');
			                        if (!empty($pro['id'])) {
			                        $this->db->where('name_id', $pro['id']);
			                        }
			                        $this->db->where('lang_type', $user_lang);
			                        $lang_pro = $this->db->get('users_lang')->row_array();
									$pro_name = (!empty($lang_pro['name'])) ? $lang_pro['name'] : $pro['name'];
									?>
									<option  value="<?=$pro['id']?>"><?php echo ucfirst($pro_name);?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo(!empty($booking['lg_admin_from_date']))?($booking['lg_admin_from_date']) : 'From Date';  ?></label>
								<div class="cal-icon">
									<?php
									if(!empty($filter['service_from'])){
										$fr_date=$filter['service_from'];
									}else{
										$fr_date='';
									}
									if(!empty($filter['service_to'])){
										$to_date=$filter['service_to'];
									}else{
										$to_date='';
									}
									?>
									<input class="form-control start_date" type="text" id="from_f" name="from" value="<?=$fr_date;?>">
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo(!empty($booking['lg_admin_to_date']))?($booking['lg_admin_to_date']) : 'To Date';  ?></label>
								<div class="cal-icon">
									<input class="form-control end_date" type="text" id="to_f" name="to" value="<?=$to_date;?>">
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="form-group">
								<button class="btn btn-primary btn-block" name="form_submit" value="submit" type="submit"><?php echo(!empty($booking['lg_admin_submit']))?($booking['lg_admin_submit']) : 'Submit';  ?></button>
							</div>
						</div>
					</div>

				</div>
			</div>
		</form>
		<!-- /Search Filter -->

		<ul class="nav nav-tabs menu-tabs">
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo base_url().'admin/total-report'; ?>"><?php echo(!empty($booking['lg_admin_all_booking']))?($booking['lg_admin_all_booking']) : 'All Booking';  ?> <span class="badge badge-primary"><?=$all_booking;?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/pending-report'; ?>"><?php echo(!empty($booking['lg_admin_pending']))?($booking['lg_admin_pending']) : 'Pending';  ?> <span class="badge badge-primary"><?=$pending;?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/inprogress-report'; ?>"><?php echo(!empty($booking['lg_admin_inprogress']))?($booking['lg_admin_inprogress']) : 'InProgress';  ?> <span class="badge badge-primary"><?=$inprogress;?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/complete-report'; ?>"><?php echo(!empty($booking['lg_admin_completed']))?($booking['lg_admin_completed']) : 'Completed';  ?> <span class="badge badge-primary"><?=$completed;?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/reject-report'; ?>"><?php echo(!empty($booking['lg_admin_rejected']))?($booking['lg_admin_rejected']) : 'Rejected';  ?> <span class="badge badge-primary"><?=$rejected;?></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url().'admin/cancel-report'; ?>"><?php echo(!empty($booking['lg_admin_canceled']))?($booking['lg_admin_canceled']) : 'Canceled';  ?> <span class="badge badge-primary"><?=$cancelled;?></span></a>
			</li>
		</ul>
		
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive total-booking-report">
							<table class="table table-hover table-center mb-0 service_table" >
                                <thead>
                                    <tr>
                                        <th><?php echo(!empty($booking['lg_admin_#']))?($booking['lg_admin_#']) : '#';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_date']))?($booking['lg_admin_date']) : 'Date';  ?></th>
                                        <th><?php echo(!empty($booking['lg_Booking_time']))?($booking['lg_Booking_time']) : 'Booking Time';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_user']))?($booking['lg_admin_user']) : 'User';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_provider']))?($booking['lg_admin_provider']) : 'Provider';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_service']))?($booking['lg_admin_service']) : 'Service';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_amount']))?($booking['lg_admin_amount']) : 'Amount';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_status']))?($booking['lg_admin_status']) : 'status';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_updated']))?($booking['lg_admin_updated']) : 'Updated';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_action']))?($booking['lg_admin_action']) : 'Action';  ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($list)) {
                                    $i=1;
                                    foreach ($list as $rows) {

									if(file_exists($rows['user_profile_img'])){
										$user_image = $rows['user_profile_img'];
									} else {
										$user_image ='assets/img/user.jpg';
									}
									if(file_exists($rows['provider_profile_img'])) {
										$provider_image = $rows['provider_profile_img'];
									} else {
										$provider_image ='assets/img/user.jpg';
									}
									if(!empty($rows['service_date'])){
										$service_date=date(settingValue('date_format'), strtotime($rows['service_date']));
									}else{
										$service_date='-';
									}
									$datef = explode(' ', $rows['updated_on']);
									
									if(settingValue('time_format') == '12 Hours') {
										$time_format = 12;
										$time = settingDefaultTimezone($datef[1],$time_format);
  
									} elseif(settingValue('time_format') == '24 Hours') {
										$time_format = 24;
										$time = settingDefaultTimezone($datef[1],$time_format);
											 
									} else {
										$time_format = 0;
										$time = settingDefaultTimezone($datef[1],$time_format);
									   
									}            

	                                $date = date(settingValue('date_format'), strtotime($datef[0]));
	                                $timeBase = $date.' '.$time;
									if(settingValue('time_format') == '12 Hours') {
										$time_format = 12;
										$from_time = settingDefaultTimezone($rows['from_time'],$time_format);
										$to_time = settingDefaultTimezone($rows['to_time'],$time_format);
		                               
										$booking_time = $from_time.' - '.$to_time;
		                            } else if(settingValue('time_format') == '24 Hours'){
										$time_format = 24;
										$from_time = settingDefaultTimezone($rows['from_time'],$time_format);
										$to_time = settingDefaultTimezone($rows['to_time'],$time_format);
		                            	
										$booking_time = $from_time.' - '.$to_time;
		                            } else {
										$time_format = 0;
										$from_time = settingDefaultTimezone($rows['from_time'],$time_format);
										$to_time = settingDefaultTimezone($rows['to_time'],$time_format);
										$booking_time = $from_time.' - '.$to_time;
		                            	
		                            }
									$badge='';
									$color='';
									if ($rows['status']==1) {
										$badge='Pending';
										$color='dark';
									}
									if ($rows['status']==2) {
										$badge='Inprogress';
										$color='info';
									}
									if ($rows['status']==3) {
										$badge='Complete Request';
										$color='primary';
									}
									if ($rows['status']==4) {
										$badge='Accepted';
										$color='purple';
									}
									if ($rows['status']==5) {
										if($rows['admin_change_status'] == 0) { $badge='Rejected by Provider'; }
										else  { $badge='Rejected'; }
										$color='warning';
									} 
									if ($rows['status']==6 && $rows['cod']==1) {
										$badge='Service Completed & Payment Pending';
										$color='primary';
									} 
									if ($rows['status']==6 && $rows['cod']==2) {
										$badge='Completed';
										$color='success';
									} 
									if ($rows['status']==7) {
										if($rows['admin_change_status'] == 0) { $badge='Cancelled by User'; }
										else  { $badge='Cancelled'; }
										$color='danger';
									}
									if ($rows['status']==8) {
										$badge='Completed';
										$color='success';
									}
									if ($rows['status']==9) {
										$badge='Waiting For Admin Refund Approval';
										$color='danger';
									}
									if ($rows['status']==10) {
										$badge='Refund Approved';
										$color='success';
									}
									if ($rows['status']==11) {
										$badge='Refund Rejected';
										$color='danger';
									} 
									if ($rows['status']==12) {
										$badge='Rescheduled';
										$color='purple';
									} 
									if($rows['admin_change_status'] == 1) {
										$badge = $badge."  by Admin";
									}
									$statcheck = 0;
									if($rows['status'] == 5 || $rows['status'] == 7 ){
										if(!empty($rows['reject_paid_token'])){
											$statcheck = 1;
										} 
									}
									if($rows['status'] == 5 || $rows['status'] == 6 || $rows['status'] == 8 || $rows['status'] == 7 || $rows['status'] == 9 || $rows['status'] == 10 || $rows['status'] == 11 || $rows['status'] == 12){
										$statcheck = 1;
									}
									$subtxt = '';
									if(!empty($rows['reject_paid_token'])){
									 	if($rows['admin_reject_comment']=="This service amount favour for User"){
									 		$subtxt="Amount refund to User";
									 	}else{
											$subtxt="";
								 	}
									}
									$badge .= '<br><span class="small">'.$subtxt."</span>";

				                    //Currency Convertion Based 
				                    $currency_code_old = $rows['currency_code'];
				                    $subscription_amount = get_gigs_currency($rows['amount'], $currency_code_old, $currency_code);
				                    $totalamount=  currency_code_sign(settings('currency')).$subscription_amount; 
				                    $user_lang = ($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
			                        $this->db->where('modules', 'user');
			                        $this->db->where('name_id', $rows['userid']);
			                        $this->db->where('lang_type', $user_lang);
			                        $lang_user = $this->db->get('users_lang')->row_array();
			                       
			                        $this->db->where('modules', 'provider');
			                        $this->db->where('name_id', $rows['providerid']);
			                        $this->db->where('lang_type', $user_lang);
			                        $lang_pro = $this->db->get('users_lang')->row_array();

                                    $this->db->where('service_id', $rows['serviceid']);
                                    $this->db->where('lang_type', $user_lang);
                                    $service_name = $this->db->get('service_lang')->row_array();
									$service_name_lang = (!empty($service_name['service_name'])) ? $service_name['service_name'] : $rows['service_title'];
                                    $user_name = (!empty($lang_user['name'])) ? $lang_user['name'] : $rows['user_name'];
                                    $pro_name = (!empty($lang_pro['name'])) ? $lang_pro['name'] : $rows['provider_name'];
									echo '<tr>
										<td>'.$i++.'</td>
										<td>'.$service_date.'</td>
										<td>'.$booking_time.'</td>
										<td>
											<h2 class="table-avatar">
												<a href="#" class="avatar avatar-xs mr-2">
													<img class="avatar-img rounded-circle" alt="" src="'.base_url().$user_image.'">
												</a>
												<a href="'.base_url().'user-details/'.$rows['userid'].'">'.str_replace('-', ' ', $user_name).'</a>
											</h2>
										</td>
										<td>
											<h2 class="table-avatar">
												<a href="#" class="avatar avatar-xs mr-2">
													<img class="avatar-img rounded-circle" alt="" src="'.base_url().$provider_image.'">
												</a>
												<a href="'.base_url().'provider-details/'.$rows['providerid'].'">'.str_replace('-', ' ', $pro_name).'</a></h2></td>

											</h2>
										</td>
										<td>'.$service_name_lang.'</td>
										<td>'.$totalamount.'</td>
										<td><label class="badge badge-'.$color.'">'.ucfirst($badge).'</lable></td>
										<td>'.$timeBase.'</td>';
										if($user_role == 1) {										
											if($statcheck == 0) {
										
												echo '<td><select class="form-control form-control-sm chngstatus" name="ser_status" data-id="'.$rows['id'].'" data-userid="'.$rows['userid'].'" data-providerid="'.$rows['providerid'].'" data-serviceid="'.$rows['serviceid'].'">
														<option value="">Select Status</option>';
														
														foreach ($servie_staus as $pro) { 
														
														echo '<option value="'.$pro['id'].'">'.$pro['value'].'</option>';
														} 
													echo '</select></td>';
													
											} else {
												echo '<td class="text-center">-</td>';
											}
									} else{
											foreach ($servie_staus as $pro) {
												if($rows['status'] == $pro['id']) {
													$status = $pro['value'];
												}
												
											}
											echo '<td>'.$status.'</td>';
										}
										echo '</tr>';
									} 
									} ?>
                                </tbody>
                            </table>
						</div> 
					</div> 
				</div> 
			</div>
		</div>
	</div>
</div>


<!-- Reschedule Modal --> 
<div class="modal fade" id="reschedule"  data-b_rowid="" data-b_userid="" data-b_providerid="" data-b_serviceid="">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo (!empty($booking['lg_reschedule'])) ? $booking['lg_reschedule'] : $default_language['en']['lg_reschedule']; ?></h5>
				
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
				
					<label><?php echo (!empty($booking['lg_Date'])) ? $booking['lg_Date'] : $default_language['en']['lg_Date']; ?> <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="reschedule_booking_date" id="reschedule_booking_date">

					<p class="error_cancel error fade" ><?php echo (!empty($booking['lg_Reason_required'])) ? $booking['lg_Reason_required'] : $default_language['en']['lg_Reason_required']; ?></p>
				</div>
				<div class="form-group">
                    <label><?php echo (!empty($booking['lg_timeslot'])) ? $booking['lg_timeslot'] : $default_language['en']['lg_timeslot']; ?> <span class="text-danger">*</span></label>
                	<select class="form-control from_time" name="from_time" id="from_time" required>
                    </select>

                </div>
				<input type="hidden" id="b_rowid" value="">
				<input type="hidden" id="b_userid" value="">
				<input type="hidden" id="b_providerid" value="">
				<input type="hidden" id="b_serviceid" value="">
				
				<div class="text-center">
				
						<button type="button" class="reschedule_btn btn btn-theme py-2 px-4 text-white bg-primary-light mx-auto" id="admin_reschedule_booking" ><?php echo (!empty($booking['lg_Submit'])) ? $booking['lg_Submit'] : 'Submit'; ?></button>
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Reshedule Model -->