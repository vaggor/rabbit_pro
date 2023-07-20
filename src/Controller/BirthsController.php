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
class BirthsController extends AppController
{

	public function index(){
		$sess = $this->request->getSession()->read('Auth.User');
		$littersTb = TableRegistry::get('Litters');
		$breedersTb = TableRegistry::get('Breeders');

		$data = $littersTb->getLitters($sess['id']);
		$does = $breedersTb->listBreeders($sess['id'],1);
        $bucks = $breedersTb->listBreeders($sess['id'],2);

        $all_births_active = 'mm-active';
		$this->set(compact('data','does','bucks','all_births_active'));
	}




	public function recordBirth(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'recordBirth';
            $resp = $appsTb->postToCurl($url,$data,$header);
            $resp = json_decode($resp,true);
            if($resp['status_id'] == 1){
                $this->Flash->success(__($resp['description']));
            }
            else{
                $this->Flash->error(__($resp['description']));
            }
            return $this->redirect(['action' => 'index']);
        }
    }



    public function editBirth(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'editBirth';
            $resp = $appsTb->postToCurl($url,$data,$header);
            $resp = json_decode($resp,true);
            //print_r($resp);exit;
            if($resp['status_id'] == 1){
                $this->Flash->success(__($resp['description']));
            }
            else{
                $this->Flash->error(__($resp['description']));
            }
            return $this->redirect(['action' => 'index']);
        }
    }



    public function getBirthDetails($id)
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
        $url = $this->endpoint.'getBirthDetails/'.$id;
        //print_r($url);exit;
        $resp = file_get_contents($url, false, $context);
        print_r($resp);exit;
        }
        
    }



    public function deleteBirth($id)
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
	        $url = $this->endpoint.'deleteBirth/'.$id;
	        //print_r($url);exit;
	        $resp = file_get_contents($url, false, $context);
	        return $this->redirect(['action' => 'index']);
        }
        
    }

}