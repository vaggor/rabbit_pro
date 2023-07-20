<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use App\Model\Table\AppsTable;

/**
 * Ledgers Model
 *
 * @property \App\Model\Table\CatsTable&\Cake\ORM\Association\BelongsTo $Cats
 * @property \App\Model\Table\LedgerTypesTable&\Cake\ORM\Association\BelongsTo $LedgerTypes
 *
 * @method \App\Model\Entity\Ledger get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ledger newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ledger[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ledger|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ledger saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ledger patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ledger[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ledger findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LedgersTable extends AppsTable
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

        $this->setTable('ledgers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LedgerTypes', [
            'foreignKey' => 'ledger_type_id',
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
            ->scalar('date')
            ->maxLength('date', 45)
            ->allowEmptyString('date');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->allowEmptyString('name');

        $validator
            ->scalar('amount')
            ->maxLength('amount', 45)
            ->allowEmptyString('amount');

        $validator
            ->scalar('note')
            ->allowEmptyString('note');

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
        $rules->add($rules->existsIn(['ledger_type_id'], 'LedgerTypes'));

        return $rules;
    }


    public function getLedgers($creator){
        $scheduleTypesTb = TableRegistry::get('ScheduleTypes');
        $ledgerTypesTb = TableRegistry::get('LedgerTypes');

        $data = $this->find()
                ->where(['deleted'=>0,'creator'=>$creator])
                ->toArray();

        $i=0;
        foreach($data as $data1){
            $data[$i]['cat_name'] = $scheduleTypesTb->getScheduleTypeName($data1['cat_id']);
            $data[$i]['ledger_type_name'] = $ledgerTypesTb->getLedgerTypeName($data1['ledger_type_id']);
            $i++;
        }
        return $data;
    }


    public function getMonthlyLedgers($creator){
        $scheduleTypesTb = TableRegistry::get('ScheduleTypes');
        $ledgerTypesTb = TableRegistry::get('LedgerTypes');

        $data = $this->find()
                ->where(['deleted'=>0,'creator'=>$creator,'created like'=>date('Y-m').'%'])
                ->toArray();

        $i=0;
        foreach($data as $data1){
            $data[$i]['cat_name'] = $scheduleTypesTb->getScheduleTypeName($data1['cat_id']);
            $data[$i]['ledger_type_name'] = $ledgerTypesTb->getLedgerTypeName($data1['ledger_type_id']);
            $i++;
        }
        return $data;
    }



    public function getLedgerById($id,$creator){
        $scheduleTypesTb = TableRegistry::get('ScheduleTypes');
        $ledgerTypesTb = TableRegistry::get('LedgerTypes');
        $breedersTb = TableRegistry::get('Breeders');
        $littersTb = TableRegistry::get('Litters');

        $data = $this->find()
                ->where(['deleted'=>0,'id'=>$id,'creator'=>$creator])
                ->toArray();

        $i=0;
        foreach($data as $data1){
            $data[$i]['cat_name'] = $scheduleTypesTb->getScheduleTypeName($data1['cat_id']);
            $data[$i]['ledger_type_name'] = $ledgerTypesTb->getLedgerTypeName($data1['ledger_type_id']);
            $data[$i]['breeder_name'] = $breedersTb->getBreederNameById($data1['breeder_id']);
            $data[$i]['litter_name'] = $littersTb->getLitterIdById($data1['litter_id']);
            $i++;
        }
        return $data;
    }


    public function getLedgerByType($type,$creator){
        $scheduleTypesTb = TableRegistry::get('ScheduleTypes');
        $ledgerTypesTb = TableRegistry::get('LedgerTypes');

        $data = $this->find()
                ->where(['deleted'=>0,'ledger_type_id'=>$type,'creator'=>$creator])
                ->toArray();

        $i=0;
        foreach($data as $data1){
            $data[$i]['cat_name'] = $scheduleTypesTb->getScheduleTypeName($data1['cat_id']);
            $data[$i]['ledger_type_name'] = $ledgerTypesTb->getLedgerTypeName($data1['ledger_type_id']);
            $i++;
        }
        return $data;
    }


    public function getMonthlyLedgerByType($type,$creator){
        $scheduleTypesTb = TableRegistry::get('ScheduleTypes');
        $ledgerTypesTb = TableRegistry::get('LedgerTypes');

        $data = $this->find()
                ->where(['deleted'=>0,'ledger_type_id'=>$type,'creator'=>$creator,'date like'=>date('Y-m').'%'])
                ->toArray();

        $i=0;
        foreach($data as $data1){
            $data[$i]['cat_name'] = $scheduleTypesTb->getScheduleTypeName($data1['cat_id']);
            $data[$i]['ledger_type_name'] = $ledgerTypesTb->getLedgerTypeName($data1['ledger_type_id']);
            $i++;
        }
        return $data;
    }


    public function getMonthlyProfitNLoss($creator){
        $scheduleTypesTb = TableRegistry::get('ScheduleTypes');
        $ledgerTypesTb = TableRegistry::get('LedgerTypes');

        $income = $this->find()
                ->where(['deleted'=>0,'ledger_type_id'=>1,'creator'=>$creator,'date like'=>date('Y-m').'%'])
                ->sumOf('amount');

        $expense = $this->find()
                ->where(['deleted'=>0,'ledger_type_id'=>2,'creator'=>$creator,'date like'=>date('Y-m').'%'])
                ->sumOf('amount');

        $profit_loss = $income - $expense;

        //print_r($income);exit;
        $data = array('income'=>$income,'expense'=>$expense,'profit_loss'=>$profit_loss);
        return $data;
    }



    public function deleteLedger($id,$creator){
        $query = $this->query();
        $result = $query->update()
                    ->set(['deleted' => 1,'creator'=>$creator])
                    ->where(['id' => $id])
                    ->execute();
        return $result;
    }



}
