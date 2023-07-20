<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CountriesTable extends Table
{
	public function listCountries(){
		$data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->toArray();
            return $data;
	}
}

?>