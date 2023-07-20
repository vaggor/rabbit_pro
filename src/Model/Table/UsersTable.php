<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Table\AppsTable;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Model
 *
 * @property \App\Model\Table\AsssocAcctsTable&\Cake\ORM\Association\BelongsTo $AsssocAccts
 * @property \App\Model\Table\StatusesTable&\Cake\ORM\Association\BelongsTo $Statuses
 * @property \App\Model\Table\UsergroupsTable&\Cake\ORM\Association\BelongsTo $Usergroups
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends AppsTable
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
        ]);
        $this->belongsTo('Usergroups', [
            'foreignKey' => 'usergroup_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    /*public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');

        $validator
            ->scalar('phone_no')
            ->maxLength('phone_no', 100)
            ->allowEmptyString('phone_no');

        $validator
            ->integer('deleted')
            ->allowEmptyString('deleted');

        return $validator;
    }*/

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['status_id'], 'Statuses'));
        $rules->add($rules->existsIn(['usergroup_id'], 'Usergroups'));

        return $rules;
    }

    public function hashPass($value){
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($value);
    }


    public function editUserSuccessResponse($err_mess,$model,$name,$phone){
        $json = '{
            "'.$model.'": {
                "status_id": "1",
                "status": "Success",
                "description": "'.$err_mess.'",
                "name": "'.$name.'",
                "phone": "'.$phone.'"
            }
        }';
        return $json;
    }
    


    public function getActiveUsers(){
        $data = $this->find()
                ->where(['deleted'=>0,'status_id'=>2])
                ->toArray();
        return $data;
    }


    public function getExpiredAccountsByDate($date){
        $data = $this->find()
                ->where(['deleted'=>0,'status_id'=>2,'expire_date like'=>$date.'%'])
                ->toArray();
        return $data;
    }


    public function getUsers(){
        $data = $this->find()
                ->toArray();
        return $data;
    }

    public function getDetailUserById($id){
        $data = $this->find()
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return $data;
    }

    public function getUsersByStatus($status){
        $data = $this->find()
                ->where(['deleted'=>0,'status_id'=>$status])
                ->toArray();
        return $data;
    }

    public function getDetailUserByEmail($email){
        $data = $this->find()
                ->where(['deleted'=>0,'email'=>$email])
                ->toArray();
        return $data;
    }

    
    public function getUserById($id){
        //print_r('expression');exit;
        $data = $this->find()
                ->where(['id'=>$id])
                ->toArray();
        return $data;
    }


    public function getNameById($id){
        //print_r('expression');exit;
        $data = $this->find()
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return $data[0]['name'];
    }


    public function getEmailById($id){
        //print_r('expression');exit;
        $data = $this->find()
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return $data[0]['email'];
    }


    public function getIdByEmail($email){
        //print_r('expression');exit;
        $data = $this->find()
                ->where(['deleted'=>0,'email'=>$email])
                ->toArray();
        return $data[0]['id'];
    }


    public function getPhoneNumberById($id){
        //print_r('expression');exit;
        $data = $this->find()
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return $data[0]['phone_no'];
    }


    public function getPackageById($id){
        //print_r('expression');exit;
        $data = $this->find()
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return $data[0]['package_id'];
    }


    public function getExpiryDateById($id){
        //print_r('expression');exit;
        $data = $this->find()
                ->where(['deleted'=>0,'id'=>$id])
                ->toArray();
        return @$data[0]['expire_date'];
    }


    public function login($email,$pass){
        $count = $this->find('count')
                ->where(['deleted'=>0,'status_id'=>2,'email'=>$email,'password'=>$pass]);
                //->toArray();
        return $count;

    }

    public function getCustomerIdByEmailAndPassword($email,$pass){
        $data = $this->find()
                ->where(['deleted'=>0,'status_id'=>2,'email'=>$email,'password'=>$pass])
                ->toArray();
        return $data[0]['id'];

    }

    public function getCustomerInfoByEmailAndPassword($email,$pass){
        $data = $this->find()
                ->where(['deleted'=>0,'status_id'=>2,'email'=>$email,'password'=>$pass])
                ->toArray();
        return $data;

    }



    public function getUserByPassword($pass){
        $data = $this->find()
                ->where(['deleted'=>0,'password'=>$pass])
                ->toArray();
        return $data;

    }

    
    


    public function verifyEmail($code){
        //print_r($code);exit;
        $data = $this->find()
                ->where(['deleted'=>0,'status_id'=>1,'hash'=>$code])
                ->count();
        //print_r($data);exit;
        return $data;
    }


    public function chkEmailExist($email){
        //print_r($key);exit;
        $count = $this->find()
                ->where(['deleted'=>0,'email'=>$email])
                ->count();
        return $count;
    }



    public function getExistenceUserByHash($hash){
        $data = $this->find()
                ->where(['deleted'=>0,'hash'=>$hash]);
        //print_r($data);exit;
        return $data;
    }

    public function getUserIdByHash($harsh){
        $data = $this->find()
                ->where(['deleted'=>0,'hash'=>$harsh])
                ->toArray();
        return $data[0]['id'];

    }

   
    public function updatePassword($password,$id){
        //$user_id = $this->getUserIdByHash($hash);
        $query = $this->query();
        $result = $query->update()
                    ->set(['password' => $password, 'modified'=>date('Y-m-d H:i'),'modifier'=>$id])
                    ->where(['id' => $id,'deleted'=>0,'status_id'=>2])
                    ->execute();
        return $result;
    }

    public function updatePasswordById($new_pass,$id){
        $query = $this->query();
        $result = $query->update()
                    ->set(['password' => $password, 'modified'=>date('Y-m-d H:a'),'modifier'=>$id])
                    ->where(['id' => $id,'deleted'=>0,'status_id'=>2])
                    ->execute();
        return $result;
    }


    public function updateRenewAndExpireDate($renew_date,$expire_date,$id){
        $query = $this->query();
        $result = $query->update()
                    ->set(['renew_date' => $renew_date, 'expire_date'=>$expire_date])
                    ->where(['id' => $id,'deleted'=>0])
                    ->execute();
        return $result;
    }


    public function updateStatus($id,$status){
        //print_r($id);exit;
        $query = $this->query();
        $result = $query->update()
                    ->set(['status_id' => $status])
                    ->where(['id' => $id,'deleted'=>0])
                    ->execute();
        return $result;
    }


    public function updateHash($email,$hash){
        $id = $this->getIdByEmail($email);
        $query = $this->query();
        $result = $query->update()
                    ->set(['hash' => $hash])
                    ->where(['id' => $id,'deleted'=>0])
                    ->execute();
        return $result;
    }


    public function deleteUser($id,$user_id){
        $query = $this->query();
        $result = $query->update()
                    ->set(['deleted' => 1, 'modified'=>date('Y-m-d H:a'),'modifier'=>$user_id])
                    ->where(['id' => $id])
                    ->execute();
        return $result;
    }
}
