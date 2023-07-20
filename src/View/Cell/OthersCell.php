<?php

namespace App\View\Cell;

use Cake\View\Cell;

class OthersCell extends Cell
{
    public function age($dob)
    {
        $ts1 = strtotime($dob);
		$ts2 = strtotime(date('Y-m-d'));
		
		$diff = abs($ts2 - $ts1);  
		$years = floor($diff / (365*60*60*24)); 
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
		//print_r($days);exit;
		$age = $years.' year(s), '.$months.' month(s) '.$days.' day(s)';
        $this->set('age', $age);
    }



    public function get_no_of_liters($sex,$breeder_id){
    	$this->loadModel('Litters');
    	$no_of_litters = $this->Litters->getNoLitters($breeder_id,$sex);
    	$this->set('no_of_litters', $no_of_litters);
    }


    public function get_no_of_kits($sex,$breeder_id){
    	$this->loadModel('Litters');
    	$no_of_kits = $this->Litters->getNoLitters($breeder_id,$sex);
    	$this->set('no_of_kits', $no_of_kits);
    }

    public function get_latest_weight($breeder_id){
    	$this->loadModel('Weights');
    	$weight = $this->Weights->getLatestWeightsByBreederId($breeder_id);
    	//print_r($weight);exit;
    	$this->set('weight', $weight);
    }



}

?>