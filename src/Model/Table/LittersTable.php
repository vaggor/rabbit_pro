<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Table\AppsTable;
use Cake\ORM\TableRegistry;

/**
 * Litters Model
 *
 * @property \App\Model\Table\LittersTable&\Cake\ORM\Association\BelongsTo $Litters
 * @property \App\Model\Table\PlansTable&\Cake\ORM\Association\BelongsTo $Plans
 * @property \App\Model\Table\BreedsTable&\Cake\ORM\Association\BelongsTo $Breeds
 * @property \App\Model\Table\LittersTable&\Cake\ORM\Association\HasMany $Litters
 *
 * @method \App\Model\Entity\Litter get($primaryKey, $options = [])
 * @method \App\Model\Entity\Litter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Litter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Litter|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Litter saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Litter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Litter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Litter findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LittersTable extends AppsTable
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

        $this->setTable('litters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        
        $this->belongsTo('Plans', [
            'foreignKey' => 'plan_id',
        ]);
        $this->belongsTo('Breeds', [
            'foreignKey' => 'breed_id',
        ]);
        $this->hasMany('Litters', [
            'foreignKey' => 'litter_id',
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
            ->integer('no_live_kits')
            ->allowEmptyString('no_live_kits');

        $validator
            ->integer('no_dead_kits')
            ->allowEmptyString('no_dead_kits');

        $validator
            ->integer('no_kits')
            ->allowEmptyString('no_kits');

        $validator
            ->scalar('cage')
            ->maxLength('cage', 45)
            ->allowEmptyString('cage');

        $validator
            ->integer('buck')
            ->allowEmptyString('buck');

        $validator
            ->integer('doe')
            ->allowEmptyString('doe');

        $validator
            ->scalar('date_bred')
            ->maxLength('date_bred', 45)
            ->allowEmptyString('date_bred');

        $validator
            ->scalar('date_born')
            ->maxLength('date_born', 45)
            ->allowEmptyString('date_born');

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
        //$rules->add($rules->existsIn(['litter_id'], 'Litters'));
        $rules->add($rules->existsIn(['plan_id'], 'Plans'));
        $rules->add($rules->existsIn(['breed_id'], 'Breeds'));

        return $rules;
    }


    public function listLitters($creator){
        $data = $this->find('list',['keyField' => 'id','valueField' => 'symbol'])
            ->select(['id'])
            ->where(['deleted'=>0, 'creator'=>$creator])
            ->toArray();
            return $data;
    }


    public function getLitters($creator){
        $data = $this->find()
                ->where(['deleted'=>0,'creator'=>$creator])
                ->toArray();
        return $data;
    }


    public function getLitterById($id){
        $data = $this->find()
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return $data;
    }



    public function getBirthDetailsJson($id){
        $plansTb = TableRegistry::get('Plans');

        $birth_data = $this->getLitterById($id);
        $data = array();
        foreach ($birth_data as $birth_data) {
            $data['id'] = $birth_data->id;
            $data['litter_id'] = $birth_data->litter_id;
            $data['plan_id'] = $birth_data->plan_id;
            $data['plan_name'] = $plansTb->getPlanNameById($birth_data->plan_id);
            $data['no_live_kits'] = $birth_data->no_live_kits;
            $data['no_dead_kits'] = $birth_data->no_dead_kits;
            $data['no_kits'] = $birth_data->no_kits;
            $data['cage'] = $birth_data->cage;
            $data['date_bred'] = $birth_data->date_bred;
            $data['date_born'] = $birth_data->date_born;
        }
        return $data;
    }



    public function getNoLitters($breeder_id,$sex){
        if($sex == 1){
            $data = $this->find()
                ->where(['deleted'=>0,'doe'=>$breeder_id])
                ->count();
        }
        else{
            $data = $this->find()
                ->where(['deleted'=>0,'buck'=>$breeder_id])
                ->count();
        }
        return $data;
    }
    

    public function getNoKits($breeder_id,$sex){
        if($sex == 1){
            $data = $this->find()
                ->where(['deleted'=>0,'doe'=>$breeder_id])
                ->sum('no_kits');
        }
        else{
            $data = $this->find()
                ->where(['deleted'=>0,'buck'=>$breeder_id])
                ->sum('no_kits');
        }
        return $data;
    }



    public function getNoLiveKits($creator){
        $data = $this->find()
                ->select(['no_live_kits'=>'SUM(no_live_kits)'])
                ->where(['deleted'=>0,'creator'=>$creator])
                ->toArray();
                //print_r($data[0]->no_live_kits);exit;
        return $data[0]->no_live_kits;
    }



    public function getLitterIdById($id){
        $data = $this->find()
                ->select(['litter_id'])
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return @$data[0]['litter_id'];
    }



    public function getNoSoldById($id){
        $data = $this->find()
                ->select(['litter_id'])
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return @$data[0]['no_sold'];
    }



    public function getNoLiveKitsById($id){
        $data = $this->find()
                ->select(['no_live_kits'])
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return @$data[0]['no_sold'];
    }



    public function updateSoldLitter($id,$quantity){
        $curr_no = $this->getNoSoldById($id);
        $live_kits = $this->getNoLiveKitsById($id);
        $no_sold = $curr_no + $quantity;
        $remaining = $live_kits - $quantity;
        $query = $this->query();
        $result = $query->update()
                    ->set(['no_sold' => $no_sold,'no_live_kits'=>$remaining])
                    ->where(['id' => $id])
                    ->execute();
        return $result;
    }


    public function deleteBirth($id){
        $query = $this->query();
        $result = $query->update()
                    ->set(['deleted' => 1])
                    ->where(['id' => $id])
                    ->execute();
        return $result;
    }


}
