<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Plans Model
 *
 * @property \App\Model\Table\LittersTable&\Cake\ORM\Association\HasMany $Litters
 *
 * @method \App\Model\Entity\Plan get($primaryKey, $options = [])
 * @method \App\Model\Entity\Plan newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Plan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Plan|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Plan saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Plan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Plan[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Plan findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PlansTable extends AppsTable
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('plans');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Litters', [
            'foreignKey' => 'plan_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('buck')
            ->allowEmptyString('buck');

        $validator
            ->integer('doe')
            ->allowEmptyString('doe');

        $validator
            ->scalar('date')
            ->maxLength('date', 45)
            ->allowEmptyString('date');

        $validator
            ->integer('creator')
            ->allowEmptyString('creator');

        $validator
            ->integer('deleted')
            ->allowEmptyString('deleted');

        return $validator;
    }




    public function listPlans(){
        $data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0])
            ->toArray();
            return $data;
    }


    public function listPendingPlans($creator){
        $data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0,'creator'=>$creator,'date >='=>date('Y-m-d')])
            ->toArray();
            //print_r($data);exit;
            return $data;
    }


    public function getPendingPlans($creator){
        $breedersTb = TableRegistry::get('Breeders');
        $data = $this->find()
            ->where(['deleted'=>0,'creator'=>$creator,'date >='=>date('Y-m-d')])
            ->toArray();

            $i=0;
            foreach($data as $data1){
                $data[$i]['buck_name'] = $breedersTb->getBreederNameById($data1['buck']);
                $data[$i]['doe_name'] = $breedersTb->getBreederNameById($data1['doe']);
                $i++;
            }
            //print_r($data);exit;
            return $data;
    }


    public function getAllPlans($creator){
        $breedersTb = TableRegistry::get('Breeders');
        $data = $this->find()
            ->where(['deleted'=>0,'creator'=>$creator])
            ->toArray();

            $i=0;
            foreach($data as $data1){
                $data[$i]['buck_name'] = $breedersTb->getBreederNameById($data1['buck']);
                $data[$i]['doe_name'] = $breedersTb->getBreederNameById($data1['doe']);
                $i++;
            }
            //print_r($data);exit;
            return $data;
    }


    public function getPlansById($id){
        $data = $this->find()
            ->where(['deleted'=>0,'id'=>$id])
            ->toArray();
            return $data;
    }




    public function getPlansByIdJson($id){
        $breedersTb = TableRegistry::get('Breeders');
        $data1 = $this->getPlansById($id);
        $data = array();
        foreach($data1 as $data1){
            $data['id'] = $data1->id;
            $data['name'] = $data1->name;
            $data['buck'] = $data1->buck;
            $data['doe'] = $data1->doe;
            $data['buck_name'] = $breedersTb->getBreederNameById($data1->buck);
            $data['doe_name'] = $breedersTb->getBreederNameById($data1->doe);
            $data['date'] = $data1->date;
        }
        return $data;
    }



    public function getPlanNameById($id){
        $data = $this->find()
            ->select(['name'])
            ->where(['deleted'=>0,'id'=>$id])
            ->toArray();
            return @$data[0]['name'];
    }



    public function deletePlan($id,$creator){
        $schedulesTb = TableRegistry::get('Schedules');

        $query = $this->query();
        $result = $query->update()
                    ->set(['deleted' => 1])
                    ->where(['id' => $id,'creator'=>$creator])
                    ->execute();
        if($result){
            $schedulesTb->deleteTaskByPlan($id);
        }
        return $result;
    }
    


}
