<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class BillsTable extends Table
{
	public function listPackageItems(){
		$data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0])
            ->toArray();
            return $data;
	}


	public function getBillsByUserId($user_id){
        $data = $this->find()
                ->where(['deleted'=>0,'user_id'=>$user_id])
                ->toArray();
        return $data;
    }


    public function getLastExpiryDateByUserId($user_id){
        $data = $this->find()
                ->select(['expire_date'])
                ->where(['deleted'=>0,'user_id'=>$user_id])
                ->limit(10)
                ->order(['id'=>'desc'])
                ->toArray();
        return $data[0]['expire_date'];
    }


    public function createBill($package_id,$user_id,$type,$order_no=null){
    	$packagesTbl = TableRegistry::get('Packages');
    	$billsTbl = TableRegistry::get('Bills');
    	$packages_info = $packagesTbl->getPackageById($package_id);
    	$renew_date = date('Y-m-d H:i');
        $last_expire_date = $this->getLastExpiryDateByUserId($user_id);
    	if($type == 'monthly'){
    		$price = $packages_info[0]->price_m;
            if(strtotime($last_expire_date) < strtotime(date('Y-m-d H:i'))){
                $expire_date = date('Y-m-d H:i', strtotime('+1 month'));
            }
            else{
                $expire_date = date('Y-m-d H:i', strtotime($last_expire_date.'+1 month'));
            }
    	}
    	elseif($type == 'yearly'){
    		$price = $packages_info[0]->price_yr;
            if(strtotime($last_expire_date) < strtotime(date('Y-m-d H:i'))){
                $expire_date = date('Y-m-d H:i', strtotime('+12 month'));
            }
            else{
                $expire_date = date('Y-m-d H:i', strtotime($last_expire_date.'+12 month'));
            }
            //print_r($starting_date);exit;
            //print_r($expire_date);exit;
    	}
		$data = array();
		$data = $billsTbl->newEntity();
		$data->package_id = $package_id;
		$data->user_id = $user_id;
		$data->price = $price;
        $data->order_no = $order_no;
		$data->renew_date = $renew_date;
		$data->expire_date = $expire_date;
		$data->created = date('Y-m-d H:i');
		//print_r($data);exit;
		$billsTbl->save($data);
		return array('renew_date'=>$renew_date, 'expire_date'=>$expire_date);
	}
}

?>