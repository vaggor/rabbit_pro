<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Plans Controller
 *
 * @property \App\Model\Table\PlansTable $Plans
 *
 * @method \App\Model\Entity\Plan[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TasksController extends AppController
{
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
            $url = $this->endpoint.'getTasks/'.$sess['id'].'/'.$type;
            //print_r($url);exit;
            $resp = file_get_contents($url, false, $context);
            $data = json_decode($resp,true);
        }

        if($type == 'all'){
            $task_all_active = 'mm-active';
            $title = 'All Task';
        }
        else{
            $task_all_active = '';
        }

        if($type == 'pending'){
            $task_pending_active = 'mm-active';
            $title = 'Pending Task';
        }
        else{
            $task_pending_active = '';
        }

        $this->set(compact('data','task_all_active','task_pending_active','title'));
    }




    public function getTaskDetail($id=null)
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
            $url = $this->endpoint.'getTaskDetail/'.$sess['id'].'/'.$id;
            //print_r($url);exit;
            $resp = file_get_contents($url, false, $context);
            print_r($resp);exit;
        }

    }

    



    public function newTask(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'addNewTask';
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



   


   public function editTask(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'editTask';
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



    public function deleteTask($id=null)
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
            $url = $this->endpoint.'deleteTask/'.$sess['id'].'/'.$id;
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
                $url = $this->endpoint.'deleteTask/'.$sess['id'].'/'.$id;
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
