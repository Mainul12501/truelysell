<?php
	$service_list = $language_content;
	$refund_staus = array(
array("id"=>1,'value'=>'Approved'),
array("id"=>2,'value'=>'Rejected'),
);
?>
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">						
						<?php echo(!empty($service_list['lg_admin_refund_request']))?($service_list['lg_admin_refund_request']) : 'Refund Request';  ?>
					</h3>
				</div>
				<div class="col-auto text-right">
					<a href="<?php echo $base_url; ?>refund-request-list" class="btn btn-primary add-button"><i class="fas fa-sync"></i></a>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<div class="status-toggle mb-3 d-flex">
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-center mb-0 service_table">
                                <thead>
                                    <tr>
                                        <th><?php echo(!empty($service_list['lg_admin_#']))?($service_list['lg_admin_#']) : '#';  ?></th>
                                        <th><?php echo(!empty($service_list['lg_admin_provider_name']))?($service_list['lg_admin_provider_name']) : 'Provider Name';  ?></th>
                                        <th><?php echo(!empty($service_list['lg_admin_username']))?($service_list['lg_admin_username']) : 'username';  ?></th>
                                        <th><?php echo(!empty($service_list['lg_admin_service']))?($service_list['lg_admin_service']) : 'Service';  ?></th>
                                        <th><?php echo(!empty($service_list['lg_admin_amount']))?($service_list['lg_admin_amount']) : 'Amount';  ?></th>
                                        <th><?php echo(!empty($service_list['lg_admin_date']))?($service_list['lg_admin_date']) : 'Date';  ?></th>
                                        <th><?php echo(!empty($service_list['lg_admin_deleted_reason']))?($service_list['lg_admin_deleted_reason']) : 'Deleted Reason';  ?></th>
                                        <th><?php echo(!empty($service_list['lg_admin_action']))?($service_list['lg_admin_action']) : 'Action';  ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($list)) {
									$i=1;
									
									foreach ($list as $rows) {
									if(!empty($rows['created_at'])){
										$date=date(settingValue('date_format'), strtotime($rows['created_at']));
									}else{
										$date='-';
									}

									$user_lang = ($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
									$this->db->where('modules', 'provider');
			                        $this->db->where('name_id', $rows['provider_id']);
			                        $this->db->where('lang_type', $user_lang);
			                        $pro_name = $this->db->get('users_lang')->row_array();

			                        $this->db->where('modules', 'user');
			                        $this->db->where('name_id', $rows['user_id']);
			                        $this->db->where('lang_type', $user_lang);
			                        $user_name = $this->db->get('users_lang')->row_array();	

                                    $this->db->where('service_id', $rows['service_id']);
                                    $this->db->where('lang_type', $user_lang);
                                    $service_name = $this->db->get('service_lang')->row_array();
                                    $services_name = $this->db->where('id',$rows['service_id'])->get('services')->row_array();
                                    $refund_reason = wordwrap($rows['reason'], 50, '<br />', true);
                                    $badge= '';
                                    $disabled= '';
                                    if ($rows['status']==1) {
										$badge='approval';
										$color='info';
										$disabled = "disabled";
									}
									$this->db->where('id', $rows['provider_id']);
                                    $provider_name = $this->db->get('providers')->row_array();
                                    
                                    $this->db->where('id', $rows['user_id']);
                                    $users_name = $this->db->get('users')->row_array();

                                    $user_currencycode = $this->db->where('id',$rows['user_id'])->get('users')->row_array();
                                    
                                    $bookingCurrecyCode = $this->db->where('id',$rows['booking_id'])->get('book_service')->row()->currency_code;
									
                                    $currency_code_old = $user_currencycode['currency_code'];
				                    $refund_amount = get_gigs_currency($rows['amount'], $bookingCurrecyCode, settings('currency'));
				                    $totalamount=  currency_code_sign(settings('currency')).$refund_amount; 
									 ?>
									<tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo(!empty($pro_name['name']))?($pro_name['name']) : $provider_name['name'];  ?></td>                                       
                                        <td><?php echo(!empty($user_name['name']))?($user_name['name']) : $users_name['name']; ?></td>
                                        <td><?php echo(!empty($service_name['service_name']))?($service_name['service_name']) : '-';  ?></td>
                                        <td><?php echo $totalamount; ?></td>
                                        <td><?php echo $date; ?></td>
                                        <td><?php echo $rows['reason']; ?></td>
										<td> 
											<?php if($rows['status'] == 0) { ?>
											<select class="form-control form-control-sm refun_status" name="refun_status" data-id="<?php echo $rows['id']; ?>"  data-booking_id="<?php echo $rows['booking_id']; ?>" <?php $disabled; ?>> 
												<option value="">
													<?php echo(!empty($service_list['lg_admin_select_status']))?($service_list['lg_admin_select_status']) : 'Select Status';  ?>
												</option>
												<?php foreach ($refund_staus as $pro) { 
													if($rows['status'] == $pro['id']) { 
														$select = 'selected';
													} ?>
												<option value="<?php echo $pro['id']; ?>"><?php echo $pro['value']; ?></option>
											<?php } ?> 
											</select>
										<?php } elseif($rows['status'] == 1) { ?>

												<span class="badge badge-success">Approved</span>

											 <?php  } else { ?>
											  	<span class="badge badge-danger">Rejected</span>
											<?php  } 

										?>
										</td>
									</tr>
								
								<?php 	} } ?>
                                </tbody>
                            </table>
						</div> 
					</div> 
				</div>
			</div>
		</div>
	</div>
</div>