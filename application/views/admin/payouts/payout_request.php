<?php 
    $booking=$language_content;
?>
<div class="page-wrapper">
    <div class="content container-fluid">
    
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title"><?php echo(!empty($booking['lg_admin_payout_requests']))?($booking['lg_admin_payout_requests']) : 'Payout Requests';  ?></h3>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 categories_table" id="categories_table" >
                                <thead>
                                    <tr>
                                        <th><?php echo(!empty($booking['lg_admin_#']))?($booking['lg_admin_#']) : '#';  ?></th>
                                        <th><?php echo(!empty($booking['lg_Name']))?($booking['lg_Name']) : 'Name';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_payout_method']))?($booking['lg_admin_payout_method']) : 'Payout Method';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_payout_amount']))?($booking['lg_admin_payout_amount']) : 'Amount';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_status']))?($booking['lg_admin_status']) : 'Status';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_created_at']))?($booking['lg_admin_created_at']) : 'Created At';  ?></th>
                                        <th><?php echo(!empty($booking['lg_admin_action']))?($booking['lg_admin_action']) : 'Action';  ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($requests_data)) {

                                    $i=1;
                                    foreach ($requests_data as $rows) { 
                                        $pro_name = $this->db->get_where('providers', array('id'=>$rows['user_id']))->row()->name;
                                        //currency
                                       
                                        $currency_code_old = $rows['currency'];
				                        $allservice_amount = get_gigs_currency($rows['amount'], $currency_code_old, settings('currency'));
				                        $amount=  currency_code_sign(settings('currency')).$allservice_amount; 

                                        ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $pro_name; ?></td>
                                        <td><?php echo $rows['payout_method']; ?></td>
                                        <td><?php echo $amount ?></td> 
                                        <td><?php echo 'Pending';?></td>
                                        <?php $date=date(settingValue('date_format'), strtotime($rows['created_datetime'])); ?>
                                      
                                        <td><?php echo $date ?></td>
                                        <td> 
                                            <select class="form-control payoutstatus" name="payout_status" data-id="<?php echo $rows['id']; ?>" data-userid="<?php echo $rows['user_id']; ?>" data-amount="<?php echo $rows['amount'];?>" >
                                                <option value="">Select Status</option>
                                                <option value="1">Approved</option>
                                                <option value="2">Cancelled</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php } 
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