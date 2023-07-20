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
class BreedersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    //public $endpoint = 'http://localhost:8888/rabbit_pro/app/api/';

    public function index()
    {
        //$this->viewBuilder()->setLayout('test');
        /*$breedsTb = TableRegistry::get('Breeds');
        $sexesTb = TableRegistry::get('Sexes');
        $defaulTasksTb = TableRegistry::get('DefaultTasks');*/

        $sess = $this->request->getSession()->read('Auth.User');
        $data = $this->Breeders->getBreeders($sess['id']);
        $breeder_index_active = 'mm-active';
        /*$breeds = $breedsTb->listBreeds();
        $sexes = $sexesTb->listSexes();*/
       /* $does = $this->Breeders->listBreeders($sess['id'],1);
        $bucks = $this->Breeders->listBreeders($sess['id'],2);
        $default_tasks = $defaulTasksTb->getDefaultTasks(2);*/
        //print_r($sess['id']);exit;
        $this->set(compact('data','breeder_index_active'));
    }



    public function getBreedersBySex($sex){
        $sess = $this->request->getSession()->read('Auth.User');
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
            $url = $this->endpoint.'getBreedersBySex/'.$sess['id'].'/'.$sex;
            //print_r($url);exit;
            $resp = file_get_contents($url, false, $context);
            $data = json_decode($resp,true);

            if($sex == 2){
                $buck_active = 'mm-active';
                $title = 'Bucks';
            }
            else{
                $buck_active = '';
            }
            if($sex == 1){
                $doe_active = 'mm-active';
                $title = 'Does';
            }
            else{
                $doe_active = '';
            }
            //print_r($data);exit;
            $this->set(compact('data','buck_active','doe_active','title'));
        }
    }




    public function getBreedersByStatus($status_id){
        $sess = $this->request->getSession()->read('Auth.User');
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
            $url = $this->endpoint.'getBreedersByStatus/'.$sess['id'].'/'.$status_id;
            //print_r($url);exit;
            $resp = file_get_contents($url, false, $context);
            $data = json_decode($resp,true);

            if($status_id == 4){
                $sold_active = 'mm-active';
                $title = 'Sold';
            }
            else{
                $sold_active = '';
            }
            if($status_id == 5){
                $butchered_active = 'mm-active';
                $title = 'Butchered';
            }
            else{
                $butchered_active = '';
            }
            if($status_id == 6){
                $dead_active = 'mm-active';
                $title = 'Died';
            }
            else{
                $dead_active = '';
            }
            //print_r($data);exit;
            $this->set(compact('data','sold_active','butchered_active','dead_active','title'));
        }
    }







    public function view($id = null)
    {
        $sess = $this->request->getSession()->read('Auth.User');
        $weightsTb = TableRegistry::get('Weights');
        $breedersTb = TableRegistry::get('Breeders');

        $does = $breedersTb->listBreeders($sess['id'],1);
        $bucks = $breedersTb->listBreeders($sess['id'],2);


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
        $url = $this->endpoint.'getBreederDetails/'.$id;
            //print_r($url);exit;
        $resp = file_get_contents($url, false, $context);
        $resp = json_decode($resp,true);

        $weight_url = $this->endpoint.'getBreederWeight/'.$sess['id'].'/'.$id;
            //print_r($url);exit;
        $weight_resp = file_get_contents($weight_url, false, $context);
        $data = json_decode($weight_resp,true);

        $this->set(compact('data','does','bucks','id','resp'));
    }





    public function getBreederDetailsWeb($id)
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
        $url = $this->endpoint.'getBreederDetails/'.$id;
        //print_r($url);exit;
        $resp = file_get_contents($url, false, $context);
        print_r($resp);exit;
        }
        
    }



    public function getBreederName($id)
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
        $url = $this->endpoint.'getRabbitName/'.$id;
        //print_r($url);exit;
        $resp = file_get_contents($url, false, $context);
        print_r($resp);exit;
        }
        
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function new_breeder()
    {
        $sess = $this->request->getSession()->read('Auth.User');
        $breeds = $this->Breeders->Breeds->find('list', ['limit' => 200]);
        $sexes = $this->Breeders->Sexes->find('list', ['limit' => 200]);
        $does = $this->Breeders->listBreeders($sess['id'],1);
        $bucks = $this->Breeders->listBreeders($sess['id'],2);
        $this->set(compact('does','bucks', 'breeds', 'sexes'));
    }



    public function addNewBreed(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'add_new_breeder';
            $resp = $appsTb->postToCurl($url,$data,$header);
            $resp = json_decode($resp,true);
            //print_r($resp);exit;
            if($resp['User']['status_id'] == 1){
                $this->Flash->success(__($resp['User']['description']));
            }
            else{
                $this->Flash->error(__($resp['User']['description']));
            }
            return $this->redirect($this->referer());
        }
    }



    public function newBreed(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'newBreed';
            $resp = $appsTb->postToCurl($url,$data,$header);
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



    public function sellBreeder(){
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



    /**
     * Edit method
     *
     * @param string|null $id Breeder id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function editBreeder($id = null)
    {
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['modifier'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'editBreeder';
            $resp = $appsTb->postToCurl($url,$data,$header);
            //print_r($resp);exit;
            $resp = json_decode($resp,true);
            if($resp['User']['status_id'] == 1){
                $this->Flash->success(__($resp['User']['description']));
            }
            else{
                $this->Flash->error(__($resp['User']['description']));
            }
            return $this->redirect($this->referer());
        }
        
    }





    public function deleteBreeder($id)
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
            $url = $this->endpoint.'deleteBreeder/'.$id.'/'.$sess['id'];
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





    public function deleteWeight($id)
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
            $url = $this->endpoint.'deleteBreederWeight/'.$id.'/'.$sess['id'];
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




    public function exportBreeders()
    {
        $this->viewBuilder()->setLayout('');
        $sess = $this->request->getSession()->read('Auth.User');
        $data = $this->Breeders->getBreedersByStatus($sess['id'],[2,4,5,6]);
        $this->set(compact('data'));
    }





    public function printCageCard($id=null)
    {
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        $this->viewBuilder()->setLayout('cage_card');
        if ($this->request->is('post')) {
            $data = $this->request->data;
            //print_r($data['print']);exit;
            if(!isset($data['print'])){
                $this->Flash->error(__('Please select items to print'));
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

            $ids = implode(',', $data['print']);
            //print_r($ids);exit;
            $url = $this->endpoint.'getBreederDetails2/'.$sess['id'].'/'.$ids;
            //print_r($url);exit;
            $resp = file_get_contents($url, false, $context);
            //print_r($resp);exit;
            $data = json_decode($resp,true);
            //print_r($data);exit;
            $this->set(compact('data'));
        }
        elseif ($this->request->is('get')) {
            
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

            $ids = $id;
            //print_r($ids);exit;
            $url = $this->endpoint.'getBreederDetails2/'.$sess['id'].'/'.$ids;
            //print_r($url);exit;
            $resp = file_get_contents($url, false, $context);
            //print_r($resp);exit;
            $data = json_decode($resp,true);
            //print_r($data);exit;
            $this->set(compact('data'));
        }
    }




    public function addWeight(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'addNewBreederWeight';
            $resp = $appsTb->postToCurl($url,$data,$header);
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
