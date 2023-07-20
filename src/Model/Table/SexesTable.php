<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SexesTable extends Table
{
	public function listSexes(){
		$data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0])
            ->toArray();
            return $data;
	}
}

?>