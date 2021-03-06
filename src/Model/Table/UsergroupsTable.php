<?php
namespace App\Model\Table;

use App\Model\Entity\Usergroup;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Usergroups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\HasMany $UsergroupRoles
 */
class UsergroupsTable extends Table
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
        $this->addBehavior('SoftDeletable');
        $this->table('usergroups');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('UsergroupRoles', [
            'foreignKey' => 'usergroup_id'
        ]);

        $this->hasMany('CmsuserUsergroups', [
            'foreignKey' => 'usergroup_id'
        ]);

 		$this->hasMany('Cmsusers', [
            'foreignKey' => 'usergroup_id'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('group_name', 'valid', ['rule' => [$this, 'isGroupNameValid'], 'message' => 'The group name is not unique'])
            ->requirePresence('group_name', 'create')
            ->notEmpty('group_name');

        $validator
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->requirePresence('modified_on', 'create')
            ->notEmpty('modified_on');

        $validator
            ->add('status', 'valid', ['rule' => 'boolean'])
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    public function isGroupNameValid($value, $context)
    {
        $condition = ['group_name' => $value];
        $result = $this->find('all', ['conditions' => $condition])->count();
        return ($result == 0);
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
        $rules->add($rules->existsIn(['company_id'], 'Companies'));
        return $rules;
    }
}
