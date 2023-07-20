<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class StatusesTable extends Table
{
	public function listStatuses(){
		$data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0])
            ->toArray();
            return $data;
	}


	public function listSoldNButcheredStatuses(){
		$data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0,'id in'=>[4,5]])
            ->toArray();
            return $data;
	}
}

?>