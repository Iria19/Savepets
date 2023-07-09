<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Mailer\Mailer;
/**
 * PublicationAdoption Controller
 *
 * @property \App\Model\Table\PublicationAdoptionTable $PublicationAdoption
 * @method \App\Model\Entity\PublicationAdoption[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PublicationAdoptionController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
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
        //atributos busqueda
        $keyUrgente = $this->request->getQuery('keyUrgente');
        $keyEspecie = $this->request->getQuery('keyEspecie');
        $keyRaza = $this->request->getQuery('keyRaza');
        $keySexo = $this->request->getQuery('keySexo');
        if($keyEspecie||$keyRaza||$keySexo){//búsqueda
            $allAnimal = $this->getTableLocator()->get('Animal');
            $AdopcionAnimal = $allAnimal->find('all')->where
            ([
                ['or'=>[['race like'=>'%'.$keyRaza.'%'],['race IS'=>NULL]]],
                ['or'=>[['sex like'=>'%'.$keySexo.'%'],['sex IS'=>NULL]]],
                ['or'=>[['specie like'=>'%'.$keyEspecie.'%'],['specie IS'=>NULL]]]
                ])->select('id');
            if($keyUrgente){
                $PublicationAdoptionShow =$PublicationAdoptionShow = $this->PublicationAdoption->find('all', ['limit' => 200])->where([ ['or'=>[['urgent like'=>'%'.$keyUrgente.'%'],['urgent IS'=>NULL]]], 'PublicationAdoption.animal_id IN'=>$AdopcionAnimal]);
            }else{
                $PublicationAdoptionShow =  $this->PublicationAdoption->find('all', ['limit' => 200])->where(['PublicationAdoption.animal_id IN'=>$AdopcionAnimal]);            
            }
        }else{
            if($keyUrgente){
                $PublicationAdoptionShow = $this->PublicationAdoption->find('all', ['limit' => 200])->where(['urgent like'=>'%'.$keyUrgente.'%']);
            }else{//Todos
                $PublicationAdoptionShow = $this->PublicationAdoption;
            }
        }
 
        $publicationAdoption = $this->paginate($PublicationAdoptionShow, ['contain' => ['Publication', 'Animal', 'User'],'order' => ['id'=>'desc']]);

        $this->set(compact('publicationAdoption'));
    }

    /**
     * View method
     *
     * @param string|null $id Publication Adoption id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $publicationAdoption = $this->PublicationAdoption->get($id, [
            'contain' => ['Publication', 'Animal', 'User','Comment', 'Comment.User'],
        ]);

        $this->set(compact('publicationAdoption'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $publicationAdoption = $this->PublicationAdoption->newEmptyEntity();
        if ($this->request->is('post')) {
            $publicationAdoption = $this->PublicationAdoption->patchEntity($publicationAdoption, $this->request->getData());

            $publication_animal_id=$publicationAdoption['animal_id'];
            $publication_user_id=$publicationAdoption['user_id'];

            if ($this->PublicationAdoption->save($publicationAdoption)) {
                $this->Flash->success(__('Publicado correctamente.'));

                //buscar pais y provincia usuario
                $allUser = $this->getTableLocator()->get('User');
                $useraddressid = $allUser->find('all', ['limit' => 200])->where(['id'=>$publication_user_id])->select('addres_id')->first();
                $allAddress = $this->getTableLocator()->get('Address');
                $userpais = $allAddress->find('all', ['limit' => 200])->where(['id'=>$useraddressid["addres_id"]])->select('country')->first();
                $userpais=$userpais['country'];
                $userprovince = $allAddress->find('all', ['limit' => 200])->where(['id'=>$useraddressid["addres_id"]])->select('province')->first();
                $userprovince=$userprovince['province'];

                //buscar especie y raza animal
                $allAnimal = $this->getTableLocator()->get('Animal');
                $animalspecie = $allAnimal->find('all', ['limit' => 200])->where(['id'=>$publication_animal_id])->select('specie')->first();
                $animalspecie=$animalspecie['specie'];

                $animalraza = $allAnimal->find('all', ['limit' => 200])->where(['id'=>$publication_animal_id])->select('race')->first();
                $animalraza=$animalraza['race'];

                $allAlert = $this->getTableLocator()->get('Alert');
                //busco usuarios que tienen alerta
                $allalertusers = $allAlert->find('all', ['limit' => 200])->where([['active IS'=>'yes'],
                ['or'=>[['country IS'=>$userpais],['country IS'=>NULL]]],
                ['or'=>[['province IS'=>$userprovince],['province IS'=>NULL],['province IS'=>'']]],
                ['or'=>[['specie IS'=>$animalspecie],['specie IS'=>NULL],['specie IS'=>'']]],
                ['or'=>[['race IS'=>$animalraza],['race IS'=>NULL],['race IS'=>'']]]
                ])->select('user_id');
                foreach ($allalertusers as $allalertuser){ //para cada usuario
                    $usuarioid=$allalertuser['user_id'];
                    $usuarioemail = $allUser->find('all')->where(['id'=>$usuarioid])->select('email')->first();//busco correo usuario
                    $usuarioemail =$usuarioemail['email'];

                    //titulo de la alerta
                    $alerttitle = $allAlert->find('all', ['limit' => 200])->where([['active IS'=>'yes'],['user_id IS'=>$usuarioid],
                    ['or'=>[['country IS'=>$userpais],['country IS'=>NULL]]],
                    ['or'=>[['province IS'=>$userprovince],['province IS'=>NULL],['province IS'=>'']]],
                    ['or'=>[['specie IS'=>$animalspecie],['specie IS'=>NULL],['specie IS'=>'']]],
                    ['or'=>[['race IS'=>$animalraza],['race IS'=>NULL],['race IS'=>'']]]
                    ])->select('title')->first();
                    $alerttitle=$alerttitle['title'];

                    //Envio correo
                    $to = $usuarioemail;
                    $subject = "SAVEPETS";
                    $txt = $alerttitle;
                    $headers = "From: savepetsiria@outlook.com";
                    $success = mail($to,$subject,$txt,$headers);
                    
                      
                }
             return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Ha habido un error al crear la publicación . Por favor intentalo de nuevo.'));
        }
        $publication = $this->PublicationAdoption->Publication->find('list', ['limit' => 200])->all();
        $animal = $this->PublicationAdoption->Animal->find('list', ['limit' => 200])->all();
        $user = $this->PublicationAdoption->User->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationAdoption', 'publication', 'animal', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Publication Adoption id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $publicationAdoption = $this->PublicationAdoption->get($id, [
            'contain' => ['Publication', 'Animal', 'User'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $publicationAdoption = $this->PublicationAdoption->patchEntity($publicationAdoption, $this->request->getData());
            if ($this->PublicationAdoption->save($publicationAdoption)) {
                $this->Flash->success(__('La publicación se ha actualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La publicación no se ha podido actualizar. Por favor intentalo de nuevo.'));
        }
        $publication = $this->PublicationAdoption->Publication->find('list', ['limit' => 200])->all();
        $animal = $this->PublicationAdoption->Animal->find('list', ['limit' => 200])->all();
        $user = $this->PublicationAdoption->User->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationAdoption', 'publication', 'animal', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Publication Adoption id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $publicationAdoption = $this->PublicationAdoption->get($id);
        $publication_id = $publicationAdoption->publication_id;

        if ($this->PublicationAdoption->delete($publicationAdoption)) {
            $allPublications = $this->getTableLocator()->get('Publication');
            $PubliAdopPublication=$allPublications->find()->where(['id'=>$publication_id])->first();//busco si es una publicación stray y cojo imagen
            $allPublications->delete($PubliAdopPublication);
            $this->Flash->success(__('Publicación eliminada.'));
        } else {
            $this->Flash->error(__('La publicación no se ha podido eliminar. Por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
