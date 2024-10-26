<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    use SendGrid\Mail\To;
    use SendGrid\Mail\Cc;
    use SendGrid\Mail\Bcc;
    use SendGrid\Mail\From;
    use SendGrid\Mail\Content;
    use SendGrid\Mail\Personalization;
    use SendGrid\Mail\Subject;
    use SendGrid\Mail\Header;
    use SendGrid\Mail\CustomArg;
    use SendGrid\Mail\SendAt;
    use SendGrid\Mail\Attachment;
    use SendGrid\Mail\Asm;
    use SendGrid\Mail\MailSettings;
    use SendGrid\Mail\BccSettings;
    use SendGrid\Mail\SandBoxMode;
    use SendGrid\Mail\BypassListManagement;
    use SendGrid\Mail\Footer;
    use SendGrid\Mail\SpamCheck;
    use SendGrid\Mail\TrackingSettings;
    use SendGrid\Mail\ClickTracking;
    use SendGrid\Mail\OpenTracking;
    use SendGrid\Mail\SubscriptionTracking;
    use SendGrid\Mail\Ganalytics;
    use SendGrid\Mail\ReplyTo;
    use SendGrid\Mail\Mail;
class Sendemail {

    public function __construct() {

        $this->ci = & get_instance();
        $this->sendgrid = !empty(settingValue("sendgrid_key"))?settingValue("sendgrid_key"):"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";
        
    }

    public function sendgrid_email($from_email,$to_email,$subject,$message)
    {    

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($from_email);
        $email->setSubject($subject);
        $email->addTo($to_email);
        $email->addContent(
            "text/html", $message
        );
        $sendgrid = new \SendGrid($this->sendgrid);
        if ($sendgrid->send($email)) {
            return "TRUE";
        } else {
            return "FALSE";
        }
        /*try {
            $response = $sendgrid->send($email);
            print_r($response->status);exit;
        } catch (Exception $e) {

        }           */
    }
}