<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Ahc\Jwt\JWT;
use Cake\Mailer\MailerAwareTrait;

/**
 * Users Model
 *
 * @property \App\Model\Table\FeedCommentsTable&\Cake\ORM\Association\HasMany $FeedComments
 * @property \App\Model\Table\FeedDislikesTable&\Cake\ORM\Association\HasMany $FeedDislikes
 * @property \App\Model\Table\FeedLikesTable&\Cake\ORM\Association\HasMany $FeedLikes
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\HasMany $Transactions
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
{
    use MailerAwareTrait;
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('FeedComments', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('FeedDislikes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('FeedLikes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Transactions', [
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

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Email already registered']);

        $validator
            ->scalar('password')
            ->maxLength('password', 500)
            ->requirePresence('password', 'create')
            ->notEmptyString('password')
            ->sameAs('password', 'password2', 'Passwords do not match');

        $validator
            ->scalar('contact_no')
            ->maxLength('contact_no', 45)
            ->allowEmptyString('contact_no');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 45)
            ->allowEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 45)
            ->allowEmptyString('last_name');

        $validator
            ->scalar('street_name')
            ->maxLength('street_name', 45)
            ->allowEmptyString('street_name');

        $validator
            ->scalar('barangay')
            ->maxLength('barangay', 45)
            ->allowEmptyString('barangay');

        $validator
            ->scalar('city')
            ->maxLength('city', 45)
            ->allowEmptyString('city');

        $validator
            ->scalar('country')
            ->maxLength('country', 45)
            ->allowEmptyString('country');

        $validator
            ->allowEmptyString('is_admin');

        $validator
            ->allowEmptyString('is_active');

        $validator
            ->scalar('verification_token')
            ->maxLength('verification_token', 500)
            ->allowEmptyString('verification_token');

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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    public function afterSave ($event, $entity) {
        $jwt = new JWT('secret', 'HS256', 3600, 10);
        // pr($entity);die();
        if ($entity->is_admin === 0) {
            if ($entity->isNew()) {
                $token = $jwt->encode([
                    'id' => $entity->id,
                    'email' => $entity->email
                ]);

                $entity->verification_token = $token;
                if ($this->save($entity)) { //generate token and send email after saving user
                    // $this->getMailer('User')->send('welcome', [$entity]);
                } else {
                    die('xxx');
                }
            }
        }
    }
}
