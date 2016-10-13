<?php
namespace App\Model\Table;

use App\Model\Entity\Message;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Message Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Msgs
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Senders
 */
class MessageTable extends Table
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

        $this->table('message');
        $this->displayField('msg_id');
        $this->primaryKey('msg_id');

       
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
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');

        $validator
            ->requirePresence('msg_content', 'create')
            ->notEmpty('msg_content','Message Body is required');


        $validator
            ->date('msg_date')
            ->requirePresence('msg_date', 'create')
            ->notEmpty('msg_date');

        $validator
            ->integer('is_read')
            ->requirePresence('is_read', 'create')
            ->notEmpty('is_read');

        $validator
            ->integer('is_deleted')
            ->requirePresence('is_deleted', 'create')
            ->notEmpty('is_deleted');

        return $validator;
    }

   
}
