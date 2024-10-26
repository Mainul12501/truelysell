<?php 
$admin_settings = $language_content;
?>
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Payment Settings</h3>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
		
		<ul class="nav nav-tabs menu-tabs">
		<li class="nav-item ">
				<a class="nav-link" href="<?php echo base_url() . 'admin/stripe-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_stripe']))?($admin_settings['lg_admin_stripe']) : 'Stripe';  ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/razorpay-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_razorpay']))?($admin_settings['lg_admin_razorpay']) : 'Razorpay';  ?> </a>
			</li>
			<li class="nav-item ">
				<a class="nav-link" href="<?php echo base_url() . 'admin/paypal-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_paypal']))?($admin_settings['lg_admin_paypal']) : 'PayPal';  ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/paystack-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_paystack']))?($admin_settings['lg_admin_paystack']) : 'Paystack';  ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/paysolution-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_paysolution']))?($admin_settings['lg_admin_paysolution']) : 'Paysolution';  ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/offlinepayment'; ?>"><?php echo(!empty($admin_settings['lg_admin_bank_transfer']))?($admin_settings['lg_admin_bank_transfer']) : 'Bank Transfer';  ?></a>
			</li>
            <li class="nav-item active">
				<a class="nav-link" href="<?php echo base_url() . 'admin/midtrans-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_midtrans']))?($admin_settings['lg_admin_midtrans']) : 'Midtrans';  ?></a>
			</li>
            <li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/flutter-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_flutterwave']))?($admin_settings['lg_admin_flutterwave']) : 'FlutterWave';  ?></a>
			</li> 
            <li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/iyzico-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_iyzico']))?($admin_settings['lg_admin_iyzico']) : 'Iyzico';  ?></a>
			</li>
            <li class="nav-item d-none">
				<a class="nav-link" href="<?php echo base_url() . 'admin/midtrans_payout_gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_midtrans_payout']))?($admin_settings['lg_admin_midtrans_payout']) : 'Midtrans Payout';  ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/cod-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_cod']))?($admin_settings['lg_admin_cod']) : 'COD';  ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/wallet-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_wallet']))?($admin_settings['lg_admin_wallet']) : 'Wallet';  ?></a>
			</li>
		</ul>
		
        <div class="row">
            <div class="col-lg-8">
				<form action="<?php  echo base_url() . 'admin/settings/midtrans_edit/'  . $list['id']; ?>" method="post">
					<div class="card">
						<div class="card-header">
							<div class="row">
								<div class="col">
									<h4 class="card-title">
									<?php echo(!empty($admin_settings['lg_admin_midtrans']))?($admin_settings['lg_admin_midtrans']) : 'Midtrans';  ?>
									</h4>
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								</div>
								<div class="col-auto">
									<div class="status-toggle">
										<input class="check" name="midtrans_show" type="checkbox"  value="1" id="switch" <?php if($list['status']== 1) { ?>checked <?php } ?>>
										<label for="switch" class="checktoggle">checkbox</label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
                            <div class="form-group">
                                <label>
									<?php echo(!empty($admin_settings['lg_admin_midtrans_option']))?($admin_settings['lg_admin_midtrans_option']) : 'Midtrans Option';  ?>
								</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input midtrans_payment" id="sandbox" name="gateway_type" value="sandbox" type="radio" <?= ($list['gateway_type'] == "sandbox") ? 'checked' : '' ?> >
                                        <label class="custom-control-label" for="sandbox">Sandbox</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input midtrans_payment" id="livepaypal" name="gateway_type" value="live" type="radio"  <?= ($list['gateway_type'] == "live") ? 'checked' : '' ?> >
                                        <label class="custom-control-label" for="livepaypal">Live</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>
									<?php echo(!empty($admin_settings['lg_admin_gatewayname']))?($admin_settings['lg_admin_gatewayname']) : 'Gateway Name';  ?>
								</label>
                                <input  type="text" id="midtrans_gateway_name" name="midtrans_gateway_name"  value="<?php if (!empty($list['gateway_name'])) {echo $list['gateway_name'];} ?>" class="form-control" placeholder="Gateway Name">
                            </div>
                            <div class="form-group">
                                <label><?php echo(!empty($admin_settings['lg_admin_client_key']))?($admin_settings['lg_admin_client_key']) : 'Client Key';  ?></label>
                            <?php if ($this->session->userdata('role') == 1) { ?>
                                <input type="text" id="client_key" name="client_key" value="<?php if (!empty($list['client_key'])) {echo $list['client_key'];} ?>" class="form-control">
                            <?php } else {
                            	$client_key_length = strlen($list['client_key']);
                            	$str = str_repeat("x", $client_key_length);
                            	$client_key = "". $str;
                             ?>
                            	<input type="text" id="client_key" name="client_key" value="<?php if (!empty($client_key)) {echo $client_key;} ?>" class="form-control">
                            <?php } ?>
                            </div>
                            <div class="form-group">
                                <label>									
									<?php echo(!empty($admin_settings['lg_admin_server_key']))?($admin_settings['lg_admin_server_key']) : 'Server Key';  ?>
								</label>
                            <?php if ($this->session->userdata('role') == 1) { ?>
                                <input type="text" id="server_key" name="server_key" value="<?php if (!empty($list['serverkey_key'])) {echo $list['serverkey_key'];} ?>" class="form-control">
                            <?php } else {
                            	$server_key_length = strlen($list['serverkey_key']);
                            	$str = str_repeat("x", $server_key_length);
                            	$server_key = "". $str;
                             ?>
                            	<input type="text" id="server_key" name="server_key" value="<?php if (!empty($server_key)) {echo $server_key;} ?>" class="form-control">
                            <?php } ?>
                            </div>
                            <div class="form-group">
                                <label>
									<?php echo(!empty($admin_settings['lg_admin_merchant_id']))?($admin_settings['lg_admin_merchant_id']) : 'Merchant ID';  ?>
								</label>
                            <?php if ($this->session->userdata('role') == 1) { ?>
                                <input type="text" id="merchant_id" name="merchant_id" value="<?php if (!empty($list['merchant_id'])) {echo $list['merchant_id'];} ?>" class="form-control">
                            <?php } else {
                            	$merchant_id_length = strlen($list['merchant_id']);
                            	$str = str_repeat("x", $merchant_id_length);
                            	$merchant_id = "". $str;
                             ?>
                            	<input type="text" id="merchant_id" name="merchant_id" value="<?php if (!empty($merchant_id)) {echo $merchant_id;} ?>" class="form-control">
                            <?php } ?>
                            </div>
                            <div class="mt-4">
								<?php if ($user_role == 1) { ?>
								<button class="btn btn-primary mr-2" name="form_submit" value="submit" type="submit">									
									<?php echo(!empty($admin_settings['lg_admin_submit']))?($admin_settings['lg_admin_submit']) : 'Submit';  ?>
								</button>
								<?php } ?>
                                <a href="<?php echo base_url() . 'admin/midtrans-payment-gateway' ?>" class="btn btn-cancel m-l-5"><?php echo(!empty($admin_settings['lg_admin_cancel']))?($admin_settings['lg_admin_cancel']) : 'Cancel';  ?></a>
                            </div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
