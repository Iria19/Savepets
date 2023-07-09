<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PublicationStray Controller
 *
 * @property \App\Model\Table\PublicationStrayTable $PublicationStray
 * @method \App\Model\Entity\PublicationStray[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PublicationStrayController extends AppController
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
        //Atributos búsqueda
        $keyUrgente = $this->request->getQuery('keyUrgente');
        $keyProvincia = $this->request->getQuery('keyProvincia');
        $keyCiudad = $this->request->getQuery('keyCiudad');
        $keyPais = $this->request->getQuery('keyPais');

    if($keyProvincia || $keyCiudad || $keyPais){//Busqueda
        $allPublicationStrayAddress = $this->getTableLocator()->get('PublicationStrayAddress');
        $allAddress = $this->getTableLocator()->get('Address');

        $allAddressIDCityProvince = $allAddress->find( 'all')->where([
            ['or'=>[['city like'=>'%'.$keyCiudad.'%'],['city IS'=>NULL]]],
            ['or'=>[['province like'=>'%'.$keyProvincia.'%'],['province IS'=>NULL]]],
            ['or'=>[['country like'=>'%'.$keyPais.'%'],['country IS'=>NULL]]]
        ])->select('id');
        
        $PublicationStrayIDCityProvinceCountry = $allPublicationStrayAddress->find( 'all')->where(['addres_id IN'=>$allAddressIDCityProvince])->select('publication_stray_id');

        if($keyUrgente){
            $PublicationStrayShow = $this->PublicationStray->find('all', ['limit' => 200])->where(['PublicationStray.urgent like'=>'%'.$keyUrgente.'%', 'PublicationStray.id'=>$PublicationStrayIDCityProvinceCountry]);

        }else{
            $PublicationStrayShow = $this->PublicationStray->find('all', ['limit' => 200])->where(['PublicationStray.id'=>$PublicationStrayIDCityProvinceCountry]);

        } 
    }else{
        if($keyUrgente){
            $PublicationStrayShow = $this->PublicationStray->find('all', ['limit' => 200])->where(['urgent like'=>'%'.$keyUrgente.'%']);
        }else{//Todo
            $PublicationStrayShow = $this->PublicationStray;
        } 
    }
        $publicationStray = $this->paginate($PublicationStrayShow,['contain'=>['Publication','User'], 'order' => ['id'=>'desc']]);

        $this->set(compact('publicationStray'));
    }

    /**
     * View method
     *
     * @param string|null $id Publication Stray id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $publicationStray = $this->PublicationStray->get($id,['contain'=>['Publication','User','Comment', 'Comment.User']]);

        $this->set(compact('publicationStray'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $publicationStray = $this->PublicationStray->newEmptyEntity();
        if ($this->request->is('post')) {
            $publicationStray = $this->PublicationStray->patchEntity($publicationStray, $this->request->getData());
            if(!$publicationStray->getErrors){
                $image = $this->request->getData('image_file');
                if($image && ($image->getClientMediaType()!='image/png' && $image->getClientMediaType()!='image/jpg'&& $image->getClientMediaType()!='image/jpeg' && $image->getClientFilename()!="")){//compruebo extension
                    $this->Flash->error(__('La imagen debe ser jpg, jpeg o png.'));
                }else{
                    $name=null;

                    if($image !=NULL){//Hay imagen se coge nombre fichero
                        $name  = $image->getClientFilename();
                    }
                    if( !is_dir(WWW_ROOT.'img'.DS.'strayanimal-img') ){//No esta directorio se crea
                        mkdir(WWW_ROOT.'img'.DS.'strayanimal-img',0775);
                    }
                    if($name){//Hay imagen

                        $allUsers = $this->getTableLocator()->get('User');//Conecto con users
                        $query = $allUsers->find()->where(['id' => $publicationStray->user_id])->select('username')->first();
                        $name=$query['username'].'-'.date('d-m-y h:i:s').'-'.$name;//nombre unico
                        $targetPath = WWW_ROOT.'img'.DS.'strayanimal-img'.DS.$name;
                        $publicationStray->image = 'strayanimal-img/'.$name;//se asigna img
                    }
                    

                    if ($this->PublicationStray->save($publicationStray)) {
                        if($image && $image->getClientFilename()!=''){//se mueve img
                            if($image->getStream()->getMetadata('uri')!='/var/www/html/savepets/webroot/img/testimagen.jpg'){//no es test
                                $image->moveTo($targetPath);
                            }
                        }
                        $this->Flash->success(__('Publicado correctamente.'));
                        return $this->redirect(['action' => 'index']);
                    }
                }
            }
            $this->Flash->error(__('Ha habido un error al crear la publicación . Por favor intentalo de nuevo.'));
        }
        $address = $this->PublicationStray->Address->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationStray', 'address'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Publication Stray id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $publicationStray = $this->PublicationStray->get($id,['contain'=>['Publication','User']]);
        $imgpath = WWW_ROOT . 'img' . DS . $publicationStray->image;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $publicationStray = $this->PublicationStray->patchEntity($publicationStray, $this->request->getData());
            $image = $this->request->getData('change_image');//imagen nueva
            if($image && ($image->getClientMediaType()!='image/png' && $image->getClientMediaType()!='image/jpg'&& $image->getClientMediaType()!='image/jpeg' && $image->getClientFilename()!="")){//comprueba extension
                $this->Flash->error(__('La imagen debe ser jpg, jpeg o png.'));
            }else{
                $name=null;

                if($image !=NULL){//obtiene nombre img
                    $name  = $image->getClientFilename();
                }
                if (!$publicationStray->getErrors) {
                    $image = $this->request->getData('change_image');//obtiene img
    
                    if (!is_dir(WWW_ROOT . 'img' . DS . 'strayanimal-img')){//No hay directorio se crea
                        mkdir(WWW_ROOT . 'img' . DS . 'strayanimal-img', 0775);
                    }
                    if ($name){

                        $allUsers = $this->getTableLocator()->get('User');//Conecto con users
                        $query = $allUsers->find()->where(['id' => $publicationStray->user_id])->select('username')->first();
                        $name=$query['username'].'-'.date('d-m-y h:i:s').'-'.$name;//nombre unico
                        $targetPath = WWW_ROOT . 'img' . DS . 'strayanimal-img' . DS . $name;
                        if (file_exists($imgpath)&& !preg_match('/^\/var\/www\/html\/savepets\/webroot\/img\/strayanimal-img\/$/',$imgpath)&& !preg_match('/^\/var\/www\/html\/savepets\/webroot\/img\/$/',$imgpath)) {//si cambia img, anterior se borra
                            unlink($imgpath);
                        }
                        $publicationStray->image = 'strayanimal-img/' . $name;                    
                    }   
                    
                    if ($this->PublicationStray->save($publicationStray)) {
                        if($image && $image->getClientFilename()!=''){//hay img
                            if($image->getStream()->getMetadata('uri')!='/var/www/html/savepets/webroot/img/testimagen.jpg'){//se mueve img
                                $image->moveTo($targetPath);
                            }
                        }
                        $this->Flash->success(__('La publicación se ha actualizado.'));

                        return $this->redirect(['action' => 'index']);
                    }
                }
            }
            $this->Flash->error(__('La publicación no se ha podido actualizar. Por favor intentalo de nuevo.'));
        }
        //$address = $this->PublicationStray->Address->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationStray'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Publication Stray id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $publicationStray = $this->PublicationStray->get($id);
        $publication_id = $publicationStray->publication_id;
        $imgpath = WWW_ROOT.'img'.DS.$publicationStray->image;
        $allPublicationStrayAddress = $this->getTableLocator()->get('PublicationStrayAddress');
        $AddressID=$allPublicationStrayAddress->find()->where(['publication_stray_id'=>$id])->select('addres_id'); //Encuentro la dirección    
        $borrarimg=false;
        if($AddressID!=NULL){//Si existe la dirección
            //Imagen
            $addresstable=$this->getTableLocator()->get('Address');    
            foreach($AddressID as $AddressaIDBorrarindiv){
                $AddressaBorrar=$addresstable->find('all')->where(['id'=>$AddressaIDBorrarindiv['addres_id']])->first();

                $AddressaBorrarIMG=$allPublicationStrayAddress->find()->where(['publication_stray_id'=>$id])->select('image')->first();//busca imagen de direcciones de esta publicacion
                if(!empty($AddressaBorrarIMG) || $AddressaBorrarIMG!= NULL){
                    $imgpathAddressaBorrarIMG = WWW_ROOT.'img'.DS.$AddressaBorrarIMG->image;
                    $AddressaBorrarIMG=$AddressaBorrarIMG->image;
                }
                $borrarimg=true;//se debe borrar img
            }
        }        
        if ($this->PublicationStray->delete($publicationStray)) {

            $allPublications = $this->getTableLocator()->get('Publication');
            $PubliStrayPublication=$allPublications->find()->where(['id'=>$publication_id])->first();//busco si es una publicación stray y cojo imagen
            $allPublications->delete($PubliStrayPublication);

            if(file_exists($imgpath) ){
                $imageStrayAnimal=$publicationStray->image;
                if(!empty($imageStrayAnimal)&& !preg_match('/^strayanimal-img\/$/',$imageStrayAnimal)){//se borra img
                    unlink($imgpath);
                }
            }
            if($borrarimg){//se debe borrar imagenes de direcciones de publicacion perdidos
                if ($addresstable->delete($AddressaBorrar)) {
                    if(!empty($AddressaBorrarIMG) || $AddressaBorrarIMG!= NULL){ 

                        if(file_exists($imgpathAddressaBorrarIMG) ){
                            if(!empty($AddressaBorrarIMG) && !preg_match('/^addresstrayanimal-img\/$/',$AddressaBorrarIMG)){//se borra
                                unlink($imgpathAddressaBorrarIMG);

                            }
                        }
                    }
                }
            }

            $this->Flash->success(__('Publicación de perdidos eliminada.'));
     } else {
            $this->Flash->error(__('La publicación de perdidos no se ha podido eliminar. Por favor intentalo de nuevo.'));
        }

       return $this->redirect(['action' => 'index']);
    }
}
