<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TransactionDetail Entity
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $product_stocks_id
 * @property int|null $total_qty
 * @property int|null $transaction_id
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\ProductStock $product_stock
 * @property \App\Model\Entity\Transaction $transaction
 */
class TransactionDetail extends Entity
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
        'product_id' => true,
        'product_stocks_id' => true,
        'total_qty' => true,
        'transaction_id' => true,
        'product' => true,
        'product_stock' => true,
        'transaction' => true,
    ];
}
