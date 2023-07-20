<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UnitMeasurementsTable extends Table
{
	public function listUnitMeasurements(){
		$data = $this->find('list',['keyField' => 'id','valueField' => 'symbol'])
            ->select(['id'])
            ->where(['deleted'=>0])
            ->toArray();
            return $data;
	}


	public function getUnitName($id){
		$data = $this->find()
            ->select(['symbol'])
            ->where(['deleted'=>0,'id'=>$id])
            ->toArray();
            //print_r($data[0]['name']);exit;
            return $data[0]['symbol'];
	}
}

?>