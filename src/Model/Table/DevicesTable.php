<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cuisines Model
 *
 * @property \App\Model\Table\RestaurantsTable|\Cake\ORM\Association\HasMany $Restaurants
 *
 * @method \App\Model\Entity\Cuisine get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cuisine newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cuisine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cuisine|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cuisine|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cuisine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cuisine[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cuisine findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DevicesTable extends Table
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

        $this->setTable('devices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Devices', [
            'foreignKey' => 'device_id',
            'joinType' => 'INNER'
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

//        $validator
//            ->scalar('name')
//            ->maxLength('name', 250)
//            ->requirePresence('name', 'create')
//            ->notEmpty('name');

        return $validator;
    }
}
