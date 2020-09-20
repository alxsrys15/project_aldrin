<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property int|null $category_id
 * @property string|null $imgs
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\ProductStock[] $product_stocks
 * @property \App\Model\Entity\TransactionDetail[] $transaction_details
 */
class Product extends Entity
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
        'name' => true,
        'description' => true,
        'price' => true,
        'category_id' => true,
        'imgs' => true,
        'category' => true,
        'product_stocks' => true,
        'transaction_details' => true,
    ];
}
