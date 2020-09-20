<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FeedDislikes Model
 *
 * @property \App\Model\Table\FeedsTable&\Cake\ORM\Association\BelongsTo $Feeds
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\FeedDislike get($primaryKey, $options = [])
 * @method \App\Model\Entity\FeedDislike newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FeedDislike[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FeedDislike|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FeedDislike saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FeedDislike patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FeedDislike[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FeedDislike findOrCreate($search, callable $callback = null, $options = [])
 */
class FeedDislikesTable extends Table
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

        $this->setTable('feed_dislikes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Feeds', [
            'foreignKey' => 'feed_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['feed_id'], 'Feeds'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
