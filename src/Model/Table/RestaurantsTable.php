<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Restaurants Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CuisinesTable|\Cake\ORM\Association\BelongsTo $Cuisines
 * @property \App\Model\Table\MenusTable|\Cake\ORM\Association\HasMany $Menus
 *
 * @method \App\Model\Entity\Restaurant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Restaurant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Restaurant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Restaurant|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Restaurant|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Restaurant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Restaurant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Restaurant findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RestaurantsTable extends Table
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

        $this->setTable('restaurants');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cuisines', [
            'foreignKey' => 'cuisine_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Menus', [
            'foreignKey' => 'restaurant_id'
        ]);
        $this->hasMany('Ratings', [
            'foreignKey' => 'restaurant_id'
        ]);
        $this->hasMany('RestaurantAmenities', [
            'foreignKey' => 'restaurant_id'
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

        $validator
            ->scalar('name')
            ->maxLength('name', 250)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

//        $validator
//            ->scalar('image')
//            ->maxLength('image', 250)
//            ->requirePresence('image', 'create')
//            ->notEmpty('image');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->scalar('address')
            ->maxLength('address', 250)
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 250)
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 250)
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

        $validator
            ->numeric('starting_price')
            ->requirePresence('starting_price', 'create')
            ->notEmpty('starting_price');

//        $validator
//            ->numeric('avg_rating')
//            ->requirePresence('avg_rating', 'create')
//            ->notEmpty('avg_rating');

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
        $rules->add($rules->existsIn(['cuisine_id'], 'Cuisines'));

        return $rules;
    }
}
