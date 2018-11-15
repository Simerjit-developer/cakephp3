<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $restaurant_name
 * @property string $location
 * @property string $content
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User[] $users
 */
class Suggestion extends Entity
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
        'restaurant_name' => true,
        'location' => true,
        'content' => true,
        'created' => true,
        'modified' => true,
        'users'=>true
    ];
}
