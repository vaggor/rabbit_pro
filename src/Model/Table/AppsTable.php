<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
//use Client;
//use Twilio\Rest\Client;


class AppsTable extends Table{
	public function newFailureResponse($err_mess){
		$json = '{
	            "status_id": "00",
	            "status": "Failed",
	            "description": "'.$err_mess.'"
	    }';
		return $json;
	}

	public function newSuccessResponse($err_mess){
		$json = '{
	            "status_id": "1",
	            "status": "Success",
	            "description": "'.$err_mess.'"
	    }';
		return $json;
	}


	public function failureResponse($err_mess,$model){
		$json = '{
	        "'.$model.'": {
	            "status_id": "00",
	            "status": "Failed",
	            "description": "'.$err_mess.'"
	        }
	    }';
		return $json;
	}

	public function successResponse($err_mess,$model){
		$json = '{
	        "'.$model.'": {
	            "status_id": "1",
	            "status": "Success",
	            "description": "'.$err_mess.'"
	        }
	    }';
		return $json;
	}


	public function successResponseCreateTransaction($err_mess,$model,$id,$amount){
		$json = '{
	        "'.$model.'": {
	            "status_id": "1",
	            "status": "Success",
	            "description": "'.$err_mess.'",
	            "id": "'.$id.'",
	            "amount": "'.$amount.'"
	        }
	    }';
		return $json;
	}


	public function successResponseCreateUser($api_key,$mess){
		$json = '{
	        "User": {
	            "status_id": "1",
	            "status": "Success",
	            "description": "'.$mess.'"
	        }
	    }';
		return $json;
	}

	public function successResponseLoginUser($cust_info,$mess){
		//print_r($cust_info[0]->id);exit;
		$json = '{
	        "User": {
	            "status_id": "1",
	            "status": "Success",
	            "description": "'.$mess.'",
	            "customer_id": "'.$cust_info[0]->id.'",
	            "name": "'.$cust_info[0]->name.'",
	            "phone": "'.$cust_info[0]->phone_no.'",
	            "email": "'.$cust_info[0]->email.'"
	        }
	    }';
		return $json;
	}


	public function successResponseDistance($distance,$duration,$unit_amount,$amount){
		$json = '{
	        "Transaction": {
	            "status_id": "1",
	            "status": "Success",
	            "distance": "'.$distance.'",
	            "duration": "'.$duration.'",
	            "unit_amount": "'.$unit_amount.'",
	            "amount": "'.$amount.'"
	        }
	    }';
		return $json;
	}


	public function sendEmailRequest($to,$subject,$body){
		$json = '{
				    "from": "info@rabbitpro.net",
				    "alias": "RabbitPro",
				    "to": "'.$to.'",
				    "subject": "'.$subject.'",
				    "message": "'.$body.'"
				}';
		return $json;
	}



	public function sendSmsRequest($to,$body){
		$json = '{
				    "to": "'.$to.'",
				    "from": "RabbitPro",
				    "message": "'.$body.'"
				}';
		return $json;
	}




	public function momoRequestOther($key,$order_id,$name,$amount,$description,$momo_number,$network){
		$secrete = md5('V1cT0_gen'.$key.md5('^sq%K5Sv'));
		$merchant_id = 'NPS_000083';
		$callback_url = 'https://rabbitpro.net/app/api/nalo_callback';
		if($network == 'VODAFONE'){
			$json = '{
				    "merchant_id": "'.$merchant_id.'",
					"secrete":"'.$secrete.'",
					"key":"'.$key.'",
					"order_id":"'.$order_id.'",
					"customerName":"'.$name.'",
					"amount":"'.$amount.'",
					"item_desc": "'.$description.'",
					"customerNumber": "'.$momo_number.'",
					"payby": "'.$network.'",
					"newVodaPayment":true,
					"callback": "'.$callback_url.'"
				}';
		}
		else{
			$json = '{
				    "merchant_id": "'.$merchant_id.'",
					"secrete":"'.$secrete.'",
					"key":"'.$key.'",
					"order_id":"'.$order_id.'",
					"customerName":"'.$name.'",
					"amount":"'.$amount.'",
					"item_desc": "'.$description.'",
					"customerNumber": "'.$momo_number.'",
					"payby": "'.$network.'",
					"callback": "'.$callback_url.'"
				}';
		}
		
		return $json;
	}





	public function generateRandomDigits($len){
      $chars = '1234567890';
      $shuffle = str_shuffle($chars);
      $num = substr($shuffle,0,$len);
      $msgid = $num;
      return $msgid;
  	}





	public function generateCode($len){
	    if (function_exists('com_create_guid')){
	        $uuid = com_create_guid();
	    }else{
	        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	        $charid = strtoupper(md5(uniqid(rand(), true)));
	        $uuid = chr(123)
	                .substr($charid, 0, 8)
	                .substr($charid, 8, 4)
	                .substr($charid,12, 4)
	                .substr($charid,16, 4)
	                .substr($charid,20,12)
	                .chr(125);
	        $uuid = substr($uuid, 8,$len);
	    }
	    return $uuid;
  	}


  	public function getToCurl($url){
		$CURL = curl_init();
	    curl_setopt($CURL, CURLOPT_URL, $url); 
	    //curl_setopt($CURL, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
	    //curl_setopt($CURL, CURLOPT_POST, 1); 
	    //curl_setopt($CURL, CURLOPT_POSTFIELDS, $data); 
	    curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-type: application/json; charset=utf-8'));
	    curl_setopt($CURL, CURLOPT_HEADER, false); 
	    curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($CURL, CURLOPT_CUSTOMREQUEST, "GET"); 
	    curl_setopt($CURL, CURLOPT_RETURNTRANSFER, true);
	    $resp = curl_exec($CURL); 
	    //$status_code = curl_getinfo($CURL, CURLINFO_HTTP_CODE);  
	    //print_r($resp);exit;
	    return $resp;
	}

	public function postToCurl($url,$data,$header){
		$CURL = curl_init();
	    curl_setopt($CURL, CURLOPT_URL, $url); 
	    //curl_setopt($CURL, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
	    curl_setopt($CURL, CURLOPT_POST, 1); 
	    curl_setopt($CURL, CURLOPT_POSTFIELDS, $data); 
	    curl_setopt($CURL, CURLOPT_HTTPHEADER, $header);
	    curl_setopt($CURL, CURLOPT_HEADER, false); 
	    curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($CURL, CURLOPT_CUSTOMREQUEST, "POST"); 
	    curl_setopt($CURL, CURLOPT_RETURNTRANSFER, true);
	    $resp = curl_exec($CURL); 
	    //$status_code = curl_getinfo($CURL, CURLINFO_HTTP_CODE);  
	    //print_r(curl_getinfo($CURL));exit;
	    return $resp;
	}


	public function sendEmail($to,$subject,$body){
		$message = '
		<html>
			<head>
				<title>GrabNEarn</title>
			</head>
			<body>
				<p>'.$body.'</p>
			</body>
		</html>
		';

		// To send HTML mail, the Content-type header must be set
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';

		// Additional headers
		//$headers[] = 'To: Victor <'.$to.'>';
		$headers[] = 'From: GrabNEarn <notifications@grabnearn.com>';
				
		//$this->log($to, 'debug');
		// Mail it
		$resp = mail($to, $subject, $message, implode("\r\n", $headers));
		//print_r($resp);exit;
		return $resp;
	}

	public function sendEmailCurl($to,$subject,$body){
		$email_json = $this->sendEmailRequest($to,$subject,$body);
		$url = 'http://ialert.clickmegh.com/ialert/ialert/api_v1_0/send_message';
		//print_r($email_json);exit;
		$this->postToCurl($url,$email_json);
		return;
	}


	public function validatePhoneNumber($phone){
		$phone_ln = strlen($phone);
		$first_3_digits = substr($phone, 0,3);
		$first_1_digits = substr($phone, 0,1);
		if($phone_ln == 10 and $first_1_digits == '0'){
			$phone = '233'.substr($phone, 1,9);
		}
		elseif($phone_ln == 12 and $first_3_digits == '233'){
			$phone = $phone;
		}
		else{
			$phone = 0;
		}
		return $phone;
	}




	public function debitMomoWallet($phone,$network,$amount,$ref,$log_code){ 
		$post_data = "msisdn=".$phone."&amount=".$amount."&mno=".$network."&kuwaita=malipo&refID=".$ref;  
		$url = "https://fs1.nsano.com:5001/api/fusion/tp/4722cf59670448ce99e15e47958326fa";
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_PORT => "5001",
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 180,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_SSL_VERIFYHOST=>false,
          CURLOPT_SSL_VERIFYPEER=>false,
          CURLOPT_POSTFIELDS => $post_data,
          CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Cache-Control: no-cache",
            "Connection: keep-alive",
            "Content-Type: application/x-www-form-urlencoded",
            "Host: fs1.nsano.com:5001",          
            "cache-control: no-cache"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) 
            {
              $response = "cURL Error #:" . $err;
            } 

        $log = new Log();
        $log->createLog($log_code,$url,'debitMomoWallet',$post_data,$response);
        return  $response;
    }




    public function sendWhatsappMessage($to,$body){
		//App::import('Vendor', 'Autoload', array('file' => 'twilio_sdk/autoload.php'));
		//require_once(ROOT . DS . 'vendor' . DS  . 'twilio_sdk' . DS . 'autoload.php');
		require_once(ROOT . DS . 'vendor' . DS  . 'twilio_sdk' . DS . 'twilio' .DS.'sdk'.DS.'Twilio'.DS.'Rest'.DS.'Client.php');

		// Use the REST API Client to make requests to the Twilio REST API
		//use Twilio\Rest\Client;
		// Your Account SID and Auth Token from twilio.com/console
		$sid = 'AC55a5b9b5fd68134eb20705654fc90570';
		$token = '070c2e592ef5b84d1d054463bbd0c6c2';
		//$twilio = new Client($sid, $token);
		//$twilio = new Twilio\Rest\Client($sid, $token);
		$twilio = new Client($sid, $token);

		$message = $twilio->messages
        			->create($to, // to
                           array(
                               "from" => "whatsapp:+14155238886",
                               "body" => $body
                           )
                  	);

		return $message;
	}



}

?>