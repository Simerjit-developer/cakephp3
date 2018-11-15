<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Menu Entity
 *
 * @property int $id
 * @property int $restaurant_id
 * @property int $category_id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Restaurant $restaurant
 * @property \App\Model\Entity\Category $category
 */
class Menu extends Entity
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
        'category_id' => true,
        'name' => true,
        'name_p' => true,
        'description' => true,
        'description_p' => true,
        'price' => true,
        'created' => true,
        'modified' => true,
        'restaurant' => true,
        'freeavailable' =>true,
        'category' => true
    ];
}
