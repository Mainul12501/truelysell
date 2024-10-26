<?php

    require_once(APPPATH . 'third_party/iyzipay/vendor/autoload.php');
    require_once(APPPATH . 'third_party/iyzipay/vendor/iyzico/iyzipay-php/IyzipayBootstrap.php');
   
    $apiKey  = $iyzico_apikey;
    $secretKey = $iyzico_secret_apikey;

    $paymentUrl = "https://sandbox-api.iyzipay.com";
    $redirectUrl = base_url()."iyzico-payment-post";

    $uniqId = hexdec(uniqid()) ;
    
    $options = new \Iyzipay\Options();
    $options->setApiKey($apiKey);
    $options->setSecretKey($secretKey);
    $options->setBaseUrl($paymentUrl);
  
    $ip = $this->input->ip_address();

    //try code
    $request = new \Iyzipay\Request\CreateSettlementToBalanceRequest();
    $request->setConversationId($uniqId);
    $request->setSubMerchantKey("3388507");
    $request->setLocale(\Iyzipay\Model\Locale::EN);
    $request->setCallbackUrl($redirectUrl);
    $request->setPrice("5");

    $settlementToBalance = \Iyzipay\Model\SettlementToBalance::create($request, $options);

    if($settlementToBalance){
      echo "in iyzi";
    }else
    {
        $this->session->set_flashdata('error', $checkoutFormInitialize->getErrorMessage());
    }

?>