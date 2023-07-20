<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;


/**
 * Breeders Controller
 *
 * @property \App\Model\Table\BreedersTable $Breeders
 *
 * @method \App\Model\Entity\Breeder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApiController extends AppController
{

	public function beforeFilter(Event $event){
       // allow all action
        $this->Auth->allow();
    }
    
    public function createUser() {	
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

    	if ($this->request->is('post')) {

    		$logsTb = TableRegistry::get('Logs');
    		$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$billsTb = TableRegistry::get('Bills');
    		$packagesTb = TableRegistry::get('Packages');

    		$data = $userTb->newEntity();
    		$input_data = $this->request->getData();
    		$data = $userTb->patchEntity($data, $this->request->getData());

    		$header = getallheaders();
    		$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $userTb->failureResponse($err_mess,'User');
				print_r($json_obj);exit;
			}

			$data['Users']['phone_no'] = $userTb->validatePhoneNumber($input_data['phone_no']);
			//print_r($data);exit;
		    if($input_data['phone_no'] == 0){
				$err_mess = 'Please enter a valid phone number';
				$json_obj = $userTb->failureResponse($err_mess,'User');
				$logsTb->createLog('web','create_user',json_encode($data),$json_obj);
				print_r($json_obj);exit;
			}

			if($input_data['password'] != $input_data['cpass']){
				$err_mess = 'Please Password does not match';
				$json_obj = $userTb->failureResponse($err_mess,'User');
				$logsTb->createLog('web','create_user',json_encode($data),$json_obj);
				print_r($json_obj);exit;
			}

			if($input_data['tnc'] == 0){
				$err_mess = 'Please accept Terms and Conditions';
				$json_obj = $userTb->failureResponse($err_mess,'User');
				$logsTb->createLog('web','create_user',json_encode($data),$json_obj);
				print_r($json_obj);exit;
			}

		    $chk_is_user_exist = $userTb->getDetailUserByEmail($input_data['email']);
		    if(!empty($chk_is_user_exist)){
		    	$err_mess = 'Account already exist';
				$json_obj = $userTb->failureResponse($err_mess,'User');
				$logsTb->createLog('web','create_user',json_encode($data),$json_obj);
				print_r($json_obj);exit;
		    }

		    

		    $data['usergroup_id'] = 1;
		    $data['status_id'] = 1;
		    $data['hash'] = $userTb->generateCode(20);
		    $data['created'] = date('Y-m-d H:i');
		    $data['password'] = $userTb->hashPass($input_data['password']);

		    $data['package_id'] = 5;
		    $package_data = $packagesTb->getPackageById($data['package_id']);
		    //print_r($package_data[0]->price_m);exit;
		    $data['price'] = $package_data[0]->price_m;
		    $data['renew_date'] = $data['created'];
		    $data['expire_date'] = date('Y-m-d H:i', strtotime('+1 month'));
		    //print_r($data);exit;
		    $result = $userTb->save($data);
		    //print_r($result);exit;
		    if($result){
		    	$user_id = $result->id;
		    	$type = 'monthly';
		    	$order_no = '';
		    	$billsTb->createBill($data['package_id'],$user_id,$type,$order_no);
		    	$succ_msg = "Sign up successful. You will be redirected shortly";
				$json_obj = $userTb->successResponseCreateUser($data['api_key'],$succ_msg);
		    	$logsTb->createLog('web','create_user',json_encode($data),$json_obj);

		    	$hash_url = 'https://rabbitpro.net/app/users/activateAccount/'.$data['hash'];
		    	$to = $data['email'];
		    	$subject = 'Account Activation';
		    	$body = 'Welcome to RabbitPro. To activate your account, we need to verify your E-mail address. If you ('.$to.') have requested the creation of this account, please activate your account by clicking the link below.'.$hash_url;
		    	$header = array();

		    	$email_json = $userTb->sendEmailRequest($to,$subject,$body);
		    	$url = 'http://notifications.clickmegh.com/notifications_api/api/send_email';
		    	$userTb->postToCurl($url,$email_json,$header);
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $userTb->failureResponse($err_mess,'User');
				$logsTb->createLog('web','create_user',json_encode($data),$json_obj);
			}
		    print_r($json_obj);exit;
    	}

	    
	}



	public function login()
    {
        /*$usersModel = $this->loadModel('Users');
        $pass_hash = $usersModel->hashPass('123');
        print_r($pass_hash);exit;*/
        header('Content-Type: application/json; charset=utf-8');
        $apikeyTb = TableRegistry::get('ApiKeys');
        $userTb = TableRegistry::get('Users');
        $header = getallheaders();
        $api_key = @$header['Api-Key'];
		$validate_key = $apikeyTb->validateKey($api_key);
		if($validate_key != 1){
			$err_mess = 'There is something wrong with your request';
			$json_obj = $userTb->failureResponse($err_mess,'User');
			print_r($json_obj);exit;
		}

        $userTb = TableRegistry::get('Users');
        $logsTb = TableRegistry::get('Logs');
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
        	$data = $this->request->data;
        	//print_r($data);exit;
            $user = $this->Auth->identify();
            if ($user) {
                $cust_info = $userTb->getDetailUserByEmail($data['email']);
		    	$succ_msg = "Login successful. You will be redirected shortly";
				$json_obj = $userTb->successResponseLoginUser($cust_info,$succ_msg);
            } else {
                $err_mess = 'Login Failed';
				$json_obj = $userTb->failureResponse($err_mess,'User');
            }
            $data['password'] = '*****';
            $logsTb->createLog('web','login',json_encode($data),$json_obj);
            print_r($json_obj);exit;
        }
    }



    public function resetPassword()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$logsTb = TableRegistry::get('Logs');
    		$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');

    		$data = $userTb->newEntity();
    		$input_data = $this->request->data;
    		$data = $userTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $userTb->failureResponse($err_mess,'User');
				print_r($json_obj);exit;
			}

		    $email = $input_data['email'];
		    $count = $userTb->chkEmailExist($email);
		    //print_r($count);exit;
		    if($count == 1){
		    	$hash = $userTb->generateCode(20);
		    	$userTb->updateHash($email,$hash);

		    	$succ_msg = "Click on the link sent to inbox to reset password";
				$json_obj = $userTb->successResponse($succ_msg,'User');
		    	$logsTb->createLog('web','resetPassword',json_encode($data),$json_obj);

		    	$hash_url = 'https://rabbitpro.net/app/users/passwordChanged/'.$hash;
			    $to = $email;
			    $subject = 'Password Reset';
			    $body = 'Someone has requested for your password to be reset. Click on the link to reset your password. Ignore if you did not make this request. '.$hash_url;
			    $header = array();

			    $email_json = $userTb->sendEmailRequest($to,$subject,$body);
			    $url = 'http://notifications.clickmegh.com/notifications_api/api/send_email';
			    $userTb->postToCurl($url,$email_json,$header);

			}
			else{
				$err_mess = 'Reset Failed';
				$json_obj = $userTb->failureResponse($err_mess,'User');
				$logsTb->createLog('web','resetPassword',json_encode($data),$json_obj);
			}
		    print_r($json_obj);exit;
        }
        
    }



    public function activateAccount($hash=null)
    {
    	//print_r('$hash');exit;
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $userTb->failureResponse($err_mess,'User');
				print_r($json_obj);exit;
			}
			//print_r('$hash');exit;
		    $count = $userTb->verifyEmail($hash);
		    //print_r($count);exit;
		    if($count == 1){
		    	$id = $userTb->getUserIdByHash($hash);
		    	$userTb->updateStatus($id,2);

		    	$succ_msg = "Account has been activated";
				$json_obj = $userTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog('web','activateAccount',$hash,$json_obj);

			    $to = $userTb->getEmailById($id);
			    $subject = 'Account Activation';
			    $body = 'Your account has been successfully activated.';
			    $header = array();

			    $email_json = $userTb->sendEmailRequest($to,$subject,$body);
			    $url = 'http://notifications.clickmegh.com/notifications_api/api/send_email';
			    $userTb->postToCurl($url,$email_json,$header);

			}
			else{
				$err_mess = 'Account Activation Failed';
				$json_obj = $userTb->newFailureResponse($err_mess);
				$logsTb->createLog('web','activateAccount',$hash,$json_obj);
			}
		    print_r($json_obj);exit;
        }
        
    }





    public function changePassword()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$logsTb = TableRegistry::get('Logs');
    		$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');

    		$data = $userTb->newEntity();
    		$input_data = $this->request->data;
    		$data = $userTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $userTb->failureResponse($err_mess,'User');
				print_r($json_obj);exit;
			}

		    $pass = $userTb->hashPass($input_data['password']);
			$cpass = $userTb->hashPass($input_data['cpass']);
			$opass = $userTb->hashPass($input_data['opass']);
			//print_r($pass);
			if($input_data['password'] == $input_data['cpass']){
			  	$find_user = $userTb->getDetailUserById($input_data['creator']);
				if(!empty($find_user)){
					$userTb->updatePassword($pass,$input_data['creator']);
					$succ_msg = "Password has been changed";
					$json_obj = $userTb->newSuccessResponse($succ_msg);
		    		$logsTb->createLog('web','changePassword',json_encode($input_data),$json_obj);
				}
				else{
					$succ_msg = "Your old password is wrong";
					$json_obj = $userTb->newFailureResponse($succ_msg);
		    		$logsTb->createLog('web','changePassword',json_encode($input_data),$json_obj);	
		    	}
			}
			else{
				$succ_msg = "Password does not match";
				$json_obj = $userTb->newFailureResponse($succ_msg);
		    	$logsTb->createLog('web','changePassword',json_encode($input_data),$json_obj);
			}
		    print_r($json_obj);exit;
        }
        
    }





    public function passwordChanged($hash)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');
        
        if ($this->request->is('get')) {

            $logsTb = TableRegistry::get('Logs');
            $userTb = TableRegistry::get('Users');
            $apikeyTb = TableRegistry::get('ApiKeys');
            $breedersTb = TableRegistry::get('Breeders');

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $userTb->failureResponse($err_mess,'User');
				print_r($json_obj);exit;
			}

            //$input_data = $this->request->data;
            
            $user_id = $userTb->getUserIdByHash($hash);
            if(isset($user_id) and !empty($user_id)){
                $default_pwd = $userTb->generateCode(8);
                $password = $userTb->hashPass($default_pwd);
                if($userTb->updatePassword($password,$user_id)){
                    $succ_msg = "Password has been reset. New password has been sent to your inbox.";
					$json_obj = $userTb->newSuccessResponse($succ_msg);
			    	$logsTb->createLog('web','passwordChanged',$hash,$json_obj);

				    $to = $userTb->getEmailById($user_id);
				    $subject = 'Password Reset';
				    $body = 'Your reset password is: '.$default_pwd;
				    $header = array();

				    $email_json = $userTb->sendEmailRequest($to,$subject,$body);
				    $url = 'http://notifications.clickmegh.com/notifications_api/api/send_email';
				    $userTb->postToCurl($url,$email_json,$header);

                }
                else{
                    $err_mess = 'Failed to update password';
					$json_obj = $userTb->newFailureResponse($err_mess);
					$logsTb->createLog('web','passwordChanged',$hash,$json_obj);
                }
            }
            else{
                $err_mess = 'Failed to reset password';
				$json_obj = $userTb->newFailureResponse($err_mess);
				$logsTb->createLog('web','passwordChanged',$hash,$json_obj);
            }
            print_r($json_obj);exit;
            
        }
        
    }




	



    public function getBreederDetails($id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$breedersTb = TableRegistry::get('Breeders');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $breedersTb->failureResponse($err_mess,'PackageItems');
				print_r($json_obj);exit;
			}

			$json_obj = $breedersTb->getBreederJson($id);
		    print_r(json_encode($json_obj));exit;
        }
        
    }



    public function getBreederDetails2($creator,$id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$breedersTb = TableRegistry::get('Breeders');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $breedersTb->failureResponse($err_mess,'PackageItems');
				print_r($json_obj);exit;
			}

			$json_obj = $breedersTb->getBreederIdById2Json($creator,$id);
		    print_r(json_encode($json_obj));exit;
        }
        
    }



    public function getBreedersBySex($creator,$sex_id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$breedersTb = TableRegistry::get('Breeders');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $breedersTb->failureResponse($err_mess,'PackageItems');
				print_r($json_obj);exit;
			}

			$json_obj = $breedersTb->getBreedersBySexJson($creator,$sex_id);
		    print_r(json_encode($json_obj));exit;
        }
        
    }




    public function getBreedersByStatus($creator,$status_id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$breedersTb = TableRegistry::get('Breeders');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $breedersTb->failureResponse($err_mess,'PackageItems');
				print_r($json_obj);exit;
			}

			$json_obj = $breedersTb->getBreedersByStatusJson($creator,$status_id);
		    print_r(json_encode($json_obj));exit;
        }
        
    }



    public function addNewBreeder()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$sess = $this->request->getSession()->read('Auth.User');
        	//print_r($sess);exit;
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$breedersTb = TableRegistry::get('Breeders');
    		$usersTb = TableRegistry::get('Users');
    		$packageItemsTb = TableRegistry::get('PackageItems');

    		$data = $breedersTb->newEntity();
    		$input_data = $this->request->data;
    		$data = $breedersTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $breedersTb->failureResponse($err_mess,'Breeder');
				print_r($json_obj);exit;
			}

			$no_of_breeders = $breedersTb->getNoOfBreeders($data['creator']);
			$package_id = $usersTb->getPackageById($data['creator']);
			$package_quantity = $packageItemsTb->getQuantityByPackageId($package_id);
			//print_r($package_quantity);exit;
			if($no_of_breeders >= $package_quantity){
				$err_mess = 'You have reached your maximum breeding rabbits';
				$json_obj = $breedersTb->failureResponse($err_mess,'User');
				$logsTb->createLog($input_data['soruce'],'addNewBreeder',json_encode($data),$json_obj);
				print_r($json_obj);exit;
			}


		    $data['created'] = date('Y-m-d H:i');
		    $data['creator'] = $data['creator'];
		    //print_r($input_data);exit;
		    if($breedersTb->save($data)){
		    	$succ_msg = "Breeder created successfully";
				$json_obj = $breedersTb->successResponseCreateUser($data['api_key'],$succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'addNewBreeder',json_encode($data),$json_obj);
		    	$this->Flash->success(__($succ_msg));
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $breedersTb->failureResponse($err_mess,'User');
				$logsTb->createLog($input_data['soruce'],'addNewBreeder',json_encode($data),$json_obj);
				$this->Flash->error(__($err_mess));
			}
		    print_r($json_obj);exit;
        }
        
    }



    public function editBreeder()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$sess = $this->request->getSession()->read('Auth.User');
        	//print_r($sess);exit;
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$breedersTb = TableRegistry::get('Breeders');

    		$id = $this->request->data['id'];
	        $data = $breedersTb->get($id, ['contain' => [],]);

    		$input_data = $this->request->data;
    		//print_r($input_data);exit;
    		$data = $breedersTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $breedersTb->failureResponse($err_mess,'Breeder');
				print_r($json_obj);exit;
			}

			if($input_data['status_id'] != 2){
				$data['status_id'] = $input_data['status_id'];
			}

			if($input_data['status_id'] == 6){
				$data['cause_of_death'] = $input_data['cause_of_death'];
			}
		    $data['modified'] = date('Y-m-d H:i');
		    $data['modifier'] = $input_data['modifier'];
		    //$data['creator'] = @$sess['id'];
		    //print_r($data);exit;
		    if($breedersTb->save($data)){
		    	$succ_msg = "Breeder saved successfully";
				$json_obj = $breedersTb->successResponseCreateUser($data['api_key'],$succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'addNewBreeder',json_encode($data),$json_obj);
		    	$this->Flash->success(__($succ_msg));
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $breedersTb->failureResponse($err_mess,'User');
				$logsTb->createLog($input_data['soruce'],'addNewBreeder',json_encode($data),$json_obj);
				$this->Flash->error(__($err_mess));
			}
		    print_r($json_obj);exit;
        }
        
    }



    public function deleteBreeder($id,$modifier)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$breedersTb = TableRegistry::get('Breeders');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $breedersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$del_resp = $breedersTb->flagDeleted($id,$modifier);
			if($del_resp){
				$succ_msg = "Breeder deleted successfully";
				$json_obj = $breedersTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog('','deleteBreeder','',$json_obj);
			}
		    else{
				$err_mess = 'Failed to delete';
				$json_obj = $breedersTb->newFailureResponse($err_mess);
				$logsTb->createLog('','deleteBreeder','',$json_obj);
			}
		    print_r($json_obj);exit;
        }
        
    }





    public function getBreederWeight($creator,$id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$weightsTb = TableRegistry::get('Weights');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $weightsTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$json_obj = $weightsTb->getWeightsByBreederId($id,$creator);
		    print_r(json_encode($json_obj));exit;
        }
        
    }





    public function addNewBreederWeight()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$sess = $this->request->getSession()->read('Auth.User');
        	//print_r($sess);exit;
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$weightsTb = TableRegistry::get('Weights');

    		$data = $weightsTb->newEntity();
    		$input_data = $this->request->data;
    		$data = $weightsTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $weightsTb->failureResponse($err_mess,'Breeder');
				print_r($json_obj);exit;
			}

		    $data['created'] = date('Y-m-d H:i');
		    //print_r($input_data);exit;
		    if($weightsTb->save($data)){
		    	$succ_msg = "Weight added successfully";
				$json_obj = $weightsTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'addNewBreederWeight',json_encode($data),$json_obj);
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $weightsTb->newFailureResponse($err_mess);
				$logsTb->createLog($input_data['soruce'],'addNewBreederWeight',json_encode($data),$json_obj);
			}
		    print_r($json_obj);exit;
        }
        
    }





    public function deleteBreederWeight($id,$creator)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$weightsTb = TableRegistry::get('Weights');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $weightsTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$del_resp = $weightsTb->deleteWeight($id,$creator);
			if($del_resp){
				$succ_msg = "Weight deleted successfully";
				$json_obj = $weightsTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog('','deleteBreederWeight','',$json_obj);
			}
		    else{
				$err_mess = 'Failed to delete';
				$json_obj = $weightsTb->newFailureResponse($err_mess);
				$logsTb->createLog('','deleteBreederWeight','',$json_obj);
			}
		    print_r($json_obj);exit;
        }
        
    }





    public function getBreedingPlanById($id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$plansTb = TableRegistry::get('Plans');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $plansTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$json_obj = $plansTb->getPlansByIdJson($id);
		    print_r(json_encode($json_obj));exit;
        }
        
    }



    public function deleteBreedingPlan($creator,$id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$plansTb = TableRegistry::get('Plans');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $plansTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$json_obj = $plansTb->deletePlan($id,$creator);
			//print_r($json_obj);exit;
			if($json_obj){
				$succ_msg = "Successfully deleted";
				$json_obj = $plansTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog('','deleteBirth','',$json_obj);
			}
			else{
				$succ_msg = "Failed to deleted";
				$json_obj = $plansTb->newFailureResponse($succ_msg);
		    	$logsTb->createLog('','deleteBirth','',$json_obj);
			}
			print_r($json_obj);exit;
        }
        
    }




    public function newBreed()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$sess = $this->request->getSession()->read('Auth.User');
        	//print_r($sess);exit;
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$plansTb = TableRegistry::get('Plans');
    		$defaultTaskTb = TableRegistry::get('DefaultTasks');
    		$scheduleTb = TableRegistry::get('Schedules');
    		$breedersTb = TableRegistry::get('Breeders');

    		$data = $plansTb->newEntity();
    		$input_data = $this->request->data;
    		$data = $plansTb->patchEntity($data, $this->request->getData());

    		$doe_name = $breedersTb->getBreederNameById($data['doe']);
    		$buck_name = $breedersTb->getBreederNameById($data['buck']);

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $plansTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

		    $data['created'] = date('Y-m-d H:i');
		    $data['name'] = $data['date'].'('.$doe_name.'&'.$buck_name.')';
		    //print_r($input_data);exit;
		    $res = $plansTb->save($data);
		    if($res){
		    	$plan_id = $res->id;
		    	$tasks = $defaultTaskTb->getDefaultTasks(2);
		    	foreach($tasks as $task){
		    		$scheduleTb->saveSchedule($data['doe'],$task->name,$data['creator'],$data['date'],$plan_id);
		    	}
		    	$succ_msg = "Successfully saved";
				$json_obj = $plansTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'newBreed',json_encode($data),$json_obj);
		    	$this->Flash->success(__($succ_msg));
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $plansTb->newFailureResponse($err_mess);
				$logsTb->createLog($input_data['soruce'],'newBreed',json_encode($data),$json_obj);
				$this->Flash->error(__($err_mess));
			}
		    print_r($json_obj);exit;
        }
        
    }




    public function editBreed()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	//$sess = $this->request->getSession()->read('Auth.User');
        	//print_r($sess);exit;
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$plansTb = TableRegistry::get('Plans');
    		$defaultTaskTb = TableRegistry::get('DefaultTasks');
    		$scheduleTb = TableRegistry::get('Schedules');
    		$breedersTb = TableRegistry::get('Breeders');

    		$id = $this->request->data['id'];
	        $data = $plansTb->get($id, ['contain' => [],]);

    		$input_data = $this->request->data;
    		$data = $plansTb->patchEntity($data, $this->request->getData());

    		$doe_name = $breedersTb->getBreederNameById($input_data['doe']);
    		$buck_name = $breedersTb->getBreederNameById($input_data['buck']);

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $plansTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

		    $data['modified'] = date('Y-m-d H:i');
		    $data['name'] = $input_data['date'].'('.$doe_name.'&'.$buck_name.')';
		    //print_r($input_data);exit;
		    $res = $plansTb->save($data);
		    if($res){
		    	$scheduleTb->deleteTaskByPlan($input_data['id']);
		    	$tasks = $defaultTaskTb->getDefaultTasks(2);
		    	foreach($tasks as $task){
		    		$scheduleTb->saveSchedule($data['doe'],$task->name,$data['creator'],$data['date'],$input_data['id']);
		    	}
		    	$succ_msg = "Successfully saved";
				$json_obj = $plansTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'newBreed',json_encode($data),$json_obj);
		    	$this->Flash->success(__($succ_msg));
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $plansTb->newFailureResponse($err_mess);
				$logsTb->createLog($input_data['soruce'],'newBreed',json_encode($data),$json_obj);
				$this->Flash->error(__($err_mess));
			}
		    print_r($json_obj);exit;
        }
        
    }




    public function recordBirth()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$sess = $this->request->getSession()->read('Auth.User');
        	//print_r($sess);exit;
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$littersTb = TableRegistry::get('Litters');
    		$plansTb = TableRegistry::get('Plans');

    		$data = $littersTb->newEntity();
    		$input_data = $this->request->data;
    		$data = $littersTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $littersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$plan_data = $plansTb->getPlansById($data['plan_id']);
		    $data['buck'] = $plan_data[0]['buck'];
		    $data['doe'] = $plan_data[0]['doe'];
		    $data['created'] = date('Y-m-d H:i');
		    //print_r($data);exit;
		    if($littersTb->save($data)){
		    	$succ_msg = "Successfully saved";
				$json_obj = $littersTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'newBreed',json_encode($data),$json_obj);
		    	$this->Flash->success(__($succ_msg));
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $littersTb->newFailureResponse($err_mess);
				$logsTb->createLog($input_data['soruce'],'newBreed',json_encode($data),$json_obj);
				$this->Flash->error(__($err_mess));
			}
		    print_r($json_obj);exit;
        }
        
    }




    public function editBirth()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$sess = $this->request->getSession()->read('Auth.User');
        	//print_r($sess);exit;
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$littersTb = TableRegistry::get('Litters');
    		$plansTb = TableRegistry::get('Plans');

    		$id = $this->request->data['id'];
	        $data = $littersTb->get($id, ['contain' => [],]);

    		$input_data = $this->request->data;
    		$data = $littersTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $littersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			//print_r($data);exit;
			$plan_data = $plansTb->getPlansById($data['plan_id']);
		    $data['buck'] = $plan_data[0]['buck'];
		    $data['doe'] = $plan_data[0]['doe'];
		    $data['created'] = date('Y-m-d H:i');
		    //print_r($data);exit;
		    if($littersTb->save($data)){
		    	$succ_msg = "Successfully saved";
				$json_obj = $littersTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'editBirth',json_encode($data),$json_obj);
		    	$this->Flash->success(__($succ_msg));
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $littersTb->newFailureResponse($err_mess);
				$logsTb->createLog($input_data['soruce'],'editBirth',json_encode($data),$json_obj);
				$this->Flash->error(__($err_mess));
			}
		    print_r($json_obj);exit;
        }
        
    }





    public function getPackageItem($id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$packageItemsTb = TableRegistry::get('PackageItems');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $packageItemsTb->failureResponse($err_mess,'PackageItems');
				print_r($json_obj);exit;
			}

			$json_obj = $packageItemsTb->getPackageItemByIdJson($id);
		    print_r(json_encode($json_obj));exit;
        }
        
    }





    public function getBirthDetails($id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$littersTb = TableRegistry::get('Litters');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $littersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$json_obj = $littersTb->getBirthDetailsJson($id);
		    print_r(json_encode($json_obj));exit;
        }
        
    }





    public function getDefaultTasks($type)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$defaulTasksTb = TableRegistry::get('DefaultTasks');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $packageItemsTb->failureResponse($err_mess,'PackageItems');
				print_r($json_obj);exit;
			}

			$json_obj = $defaulTasksTb->getDefaultTasks($type);
		    print_r(json_encode($json_obj));exit;
        }
        
    }




    public function getRabbitName($id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$breedersTb = TableRegistry::get('Breeders');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $breedersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$json_obj = $breedersTb->getBreederNameAndSexJson($id);
		    print_r(json_encode($json_obj));exit;
        }
        
    }



    public function deleteBirth($id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$littersTb = TableRegistry::get('Litters');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $littersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$json_obj = $littersTb->deleteBirth($id);
			//print_r($json_obj);exit;
			if($json_obj){
				$succ_msg = "Successfully deleted";
				$json_obj = $littersTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog('','deleteBirth','',$json_obj);
			}
			else{
				$succ_msg = "Failed to deleted";
				$json_obj = $littersTb->newFailureResponse($succ_msg);
		    	$logsTb->createLog('','deleteBirth','',$json_obj);
			}
			print_r($json_obj);exit;
        }
        
    }



    public function getLedgersByType($creator,$type=null)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$ledgersTb = TableRegistry::get('Ledgers');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $ledgersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}
			if(!empty($type)){
				$json_obj = $ledgersTb->getMonthlyLedgerByType($type,$creator);
			}
			else{
				$json_obj = $ledgersTb->getMonthlyLedgers($creator);
			}
		    print_r(json_encode($json_obj));exit;
        }
        
    }



    public function getLedgersById($creator,$id=null)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$ledgersTb = TableRegistry::get('Ledgers');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $ledgersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}
			$json_obj = $ledgersTb->getLedgerById($id,$creator);
		    print_r(json_encode($json_obj));exit;
        }
        
    }



    public function getTotalIncomeNExpense($creator){
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$ledgersTb = TableRegistry::get('Ledgers');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $ledgersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}
			$json_obj = $ledgersTb->getMonthlyProfitNLoss($creator);
		    print_r(json_encode($json_obj));exit;
        }
    }




    public function addToLedger()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$sess = $this->request->getSession()->read('Auth.User');
        	//print_r($sess);exit;
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$ledgersTb = TableRegistry::get('Ledgers');
    		$breedersTb = TableRegistry::get('Breeders');
    		$littersTb = TableRegistry::get('Litters');

    		$data = $ledgersTb->newEntity();
    		$input_data = $this->request->data;
    		$data = $ledgersTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $ledgersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			//print_r($input_data);exit;
			if($input_data['cat_id'] == 2){
				if($input_data['status_id'] == 4){
					$status_name = 'Sold';
				}
				elseif($input_data['status_id'] == 5){
					$status_name = 'Butchered';
				}
				$data['name'] = $status_name.' breeder '.$breedersTb->getBreederNameById($input_data['breeder_id']);
				$data['breeder'] = $breedersTb->getBreederIdById($input_data['breeder_id']).':'.$breedersTb->getBreederNameById($input_data['breeder_id']);
				$breedersTb->updateStatus($input_data['breeder_id'],$input_data['status_id']);
			}
			elseif($input_data['cat_id'] == 3){
				if($input_data['status_id'] == 4){
					$status_name = 'Sold';
				}
				elseif($input_data['status_id'] == 5){
					$status_name = 'Butchered';
				}
				$data['name'] = $status_name.' litter '.$littersTb->getLitterIdById($input_data['litter_id']);
				$data['breeder'] = $littersTb->getLitterIdById($input_data['litter_id']);
				$littersTb->updateSoldLitter($input_data['litter_id'],$input_data['quantity']);
			}
			

		    $data['created'] = date('Y-m-d H:i');
		    //print_r($data);exit;
		    if($ledgersTb->save($data)){
		    	$succ_msg = "Successfully saved";
				$json_obj = $ledgersTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'addToLedger',json_encode($data),$json_obj);
		    	$this->Flash->success(__($succ_msg));
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $ledgersTb->newFailureResponse($err_mess);
				$logsTb->createLog($input_data['soruce'],'addToLedger',json_encode($data),$json_obj);
				$this->Flash->error(__($err_mess));
			}
		    print_r($json_obj);exit;
        }
        
    }




    public function editLedger()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$sess = $this->request->getSession()->read('Auth.User');
        	//print_r($sess);exit;
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$ledgersTb = TableRegistry::get('Ledgers');
    		$breedersTb = TableRegistry::get('Breeders');
    		$littersTb = TableRegistry::get('Litters');

    		$id = $this->request->data['id'];
	        $data = $ledgersTb->get($id, ['contain' => [],]);

    		$input_data = $this->request->data;
    		$data = $ledgersTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $ledgersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			//print_r($input_data);exit;
			if($input_data['cat_id'] == 2){
				if($input_data['status_id'] == 4){
					$status_name = 'Sold';
				}
				elseif($input_data['status_id'] == 5){
					$status_name = 'Butchered';
				}
				$data['name'] = $status_name.' breeder '.$breedersTb->getBreederNameById($input_data['breeder_id']);
				$data['breeder'] = $breedersTb->getBreederIdById($input_data['breeder_id']).':'.$breedersTb->getBreederNameById($input_data['breeder_id']);
				$breedersTb->updateStatus($input_data['breeder_id'],$input_data['status_id']);
			}
			elseif($input_data['cat_id'] == 3){
				if($input_data['status_id'] == 4){
					$status_name = 'Sold';
				}
				elseif($input_data['status_id'] == 5){
					$status_name = 'Butchered';
				}
				$data['name'] = $status_name.' litter '.$littersTb->getLitterIdById($input_data['litter_id']);
				$data['breeder'] = $littersTb->getLitterIdById($input_data['litter_id']);
				$littersTb->updateSoldLitter($input_data['litter_id'],$input_data['quantity']);
			}
			

		    $data['created'] = date('Y-m-d H:i');
		    //print_r($data);exit;
		    if($ledgersTb->save($data)){
		    	$succ_msg = "Successfully saved";
				$json_obj = $ledgersTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'editLedger',json_encode($data),$json_obj);
		    	$this->Flash->success(__($succ_msg));
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $ledgersTb->newFailureResponse($err_mess);
				$logsTb->createLog($input_data['soruce'],'editLedger',json_encode($data),$json_obj);
				$this->Flash->error(__($err_mess));
			}
		    print_r($json_obj);exit;
        }
        
    }



    public function ledgerReport(){
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$ledgersTb = TableRegistry::get('Ledgers');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $ledgersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$input_data = $this->request->data;
			$creator = @$input_data['creator'];
			$date_from = @$input_data['date_from'];
			$date_to = @$input_data['date_to'];
			$cat_id = @$input_data['cat_id'];
			$type = @$input_data['ledger_type_id'];

			if($date_from == 0){
				$date_from = '';
			}
			if($date_to == 0){
				$date_to = '';
			}
			if($cat_id == 0){
				$cat_id = '';
			}
			if($type == 0){
				$type = '';
			}
			
			$condition =array();
			if($date_from and !$date_to) $condition[]="l.date >= '$date_from' ";	
			if($date_to and !$date_from) $condition[]="l.date <= '$date_to' ";	
			if($date_to and $date_from) $condition[]="l.date  between  '$date_from' and '$date_to' ";	
			
			if($cat_id) $condition[]="l.cat_id = '$cat_id' ";	
			if($type) $condition[]="l.ledger_type_id = '$type' ";
			if($creator) $condition[]="l.creator = '$creator' ";	
			$condition = implode ( ' and ' , $condition );
			$table = 'ledgers l';

			$conn = ConnectionManager::get('default');
			if(!empty($condition)){
				$sql = "select l.*,s.name as 'cat_name',t.name as 'ledger_type_name' from $table inner join schedule_types s on  s.id = l.cat_id
						inner join ledger_types t on t.id = l.ledger_type_id where $condition and l.deleted =0 order by l.id desc";
				$stmt = $conn->execute($sql);
				$results['data'] = $stmt ->fetchAll('assoc');

				$sql2 = "select sum(amount) as income from $table where $condition and ledger_type_id = 1 and deleted =0 order by id desc";
				$stmt2 = $conn->execute($sql2);
				$results2 = $stmt2 ->fetchAll('assoc');
				$income = @$results2[0]['income'];

				$sql3 = "select sum(amount) as expense from $table where $condition and ledger_type_id = 2 and deleted =0 order by id desc";
				$stmt3 = $conn->execute($sql3);
				$results3 = $stmt3 ->fetchAll('assoc');
				$expense = @$results3[0]['expense'];

				$pnl = $income - $expense;

				$results['stats']['income'] = $income;
				$results['stats']['expense'] = $expense;
				$results['stats']['pnl'] = $pnl;
			}
			
			//print_r($sql);exit;
		    print_r(json_encode($results));exit;
        }
    }





    public function deleteLedger($creator,$id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$ledgersTb = TableRegistry::get('Ledgers');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $ledgersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$json_obj = $ledgersTb->deleteLedger($id,$creator);
			//print_r($json_obj);exit;
			if($json_obj){
				$succ_msg = "Successfully deleted";
				$json_obj = $ledgersTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog('','deleteLedger','',$json_obj);
			}
			else{
				$succ_msg = "Failed to deleted";
				$json_obj = $ledgersTb->newFailureResponse($succ_msg);
		    	$logsTb->createLog('','deleteLedger','',$json_obj);
			}
			print_r($json_obj);exit;
        }
        
    }




    public function getBreedingPlans($creator,$type)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$plansTb = TableRegistry::get('Plans');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $plansTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}
			if($type == 'pending'){
				$json_obj = $plansTb->getPendingPlans($creator);
			}
			elseif($type == 'all'){
				$json_obj = $plansTb->getAllPlans($creator);
			}
		    print_r(json_encode($json_obj));exit;
        }
        
    }




    public function getSchedules($creator,$plan_id=null)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$schedulesTb = TableRegistry::get('Schedules');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $plansTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}
			if(empty($plan_id)){
				$json_obj = $schedulesTb->getPendingSchedules($creator);
			}
			else{
				$json_obj = $schedulesTb->getScheduleByPlanId($creator,$plan_id);
			}
		    print_r(json_encode($json_obj));exit;
        }
        
    }



    public function getScheduleByType($creator,$type=null)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$schedulesTb = TableRegistry::get('Schedules');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $plansTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}
			$json_obj = $schedulesTb->getScheduleByType($creator,$type);
		    print_r(json_encode($json_obj));exit;
        }
        
    }





    public function getTasks($creator,$type)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$schedulesTb = TableRegistry::get('Schedules');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $schedulesTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}
			if($type == 'pending'){
				$json_obj = $schedulesTb->getPendingSchedules($creator);
			}
			elseif($type == 'all'){
				$json_obj = $schedulesTb->getAllSchedules($creator);
			}
		    print_r(json_encode($json_obj));exit;
        }
        
    }



    public function getTaskDetail($creator,$id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$schedulesTb = TableRegistry::get('Schedules');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $schedulesTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}
			$json_obj = $schedulesTb->getScheduleById($creator,$id);
		    print_r(json_encode($json_obj));exit;
        }
        
    }




    public function addNewTask()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$sess = $this->request->getSession()->read('Auth.User');
        	//print_r($sess);exit;
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$schedulesTb = TableRegistry::get('Schedules');

    		$data = $schedulesTb->newEntity();
    		$input_data = $this->request->data;
    		$data = $schedulesTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $schedulesTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

		    $data['created'] = date('Y-m-d H:i');
		    //print_r($data);exit;
		    if($schedulesTb->save($data)){
		    	$succ_msg = "Successfully saved";
				$json_obj = $schedulesTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'addNewTask',json_encode($data),$json_obj);
		    	$this->Flash->success(__($succ_msg));
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $schedulesTb->newFailureResponse($err_mess);
				$logsTb->createLog($input_data['soruce'],'addNewTask',json_encode($data),$json_obj);
				$this->Flash->error(__($err_mess));
			}
		    print_r($json_obj);exit;
        }
        
    }




    public function editTask()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {

        	$sess = $this->request->getSession()->read('Auth.User');
        	//print_r($sess);exit;
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$schedulesTb = TableRegistry::get('Schedules');

    		$id = $this->request->data['id'];
	        $data = $schedulesTb->get($id, ['contain' => [],]);
    		$input_data = $this->request->data;
    		$data = $schedulesTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $schedulesTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

		    $data['created'] = date('Y-m-d H:i');
		    //print_r($data);exit;
		    if($schedulesTb->save($data)){
		    	$succ_msg = "Successfully saved";
				$json_obj = $schedulesTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'addNewTask',json_encode($data),$json_obj);
		    	$this->Flash->success(__($succ_msg));
		    	
			}
			else{
				$err_mess = 'Failed to save';
				$json_obj = $schedulesTb->newFailureResponse($err_mess);
				$logsTb->createLog($input_data['soruce'],'addNewTask',json_encode($data),$json_obj);
				$this->Flash->error(__($err_mess));
			}
		    print_r($json_obj);exit;
        }
        
    }





    public function deleteTask($creator,$id)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$schedulesTb = TableRegistry::get('Schedules');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $schedulesTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$json_obj = $schedulesTb->deleteTaskById($creator,$id);
			//print_r($json_obj);exit;
			if($json_obj){
				$succ_msg = "Successfully deleted";
				$json_obj = $schedulesTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog('','deleteBirth','',$json_obj);
			}
			else{
				$succ_msg = "Failed to deleted";
				$json_obj = $schedulesTb->newFailureResponse($succ_msg);
		    	$logsTb->createLog('','deleteBirth','',$json_obj);
			}
			print_r($json_obj);exit;
        }
        
    }






    public function getDashBoardStats($creator)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$breedersTb = TableRegistry::get('Breeders');
    		$littersTb = TableRegistry::get('Litters');
    		$ledgersTb = TableRegistry::get('Ledgers');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $breedersTb->failureResponse($err_mess,'PackageItems');
				print_r($json_obj);exit;
			}

			$json_obj = array();
			$no_litters = $littersTb->getNoLiveKits($creator);
			$no_breeders = $breedersTb->getNoOfBreeders($creator);
			$no_bucks = $breedersTb->getNoOfBucks($creator);
			$no_does = $breedersTb->getNoOfDoes($creator);
			$no_deaths = $breedersTb->getNoOfBreedersByStatus($creator,6);
			$mortality_rate = ($no_deaths/$no_breeders)*100;
			$pnl = $ledgersTb->getMonthlyProfitNLoss($creator);
			//print_r($no_litters);exit;

			$json_obj['no_litters'] = $no_litters;
			$json_obj['no_breeders'] = $no_breeders;
			$json_obj['no_bucks'] = $no_bucks;
			$json_obj['no_does'] = $no_does;
			$json_obj['mortality_rate'] = $mortality_rate.'%';
			$json_obj['pnl'] = $pnl;

		    print_r(json_encode($json_obj));exit;
        }
        
    }




    public function getPackages($type)
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$packageItemsTb = TableRegistry::get('PackageItems');
    		$packagesTb = TableRegistry::get('Packages');

    		//$input_data = $this->request->data;
            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $breedersTb->failureResponse($err_mess,'PackageItems');
				print_r($json_obj);exit;
			}

			$json_obj = $packagesTb->getPackagesById($type);

		    print_r(json_encode($json_obj));exit;
        }
        
    }



    public function createOrder()
    {
    	header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('post')) {
        	$logsTb = TableRegistry::get('Logs');
    		//$userTb = TableRegistry::get('Users');
    		$apikeyTb = TableRegistry::get('ApiKeys');
    		$ordersTb = TableRegistry::get('Orders');
    		$usersTb = TableRegistry::get('Users');
    		$packagesTb = TableRegistry::get('Packages');

    		$data = $ordersTb->newEntity();
    		$input_data = $this->request->data;
    		$data = $ordersTb->patchEntity($data, $this->request->getData());

            $header = getallheaders();
			//print_r($header);exit;

			$api_key = @$header['Api-Key'];
			$validate_key = $apikeyTb->validateKey($api_key);
			if($validate_key != 1){
				$err_mess = 'There is something wrong with your request';
				$json_obj = $ordersTb->newFailureResponse($err_mess);
				print_r($json_obj);exit;
			}

			$package_data = $packagesTb->getPackageById($data['package_id']);
			//print_r($package_data[0]);exit;
			if($data['type'] == 'a'){
				$duration = 'year';
				$price = $package_data[0]->price_yr;
			}
			elseif($data['type'] == 'm'){
				$duration = 'month';
				$price = $package_data[0]->price_m;
			}
			$price = 0.1;

			$key = $ordersTb->generateRandomDigits(4);
			$data['url'] = 'https://api.nalosolutions.com/payplus/api/';
			$header = array();

			$data['momo_number'] = $ordersTb->validatePhoneNumber($data['momo_number']);
			$data['order_no'] = date('ymd').$ordersTb->generateCode(4);
			$data['amount'] = $price;
			$data['package'] = $package_data[0]->name;
			$data['name'] = $usersTb->getNameById($data['user_id']);
			$data['description'] = 'Renewal Of Account'; 
			$data['req'] = $ordersTb->momoRequestOther($key,$data['order_no'],$data['name'],$price,$data['description'],$data['momo_number'],$data['network']);
			//print_r($data);exit;
			$data['resp'] = $ordersTb->postToCurl($data['url'],$data['req'],$header);
			$resp_arr = json_decode($data['resp'],truw);
			$data['invoice_no'] = $resp_arr['InvoiceNo'];
			$data['status'] = $resp_arr['Status'];
		    $data['created'] = date('Y-m-d H:i');
		    //print_r($data);exit;
		    if($data['status'] == 'Accepted'){
		    	$ordersTb->save($data);
		    	$succ_msg = "Payment Accepted. Follow the instructions in the sms received to approve the payment. For enquaries call 0242158047";
				$json_obj = $ordersTb->newSuccessResponse($succ_msg);
		    	$logsTb->createLog($input_data['soruce'],'createOrder',json_encode($data),$json_obj);
		    	$this->Flash->success(__($succ_msg));
		    	
			}
			else{
				$err_mess = 'Payment was not accepted. Please try again';
				$json_obj = $ordersTb->newFailureResponse($err_mess);
				$logsTb->createLog($input_data['soruce'],'createOrder',$data['req'],$data['resp']);
				$this->Flash->error(__($err_mess));
			}
		    print_r($json_obj);exit;
        }
        
    }





    public function naloCallback(){
    	$data1 =  trim(file_get_contents('php://input'));
    	$data = json_decode($data1,true);
    	//print_r($data);exit;

    	$ordersTb = TableRegistry::get('Orders');
    	$usersTb = TableRegistry::get('Users');
    	$billsTb = TableRegistry::get('Bills');
    	$packagesTb = TableRegistry::get('Packages');

    	$user_id = $ordersTb->getUserIdByOrderNo($data['Order_id']);
    	$email = $usersTb->getEmailById($user_id);
    	$phone_no = $usersTb->getPhoneNumberById($user_id);
    	$curr_status = $ordersTb->getStatusByOrderNo($data['Order_id']);

    	if($curr_status == 'Accepted'){
    		$res = $ordersTb->updateOrderStatus($data['Status'],$data['Order_id'],$data1);
	        $subject = 'Payment Notification';
	    	if($data['Status'] == 'PAID'){	
	            $body = 'Payment for Order No: '.$data['Order_id'].' has been successfully paid';
	            $type1 = $ordersTb->getTypeByOrderNo($data['Order_id']);
	            if($type1 == 'a'){
	            	$type = 'yearly';
	            }
	            if($type1 == 'm'){
	            	$type = 'monthly';
	            }
	            $package_name = $ordersTb->getPackageByOrderNo($data['Order_id']);
	            $package_id = $packagesTb->getPackageIDByName($package_name);
	            $bill_resp = $billsTb->createBill($package_id,$user_id,$type,$data['Order_id']);
	            $usersTb->updateRenewAndExpireDate($bill_resp['renew_date'],$bill_resp['expire_date'],$user_id);

	    	}
	    	else{
	    		$body = 'Payment for Order No: '.$data['Order_id'].' was not successful';
	    	}

	    	$header = array();

	        $ordersTb->sendOrderEmail($email,$subject,$body,$data['Order_id']);
	        $ordersTb->sendOderSms($phone_no,$body,$data['Order_id']);
    	}
        $json_obj = '{"Response":"OK"}';
        print_r($json_obj);exit;
    }



}

?>