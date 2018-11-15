<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cart Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $quantity
 * @property string $comment
 * @property bool $refill
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Product $product
 */
class Order extends Entity
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
        'order_number'=>true,
        'restaurant_id' => true,
        'table_id' => true,
        'waiter_id' => true,
        'subtotal' => true,
        'commission'=>true,
        'tax' => true,
        'totalamount' => true,
        'payment_method' => true,
        'payment_token' => true,
        'stripe_orderid'=>true,
        'card_id' => true,
        'gratuity' => true,
        'created' => true,
        'modified' => true,
        'orderdiscount'=>true,
        'user' => true,
        'restaurant' => true,
        'table' => true,
        'waiter' => true,
        'order_items'=>true
    ];
}
