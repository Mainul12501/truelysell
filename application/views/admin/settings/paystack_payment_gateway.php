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
			<li class="nav-item active">
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
				<form action="<?php echo base_url() . 'admin/settings/paystack_edit/' . $list['id']; ?>" method="post">
					<div class="card">
						<div class="card-header">
							<div class="row">
								<div class="col">
									<h4 class="card-title"><?php echo(!empty($admin_settings['lg_admin_paystack']))?($admin_settings['lg_admin_paystack']) : 'Paystack';  ?></h4>
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								</div>
								<div class="col-auto">
									<div class="status-toggle">
										<input class="check" name="paystack_show" type="checkbox" value="1" id="switch" <?php if($list['status']== 1) { ?>checked <?php } ?>>
										<label for="switch" class="checktoggle">checkbox</label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label><?php echo(!empty($admin_settings['lg_admin_paystack_gateway']))?($admin_settings['lg_admin_paystack_gateway']) : 'Paystack Gateway';  ?></label>
								<div>
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input paystack_payment" id="paystack_sandbox" type="radio" required="" name="gateway_type" value="sandbox" <?= ($list['gateway_type'] == "sandbox") ? 'checked' : '' ?>>
										<label class="custom-control-label" for="paystack_sandbox"><?php echo(!empty($admin_settings['lg_admin_sandbox']))?($admin_settings['lg_admin_sandbox']) : 'Sandbox';  ?></label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input paystack_payment" id="live_paystack" type="radio" required="" name="gateway_type" value="live" <?= ($list['gateway_type'] == "live") ? 'checked' : '' ?>>
									<label class="custom-control-label" for="live_paystack"><?php echo(!empty($admin_settings['lg_admin_live']))?($admin_settings['lg_admin_live']) : 'Live';  ?></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label><?php echo(!empty($admin_settings['lg_admin_gatewayname']))?($admin_settings['lg_admin_gatewayname']) : 'Gateway Name';  ?></label>
								<input class="form-control" type="text" name="gateway_name" id="gateway_name" value="<?php if (!empty($list['gateway_name'])) { echo $list['gateway_name']; } ?>" >
							</div>
							<div class="form-group">
                                <label><?php echo(!empty($admin_settings['lg_admin_apikey']))?($admin_settings['lg_admin_apikey']) : 'API Key';  ?></label>
                            <?php if ($this->session->userdata('role') == 1) { ?>
                                <input type="text" id="api_key" name="api_key" value="<?php if (!empty($list['api_key'])) {echo $list['api_key'];} ?>" class="form-control">
                            <?php } else {
                            	$api_length = strlen($list['api_key']);
                            	$str = str_repeat("x", $api_length-8);
                            	$api_key = "pk_test_". $str;
                             ?>
                            	<input type="text" id="api_key" name="api_key" value="<?php if (!empty($api_key)) {echo $api_key;} ?>" class="form-control">
                            <?php } ?>
                            </div>
							<div class="form-group">
                                <label><?php echo(!empty($admin_settings['lg_admin_secretkey']))?($admin_settings['lg_admin_secretkey']) : 'Secret key';  ?></label>
                            <?php if ($this->session->userdata('role') == 1) { ?>
                                <input type="text" id="value" name="value" value="<?php if (!empty($list['value'])) {echo $list['value'];} ?>" class="form-control">
                            <?php } else {
                            	$value_length = strlen($list['value']);
			                    $strs = str_repeat("x", $value_length-8);
			                    $value = "sk_test_". $strs;
                             ?>
                            	<input type="text" id="value" name="value" value="<?php if (!empty($value)) {echo $value;} ?>" class="form-control">
                            <?php } ?>
                            </div>
                            <div class="mt-4">
								<button class="btn btn-primary mr-2" name="form_submit" value="submit" type="submit"><?php echo(!empty($admin_settings['lg_admin_submit']))?($admin_settings['lg_admin_submit']) : 'Submit';  ?></button>
                                <a href="<?php echo base_url() . 'admin/paystack-payment-gateway' ?>" class="btn btn-cancel m-l-5"><?php echo(!empty($admin_settings['lg_admin_cancel']))?($admin_settings['lg_admin_cancel']) : 'Cancel';  ?></a>
                            </div>
						</div>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
