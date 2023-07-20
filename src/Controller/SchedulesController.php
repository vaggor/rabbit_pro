<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Schedules Controller
 *
 * @property \App\Model\Table\SchedulesTable $Schedules
 *
 * @method \App\Model\Entity\Schedule[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SchedulesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($type)
    {
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is('get')) {

            $apikeysTb = TableRegistry::get('ApiKeys');
            $api_key = $apikeysTb->getApiKey();
            $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'header' => "Api-Key: ".$api_key."\r\n" 
            ),
            "ssl" => [
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ]
            ));
            $url = $this->endpoint.'getBreedingPlans/'.$sess['id'].'/'.$type;
            //print_r($url);exit;
            $resp = file_get_contents($url, false, $context);
            $data = json_decode($resp,true);
        }

        if($type == 'all'){
            $schedule_all_active = 'mm-active';
        }
        else{
            $schedule_all_active = '';
        }

        if($type == 'pending'){
            $schedule_pending_active = 'mm-active';
        }
        else{
            $schedule_pending_active = '';
        }

        $this->set(compact('data','schedule_all_active','schedule_pending_active'));
    }

    



    public function getSchedules($plan_id=null)
    {
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is('get')) {

            $apikeysTb = TableRegistry::get('ApiKeys');
            $api_key = $apikeysTb->getApiKey();
            $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'header' => "Api-Key: ".$api_key."\r\n" 
            ),
            "ssl" => [
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ]
            ));
            $url = $this->endpoint.'getSchedules/'.$sess['id'].'/'.$plan_id;
            //print_r($url);exit;
            $resp = file_get_contents($url, false, $context);
            print_r($resp);exit;
        }

    }


   


    public function editSchedule(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'editBreed';
            $resp = $appsTb->postToCurl($url,$data,$header);
            //print_r($resp);exit;
            $resp = json_decode($resp,true);
            if($resp['status_id'] == 1){
                $this->Flash->success(__($resp['description']));
            }
            else{
                $this->Flash->error(__($resp['description']));
            }
            return $this->redirect(['action' => 'index','all']);
        }
    }




    public function getItemToBeEdited($id)
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($this->request->is('get')) {

            $apikeysTb = TableRegistry::get('ApiKeys');
            $api_key = $apikeysTb->getApiKey();
            $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'header' => "Api-Key: ".$api_key."\r\n" 
            ),
            "ssl" => [
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ]
        ));
        $url = $this->endpoint.'getBreedingPlanById/'.$id;
        //print_r($url);exit;
        $resp = file_get_contents($url, false, $context);
        print_r($resp);exit;
        }
        
    }





    public function deletePlan($plan_id=null)
    {
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is('get')) {

            $apikeysTb = TableRegistry::get('ApiKeys');
            $api_key = $apikeysTb->getApiKey();
            $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'header' => "Api-Key: ".$api_key."\r\n" 
            ),
            "ssl" => [
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ]
            ));
            $url = $this->endpoint.'deleteBreedingPlan/'.$sess['id'].'/'.$plan_id;
            //print_r($url);exit;
            $resp = file_get_contents($url, false, $context);
            $resp = json_decode($resp,true);
            if($resp['status_id'] == 1){
                $this->Flash->success(__($resp['description']));
            }
            else{
                $this->Flash->error(__($resp['description']));
            }
            return $this->redirect($this->referer());
        }

    }



}
