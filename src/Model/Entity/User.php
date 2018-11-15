<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $address
 * @property string $nationality
 * @property string $description
 * @property string $role
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Cart[] $carts
 * @property \App\Model\Entity\Restaurant[] $restaurants
 */
class User extends Entity
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
        'firstname' => true,
        'lastname' => true,
        'username' => true,
        'email' => true,
        'password' => true,
        'image' => true,
        'address' => true,
        'nationality' => true,
        'description' => true,
        'role' => true,
        'passkey'=>true,
        'timeout'=>true,
        'facebook_token' => true,
        'google_token' => true,
        'instagram_token' => true,
        'twitter_token' => true,
        'otp'=>true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'carts' => true,
        'restaurants' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
       // 'password'
    ];
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
