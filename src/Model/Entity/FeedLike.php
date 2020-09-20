<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FeedLike Entity
 *
 * @property int $id
 * @property int|null $feed_id
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\Feed $feed
 * @property \App\Model\Entity\User $user
 */
class FeedLike extends Entity
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
        'feed_id' => true,
        'user_id' => true,
        'feed' => true,
        'user' => true,
    ];
}
