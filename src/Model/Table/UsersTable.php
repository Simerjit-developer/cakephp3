<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
/**
 * Users Model
 *
 * @property \App\Model\Table\CartsTable|\Cake\ORM\Association\HasMany $Carts
 * @property \App\Model\Table\RestaurantsTable|\Cake\ORM\Association\HasMany $Restaurants
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Carts', [
            'foreignKey' => 'user_id'
        ])->setDependent(true);
        
        $this->hasMany('Restaurants', [
            'foreignKey' => 'user_id'
        ])->setDependent(true);
        
        $this->hasMany('Orders', [
            'foreignKey' => 'user_id'
        ])->setDependent(true);
        
        $this->hasMany('Suggestions', [
            'foreignKey' => 'user_id'
        ])->setDependent(true);
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
            ->allowEmpty('id', 'create');

//        $validator
//            ->scalar('firstname')
//            ->maxLength('firstname', 250)
//            ->requirePresence('firstname', 'create')
//            ->notEmpty('firstname');
//        
//        $validator
//            ->scalar('lastname')
//            ->maxLength('lastname', 250)
//            ->requirePresence('lastname', 'create')
//            ->notEmpty('lastname');

//        $validator
//            ->scalar('username')
//            ->maxLength('username', 250)
//            ->requirePresence('username', 'create')
//            ->notEmpty('username')
//            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

//        $validator
//            ->email('email')
//            ->requirePresence('email', 'create')
//            ->notEmpty('email')
//            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

//        $validator
//            ->scalar('password')
//            ->maxLength('password', 250)
//            ->requirePresence('password', 'create')
//            ->notEmpty('password');

//        $validator
//            ->scalar('address')
//            ->maxLength('address', 250)
//            ->requirePresence('address', 'create')
//            ->notEmpty('address');

//        $validator
//            ->scalar('nationality')
//            ->maxLength('nationality', 250)
//            ->requirePresence('nationality', 'create')
//            ->notEmpty('nationality');

//        $validator
//            ->scalar('description')
//            ->requirePresence('description', 'create')
//            ->notEmpty('description');

        $validator
            ->scalar('role')
            ->maxLength('role', 20)
            ->requirePresence('role', 'create')
            ->notEmpty('role');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        //$rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
    /*
     * Validate password
     * @params: old_password, new_password, confirm_password
     */
    public function validationPassword(Validator $validator)
    {
        $validator
                ->add('old_password','custom',[
                    'rule' => function($value, $context){
                        $user = $this->get($context['data']['id']);
                        if($user)
                        {
                            if((new DefaultPasswordHasher)->check($value, $user->password))
                            {
                                return true;
                            }
                        }
                        return false;
                    },
                    'message' => 'Your old password does not match the entered password!',
                ])
                ->notEmpty('old_password');
        
        $validator
                ->add('new_password',[
                    'length' => [
                        'rule' => ['minLength',4],
                        'message' => 'Please enter atleast 4 characters in password your password.'
                    ]
                ])
                ->add('new_password',[
                    'match' => [
                        'rule' => ['compareWith','confirm_password'],
                        'message' => 'Sorry! Password does not match. Please try again!'
                    ]
                ])
                ->notEmpty('new_password');
        
        $validator
                ->add('confirm_password',[
                    'length' => [
                        'rule' => ['minLength',4],
                        'message' => 'Please enter atleast 4 characters in password your password.'
                    ]
                ])
                ->add('confirm_password',[
                    'match' => [
                        'rule' => ['compareWith','new_password'],
                        'message' => 'Sorry! Password dose not match. Please try again!'
                    ]
                ])
                ->notEmpty('confirm_password');
        
        return $validator;
    }
}
