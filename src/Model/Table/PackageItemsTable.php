<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class PackageItemsTable extends Table
{


	public function listPackageItems(){
		$data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0])
            ->toArray();
            return $data;
	}


	public function getPackageItems(){
        $data = $this->find()
                ->where(['deleted'=>0])
                ->toArray();
        return $data;
    }


    public function getPackageItemById($id){
        $data = $this->find()
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return $data;
    }


    public function getPackageItemByPackageId($package_id){
        $data = $this->find()
                ->where(['deleted'=>0,'package_id'=>$package_id])
                ->toArray();
        return $data;
    }


    public function getQuantityByPackageId($package_id){
        $data = $this->find()
                ->where(['deleted'=>0,'package_id'=>$package_id,'name like'=>'Up to%'])
                ->toArray();
        return $data[0]['quantity'];
    }


    public function getPackageItemByIdJson($id){
    	$packagesTb = TableRegistry::get('Packages');
    	$data2 = $this->getPackageItemById($id);
    	$data = array();
    	foreach ($data2 as $data2) {
    		//print_r($data2);exit;
    		$data['id'] = $data2->id;
    		$data['name'] = $data2->name;
    		$data['quantity'] = $data2->quantity;
    		$data['package_id'] = $data2->package_id;
    		$data['package_name'] = $packagesTb->getPackageNameById($data['package_id']);
    	}
    	return $data;
    }


    public function deletePackageItem($id){
        $query = $this->query();
        $result = $query->update()
                    ->set(['deleted' => 1])
                    ->where(['id' => $id])
                    ->execute();
        return $result;
    }
}

?>