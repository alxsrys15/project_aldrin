<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HistInventory Entity
 *
 * @property int $id
 * @property int|null $product_stock_id
 * @property string|null $action
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\ProductStock $product_stock
 * @property \App\Model\Entity\User $user
 */
class HistInventory extends Entity
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
        'product_stock_id' => true,
        'action' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'product_stock' => true,
        'user' => true,
    ];
}
