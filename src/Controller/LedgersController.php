<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Ledgers Controller
 *
 * @property \App\Model\Table\LedgersTable $Ledgers
 *
 * @method \App\Model\Entity\Ledger[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LedgersController extends AppController
{
    public function index($type=null)
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
            $url = $this->endpoint.'getLedgersByType/'.$sess['id'].'/'.$type;
            $inc_exp_url = $this->endpoint.'getTotalIncomeNExpense/'.$sess['id'];
            //print_r($url);exit;
            $resp = file_get_contents($url, false, $context);
            $data = json_decode($resp,true);

            $inc_exp_resp = file_get_contents($inc_exp_url, false, $context);
            $inc_exp_data = json_decode($inc_exp_resp,true);
        }

        if($type == 1){
            $income_active = 'mm-active';
            $title = 'Income';
        }
        else{
            $income_active = '';
        }

        if($type == 2){
            $expenditure_active = 'mm-active';
            $title = 'Expenditure';
        }
        else{
            $expenditure_active = '';
        }

        if(empty($type)){
            $ledger_all_active = 'mm-active';
            $title = 'All Ledger';
        }
        else{
            $ledger_all_active = '';
        }

        $this->set(compact('data','inc_exp_data','income_active','expenditure_active','title','ledger_all_active'));
    }



    /**
     * View method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ledger = $this->Ledgers->get($id, [
            'contain' => ['Cats', 'LedgerTypes'],
        ]);

        $this->set('ledger', $ledger);
    }

    


    public function newLedger(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'addToLedger';
            $resp = $appsTb->postToCurl($url,$data,$header);
            //print_r($resp);exit;
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


    


    public function editLedger(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;

            if(empty($data['date'])){
                $this->Flash->error(__('Please select Date'));
                return $this->redirect($this->referer());
            }
            if(empty($data['cat_id'])){
                $this->Flash->error(__('Please select Category'));
                return $this->redirect($this->referer());
            }
            if(empty($data['ledger_type_id'])){
                $this->Flash->error(__('Please select Type'));
                return $this->redirect($this->referer());
            }
            if(empty($data['breeder_id']) and $data['cat_id'] == 2){
                $this->Flash->error(__('Please select Breeder'));
                return $this->redirect($this->referer());
            }
            if(empty($data['amount'])){
                $this->Flash->error(__('Please enter Amount'));
                return $this->redirect($this->referer());
            }
            if(empty($data['litter_id']) and $data['cat_id'] == 3){
                $this->Flash->error(__('Please select Liiter'));
                return $this->redirect($this->referer());
            }
            if(empty($data['name']) and in_array($data['cat_id'], array(1,4))){
                $this->Flash->error(__('Please enter Name'));
                return $this->redirect($this->referer());
            }
            if(empty($data['status_id']) and in_array($data['cat_id'], array(2,3))){
                $this->Flash->error(__('Please select status'));
                return $this->redirect($this->referer());
            }

            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'editLedger';
            $resp = $appsTb->postToCurl($url,$data,$header);
            //print_r($resp);exit;
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




    public function getLedgerDetail($id=null)
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
            $url = $this->endpoint.'getLedgersById/'.$sess['id'].'/'.$id;
            //print_r($url);exit;
            $resp = file_get_contents($url, false, $context);
            print_r($resp);exit;
        }

    }



    public function deleteLedger($id=null)
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
            $url = $this->endpoint.'deleteLedger/'.$sess['id'].'/'.$id;
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




    public function multipleDelete()
    {
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is('post')) {
            $data = $this->request->data;
            //print_r($data);exit;
            if(!isset($data['delete'])){
                $this->Flash->error(__('Please select items to delete'));
                return $this->redirect($this->referer());
            }
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
            $i=0;
            foreach($data['delete'] as $id){
                $url = $this->endpoint.'deleteLedger/'.$sess['id'].'/'.$id;
                //print_r($url);exit;
                $resp = file_get_contents($url, false, $context);
                $resp = json_decode($resp,true);
                if($resp['status_id'] == 1){
                    $i++;
                }
            }

            if($i >= 1){
                $this->Flash->success(__('Deleted Successfully'));
            }
            else{
                $this->Flash->error(__('Failed to deleted'));
            }
            return $this->redirect($this->referer());
        }

    }




}
