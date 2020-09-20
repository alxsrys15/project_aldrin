<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Feed Entity
 *
 * @property int $id
 * @property string|null $description
 * @property string|null $img_name
 * @property string|null $img_ext
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\FeedDislike[] $feed_dislikes
 * @property \App\Model\Entity\FeedLike[] $feed_likes
 */
class Feed extends Entity
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
        'description' => true,
        'img_name' => true,
        'img_ext' => true,
        'created' => true,
        'modified' => true,
        'feed_dislikes' => true,
        'feed_likes' => true,
    ];
}
