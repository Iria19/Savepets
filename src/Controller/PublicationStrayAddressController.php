<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PublicationStrayAddress Controller
 *
 * @property \App\Model\Table\PublicationStrayAddressTable $PublicationStrayAddress
 * @method \App\Model\Entity\PublicationStrayAddres[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PublicationStrayAddressController extends AppController
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
    public function index($CurrentPublicationStray_id=null)
    {  
        if(!empty($CurrentPublicationStray_id)||$CurrentPublicationStray_id!=NULL){

            $PublicationStrayAddressShow = $this->PublicationStrayAddress->find('all', ['limit' => 200])->where(['publication_stray_id'=>$CurrentPublicationStray_id]);

        }else{
            $PublicationStrayAddressShow = $this->PublicationStrayAddress;
        } 
        $publicationStrayAddress = $this->paginate($PublicationStrayAddressShow,['contain' => ['PublicationStray', 'Address', 'User'], 'order' => ['id'=>'desc']]);


        if(!empty($CurrentPublicationStray_id)||$CurrentPublicationStray_id!=NULL){
            $CurrentPublicationStray_id=$CurrentPublicationStray_id;

            $this->set(compact('publicationStrayAddress','CurrentPublicationStray_id'));
        }else{
            $this->set(compact('publicationStrayAddress'));

        }
    }

    /**
     * View method
     *
     * @param string|null $id Publication Stray Addres id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $publicationStrayAddres = $this->PublicationStrayAddress->get($id, [
            'contain' => ['PublicationStray', 'Address', 'User'],
        ]);
        $this->set(compact('publicationStrayAddres'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($CurrentPublicationStray_id=null)
    {
        $publicationStrayAddres = $this->PublicationStrayAddress->newEmptyEntity();
        if ($this->request->is('post')) {
            $publicationStrayAddres = $this->PublicationStrayAddress->patchEntity($publicationStrayAddres, $this->request->getData());
            if(!$publicationStrayAddres->getErrors){
                $image = $this->request->getData('image_file');
                if($image && ($image->getClientMediaType()!='image/png' && $image->getClientMediaType()!='image/jpg'&& $image->getClientMediaType()!='image/jpeg' && $image->getClientFilename()!="")){//comprueba extension
                    $this->Flash->error(__('La imagen debe ser jpg, jpeg o png.'));
                    }else{
                    $name=null;

                    if($image !=NULL){//hay img, se coge nombre
                        $name  = $image->getClientFilename();
                    }
                    if( !is_dir(WWW_ROOT.'img'.DS.'addresstrayanimal-img') ){//si no hay directorio se crea
                        mkdir(WWW_ROOT.'img'.DS.'addresstrayanimal-img',0775);
                    }
                if($name){

                        $allUsers = $this->getTableLocator()->get('User');//Conecto con users
                        $query = $allUsers->find()->where(['id' => $publicationStrayAddres->user_id])->select('username')->first();
                        $name=$query['username'].'-'.date('d-m-y h:i:s').'-'.$name;//nombre unico
                        $targetPath = WWW_ROOT.'img'.DS.'addresstrayanimal-img'.DS.$name;
                        
                        $publicationStrayAddres->image = 'addresstrayanimal-img/'.$name;
                    }
                    if ($this->PublicationStrayAddress->save($publicationStrayAddres)) {
                        if($image && $image->getClientFilename()!=''){//hay img
                            if($image->getStream()->getMetadata('uri')!='/var/www/html/savepets/webroot/img/testimagen.jpg'){//sino es test se myeve
                                $image->moveTo($targetPath);
                            }
                        }
                        $this->Flash->success(__('La dirección de la publicación de animal perdido se ha añadido.'));
                        return $this->redirect(['action' => 'index',$CurrentPublicationStray_id]);
                    }else{
                        $this->Flash->error(__('La dirección de la publicación de animal perdido se ha no podido añadir. Por favor intentalo de nuevo.'));
                    }
                }
            }
            $this->Flash->error(__('La dirección de la publicación de animal perdido se ha no podido añadir. Por favor intentalo de nuevo.'));
        }
         //$publicationStray = $this->PublicationStrayAddress->PublicationStray->find('list', ['limit' => 200])->all();
       // $address = $this->PublicationStrayAddress->Address->find('list', ['limit' => 200])->all();
      //  $user = $this->PublicationStrayAddress->User->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationStrayAddres', 'CurrentPublicationStray_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Publication Stray Addres id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $publicationStrayAddres = $this->PublicationStrayAddress->get($id, [
            'contain' => ['PublicationStray', 'Address', 'User'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $publicationStrayAddres = $this->PublicationStrayAddress->patchEntity($publicationStrayAddres, $this->request->getData());

            if (!$publicationStrayAddres->getErrors) {
                $image = $this->request->getData('change_image');
                if($image && ($image->getClientMediaType()!='image/png' && $image->getClientMediaType()!='image/jpg'&& $image->getClientMediaType()!='image/jpeg' && $image->getClientFilename()!="")){//comprueba extension
                    $this->Flash->error(__('La imagen debe ser jpg, jpeg o png.'));
                }else{
                    $name=null;

                    if($image !=NULL){//hay imagen entonces se obtiene nombre
                        $name  = $image->getClientFilename();
                    }                     
                    if (!is_dir(WWW_ROOT . 'img' . DS . 'addresstrayanimal-img')){//sino hay directorio se crea
                        mkdir(WWW_ROOT . 'img' . DS . 'addresstrayanimal-img', 0775);
                    }
                    if ($name){
                        $allUsers = $this->getTableLocator()->get('User');//Conecto con users
                        $query = $allUsers->find()->where(['id' => $publicationStrayAddres->user_id])->select('username')->first();
                        $name=$query['username'].'-'.date('d-m-y h:i:s').'-'.$name;//nombre unico
                        $targetPath = WWW_ROOT . 'img' . DS . 'addresstrayanimal-img' . DS . $name;

                        $imgpath = WWW_ROOT . 'img' . DS . $publicationStrayAddres->image;
                        if (file_exists($imgpath) && !preg_match('/^\/var\/www\/html\/savepets\/webroot\/img\/addresstrayanimal-img\/$/',$imgpath)&& !preg_match('/^\/var\/www\/html\/savepets\/webroot\/img\/$/',$imgpath)) {//imagen anterior cambia entonces se borra
                            unlink($imgpath);
                        }
                        $publicationStrayAddres->image = 'addresstrayanimal-img/' . $name;
                        
                    }   

                    if ($this->PublicationStrayAddress->save($publicationStrayAddres)) {
                        if($image && $image->getClientFilename()!=''){
                            if($image->getStream()->getMetadata('uri')!='/var/www/html/savepets/webroot/img/testimagen.jpg'){//Sino es test se mueve imagen
                                $image->moveTo($targetPath);
                            }
                        }
                        $this->Flash->success(__('La dirección de la publicación de animal perdido se ha actualizado.'));
                        return $this->redirect(['action' => 'index',$publicationStrayAddres->publication_stray_id]);
                    }else{
                        $this->Flash->error(__('La dirección de la publicación de animal perdido se ha no podido actualizar. Por favor intentalo de nuevo.'));
                    }
                }
            }
            $this->Flash->error(__('La dirección de la publicación de animal perdido se ha no podido actualizar. Por favor intentalo de nuevo.'));
        }
        $publicationStray = $this->PublicationStrayAddress->PublicationStray->find('list', ['limit' => 200])->all();
        $address = $this->PublicationStrayAddress->Address->find('list', ['limit' => 200])->all();
        $user = $this->PublicationStrayAddress->User->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationStrayAddres', 'publicationStray', 'address', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Publication Stray Addres id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $publicationStrayAddres = $this->PublicationStrayAddress->get($id);
        $imgpath = WWW_ROOT.'img'.DS.$publicationStrayAddres->image;

        $addres_id = $publicationStrayAddres->addres_id;
        if ($this->PublicationStrayAddress->delete($publicationStrayAddres)) {
            $allAddress = $this->getTableLocator()->get('Address');
            $AddPublicationStrayAddress=$allAddress->find()->where(['id'=>$addres_id])->first();//busco si es una publicación stray y cojo imagen
            $allAddress->delete($AddPublicationStrayAddress);
            if(file_exists($imgpath) ){//se borra img
                $imageStrayAnimalAddress=$publicationStrayAddres->image;
                if(!empty($imageStrayAnimalAddress)&& !preg_match('/^addresstrayanimal-img\/$/',$imageStrayAnimalAddress)){
                    unlink($imgpath);
               }
            }
            $this->Flash->success(__('La dirección de la publicación de animal perdido se ha borrado.'));
        } else {
            $this->Flash->error(__('La dirección de la publicación de animal perdido se ha no podido borrar. Por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index',$publicationStrayAddres->publication_stray_id]);
    }
}
