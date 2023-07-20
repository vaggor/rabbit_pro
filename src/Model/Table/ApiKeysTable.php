<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ApiKeysTable extends Table{


	public function getApiKey(){
		$data = $this->find()
			->where(['deleted'=>0])
            ->toArray();
            //print_r($data[0]['key']);exit;
        $key = $data[0]['key'];
        return $key;
	}


	public function validateKey($key){
        $exp = explode(',', $key);
        //print_r($exp[0]);exit;
        if(empty($key)){
            $count = 0;
        }
        else{
            $count = $this->find()
            	->where(['deleted'=>0,'key'=>$exp[0]])
            	->count();
            //print_r($count);exit;
        }
        return $count;
    }
}

?>