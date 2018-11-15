<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Carts Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\Cart get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cart newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cart[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cart|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cart|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cart patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cart[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cart findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends Table
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

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tables', [
            'foreignKey' => 'table_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Restaurants', [
            'foreignKey' => 'restaurant_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Waiters', [
            'foreignKey' => 'waiter_id',
            //'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cards', [
            'foreignKey' => 'card_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('OrderItems', [
            'foreignKey' => 'order_id'
        ])->setDependent(true);
        
         $this->hasMany('Ratings', [
            'foreignKey' => 'order_id'
        ])->setDependent(true);
        
         $this->belongsTo('Discounts', [
            'foreignKey' => 'discount_id',
            'joinType' => 'LEFT'
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
            ->allowEmpty('id', 'create');

        $validator
            ->integer('user_id')
            ->requirePresence('user_id', 'create')
            ->notEmpty('user_id');
        
        $validator
            ->integer('restaurant_id')
            ->requirePresence('restaurant_id', 'create')
            ->notEmpty('restaurant_id');
        
        $validator
            ->integer('table_id')
            ->requirePresence('table_id', 'create')
            ->notEmpty('table_id');
        
//        $validator
//            ->integer('waiter_id')
//            ->requirePresence('waiter_id', 'create')
//            ->notEmpty('waiter_id');
        
        $validator
            ->scalar('subtotal')
            ->requirePresence('subtotal', 'create')
            ->notEmpty('subtotal');
        
        $validator
            ->scalar('tax')
            ->requirePresence('tax', 'create')
            ->notEmpty('tax');
        
        $validator
            ->scalar('totalamount')
            ->requirePresence('totalamount', 'create')
            ->notEmpty('totalamount');
        
//        $validator
//            ->scalar('payment_method')
//            ->requirePresence('payment_method', 'create')
//            ->notEmpty('payment_method');
        
//        $validator
//            ->integer('card_id')
//            ->requirePresence('card_id', 'create')
//            ->notEmpty('card_id');
        
        $validator
            ->scalar('gratuity')
            ->requirePresence('gratuity', 'create')
            ->notEmpty('gratuity');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['restaurant_id'], 'Restaurants'));
        //$rules->add($rules->existsIn(['waiter_id'], 'Waiters'));

        return $rules;
    }
}