<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Restaurant Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property int $cuisine_id
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property float $starting_price
 * @property float $avg_rating
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Cuisine $cuisine
 * @property \App\Model\Entity\Menu[] $menus
 */
class Restaurant extends Entity
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
        'user_id' => true,
        'name' => true,
        'name_p' => true,
        'image' => true,
        'description' => true,
        'description_p' => true,
        'cuisine_id' => true,
        'address' => true,
        'address_p' => true,
        'latitude' => true,
        'longitude' => true,
        'starting_price' => true,
        'avg_rating' => true,
        'total_tables '=>true,
        'order_time'=>true,
        'commision' => true,
        'gratuity' => true,
        'tax'=>true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'cuisine' => true,
        'menus' => true,
        'restaurant_amenities'=>true
    ];
}
