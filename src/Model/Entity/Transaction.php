<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaction Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property float|null $total_price
 * @property float|null $shipping_fee
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $status_id
 * @property int|null $transaction_type_id
 * @property string|null $paypal_token
 * @property string|null $payment_image
 * @property string $street
 * @property string $barangay
 * @property string $city
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Status $status
 * @property \App\Model\Entity\TransactionType $transaction_type
 * @property \App\Model\Entity\TransactionDetail[] $transaction_details
 */
class Transaction extends Entity
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
        'total_price' => true,
        'shipping_fee' => true,
        'created' => true,
        'modified' => true,
        'status_id' => true,
        'transaction_type_id' => true,
        'paypal_token' => true,
        'payment_image' => true,
        'street' => true,
        'barangay' => true,
        'city' => true,
        'user' => true,
        'status' => true,
        'transaction_type' => true,
        'transaction_details' => true,
    ];
}
