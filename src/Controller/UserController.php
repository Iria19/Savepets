<?php
declare(strict_types=1);

namespace App\Controller;


/**
 * User Controller
 *
 * @property \App\Model\Table\UserTable $User
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {     
        $keyUsername = $this->request->getQuery('key');
        $keyRole = $this->request->getQuery('keyRole');

        if($keyUsername||$keyRole){
            $use = $this->User->find('all', ['limit' => 200])->where([
                ['or'=>[['username like'=>'%'.$keyUsername.'%'],['username IS'=>NULL]]],
                ['or'=>[['role like'=>'%'.$keyRole.'%'],['role IS'=>NULL]]]
                ]);
        }else{
            $use = $this->User;
        }
        if($this->Authentication->getIdentity()){

            $currentUser =$this->request->getAttribute('identity');
            $currentUserID =$currentUser['id']; //id usuario logeado
            $currentUserRol =$currentUser['role']; //rol usuario logeado
            if ($currentUserRol=='admin'){
                $user = $this->paginate($use, ['order' => ['id'=>'desc']]);
            }else{
                $alluse = $use->find('all', ['limit' => 200])->where(['or'=>[['role'=>'admin'],['role'=>'shelter'],['id'=>$currentUserID]]]);
                $user = $this->paginate($alluse, ['order' => ['id'=>'desc']]);
            }
            
        }else{//Si es usuario estandar ve las que esta protectoras y a si mismo 
            $alluse = $use->find('all', ['limit' => 200])->where(['or'=>[['role'=>'admin'],['role'=>'shelter']]]);
            $user = $this->paginate($alluse, ['order' => ['id'=>'desc']]);

        }

        $this->set(compact('user'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
            $user = $this->User->get($id, [
                'contain' => ['Address','FeatureUser'],
            ]);
            $this->set(compact('user'));
    }

    /**
     * Analysis method
     *
     * @param string|null $id User id.
     * @param string|null $username Username.
     */
    public function analysis($id=null,$username = null)
    {
        $user = $this->User->get($id, [
            'contain' => ['Address','FeatureUser'],
        ]);
        //por animal
        $countvisitasperro=0;
        $countvisitasgato=0;
        $countvisitasconejo=0;
        $countvisitashamnster=0;
        $countvisitasserpiente=0;
        $countvisitastortuga=0;
        $countvisitasotro=0;

        //genero
        $countvisitasgenerohombre=0;
        $countvisitasgeneromujer=0;
        $countvisitasgeneronobinario=0;
        $countvisitasgenerootro=0;

        //edad
        $countvisitasmenotreintaotro=0;
        $countvisitasteintasesenta=0;
        $countvisitasmassesenta=0;

        //hijos
        $countvisitasnohijo=0;
        $countvisitasunhijo=0;
        $countvisitasdoshijos=0;
        $countvisitasmasdoshijos=0;

        $fichero = fopen("history.csv", "r");//abro fichero

            /* Se recorre el csv */
            while(($row = fgetcsv($fichero)) !== FALSE) {
               if($row[26]==$username){
                $edad=intval($row[11]);
                $hijos=intval($row[15]);
                $genero=$row[19];
                $specie=$row[20];
                //contador para cada variable de cada gráfica
                switch ($specie) {
                    case $specie=='dog':
                        $countvisitasperro+=1;
                        break;
                    case $specie=='cat':
                        $countvisitasgato+=1;
                        break;
                    case $specie=='bunny':
                        $countvisitasconejo+=1;
                        break;
                    case $specie=='hamster':
                        $countvisitashamnster+=1;
                        break;
                    case $specie=='snake':
                        $countvisitasserpiente+=1;
                        break;
                    case $specie=='turtless':
                        $countvisitastortuga+=1;
                        break;
                    default:
                        $countvisitasotro+=1;
                    break;

                }

                switch ($genero) {
                    case $genero=='male':
                        $countvisitasgenerohombre+=1;
                        break;
                    case $genero=='female':
                        $countvisitasgeneromujer+=1;
                        break;
                    case $genero=='nobinary':
                        $countvisitasgeneronobinario+=1;
                        break;
                    default:
                        $countvisitasgenerootro+=1;
                    break;

                }

                switch ($edad) {
                    case $edad<=30:
                        $countvisitasmenotreintaotro+=1;
                        break;
                    case ($edad>30 && $edad<60):
                        $countvisitasteintasesenta+=1;
                        break;
                    case $edad>=60:
                        $countvisitasmassesenta+=1;
                        break;                    
                }


                switch ($hijos) {
                    case $hijos==0:
                        $countvisitasnohijo+=1;
                        break;
                    case $hijos==1:
                        $countvisitasunhijo+=1;
                        break;
                    case $hijos==2:
                        $countvisitasdoshijos+=1;
                        break;
                    case $hijos>2:
                        $countvisitasmasdoshijos+=1;
                        break;
                    default:
                    $countvisitasnohijo+=1;
                    break;
                }
            }
        }
        //Se ponen todos los valores en csv
        $array = array($countvisitasperro,$countvisitasgato,$countvisitasgato,$countvisitasconejo,$countvisitashamnster,$countvisitasserpiente,$countvisitastortuga,$countvisitasotro,$countvisitasgenerohombre,$countvisitasgeneromujer,$countvisitasgeneronobinario,$countvisitasgenerootro,$countvisitasmenotreintaotro,
            $countvisitasteintasesenta,$countvisitasmassesenta,$countvisitasnohijo,$countvisitasunhijo,$countvisitasdoshijos,$countvisitasmasdoshijos);
       
        $this->set(compact('user','array'));

    
}

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $user = $this->User->newEmptyEntity();

        if ($this->request->is('post')) {

            $user = $this->User->patchEntity($user, $this->request->getData());
            if ($this->User->save($user)) {
                $this->Flash->success(__('Usuario registrado.'));

                return $this->redirect(['action' => 'login']);
            }
            
            $this->Flash->error(__('Error al registrar usuario, por favor intentalo de nuevo.'));
        }
         $this->set(compact('user'));
    }


    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->User->get($id, [
            'contain' => ['Address','FeatureUser'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->User->patchEntity($user, $this->request->getData());
            if ($this->User->save($user)) {
                $this->Flash->success(__('Usuario modificado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El usuario no se ha podido modificar, por favor vuelva a intentarlo.'));
        }

        
        $this->set(compact('user'));
    }

    /**
     * logout method
     *
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'User', 'action' => 'login']);
        }
    }
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->User->get($id);
        //Se anonimiza, cambia nombre de usuario y contraseña
        $user['username']=__('Anonimo').$id;
        $user['password']=__('Anonimo').$id;

        $user = $this->User->patchEntity($user, $this->request->getData());
        if ($this->User->save($user)) {
            $this->Flash->success(__('El usuario se ha eliminado.'));
            if($this->request->getAttribute('identity')['id']==$id){
                return $this->redirect(['controller' => 'User', 'action' => 'logout']);
            }
        } else {
            $this->Flash->error(__('El usuario no se ha podido eliminar, por favor intentalo de nuevo.'));
        }
        
        return $this->redirect(['controller' => 'User', 'action' => 'index']);

    }


    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
       // $this->Authentication->addUnauthenticatedActions(['login']);
        $this->Authentication->addUnauthenticatedActions(['login', 'add','index']);
    }


    /**
     * login method
     *
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {

            // redirect to /articles after login success
            // $redirect = $this->request->getQuery('redirect', [
            //     'controller' => 'Address',
            //     'action' => 'index',
            // ]);
            return $this->redirect(['controller' => 'Pages', 'action' => 'index']);
        }
        
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('DNI/NIE/CIF o contraseña incorrecta.'));
        }
    }

}

