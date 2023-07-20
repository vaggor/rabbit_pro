<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class PackagesTable extends Table
{



	public function listPackages(){
		$data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0])
            ->toArray();
            return $data;
	}


	public function getPackageById($id){
		$data = $this->find()
            ->where(['deleted'=>0,'id'=>$id])
            ->toArray();
            //print_r($data[0]['name']);exit;
            return $data;
	}


      public function getPackageNameById($id){
            $data = $this->find()
            ->select(['name'])
            ->where(['deleted'=>0,'id'=>$id])
            ->toArray();
            //print_r($data[0]['name']);exit;
            return $data[0]['name'];
      }


	public function getPackageIDByName($name){
            $data = $this->find()
            ->select(['id'])
            ->where(['deleted'=>0,'name'=>$name])
            ->toArray();
            //print_r($name);exit;
            return $data[0]['id'];
      }


      public function getPackagesById($type){
            $packageItemsTb = TableRegistry::get('PackageItems');
            if($type == 'a'){

            }
            $data = $this->find('all')
            ->where(['deleted'=>0,'id !='=>5])
            ->toArray();
            //print_r($data);exit;
            $i=0;
            foreach($data as $data1){
                  if($type == 'a'){
                        $data[$i]['price'] = $data1->price_yr;
                  }
                  else{
                        $data[$i]['price'] = $data1->price_m;
                  }
                  $data[$i]['package_items'] = $packageItemsTb->getPackageItemByPackageId($data1->id);
                  $i++;
            }
            return $data;
      }
}

?>