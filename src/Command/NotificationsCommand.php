<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class NotificationsCommand extends Command
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Schedules');
        $this->loadModel('Users');
        $this->loadModel('Logs');
        $this->loadModel('Jobs');
        $this->loadModel('Orders');

    }

    protected function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser
            ->addArgument('name', [
                'help' => 'What is your name'
            ]);

        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $this->Jobs->createJobLog();
        $this->sendEmail();
        $this->sendSms();
        $this->sendFirstExpirationReminderEmail();
        $this->sendFinalExpirationEmail();
        $this->deactivateAccount();
        $this->clearUnapprovedOrders();
    }






    public function sendEmail(){
        $datas = $this->Schedules->getTodayEmailSchedules();
        foreach($datas as $data){
            //print_r($data->id);exit;
            $to = $this->Users->getEmailById($data->creator);
            $subject = 'Task Alert';
            $body = $data->name;
            $header = array();

            $email_json = $this->Schedules->sendEmailRequest($to,$subject,$body);
            $url = 'http://notifications.clickmegh.com/notifications_api/api/send_email';
            $res = $this->Schedules->postToCurl($url,$email_json,$header);

            if($res == 1){
                $this->Schedules->updateEmailDate($data->id);
            }
            else{
                $this->Logs->createLog('user_id:'.$data->id,'sendEmail',$email_json,$res);
            }

        }
        //print_r($data);exit;
    }





    public function sendSms(){
        $datas = $this->Schedules->getTodaySmsSchedules();
        //print_r($datas);exit;
        foreach($datas as $data){
            $package = $this->Users->getPackageById($data->creator);
            //print_r($package);exit;
            if(!in_array($package, array(1,5))){
                $to = $this->Users->getPhoneNumberById($data->creator);
                $body = $data->name;
                $header = array();

                $email_json = $this->Schedules->sendSmsRequest($to,$body);
                $url = 'http://notifications.clickmegh.com/notifications_api/api/send_sms';
                $res_json = $this->Schedules->postToCurl($url,$email_json,$header);
                //print_r($res_json);exit;
                $res = explode('|', $res_json);

                if($res[0] == 1701){
                    $this->Schedules->updateSmsDate($data->id);
                }
                else{
                    $this->Logs->createLog('user_id:'.$data->id,'sendSms',$email_json,$res_json);
                }

                
            }
            //print_r($data->id);exit;
        }
        //print_r($data);exit;
    }



    public function sendFirstExpirationReminderEmail(){
        $date = date('Y-m-d', strtotime('3 days', strtotime(date('Y-m-d'))));
        //print_r($date);exit;
        $datas = $this->Users->getExpiredAccountsByDate($date);
        //print_r($datas);exit;
        foreach($datas as $data){
            //print_r($data->id);exit;
            $to = $data->email;
            $subject = 'Your RabbitPro Account Ends in 3 Days';
            $body = 'Hi '.$data->name.',<br> I hope you have been enjoying the benefits of using RabbitPro to manage your rabbitry. <p>We want to inform you your account expires in 3 days. Kindly login to renew your account to keep enjoying RabbitPro.</p> <p>Thanks and best wishes,<br>The RabbitPro Team.</p>';
            $header = array();

            $email_json = $this->Users->sendEmailRequest($to,$subject,$body);
            $url = 'http://notifications.clickmegh.com/notifications_api/api/send_email';
            $res = $this->Users->postToCurl($url,$email_json,$header);

            $this->Logs->createLog('user_id:'.$data->name,'sendFirstExpirationReminderEmail',$email_json,$res);

        }
        //print_r($data);exit;
    }




    public function sendFinalExpirationEmail(){
        $date = date('Y-m-d');
        //print_r($date);exit;
        $datas = $this->Users->getExpiredAccountsByDate($date);
        //print_r($datas);exit;
        foreach($datas as $data){
            //print_r($data->id);exit;
            $to = $data->email;
            $subject = 'Your RabbitPro Account Ends Today';
            $body = 'Hi '.$data->name.',<br> I hope you have been enjoying the benefits of using RabbitPro to manage your rabbitry. <p>We want to inform you your account expires today. Kindly login to renew your account to keep enjoying RabbitPro.</p> <p>Thanks and best wishes,<br>The RabbitPro Team.</p>';
            $header = array();

            $email_json = $this->Users->sendEmailRequest($to,$subject,$body);
            $url = 'http://notifications.clickmegh.com/notifications_api/api/send_email';
            $res = $this->Users->postToCurl($url,$email_json,$header);

            $this->Logs->createLog('user_id:'.$data->name,'sendFinalExpirationEmail',$email_json,$res);

        }
        //print_r($data);exit;
    }



    public function deactivateAccount(){
        $date = date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-d'))));
        //print_r($date);exit;
        $datas = $this->Users->getExpiredAccountsByDate($date);
        //print_r($datas);exit;
        foreach($datas as $data){
            //print_r($data->id);exit;
            $status = 3;
            $res = $this->Users->updateStatus($data->id,$status);
        }
    }



    public function clearUnapprovedOrders(){
        $datas = $this->Orders->getPreviousDayUnapprovedOrders();
        //print_r($datas);exit;
        foreach($datas as $data){
            //print_r($data->id);exit;
            $res = $this->Orders->deleteOrder($data->id);
        }
    }


}

?>