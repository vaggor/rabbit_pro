<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password'],
                    //'userModel' => 'Users'
                    'scope' => ['Users.status_id !=' => 1,'deleted'=>0]
                ],
            ],
            'loginRedirect' => [
                'controller' => 'dashboard',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'users',
                'action' => 'login',
                'home'
            ],
            'unauthorizedRedirect' => $this->referer()
        ]);
        $this->Auth->allow(['login', 'logout','signup','resetPassword','passwordChanged','reset-password','activateAccount']);

        $sess = $this->request->getSession()->read('Auth.User');

        $planesTb = TableRegistry::get('Plans');
        $breedsTb = TableRegistry::get('Breeds');
        $sexesTb = TableRegistry::get('Sexes');
        $BreedersTb = TableRegistry::get('Breeders');
        $defaulTasksTb = TableRegistry::get('DefaultTasks');
        $statusesTb = TableRegistry::get('Statuses');
        $scheduleTypesTb = TableRegistry::get('ScheduleTypes');
        $ledgerTypesTb = TableRegistry::get('LedgerTypes');
        $littersTb = TableRegistry::get('Litters');
        $wightUnitsTb = TableRegistry::get('UnitMeasurements');

        $planes = $planesTb->listPendingPlans(@$sess['id']);
        $breeds = $breedsTb->listBreeds();
        $sexes = $sexesTb->listSexes();
        $does = $BreedersTb->listBreeders(@$sess['id'],1);
        $bucks = $BreedersTb->listBreeders(@$sess['id'],2);

        $does2 = $BreedersTb->listAllBreeders(@$sess['id'],1);
        $bucks2 = $BreedersTb->listAllBreeders(@$sess['id'],2);

        $default_tasks = $defaulTasksTb->getDefaultTasks(2);
        $statuses = $statusesTb->listStatuses();
        $schedule_types = $scheduleTypesTb->listScheduleTypes();
        $ledger_types = $ledgerTypesTb->listLedgerTypes();
        $breeders = $BreedersTb->listAllsexBreeders(@$sess['id']);
        $litters = $littersTb->listLitters(@$sess['id']);
        $sold_butchered_statuses = $statusesTb->listSoldNButcheredStatuses();
        $all_breeders = $BreedersTb->listBreedersByStatus(@$sess['id'],[2,4,5,6]);
        $units = $wightUnitsTb->listUnitMeasurements();
        //print_r($does);exit;
        $this->set(compact('planes','sess','does','bucks','does2','bucks2', 'breeds', 'sexes','default_tasks','statuses','schedule_types','ledger_types','breeders','litters','sold_butchered_statuses','all_breeders','units'));

    }

    public $endpoint = 'http://localhost:8888/rabbit_pro/app/api/';


    public function beforeRender(Event $event){
        $usergroupsModel = $this->loadModel('Usergroups');
        $sess = $this->request->getSession()->read('Auth.User');
        $list_usergroups = $usergroupsModel->listUsergroups();
        //print_r($sess);exit;
        $this->set(compact('sess','list_usergroups'));
        //$this->set('inflector', new inflector);
    }

    public function beforeFilter(Event $event){
        $sess = $this->request->getSession()->read('Auth.User');
        if(!in_array($this->request->getParam('action'), array('login','logout','signup','resetPassword','subscription','order','activateAccount'))){
            //print_r($sess['id']);exit;
            $this->checkExpiry(@$sess['id']);
        }
    }


    public function checkExpiry($id){
        $userTb = TableRegistry::get('Users');
        $expire_date1 = $userTb->getExpiryDateById($id);
        //print_r($expire_date1);exit;
        $today = strtotime(date('Y-m-d H:i'));
        $expire_date = strtotime($expire_date1);
        //print_r($today);exit;
        if($today > $expire_date){
            return $this->redirect('/dashboard/subscription/a');
        }
    }
}
