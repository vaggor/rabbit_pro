<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;


class DefaultTasksTable extends Table
{

	public function getDefaultTasks($type){
        $data = $this->find()
                ->where(['deleted'=>0,'type'=>$type])
                ->order(['position'=>'asc'])
                ->toArray();
        return $data;
    }



    public function getDefaultTasksJson($type){
        $data1 = $this->getDefaultTasks($type);
        $data = array();
        foreach ($$data1 as $data1key => $data1value) {
           $data[$data1key] = $data1value['name'];
        }
        return $data;
    }


   

}

?>