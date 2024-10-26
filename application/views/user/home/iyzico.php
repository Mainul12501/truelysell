<?php
    require_once(APPPATH . 'third_party/iyzipay/vendor/autoload.php');
    require_once(APPPATH . 'third_party/iyzipay/vendor/iyzico/iyzipay-php/IyzipayBootstrap.php');
   
    $apiKey  = $iyzico_apikey;
    $secretKey = $iyzico_secret_apikey;

    $currencyCode = $user['currency_code'];
    

    $paymentUrl = "https://sandbox-api.iyzipay.com";
    $redirectUrl = base_url()."iyzico-payment-post";

    $uniqId = "IZY".uniqid();
    
    $options = new \Iyzipay\Options();
    $options->setApiKey($apiKey);
    $options->setSecretKey($secretKey);
    $options->setBaseUrl($paymentUrl);
  
    
    $ip = $this->input->ip_address();

    $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
    $request->setLocale(\Iyzipay\Model\Locale::EN);
    $request->setConversationId($uniqId);
    $request->setPrice("1");
    $request->setPaidPrice($amount);
    $request->setCurrency($currencyCode);
    // $request->setCurrency(\Iyzipay\Model\Currency::USD);
    $request->setBasketId("B67832");
    $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
    $request->setCallbackUrl($redirectUrl);
    $request->setEnabledInstallments(array(2, 3, 6, 9));
    
    $buyer = new \Iyzipay\Model\Buyer();
    $buyer->setId("BY789");
    $buyer->setName($user['name']);
    $buyer->setSurname("not set");
    $buyer->setGsmNumber($user['mobile_no']);
    $buyer->setEmail($user['email']);
    $buyer->setIdentityNumber("74300864791");
    $buyer->setLastLoginDate($user['last_login']);
    $buyer->setRegistrationDate($user['created_at']);
    $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
    $buyer->setIp($ip);
    $buyer->setCity("Istanbul");
    $buyer->setCountry("Turkey");
    $buyer->setZipCode("34732");
    
    $request->setBuyer($buyer);
    $shippingAddress = new \Iyzipay\Model\Address();
    $shippingAddress->setContactName("Jane Doe");
    $shippingAddress->setCity("Istanbul");
    $shippingAddress->setCountry("Turkey");
    $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
    $shippingAddress->setZipCode("34742");
    $request->setShippingAddress($shippingAddress);
    
    $billingAddress = new \Iyzipay\Model\Address();
    $billingAddress->setContactName("Jane Doe");
    $billingAddress->setCity("Istanbul");
    $billingAddress->setCountry("Turkey");
    $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
    $billingAddress->setZipCode("34742");
    $request->setBillingAddress($billingAddress);
    
    $basketItems = array();
    $firstBasketItem = new \Iyzipay\Model\BasketItem();
    $firstBasketItem->setId("BI101");
    $firstBasketItem->setName("Binocular");
    $firstBasketItem->setCategory1("Collectibles");
    $firstBasketItem->setCategory2("Accessories");
    $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
    $firstBasketItem->setPrice("0.3");
    $basketItems[0] = $firstBasketItem;
    
    $secondBasketItem = new \Iyzipay\Model\BasketItem();
    $secondBasketItem->setId("BI102");
    $secondBasketItem->setName("Game code");
    $secondBasketItem->setCategory1("Game");
    $secondBasketItem->setCategory2("Online Game Items");
    $secondBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
    $secondBasketItem->setPrice("0.5");
    
    $basketItems[1] = $secondBasketItem;
    $thirdBasketItem = new \Iyzipay\Model\BasketItem();
    $thirdBasketItem->setId("BI103");
    $thirdBasketItem->setName("Usb");
    $thirdBasketItem->setCategory1("Electronics");
    $thirdBasketItem->setCategory2("Usb / Cable");
    $thirdBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
    $thirdBasketItem->setPrice("0.2");
    $basketItems[2] = $thirdBasketItem;
    $request->setBasketItems($basketItems);
    
    $paym = \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);
      
    if(\Iyzipay\Model\CheckoutFormInitialize::create($request, $options)){
      
        echo $paym->getcheckoutFormContent();
    }else
    {
        $this->session->set_flashdata('error', $checkoutFormInitialize->getErrorMessage());
    }
    ?>

<div id="iyzipay-checkout-form" class="responsive"></div>
