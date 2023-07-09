<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Alert Controller
 *
 * @property \App\Model\Table\AlertTable $Alert
 * @method \App\Model\Entity\Alert[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlertController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $currentUser =$this->request->getAttribute('identity');
        $currentUserID =$currentUser['id']; //id usuario logeado
        $currentUserRol =$currentUser['role']; //id usuario logeado
        if($currentUserRol=='admin'){//Es admin
            $allalert = $this->Alert;
        }else{ //Busco las alertas de ese usuario
            $allalert = $this->Alert->find('all', ['limit' => 200])->where(['user_id' => $currentUserID]); 
        }
        $alert = $this->paginate($allalert,['contain' => ['User'], 'order' => ['id'=>'desc']]);

        $this->set(compact('alert'));
    }

    /**
     * View method
     *
     * @param string|null $id Alert id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     $alert = $this->Alert->get($id, [
    //         'contain' => ['User'],
    //     ]);

    //     $this->set(compact('alert'));
    // }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alert = $this->Alert->newEmptyEntity();
        if ($this->request->is('post')) {
            $alert = $this->Alert->patchEntity($alert, $this->request->getData());
            if ($this->Alert->save($alert)) {
                $this->Flash->success(__('La alerta se ha añadido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La alerta no se ha podido añadir. Por favor intentalo de nuevo.'));
        }
        $user = $this->Alert->User->find('list', ['limit' => 200])->all();
        $this->set(compact('alert', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alert id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alert = $this->Alert->get($id, [
            'contain' => ['User'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alert = $this->Alert->patchEntity($alert, $this->request->getData());
            if ($this->Alert->save($alert)) {
                $this->Flash->success(__('La alerta se ha editado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La alerta no se ha podido editar. Por favor intentalo de nuevo.'));
        }
        $user = $this->Alert->User->find('list', ['limit' => 200])->all();
        $this->set(compact('alert', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alert id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alert = $this->Alert->get($id);
        if ($this->Alert->delete($alert)) {
            $this->Flash->success(__('La alerta se ha eliminado.'));
        } else {
            $this->Flash->error(__('La alerta no se ha podido eliminar. Por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
