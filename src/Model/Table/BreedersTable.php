<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Table\AppsTable;
use Cake\ORM\TableRegistry;

/**
 * Breeders Model
 *
 * @property \App\Model\Table\BreedersTable&\Cake\ORM\Association\BelongsTo $Breeders
 * @property \App\Model\Table\BreedsTable&\Cake\ORM\Association\BelongsTo $Breeds
 * @property \App\Model\Table\SexesTable&\Cake\ORM\Association\BelongsTo $Sexes
 * @property \App\Model\Table\BreedersTable&\Cake\ORM\Association\HasMany $Breeders
 *
 * @method \App\Model\Entity\Breeder get($primaryKey, $options = [])
 * @method \App\Model\Entity\Breeder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Breeder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Breeder|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Breeder saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Breeder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Breeder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Breeder findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BreedersTable extends AppsTable
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

        $this->setTable('breeders');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Breeds', [
            'foreignKey' => 'breed_id',
        ]);
        $this->belongsTo('Sexes', [
            'foreignKey' => 'sex_id',
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
            ->scalar('cage')
            ->maxLength('cage', 100)
            ->allowEmptyString('cage');

        $validator
            ->scalar('color')
            ->maxLength('color', 100)
            ->allowEmptyString('color');

        $validator
            ->scalar('weight')
            ->maxLength('weight', 45)
            ->allowEmptyString('weight');

        $validator
            ->scalar('date_born')
            ->maxLength('date_born', 50)
            ->allowEmptyString('date_born');

        $validator
            ->scalar('date_acquired')
            ->maxLength('date_acquired', 50)
            ->allowEmptyString('date_acquired');

        $validator
            ->integer('father')
            ->allowEmptyString('father');

        $validator
            ->integer('mother')
            ->allowEmptyString('mother');

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
        $rules->add($rules->existsIn(['breed_id'], 'Breeds'));
        $rules->add($rules->existsIn(['sex_id'], 'Sexes'));

        return $rules;
    }

    public function listBreeders($creator,$sex){
        $data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0,'creator'=>$creator,'sex_id'=>$sex,'status_id'=>2])
            ->toArray();
            return $data;
    }


    public function listBreedersByStatus($creator,$status_id){
        $data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0,'creator'=>$creator,'status_id in'=>$status_id])
            ->toArray();
            return $data;
    }


    public function listAllsexBreeders($creator){
        $data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0,'creator'=>$creator,'status_id'=>2])
            ->toArray();
            return $data;
    }


    public function listAllBreeders($creator,$sex){
        $data = $this->find('list',['keyField' => 'id','valueField' => 'name'])
            ->select(['id'])
            ->where(['deleted'=>0,'creator'=>$creator,'sex_id'=>$sex])
            ->toArray();
            return $data;
    }


    public function getBreeders($creator){
        $data = $this->find()
                ->where(['deleted'=>0,'creator'=>$creator,'status_id'=>2])
                ->toArray();
        return $data;
    }


    public function getBreedersByStatus($creator,$status){
        $data = $this->find()
                ->where(['deleted'=>0,'creator'=>$creator,'status_id in'=>$status])
                ->toArray();
        return $data;
    }


    public function getBreedersBySex($creator,$sex_id){
        $data = $this->find()
                ->where(['deleted'=>0,'creator'=>$creator,'sex_id'=>$sex_id,'status_id'=>2])
                ->toArray();
        return $data;
    }


    public function getBreederById($id){
        $data = $this->find()
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return $data;
    }


    public function getBreederNameById($id){
        $data = $this->find()
                ->select(['name'])
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
                //print_r($id);exit;
        return @$data[0]['name'];
    }


    public function getBreederIdById($id){
        $data = $this->find()
                ->select(['breeder_id'])
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return @$data[0]['breeder_id'];
    }



    public function getNoOfBreeders($creator){
        $no_breeders = $this->find()
                ->where(['deleted'=>0,'status_id'=>2,'creator'=>$creator])
                ->count();
        return $no_breeders;
    }


    public function getNoOfBucks($creator){
        $data = $this->find()
                ->where(['deleted'=>0,'status_id'=>2,'sex_id'=>2,'creator'=>$creator])
                ->count();
        return $data;
    }


    public function getNoOfDoes($creator){
        $data = $this->find()
                ->where(['deleted'=>0,'status_id'=>2,'sex_id'=>1,'creator'=>$creator])
                ->count();
        return $data;
    }



    public function getNoOfBreedersByStatus($creator,$status){
        $data = $this->find()
                ->where(['deleted'=>0,'creator'=>$creator,'status_id in'=>$status])
                ->count();
        return $data;
    }




    public function getBreederIdById2($creator,$id){
        $id = explode(',', $id);
        //print_r($id);exit;
        $data = $this->find()
                ->where(['deleted'=>0,'creator'=>$creator,'id in'=>$id])
                ->toArray();
        return $data;
    }



    


    public function getBreederIdById2Json($creator,$id){
        $breedsTb = TableRegistry::get('Breeds');
        $sexesTb = TableRegistry::get('Sexes');

        $list_breeds = $breedsTb->listBreeds();
        $list_sexes = $sexesTb->listSexes();
        $data = $this->getBreederIdById2($creator,$id);
        //print_r($data);exit;
        $i=0;
        foreach ($data as $data1) {
            $data[$i]['breed_name'] = $list_breeds[$data1->breed_id];
            $data[$i]['sex_name'] = $list_sexes[$data1->sex_id];
            $data[$i]['father_name'] = $this->getBreederNameById($data1->father);
            $data[$i]['mother_name'] = $this->getBreederNameById($data1->mother);
            $i++;
        }
        return $data;
    }



    public function getBreederJson($id){
        $breedsTb = TableRegistry::get('Breeds');
        $sexesTb = TableRegistry::get('Sexes');

        $list_breeds = $breedsTb->listBreeds();
        $list_sexes = $sexesTb->listSexes();
        $breeder_data = $this->getBreederById($id);
        $data = array();
        foreach ($breeder_data as $breeder_data) {
            $data['id'] = $breeder_data->id;
            $data['name'] = $breeder_data->name;
            $data['breeder_id'] = $breeder_data->breeder_id;
            $data['cage'] = $breeder_data->cage;
            $data['color'] = $breeder_data->color;
            $data['breed_id'] = $breeder_data->breed_id;
            $data['breed_name'] = $list_breeds[$breeder_data->breed_id];
            $data['sex_id'] = $breeder_data->sex_id;
            $data['sex_name'] = $list_sexes[$breeder_data->sex_id];
            $data['date_born'] = $breeder_data->date_born;
            $data['date_acquired'] = $breeder_data->date_acquired;
            $data['father'] = $breeder_data->father;
            $data['father_name'] = $this->getBreederNameById($breeder_data->father);
            $data['mother'] = $breeder_data->mother;
            $data['mother_name'] = $this->getBreederNameById($breeder_data->mother);
        }
        return $data;
    }



    public function getBreedersBySexJson($creator,$sex_id){
        $breedsTb = TableRegistry::get('Breeds');
        $sexesTb = TableRegistry::get('Sexes');

        $list_breeds = $breedsTb->listBreeds();
        $list_sexes = $sexesTb->listSexes();
        $breeder_data = $this->getBreedersBySex($creator,$sex_id);
        //print_r($breeder_data);exit;
        $data = array();
        $i=0;
        foreach ($breeder_data as $breeder_data) {
            $data[$i]['id'] = $breeder_data->id;
            $data[$i]['name'] = $breeder_data->name;
            $data[$i]['breeder_id'] = $breeder_data->breeder_id;
            $data[$i]['cage'] = $breeder_data->cage;
            $data[$i]['color'] = $breeder_data->color;
            $data[$i]['breed_id'] = $breeder_data->breed_id;
            $data[$i]['breed_name'] = $list_breeds[$breeder_data->breed_id];
            $data[$i]['sex_id'] = $breeder_data->sex_id;
            $data[$i]['sex_name'] = $list_sexes[$breeder_data->sex_id];
            $data[$i]['date_born'] = $breeder_data->date_born;
            $data[$i]['date_acquired'] = $breeder_data->date_acquired;
            $data[$i]['father'] = $breeder_data->father;
            $data[$i]['father_name'] = $this->getBreederNameById($breeder_data->father);
            $data[$i]['mother'] = $breeder_data->mother;
            $data[$i]['mother_name'] = $this->getBreederNameById($breeder_data->mother);
        $i++;}
        return $data;
    }




    public function getBreedersByStatusJson($creator,$status_id){
        $breedsTb = TableRegistry::get('Breeds');
        $sexesTb = TableRegistry::get('Sexes');

        $list_breeds = $breedsTb->listBreeds();
        $list_sexes = $sexesTb->listSexes();
        $breeder_data = $this->getBreedersByStatus($creator,$status_id);
        //print_r($breeder_data);exit;
        $data = array();
        $i=0;
        foreach ($breeder_data as $breeder_data) {
            $data[$i]['id'] = $breeder_data->id;
            $data[$i]['name'] = $breeder_data->name;
            $data[$i]['breeder_id'] = $breeder_data->breeder_id;
            $data[$i]['cage'] = $breeder_data->cage;
            $data[$i]['color'] = $breeder_data->color;
            $data[$i]['breed_id'] = $breeder_data->breed_id;
            $data[$i]['breed_name'] = $list_breeds[$breeder_data->breed_id];
            $data[$i]['sex_id'] = $breeder_data->sex_id;
            $data[$i]['sex_name'] = $list_sexes[$breeder_data->sex_id];
            $data[$i]['date_born'] = $breeder_data->date_born;
            $data[$i]['date_acquired'] = $breeder_data->date_acquired;
            $data[$i]['father'] = $breeder_data->father;
            $data[$i]['father_name'] = $this->getBreederNameById($breeder_data->father);
            $data[$i]['mother'] = $breeder_data->mother;
            $data[$i]['mother_name'] = $this->getBreederNameById($breeder_data->mother);
        $i++;}
        return $data;
    }




    public function getBreederNameAndSexJson($id){
        $breedsTb = TableRegistry::get('Breeds');
        $sexesTb = TableRegistry::get('Sexes');

        $list_breeds = $breedsTb->listBreeds();
        $list_sexes = $sexesTb->listSexes();
        $breeder_data = $this->getBreederById($id);
        $data = array();
        foreach ($breeder_data as $breeder_data) {
            $data['name'] = $breeder_data->name;
            $data['sex_id'] = $breeder_data->sex_id;
            $data['sex_name'] = $list_sexes[$breeder_data->sex_id];
        }
        return $data;
    }


    public function updateStatus($id,$status){
        $query = $this->query();
        $result = $query->update()
                    ->set(['status_id' => $status])
                    ->where(['id' => $id])
                    ->execute();
        return $result;
    }


    public function flagDeleted($id,$modifier){
        $query = $this->query();
        $result = $query->update()
                    ->set(['deleted' => 1,'modifier'=>$modifier,'modified'=>date('Y-m-d H:i')])
                    ->where(['id' => $id])
                    ->execute();
        return $result;
    }


}
