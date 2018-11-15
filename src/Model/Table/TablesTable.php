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
class TablesTable extends Table
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

        $this->setTable('tables');
        $this->setDisplayField('table_number');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Restaurants', [
            'foreignKey' => 'restaurant_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Waiters', [
            'foreignKey' => 'waiter_id',
         //   'joinType' => 'INNER'
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
            ->integer('table_number')
            ->requirePresence('table_number', 'create')
            ->notEmpty('table_number');
        
        $validator
            ->integer('restaurant_id')
            ->requirePresence('restaurant_id', 'create')
            ->notEmpty('restaurant_id');

        $validator
            ->scalar('barcode_image')
            ->requirePresence('barcode_image', 'create')
            ->notEmpty('barcode_image');

        $validator
            ->scalar('barcode_digits')
            ->requirePresence('barcode_digits', 'create')
            ->notEmpty('barcode_digits');

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
        $rules->add($rules->existsIn(['restaurant_id'], 'Restaurants'));
        $rules->add($rules->existsIn(['waiter_id'], 'Waiters'));
        return $rules;
    }
}
