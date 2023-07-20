<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsergroupsTable extends Table
{
	public function listUsergroups(){
		$data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0])
            ->toArray();
            return $data;
	}
}

?>