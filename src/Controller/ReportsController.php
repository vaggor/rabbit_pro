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
class ReportsController extends AppController
{

	public function incomeEspense(){
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        $resp['stats']['income'] = 0;
        $resp['stats']['expense'] = 0;
        $resp['stats']['pnl'] = 0;
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $this->request->params['_csrfToken'];
            $data['creator'] = $sess['id'];
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'ledgerReport';
            $resp = $appsTb->postToCurl($url,$data,$header);
            //print_r($resp);exit;
            $resp = json_decode($resp,true);
        }

        $incomeEspense_active = 'mm-active';
        $title = 'Income/Espense';

        if(empty($data['date_from'])){
        	$date_from = 0;
        }
        else{
        	$date_from = $data['date_from'];
        }

        if(empty($data['date_to'])){
        	$date_to = 0;
        }
        else{
        	$date_to = $data['date_to'];
        }

        if(empty($data['cat_id'])){
        	$cat_id = 0;
        }
        else{
        	$cat_id = $data['cat_id'];
        }

        if(empty($data['type'])){
        	$type = 0;
        }
        else{
        	$type = $data['type'];
        }

        if(empty($data['_csrfToken'])){
        	$csrf = 0;
        }
        else{
        	$csrf = $data['_csrfToken'];
        }
        //print_r($resp);exit;
        $this->set(compact('incomeEspense_active','title','resp','date_from','date_to','cat_id','type','csrf'));
    }



    public function incomeEspenseExport($date_from,$date_to,$cat_id,$type,$csrf){
    	$this->viewBuilder()->setLayout('');
        header('Content-Type: application/json; charset=utf-8');
        $sess = $this->request->getSession()->read('Auth.User');
        $resp['stats']['income'] = 0;
        $resp['stats']['expense'] = 0;
        $resp['stats']['pnl'] = 0;
        if ($this->request->is(['get'])) {
            $data = $this->request->data;
            $data['_csrfToken'] = $csrf;
            $data['creator'] = $sess['id'];
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['cat_id'] = $cat_id;
            $data['ledger_type_id'] = $type;
            //print_r($data);exit;
            $appsTb = TableRegistry::get('Apps');
            $header = array('Api-Key: CDFGT1254#*35HY!@ofr014','Cookie: csrfToken='.$data['_csrfToken']);
            $url = $this->endpoint.'ledgerReport';
            $resp = $appsTb->postToCurl($url,$data,$header);
            //print_r($resp);exit;
            $resp = json_decode($resp,true);
        }

        $incomeEspense_active = 'mm-active';
        $title = 'Income/Espense';
        //print_r($resp);exit;
        $this->set(compact('incomeEspense_active','title','resp'));
    }

}