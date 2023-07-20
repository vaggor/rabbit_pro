<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Breeders Controller
 *
 * @property \App\Model\Table\BreedersTable $Breeders
 *
 * @method \App\Model\Entity\Breeder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DashboardController extends AppController
{
    
    public function index(){
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
            $url = $this->endpoint.'getDashBoardStats/'.$sess['id'];
            $resp = file_get_contents($url, false, $context);
            $data = json_decode($resp, true);

            $task_url = $this->endpoint.'getTasks/'.$sess['id'].'/pending';
            $task_resp = file_get_contents($task_url, false, $context);
            $task_data = json_decode($task_resp, true);

            $plans_url = $this->endpoint.'getBreedingPlans/'.$sess['id'].'/pending';
            $plans_resp = file_get_contents($plans_url, false, $context);
            $plans_data = json_decode($plans_resp,true);
            //print_r($url);exit;
            
            $this->set(compact('data','task_data','plans_data'));
        }
    }



    public function subscription($type=null){
        $this->viewBuilder()->setLayout('packages');
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
            $url = $this->endpoint.'getPackages/'.$type;
            $resp = file_get_contents($url, false, $context);
            $data = json_decode($resp, true);
            //print_r($data);exit;
            
            $this->set(compact('data','type'));
        }
    }



    public function order($package_id=null,$type=null){
        $this->viewBuilder()->setLayout('payment');
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        $packagesTb = TableRegistry::get('Packages');
        $package_data = $packagesTb->getPackageById($package_id);
        if($type == 'a'){
            $price = $package_data[0]->price_yr;
        }
        elseif($type == 'm'){
            $price = $package_data[0]->price_m;
        }
        $this->set(compact('package_id','type','price'));
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['user_id'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'createOrder';
            $resp = $appsTb->postToCurl($url,$data,$header);
            //print_r($resp);exit;
            $resp = json_decode($resp,true);
            //print_r($resp);exit;
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

?>