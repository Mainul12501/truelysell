<?php 
$admin_settings = $language_content;

$servie_staus = array(
array("id"=>3,'value'=>'Rejected'),
array("id"=>1,'value'=>'Approval'),
);
?>
<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">						
						<?php echo(!empty($admin_settings['lg_admin_offer_payment_list']))?($admin_settings['lg_admin_offer_payment_list']) : 'Offline Payment List';  ?>
					</h3>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-center mb-0 categories_table" id="categories_table">
								<thead>
									<tr>
										<th><?php echo(!empty($admin_settings['lg_admin_#']))?($admin_settings['lg_admin_#']) : '#';  ?></th>
                                        <th><?php echo(!empty($admin_settings['lg_admin_users']))?($admin_settings['lg_admin_users']) : 'User';  ?></th>
                                        <th><?php echo(!empty($admin_settings['lg_admin_subscription_plan']))?($admin_settings['lg_admin_subscription_plan']) : 'Subscription Plan';  ?></th>
                                        <th><?php echo(!empty($admin_settings['lg_admin_payment_document']))?($admin_settings['lg_admin_payment_document']) : 'Payment Document';  ?></th>
                                        <th><?php echo(!empty($admin_settings['lg_admin_expiry_date']))?($admin_settings['lg_admin_expiry_date']) : 'Expiry Date';  ?></th>
                                        <th><?php echo(!empty($admin_settings['lg_admin_status']))?($admin_settings['lg_admin_status']) : 'Status';  ?></th>
                                        <th><?php echo(!empty($admin_settings['lg_admin_action']))?($admin_settings['lg_admin_action']) : 'Action';  ?></th>	  
									</tr>
								</thead>
								<tbody>
								<?php
                                    $i=1;
									$statcheck = 0;
									
                                   foreach ($list as $rows) 
                                    {
										
										$paid_status = $this->db->select('paid_status')->get_where('subscription_details', array('id'=>$rows['subscription_details_id']))->row_array();
                                    	 $badge='';
                                    	 $disabled= '';
										
										if ($rows['status'] == 0) {
											$badge='Pending';
											$color='dark';
											$statcheck = 0;
										}
									
										if ($rows['status'] == 1) {
											$badge='approval';
											$color='info';
											$disabled = "disabled";
											$statcheck = 1;
										}

										if ($rows['status'] == 2) {
											$badge='Pending';
											$color='warning';
											$disabled = "disabled";
											$statcheck = 1;
										}
										if ($rows['status'] == 3) {
											$badge='Rejected';
											$color='danger';
											$disabled = "disabled";
											$statcheck = 1;
										}
									
									$date=date(settingValue('date_format'), strtotime($rows['expiry_date_time'])); 
									$image_file_path=$rows['upload_doc'];
									if (file_exists($image_file_path))
									{
										$image = '<a href="'.base_url().$rows['upload_doc'].'" class="btn btn-primary btn-sm" download="Offline Payment Document"><i class="fas fa-download"></i></a>';
									}

									else
									{
										$image = '<span class="badge badge-warning">File Not Exist</span>';
									}
									
                                        echo'<tr>
                                        <td>'.$i++.'</td>
                                        <td>'.$rows['name'].'</td>
                                        <td>'.$rows['subscription_name'].'</td>
                                        <td>'.$image.'</td>
                                        <td>'.$date.'</td>
                                        <td><label class="badge badge-'.$color.'">'.ucfirst($badge).'</lable></td>';
                                        if($statcheck == 0) {

										echo '<td><select class="form-control refundstatus" name="ser_status" data-id="'.$rows['sub_id'].'" data-pay="'.$rows['id'].'" data-userid="'.$rows['subscriber_id'].'" data-detail-id="'.$rows['subscription_details_id'].'"'.$disabled.'> 
												<option value="">Select Status</option>';
												foreach ($servie_staus as $pro) { 
												echo '<option value="'.$pro['id'].'">'.$pro['value'].'</option>';
												} 
											echo '</select></td>';
										}else {
												echo '<td class="text-center">-</td>
												</tr>';
											}
                                         
                                       
                                    }

                                    ?>
								</tbody>
							</table>
						</div> 
					</div> 
				</div>
			</div>
		</div>
	</div>
</div>