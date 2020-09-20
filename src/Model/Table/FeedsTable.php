<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Feeds Model
 *
 * @property &\Cake\ORM\Association\HasMany $FeedComments
 * @property \App\Model\Table\FeedDislikesTable&\Cake\ORM\Association\HasMany $FeedDislikes
 * @property \App\Model\Table\FeedLikesTable&\Cake\ORM\Association\HasMany $FeedLikes
 *
 * @method \App\Model\Entity\Feed get($primaryKey, $options = [])
 * @method \App\Model\Entity\Feed newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Feed[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Feed|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Feed saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Feed patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Feed[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Feed findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FeedsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('feeds');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('FeedComments', [
            'foreignKey' => 'feed_id',
        ]);
        $this->hasMany('FeedDislikes', [
            'foreignKey' => 'feed_id',
        ]);
        $this->hasMany('FeedLikes', [
            'foreignKey' => 'feed_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('description')
            ->maxLength('description', 500)
            ->allowEmptyString('description');

        $validator
            ->scalar('img_name')
            ->maxLength('img_name', 45)
            ->allowEmptyString('img_name');

        $validator
            ->scalar('img_ext')
            ->maxLength('img_ext', 45)
            ->allowEmptyString('img_ext');

        return $validator;
    }
}
