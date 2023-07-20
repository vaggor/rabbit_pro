<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function login()
    {
        /*$usersModel = $this->loadModel('Users');
        $pass_hash = $usersModel->hashPass('12345');
        print_r($pass_hash);exit;*/
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Username or password is incorrect'));
            }
        }
    }


    public function logout(){
        return $this->redirect($this->Auth->logout());
    }



    public function signup(){
        $countryTb = TableRegistry::get('Countries');
        $list_countries = $countryTb->listCountries();
        $this->viewBuilder()->setLayout('login');
        $this->set(compact('list_countries'));
    }


    public function resetPassword(){
        $this->viewBuilder()->setLayout('login');
    }



    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['AsssocAccts', 'Statuses', 'Usergroups'],
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['AsssocAccts', 'Statuses', 'Usergroups'],
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $asssocAccts = $this->Users->AsssocAccts->find('list', ['limit' => 200]);
        $statuses = $this->Users->Statuses->find('list', ['limit' => 200]);
        $usergroups = $this->Users->Usergroups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'asssocAccts', 'statuses', 'usergroups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $asssocAccts = $this->Users->AsssocAccts->find('list', ['limit' => 200]);
        $statuses = $this->Users->Statuses->find('list', ['limit' => 200]);
        $usergroups = $this->Users->Usergroups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'asssocAccts', 'statuses', 'usergroups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }



    public function passwordChanged($hash)
    {
        
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
            $url = $this->endpoint.'passwordChanged/'.$hash;
            $resp = file_get_contents($url, false, $context);
            $data = json_decode($resp, true);

            if($data['status_id'] == 1){
                $this->Flash->success(__($data['description']));
                $this->redirect('/users/login');
            }
            else{
                $this->Flash->error(__($data['description']));
                $this->redirect('/users/reset-password');
            }
            
        }
        
    }



    public function changePassword(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'changePassword';
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




    public function activateAccount($hash)
    {
        
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
            $url = $this->endpoint.'activateAccount/'.$hash;
            $resp = file_get_contents($url, false, $context);
            //print_r($resp);exit;
            $data = json_decode($resp, true);
            //print_r($data);exit;
            if($data['status_id'] == 1){
                $this->Flash->success(__($data['description']));
            }
            else{
                $this->Flash->error(__($data['description']));
            }
            $this->redirect('/users/login');
            
        }
        
    }



}
