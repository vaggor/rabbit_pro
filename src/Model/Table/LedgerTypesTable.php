<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class LedgerTypesTable extends Table
{
	public function listLedgerTypes(){
		$data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0])
            ->toArray();
            return $data;
	}



	public function getLedgerTypeName($id){
		$data = $this->find()
            ->select(['name'])
            ->where(['deleted'=>0,'id'=>$id])
            ->toArray();
            return $data[0]['name'];
	}
}

?>