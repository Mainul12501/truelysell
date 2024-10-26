<?php 
$admin_settings = $language_content;
?>
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title"><?php echo(!empty($admin_settings['lg_admin_paymentsettings']))?($admin_settings['lg_admin_paymentsettings']) : 'Payment Settings';  ?></h3>
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
            <li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/midtrans-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_midtrans']))?($admin_settings['lg_admin_midtrans']) : 'Midtrans';  ?></a>
			</li>
            <li class="nav-item">
				<a class="nav-link" href="<?php echo base_url() . 'admin/flutter-payment-gateway'; ?>"><?php echo(!empty($admin_settings['lg_admin_flutterwave']))?($admin_settings['lg_admin_flutterwave']) : 'FlutterWave';  ?></a>
			</li> 
            <li class="nav-item active">
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
				<form action="<?php  echo base_url().'admin/iyzico-payment-edit/'.$list['id']; ?>" method="post">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="card">
						<div class="card-header">
							<div class="row">
								<div class="col">
									<h4 class="card-title"><?php echo(!empty($admin_settings['lg_admin_iyzico']))?($admin_settings['lg_admin_iyzico']) : 'Iyzico';  ?></h4>
								</div>
								<div class="col-auto">
									<div class="status-toggle">
										<input class="check" name="iyzico_show" type="checkbox"  value="1" id="switch" <?php if($list['status']== 1) { ?>checked <?php } ?>>
										<label for="switch" class="checktoggle">checkbox</label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
                            <div class="form-group">
                                <label><?php echo(!empty($admin_settings['lg_admin_iyzico_option']))?($admin_settings['lg_admin_iyzico_option']) : 'Iyzico Option';  ?></label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input iyzico_payment" id="sandbox" name="gateway_type" value="sandbox" type="radio" <?= ($list['gateway_type'] == "sandbox") ? 'checked' : '' ?> >
                                        <label class="custom-control-label" for="sandbox">Sandbox</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input iyzico_payment" id="livepaypal" name="gateway_type" value="live" type="radio"  <?= ($list['gateway_type'] == "live") ? 'checked' : '' ?> >
                                        <label class="custom-control-label" for="livepaypal">Live</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?php echo(!empty($admin_settings['lg_admin_gatewayname']))?($admin_settings['lg_admin_gatewayname']) : 'Gateway Name';  ?></label>
                                <input  type="text" id="iyzico_gateway_name" name="gateway_name"  value="<?php if (!empty($list['gateway_name'])) {echo $list['gateway_name'];} ?>" required class="form-control" placeholder="Gateway Name">
                            </div>
                            <div class="form-group">
                                <label><?php echo(!empty($admin_settings['lg_admin_apikey']))?($admin_settings['lg_admin_apikey']) : 'API Key';  ?></label>
                            <?php if ($this->session->userdata('role') == 1) { ?>
                                <input type="text" id="api_key" name="api_key" value="<?php if (!empty($list['api_key'])) {echo $list['api_key'];} ?>" class="form-control">
                            <?php } else {
                            	$api_length = strlen($list['api_key']);
                            	$str = str_repeat("x", $api_length);
                            	$api_key = "". $str;
                             ?>
                            	<input type="text" id="api_key" name="api_key" value="<?php if (!empty($api_key)) {echo $api_key;} ?>" class="form-control">
                            <?php } ?>
                            </div>
                            <div class="form-group">
                                <label><?php echo(!empty($admin_settings['lg_admin_secretkey']))?($admin_settings['lg_admin_secretkey']) : 'Secret Key';  ?></label>
                            <?php if ($this->session->userdata('role') == 1) { ?>
                                <input type="text" id="secret_key" name="secret_key" value="<?php if (!empty($list['secret_key'])) {echo $list['secret_key'];} ?>" required class="form-control">
                            <?php } else {
                            	$value_length = strlen($list['secret_key']);
			                    $strs = str_repeat("x", $value_length);
			                    $value = "". $strs;
                             ?>
                            	<input type="text" id="secret_key" name="secret_key" value="<?php if (!empty($value)) {echo $value;} ?>" class="form-control">
                            <?php } ?>
                            </div>
                           
                            <div class="mt-4">
								<?php if ($user_role == 1) { ?>
								<button class="btn btn-primary mr-2" name="form_submit" value="submit" type="submit">Submit</button>
								<?php } ?>
                                <a href="<?php echo base_url() . 'admin/iyzico-payment-gateway' ?>" class="btn btn-cancel m-l-5">Cancel</a>
                            </div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
