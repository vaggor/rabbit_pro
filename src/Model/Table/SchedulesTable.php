<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Schedules Model
 *
 * @property \App\Model\Table\ScheduleTypesTable&\Cake\ORM\Association\BelongsTo $ScheduleTypes
 * @property \App\Model\Table\IconsTable&\Cake\ORM\Association\BelongsTo $Icons
 * @property \App\Model\Table\RecurringsTable&\Cake\ORM\Association\BelongsTo $Recurrings
 *
 * @method \App\Model\Entity\Schedule get($primaryKey, $options = [])
 * @method \App\Model\Entity\Schedule newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Schedule[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Schedule|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Schedule saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Schedule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Schedule[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Schedule findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SchedulesTable extends AppsTable
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

        $this->setTable('schedules');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ScheduleTypes', [
            'foreignKey' => 'schedule_type_id',
        ]);
        $this->belongsTo('Icons', [
            'foreignKey' => 'icon_id',
        ]);
        $this->belongsTo('Recurrings', [
            'foreignKey' => 'recurring_id',
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
            ->scalar('name')
            ->maxLength('name', 100)
            ->allowEmptyString('name');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['schedule_type_id'], 'ScheduleTypes'));
        $rules->add($rules->existsIn(['icon_id'], 'Icons'));
        $rules->add($rules->existsIn(['recurring_id'], 'Recurrings'));

        return $rules;
    }


    public function saveSchedule($doe,$task,$creator,$breed_date,$plan_id){
        $breedersTb = TableRegistry::get('Breeders');
        $doe_name = $breedersTb->getBreederNameById($doe);
        $date = $this->calculateTaskDate($breed_date,$task);
        $data = array();
        $schedulesTbl = TableRegistry::get('Schedules');
        $data = $schedulesTbl->newEntity();
        $data->schedule_type_id = 2;
        $data->name = $doe_name.':'.$task;
        $data->date = $date;
        $data->plan_id = $plan_id;
        $data->creator = $creator;
        $data->created = date('Y-m-d H:i');
        //print_r($data);exit;
        $schedulesTbl->save($data);
        return;
    }



    public function calculateTaskDate($breed_date,$task){
        $date = '';
        if($task == 'Breed'){
            $date = $breed_date;
        }
        elseif($task == 'pregnancy check'){
            $date = date('Y-m-d', strtotime($breed_date. ' + 14 days'));
        }
        elseif($task == 'nest box'){
            $date = date('Y-m-d', strtotime($breed_date. ' + 28 days'));
        }
        elseif($task == 'kindle/birth'){
            $date = date('Y-m-d', strtotime($breed_date. ' + 30 days'));
        }
        elseif($task == 'Wean'){
            $kindle_date = date('Y-m-d', strtotime($breed_date. ' + 30 days'));
            $date = date('Y-m-d', strtotime($kindle_date. ' + 35 days'));
        }
        return $date;
    }



    public function getTodayEmailSchedules(){
        $schedule_typesTb = TableRegistry::get('ScheduleTypes');
        $plansTb = TableRegistry::get('Plans');
        $data = $this->find()
            ->where(['deleted'=>0,'date'=>date('Y-m-d'), 'email_sent'=>0])
            ->toArray();
            //print_r($data);exit;
            return $data;
    }



    public function getTodaySmsSchedules(){
        $schedule_typesTb = TableRegistry::get('ScheduleTypes');
        $plansTb = TableRegistry::get('Plans');
        $data = $this->find()
            ->where(['deleted'=>0,'date'=>date('Y-m-d'), 'sent_sms'=>0])
            ->toArray();
            //print_r($data);exit;
            return $data;
    }



    public function getPendingSchedules($creator){
        $schedule_typesTb = TableRegistry::get('ScheduleTypes');
        $plansTb = TableRegistry::get('Plans');
        $data = $this->find()
            ->where(['deleted'=>0,'creator'=>$creator,'date >='=>date('Y-m-d')])
            ->order(['date'=>'asc'])
            ->toArray();

            $i=0;
            foreach($data as $data1){
                $data[$i]['schedule_type'] = $schedule_typesTb->getScheduleTypeName($data1['schedule_type_id']);
                $data[$i]['plan'] = $plansTb->getPlanNameById($data1['plai_id']);
                $i++;
            }
            //print_r($data);exit;
            return $data;
    }



    public function getAllSchedules($creator){
        $schedule_typesTb = TableRegistry::get('ScheduleTypes');
        $plansTb = TableRegistry::get('Plans');
        $data = $this->find()
            ->where(['deleted'=>0,'creator'=>$creator])
            ->order(['date'=>'asc'])
            ->toArray();

            $i=0;
            foreach($data as $data1){
                $data[$i]['schedule_type'] = $schedule_typesTb->getScheduleTypeName($data1['schedule_type_id']);
                $data[$i]['plan'] = $plansTb->getPlanNameById($data1['plai_id']);
                $i++;
            }
            //print_r($data);exit;
            return $data;
    }



    public function getScheduleByPlanId($creator,$plan_id){
        $schedule_typesTb = TableRegistry::get('ScheduleTypes');
        $plansTb = TableRegistry::get('Plans');
        $data = $this->find()
            ->where(['deleted'=>0,'creator'=>$creator,'plan_id'=>$plan_id])
            ->toArray();

            $i=0;
            foreach($data as $data1){
                $data[$i]['schedule_type'] = $schedule_typesTb->getScheduleTypeName($data1['schedule_type_id']);
                $data[$i]['plan'] = $plansTb->getPlanNameById($data1['plai_id']);
                $i++;
            }
            //print_r($data);exit;
            return $data;
    }


    public function getScheduleByType($creator,$type_id){
        $schedule_typesTb = TableRegistry::get('ScheduleTypes');
        $plansTb = TableRegistry::get('Plans');
        $data = $this->find()
            ->where(['deleted'=>0,'creator'=>$creator,'schedule_type_id'=>$type_id])
            ->toArray();

            $i=0;
            foreach($data as $data1){
                $data[$i]['schedule_type'] = $schedule_typesTb->getScheduleTypeName($data1['schedule_type_id']);
                $data[$i]['plan'] = $plansTb->getPlanNameById($data1['plai_id']);
                $i++;
            }
            //print_r($data);exit;
            return $data;
    }




    public function getScheduleById($creator,$id){
        $schedule_typesTb = TableRegistry::get('ScheduleTypes');
        $plansTb = TableRegistry::get('Plans');
        $data = $this->find()
            ->where(['deleted'=>0,'creator'=>$creator,'id'=>$id])
            ->toArray();

            $i=0;
            foreach($data as $data1){
                $data[$i]['schedule_type'] = $schedule_typesTb->getScheduleTypeName($data1['schedule_type_id']);
                $data[$i]['plan'] = $plansTb->getPlanNameById($data1['plai_id']);
                $i++;
            }
            //print_r($data);exit;
            return $data;
    }



    public function deleteTaskByPlan($plan_id){
        $query = $this->query();
        $result = $query->update()
                    ->set(['deleted' => 1])
                    ->where(['plan_id' => $plan_id])
                    ->execute();
        return $result;
    }



    public function deleteTaskById($creator,$id){
        $query = $this->query();
        $result = $query->update()
                    ->set(['deleted' => 1])
                    ->where(['id' => $id, 'creator'=>$creator])
                    ->execute();
        return $result;
    }



    public function updateSmsDate($id){
        $query = $this->query();
        $result = $query->update()
                    ->set(['sent_sms' => 1, 'sms_date'=>date('Y-m-d H:i')])
                    ->where(['id' => $id])
                    ->execute();
        return $result;
    }



    public function updateEmailDate($id){
        $query = $this->query();
        $result = $query->update()
                    ->set(['email_sent' => 1, 'email_date'=>date('Y-m-d H:i')])
                    ->where(['id' => $id])
                    ->execute();
        return $result;
    }




}
