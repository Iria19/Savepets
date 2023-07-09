<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Event Controller
 *
 * @property \App\Model\Table\EventTable $Event
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventController extends AppController
{    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['view','index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $event = $this->paginate($this->Event);

        $this->set(compact('event'));
    }

    /**
     * View method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $event = $this->Event->get($id, [
            'contain' => ['Address','User'],
        ]);

        $this->set(compact('event'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $event = $this->Event->newEmptyEntity();
        $allUsers = $this->getTableLocator()->get('User');//Conecto con users

        if ($this->request->is('post')) {
            $event = $this->Event->patchEntity($event, $this->request->getData());

            if ($this->Event->save($event)) {
                $this->Flash->success(__('El evento se ha añadido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El evento no se ha podido añadir. Por favor intentalo de nuevo.'));
        }
        
        $user = $allUsers->find('list', ['limit' => 200])->all();
        $this->set(compact('event','user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $event = $this->Event->get($id, [
            'contain' => ['Address','User'],
        ]);
        $allUsers = $this->getTableLocator()->get('User');//Conecto con users

        if ($this->request->is(['patch', 'post', 'put'])) {
            $event = $this->Event->patchEntity($event, $this->request->getData());
            if ($this->Event->save($event)) {
                $this->Flash->success(__('Evento actualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El evento no se ha podido actualizar. Por favor intentalo de nuevo.'));
        }

        $user = $allUsers->find('list', ['limit' => 200])->all();
        $this->set(compact('event','user'));    }

    /**
     * Delete method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $event = $this->Event->get($id);
        $addres_id = $event->addres_id;
        if ($this->Event->delete($event)) {
            $allAddress = $this->getTableLocator()->get('Address');
            $AddressEvent=$allAddress->find()->where(['id'=>$addres_id])->first();//busco si es una publicación stray y cojo imagen
            $allAddress->delete($AddressEvent);

            $this->Flash->success(__('El evento se ha eliminado.'));
        } else {
            $this->Flash->error(__('El evento no se ha podido eliminar. Por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
