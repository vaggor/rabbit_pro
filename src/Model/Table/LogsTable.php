<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;


class LogsTable extends Table{

	public function createLog($app,$operation,$msg,$resp){
		$data = array();
		$logsTbl = TableRegistry::get('Logs');
		$data = $logsTbl->newEntity();
		$data->app = $app;
		$data->operation = $operation;
		$data->req = $msg;
		$data->resp = $resp;
		$data->created = date('Y-m-d H:i');
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