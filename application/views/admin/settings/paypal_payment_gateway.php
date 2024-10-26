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
			<li class="nav-item active">
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
				<form action="<?php echo base_url() . 'admin/settings/paypal_edit/' . $list['id']; ?>" method="post">
					<div class="card">
						<div class="card-header">
							<div class="row">
								<div class="col">
									<h4 class="card-title"><?php echo(!empty($admin_settings['lg_admin_paypal']))?($admin_settings['lg_admin_paypal']) : 'PayPal';  ?></h4>
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								</div>
								<div class="col-auto">
									<div class="status-toggle">
										<input class="check" name="paypal_show" type="checkbox"   value="1" id="switch" <?php if($list['status']== 1) { ?>checked <?php } ?>>
										<label for="switch" class="checktoggle">checkbox</label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label><?php echo(!empty($admin_settings['lg_admin_paypalgateway']))?($admin_settings['lg_admin_paypalgateway']) : 'Paypal Gateway';  ?></label>
								<div>
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input paypal_payment" id="paypal_sandbox" type="radio" required="" name="paypal_gateway" value="sandbox" <?= ($list['gateway_type'] == "sandbox") ? 'checked' : '' ?>>
										<label class="custom-control-label" for="paypal_sandbox"><?php echo(!empty($admin_settings['lg_admin_sandbox']))?($admin_settings['lg_admin_sandbox']) : 'Sandbox';  ?></label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input class="custom-control-input paypal_payment" id="live_paypal" type="radio" required="" name="paypal_gateway" value="live" <?= ($list['gateway_type'] == "live") ? 'checked' : '' ?>>
									<label class="custom-control-label" for="live_paypal"><?php echo(!empty($admin_settings['lg_admin_live']))?($admin_settings['lg_admin_live']) : 'Live';  ?></label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label><?php echo(!empty($admin_settings['lg_admin_braintree_tokenization']))?($admin_settings['lg_admin_braintree_tokenization']) : 'Braintree Tokenization key';  ?></label>
							<?php if ($this->session->userdata('role') == 1) { ?>
                                <input class="form-control" type="text" name="braintree_key" id="braintree_key" value="<?php if (!empty($list['braintree_key'])) {echo $list['braintree_key'];} ?>" >
                            <?php } else {
                            	$account_length = strlen($list['braintree_key']);
			                    $strs = str_repeat("x", $account_length-1);
			                    $braintree_key = "". $strs;
                             ?>
                            	<input type="text" id="value" name="value" value="<?php if (!empty($braintree_key)) {echo $braintree_key;} ?>" class="form-control">
                            <?php } ?>
							</div>
							<div class="form-group">
								<label><?php echo(!empty($admin_settings['lg_admin_braintree_merchant']))?($admin_settings['lg_admin_braintree_merchant']) : 'Braintree Merchant ID';  ?></label>
							<?php if ($this->session->userdata('role') == 1) { ?>
                                <input class="form-control" type="text" name="braintree_merchant" id="braintree_merchant" value="<?php if (!empty($list['braintree_merchant'])) {echo $list['braintree_merchant'];} ?>" >
                            <?php } else {
                            	$account_length = strlen($list['braintree_merchant']);
			                    $strs = str_repeat("x", $account_length-1);
			                    $braintree_merchant = "". $strs;
                             ?>
                            	<input type="text" id="value" name="value" value="<?php if (!empty($braintree_merchant)) {echo $braintree_merchant;} ?>" class="form-control">
                            <?php } ?>
							</div>
							<div class="form-group">
									<label><?php echo(!empty($admin_settings['lg_admin_braintree_publickey']))?($admin_settings['lg_admin_braintree_publickey']) : 'Braintree Public key';  ?></label>
							<?php if ($this->session->userdata('role') == 1) { ?>
                                <input class="form-control" type="text" name="braintree_publickey" id="braintree_publickey" value="<?php if (!empty($list['braintree_publickey'])) {echo $list['braintree_publickey'];} ?>" >
                            <?php } else {
                            	$account_length = strlen($list['braintree_publickey']);
			                    $strs = str_repeat("x", $account_length-1);
			                    $braintree_publickey = "". $strs;
                             ?>
                            	<input type="text" id="value" name="value" value="<?php if (!empty($braintree_publickey)) {echo $braintree_publickey;} ?>" class="form-control">
                            <?php } ?>
							</div>
							<div class="form-group">
									<label><?php echo(!empty($admin_settings['lg_admin_braintree_privatekey']))?($admin_settings['lg_admin_braintree_privatekey']) : 'Braintree Private key';  ?></label>
							<?php if ($this->session->userdata('role') == 1) { ?>
                                <input class="form-control" type="text" name="braintree_privatekey" id="braintree_privatekey" value="<?php if (!empty($list['braintree_privatekey'])) {echo $list['braintree_privatekey'];} ?>" >
                            <?php } else {
                            	$account_length = strlen($list['braintree_privatekey']);
			                    $strs = str_repeat("x", $account_length-1);
			                    $braintree_privatekey = "". $strs;
                             ?>
                            	<input type="text" id="value" name="value" value="<?php if (!empty($braintree_privatekey)) {echo $braintree_privatekey;} ?>" class="form-control">
                            <?php } ?>
							</div>
							<div class="form-group">
									<label><?php echo(!empty($admin_settings['lg_admin_paypal_appid']))?($admin_settings['lg_admin_paypal_appid']) : 'Paypal APP ID';  ?></label>
							<?php if ($this->session->userdata('role') == 1) { ?>
                                <input class="form-control" type="text" name="paypal_appid" id="paypal_appid" value="<?php if (!empty($list['paypal_appid'])) {echo $list['paypal_appid'];} ?>">
                            <?php } else {
                            	$account_length = strlen($list['paypal_appid']);
			                    $strs = str_repeat("x", $account_length-1);
			                    $paypal_appid = "". $strs;
                             ?>
                            	<input type="text" id="value" name="value" value="<?php if (!empty($paypal_appid)) {echo $paypal_appid;} ?>" class="form-control">
                            <?php } ?>
							</div>
							<div class="form-group">
									<label><?php echo(!empty($admin_settings['lg_admin_paypal_secretkey']))?($admin_settings['lg_admin_paypal_secretkey']) : 'Paypal Secret Key';  ?></label>
							<?php if ($this->session->userdata('role') == 1) { ?>
                                <input class="form-control" type="text" name="paypal_appkey" id="paypal_appkey" value="<?php if (!empty($list['paypal_appkey'])) {echo $list['paypal_appkey'];} ?>" >
                            <?php } else {
                            	$account_length = strlen($list['paypal_appkey']);
			                    $strs = str_repeat("x", $account_length-1);
			                    $paypal_appkey = "". $strs;
                             ?>
                            	<input type="text" id="value" name="value" value="<?php if (!empty($paypal_appkey)) {echo $paypal_appkey;} ?>" class="form-control">
                            <?php } ?>
							</div>
                            <div class="mt-4">
								<button class="btn btn-primary mr-2" name="form_submit" value="submit" type="submit"><?php echo(!empty($admin_settings['lg_admin_submit']))?($admin_settings['lg_admin_submit']) : 'Submit';  ?></button>
                                <a href="<?php echo base_url() . 'admin/paypal-payment-gateway' ?>" class="btn btn-cancel m-l-5"><?php echo(!empty($admin_settings['lg_admin_cancel']))?($admin_settings['lg_admin_cancel']) : 'Cancel';  ?></a>
                            </div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
