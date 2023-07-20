<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use App\Model\Table\AppsTable;


class WeightsTable extends AppsTable
{

	public function getWeightsByBreederId($breeder_id,$creator){
        $unitsTb = TableRegistry::get('UnitMeasurements');
        $data = $this->find()
                ->where(['deleted'=>0,'breeder_id'=>$breeder_id,'creator'=>$creator])
                ->order(['id'=>'desc'])
                ->toArray();

        $i=0;
        foreach($data as $data1){
            //print_r($data->unit_id);exit;
            $data[$i]['unit_name'] = $unitsTb->getUnitName($data1->unit_id);
            $i++;
        }
        return $data;
    }


    public function getLatestWeightsByBreederId($breeder_id){
    	$unitsTb = TableRegistry::get('UnitMeasurements');
    	$list_units = $unitsTb->listUnitMeasurements();
        $data = $this->find()
                ->where(['deleted'=>0,'breeder_id'=>$breeder_id])
                ->order(['id'=>'desc'])
                ->limit(1)
                ->toArray();
        //print_r($data[0]['weight']);exit;
        return @$data[0]['weight'].' '.@$list_units[$data[0]['unit_id']];
    }



    public function deleteWeight($id,$creator){
        $query = $this->query();
        $result = $query->update()
                    ->set(['deleted' => 1])
                    ->where(['id' => $id,'creator'=>$creator])
                    ->execute();
        return $result;
    }

}

?>