<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Table\AppsTable;

class OrdersTable extends AppsTable
{
	public function getUserIdByOrderNo($order_no){
		$data = $this->find()
            ->select(['user_id'])
            ->where(['deleted'=>0,'order_no'=>$order_no])
            ->toArray();
            return $data[0]['user_id'];
	}


  public function getAmountByOrderNo($order_no){
    $data = $this->find()
            ->select(['amount'])
            ->where(['deleted'=>0,'order_no'=>$order_no])
            ->toArray();
            return $data[0]['amount'];
  }



  public function getPreviousDayUnapprovedOrders(){
    //$previous_day_date = date('Y-m-d', strtotime('-1 day'));
    //print_r($previous_day_date);exit;
    $data = $this->find()
            ->where(['deleted'=>0, 'created <'=>date('Y-m-d'), 'status'=>'Accepted'])
            ->toArray();
    //print_r($data);exit;
    return $data;
  }



  public function getPackageByOrderNo($order_no){
    $data = $this->find()
            ->select(['package'])
            ->where(['deleted'=>0,'order_no'=>$order_no])
            ->toArray();
            return $data[0]['package'];
  }


  public function getTypeByOrderNo($order_no){
    $data = $this->find()
            ->select(['type'])
            ->where(['deleted'=>0,'order_no'=>$order_no])
            ->toArray();
            return $data[0]['type'];
  }


  public function getStatusByOrderNo($order_no){
    $data = $this->find()
            ->select(['status'])
            ->where(['deleted'=>0,'order_no'=>$order_no])
            ->toArray();
            return $data[0]['status'];
  }


	public function updateOrderStatus($status,$order_no,$mess){
        $query = $this->query();
        $result = $query->update()
                    ->set(['status' => $status, 'modified'=>date('Y-m-d H:i'),'callback_mess'=>$mess])
                    ->where(['order_no' => $order_no,'deleted'=>0])
                    ->execute();
        return $result;
      }



      public function updateEmailSent($email_sent,$order_no){
        $query = $this->query();
        $result = $query->update()
                    ->set(['email_sent' => $email_sent, 'email_time'=>date('Y-m-d H:i')])
                    ->where(['order_no' => $order_no,'deleted'=>0])
                    ->execute();
        return $result;
      }



      public function updateSmsSent($sms_sent,$order_no){
        $query = $this->query();
        $result = $query->update()
                    ->set(['sms_sent' => $sms_sent, 'sms_time'=>date('Y-m-d H:i')])
                    ->where(['order_no' => $order_no,'deleted'=>0])
                    ->execute();
        return $result;
      }



    public function sendOrderEmail($to,$subject,$body,$order_no){
      $header = array();

      $email_json = $this->sendEmailRequest($to,$subject,$body);
      $url = 'http://notifications.clickmegh.com/notifications_api/api/send_email';
      $res = $this->postToCurl($url,$email_json,$header);

      if($res == 1){
            $this->updateEmailSent($email_json,$order_no);
      }

      return;
      
    }




    public function sendOderSms($to,$body,$order_no){
      $header = array();

      $email_json = $this->sendSmsRequest($to,$body);
      $url = 'http://notifications.clickmegh.com/notifications_api/api/send_sms';
      $res_json = $this->postToCurl($url,$email_json,$header);
      //print_r($res_json);exit;
      $res = explode('|', $res_json);

      if($res[0] == 1701){
            $this->updateSmsSent($email_json,$order_no);
      }

      return;
      
    }



    public function deleteOrder($id){
        $query = $this->query();
        $result = $query->update()
                    ->set(['deleted' => 1, 'modified'=>date('Y-m-d H:i')])
                    ->where(['id' => $id])
                    ->execute();
        return $result;
    }

}

?>