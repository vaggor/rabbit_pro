<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;


class JobsTable extends Table{

	public function createJobLog(){
		$data = array();
		$logsTbl = TableRegistry::get('Jobs');
		$data = $logsTbl->newEntity();
		$data->date = date('Y-m-d H:i');
		//print_r($data);exit;
		$logsTbl->save($data);
		return;
	}


	public function getLogs(){
		$data = $this->find()
			->order(['id'=>'desc'])
            ->toArray();
        return $data;
	}
}

?>