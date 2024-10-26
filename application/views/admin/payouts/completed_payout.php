<?php 
    $booking=$language_content;
?>
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title"><?php echo (!empty($booking['lg_admin_completed_payouts'])) ? ($booking['lg_admin_completed_payouts']) : 'Completed Payouts';  ?></h3>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive total-booking-report">
                            <table class="table table-hover table-center mb-0 completed_payout">
                                <thead>
                                    <tr>
                                        <th><?php echo (!empty($booking['lg_admin_#'])) ? ($booking['lg_admin_#']) : '#';  ?></th>
                                        <th><?php echo (!empty($booking['lg_Name'])) ? ($booking['lg_Name']) : 'Name';  ?></th>
                                        <th><?php echo (!empty($booking['lg_admin_payout_method'])) ? ($booking['lg_admin_payout_method']) : 'Payout Method';  ?></th>
                                        <th><?php echo (!empty($booking['lg_admin_payout_amount'])) ? ($booking['lg_admin_payout_amount']) : 'Amount';  ?></th>
                                        <th><?php echo (!empty($booking['lg_admin_status'])) ? ($booking['lg_admin_status']) : 'Status';  ?></th>
                                        <th><?php echo (!empty($booking['lg_admin_created_at'])) ? ($booking['lg_admin_created_at']) : 'Created At';  ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($completed_data)) {

                                        $i = 1;
                                        foreach ($completed_data as $rows) {
                                            $pro_name = $this->db->get_where('providers', array('id' => $rows['user_id']))->row()->name;
                                            //currency

                                            $currency_code_old = $rows['currency'];
                                            $allservice_amount = get_gigs_currency($rows['amount'], $currency_code_old, settings('currency'));
                                            $amount =  currency_code_sign(settings('currency')) . $allservice_amount;
                                            $datef = explode(' ', $rows['created_datetime']);

                                            if (settingValue('time_format') == '12 Hours') {
                                                $time_format = 12;
                                                $time = settingDefaultTimezone($datef[1], $time_format);
                                            } elseif (settingValue('time_format') == '24 Hours') {
                                                $time_format = 24;
                                                $time = settingDefaultTimezone($datef[1], $time_format);
                                            } else {
                                                $time_format = 0;
                                                $time = settingDefaultTimezone($datef[1], $time_format);
                                            }
                                            $date = date(settingValue('date_format'), strtotime($datef[0]));
                                            $timeBase = $date . ' ' . $time;

                                    ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $pro_name; ?></td>
                                                <td><?php echo $rows['payout_method']; ?></td>
                                                <td><?php echo $amount; ?></td>
                                                <td><?php if ($rows['status'] == 1) {
                                                        echo 'Completed';
                                                    } else {
                                                        echo 'Cancelled';
                                                    } ?></td>
                                                <td><?php echo $timeBase; ?></td>
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