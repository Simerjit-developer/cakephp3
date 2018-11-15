<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $restaurant_id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Cart[] $carts
 * @property \App\Model\Entity\Restaurant[] $restaurants
 */
class Waiter extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'restaurant_id' => true,
        'name' => true,
        'image' => true,
        'description' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'restaurants' => true
    ];
}
