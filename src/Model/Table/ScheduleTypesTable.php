<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ScheduleTypesTable extends Table
{
	public function listScheduleTypes(){
		$data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0])
            ->toArray();
            return $data;
	}



	public function getScheduleTypeName($id){
		$data = $this->find()
            ->select(['name'])
            ->where(['deleted'=>0,'id'=>$id])
            ->toArray();
            return $data[0]['name'];
	}
}

?>