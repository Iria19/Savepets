<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use ArrayObject;
/**
 * Alert Model
 *
 * @property \App\Model\Table\UserTable&\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Alert newEmptyEntity()
 * @method \App\Model\Entity\Alert newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Alert[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Alert get($primaryKey, $options = [])
 * @method \App\Model\Entity\Alert findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Alert patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Alert[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Alert|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Alert saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Alert[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Alert[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Alert[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Alert[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AlertTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('alert');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['province'])) {
            $data['province'] = ucwords($data["province"]);
        }
        if (isset($data['country'])) {
            $data['country'] = ucwords($data["country"]);
        }
        if (isset($data['race'])) {
            $data['race'] = ucwords($data["race"]);
        }
        if (isset($data['title'])) {
         $data['title'] = ucfirst($data["title"]);
         }
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('user_id',__('El identificador del usuario es un número.'))
            ->notEmptyString('user_id',__('El identificador de usuario no puede ser vacío.'));


        $validator
            ->requirePresence('country', 'create',__('El campo país es requerido.'))
            ->notEmptyString('country',__('El país no puede ser vacío.'))
            ->add('country',
            ['regex'=>[
                'rule' =>['custom','/^[\wñçÁ-Úá-ú\s]*$/i'],
                'message' => __('El país debe contener solo caracteres alfabéticos y espacios.')
            ]])
            ->add('country',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('El país debe tener mínimo 3 caracteres.')
                ]])
            ->add('country',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('El país debe tener máximo 100 caracteres.')
                ]]);

        $validator
        ->requirePresence('province', 'create',__('El campo provincia es requerido.'))
        ->allowEmptyString('province',__('La provincia puede ser vacía.'))
            ->add('province',
            ['regex'=>[
                'rule' =>['custom','/^[\wñçÁ-Úá-ú\s]*$/i'],
                'message' => __('La provincia debe contener solo caracteres alfabéticos y espacios.')
            ]])
            ->add('province',
                ['maxLength'=>[
                    'rule' =>['maxLength',30],
                    'message' => __('La provincia debe tener máximo 30 caracteres.')
                ]]);

        $validator
            ->requirePresence('specie', 'create',__('El campo especie es requerido.'))
            ->allowEmptyString('specie',__('La especie puede ser vacía.'))
            ->add('specie',
                ['inList'=>[
                    'rule' =>['inList',['cat','dog','bunny','hamster','snake','turtles','other']],
                    'message' => __('La especie debe ser una de las existentes.')
                ]]);

        $validator
            ->requirePresence('race', 'create',__('El campo raza es requerido.'))
            ->allowEmptyString('race', __('La raza pude ser vacía.'))
            ->add('race',
                ['regex'=>[
                    'rule' =>['custom','/^[\wñçÁ-Úá-ú\s]*$/i'],
                    'message' => __('Introduce una raza con caracteres alfabéticos y espacios.')
                ]])
            ->add('race',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('La raza debe tener máximo 100 caracteres.')
                ]]);

        $validator
            ->requirePresence('creation_date', 'create', __('El campo fecha de creación es requerido.'))
            ->notEmptyDateTime('creation_date',__('La fecha no puede ser vacía.'))
            ->add('creation_date', [
                'custom' => [
                'rule' => [$this,'validoDateBetween'],
                'message' => 'La fecha debe ser entre 2022 y 2050.'
                , 'provider' => 'table'
                ]])
            ->add('creation_date', [
                'dateTime' => [
                'rule' => ['dateTime'],
                'message' => 'La fecha introducida debe seguir un formato de fecha y hora correcto.',
                ]
                ]);

        $validator
            ->requirePresence('active', 'create', __('Se requiere la presencia del campo activo.'))
            ->notEmptyString('active',__('El campo activo no puede ser vacío.'))
            ->add('active',
                ['inList'=>[
                    'rule' =>['inList',['yes','no']],
                    'message' => __('Activo debe ser sí o no.')
                ]]);

        $validator
            ->scalar('title',__('El título debe ser un escalar.'))
            ->requirePresence('title', 'create', __('El campo título es requerido.'))
            ->notEmptyString('title',__('El título no puede ser vacío.'))            
            ->add('title',
                ['regex'=>[
                    'rule' =>['custom','/^[\wñçÁ-Úá-ú\s.º,\?\¿\¡\!-]*$/i'],
                    'message' => __('El título debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].')
                ]])
            ->add('title',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('El título debe tener mínimo 3 caracteres.')
                ]])
            ->add('title',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('El título debe tener máximo 100 caracteres.')
                ]]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('user_id', 'User'), ['errorField' => 'user_id']);

        return $rules;
    }
    public function validoDateBetween($date){
        if('2022-01-01 00:00:00' > $date || '2050-01-01 00:00:00' < $date){
            return false;
        }else{
            return true;
        }
    }
}
